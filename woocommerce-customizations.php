<?php
/**
 * WooCommerce Customizations für shopofthings.ch
 * Kompatibel mit WordPress 6.9 + WooCommerce 10.4+ (2025)
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/* ==========================================================================
   1. JavaScript für SKU-Kopieren + Tooltips (wird nur noch per wp_add_inline_script eingebunden)
   ========================================================================== */
add_action( 'wp_enqueue_scripts', function() {
    if ( ! function_exists( 'is_product' ) || ! is_product() ) {
        return;
    }

    $translatedString = esc_js( __( 'SKU kopiert', 'shopofthings' ) );

    $js = "
    function copyToClipboard(element) {
        var text = element.innerText || element.textContent;
        navigator.clipboard.writeText(text).then(function() {
            alert('{$translatedString}');
        }).catch(function() {
            // Fallback für sehr alte Browser
            var textarea = document.createElement('textarea');
            textarea.value = text;
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand('copy');
            document.body.removeChild(textarea);
            alert('{$translatedString}');
        });
    }

    jQuery(function($) {
        // Tooltip
        $('body').on('mouseenter mouseleave', '.tooltip', function(e) {
            var tooltipText = $(this).data('tooltip');
            if (!tooltipText) return;

            if (e.type === 'mouseenter') {
                $('<div class=\"tooltip-box\">')
                    .html(tooltipText)
                    .appendTo('body')
                    .fadeIn('fast');
                positionTooltip($(this));
            } else {
                $('.tooltip-box').remove();
            }
        });

        function positionTooltip($element) {
            var $box = $('.tooltip-box');
            var pos   = $element.offset();
            var width = $box.outerWidth();
            var height= $box.outerHeight();

            $box.css({
                top:  pos.top - height - 10,
                left: pos.left + $element.outerWidth()/2 - width/2
            });
        }

        $(window).resize(function() {
            if ($('.tooltip-box').length) {
                var $el = $('.tooltip:hover');
                if ($el.length) positionTooltip($el);
            }
        });
    });
    ";

    wp_add_inline_script( 'jquery', $js );
}, 20 );

/* ==========================================================================
   2. SKU-Spelling + Hilfsfunktionen
   ========================================================================== */
function skuToSpelling( $sku ) {
    if ( ! isSKU( $sku ) ) {
        return 'Ungültige SKU';
    }

    $mapping = [
        '3' => 'three',   '4' => 'four',    '7' => 'seven',
        'A' => 'alpha',   'E' => 'echo',    'H' => 'hotel',
        'J' => 'juliet',  'L' => 'lima',    'N' => 'november',
        'Q' => 'quebec',  'R' => 'romeo',   'T' => 'tango',
        'U' => 'uniform', 'Y' => 'yankee'
    ];

    $spelled = [];
    foreach ( str_split( $sku ) as $char ) {
        if ( isset( $mapping[ $char ] ) ) {
            $spelled[] = $mapping[ $char ];
        }
    }
    return implode( ' / ', $spelled );
}

function isSKU( $sku ) {
    return preg_match( '/^[347AEHJLNQRTUY]{4}$/', $sku );
}

/* ==========================================================================
   3. Kategorienanzeige (sortiert, ohne Brands/Sensorik usw.)
   ========================================================================== */
function display_sorted_categories( $product_id ) {
    $terms = wp_get_post_terms( $product_id, 'product_cat', [ 'fields' => 'all' ] );

    if ( is_wp_error( $terms ) || empty( $terms ) ) {
        return '';
    }

    // IDs ausschließen
    $brands_term          = get_term_by( 'slug', 'brands', 'product_cat' );
    $solution_package_term= get_term_by( 'slug', 'solution-package', 'product_cat' );
    $sensorik_term        = get_term_by( 'slug', 'sensorik', 'product_cat' );

    $exclude_ids = [];
    if ( $brands_term && ! is_wp_error( $brands_term ) ) {
        $exclude_ids[] = $brands_term->term_id;
    }
    if ( $solution_package_term && ! is_wp_error( $solution_package_term ) ) {
        $exclude_ids[] = $solution_package_term->term_id;
    }

    $sensorik_children = $sensorik_term && ! is_wp_error( $sensorik_term )
        ? get_term_children( $sensorik_term->term_id, 'product_cat' )
        : [];

    $all_tags = [];
    foreach ( $terms as $term ) {
        if ( in_array( $term->term_id, $exclude_ids, true ) ) {
            continue;
        }
        if ( $sensorik_term && in_array( $term->term_id, $sensorik_children, true ) ) {
            continue;
        }
        if ( $term->parent == 0 && ! get_term_children( $term->term_id, 'product_cat' ) ) {
            continue;
        }
        if ( get_term_children( $term->term_id, 'product_cat' ) ) {
            continue; // Nur Blattkategorien
        }

        $link = get_term_link( $term, 'product_cat' );
        if ( is_wp_error( $link ) ) {
            continue;
        }

        $all_tags[] = '<a href="' . esc_url( $link ) . '" class="category-tag">' . esc_html( $term->name ) . '</a>';
    }

    if ( empty( $all_tags ) ) {
        return '';
    }

    sort( $all_tags );
    return '<th scope="row">' . esc_html__( 'Kategorien:', 'shopofthings' ) . '</th>'
         . '<td><div class="category-tags">' . implode( '', $all_tags ) . '</div></td>';
}

/* ==========================================================================
   4. Icon-Reihen (Sensoren, Zertifizierungen …)
   ========================================================================== */
function display_icon_row( $title, $taxonomy, $attribute, $alt_text ) {
    $terms = array_map( 'trim', explode( ',', $attribute ) );
    $with_img = [];
    $without_img = [];

    foreach ( $terms as $term_name ) {
        $term = get_term_by( 'name', $term_name, $taxonomy );
        if ( ! $term || is_wp_error( $term ) ) {
            continue;
        }

        $thumb_id  = get_term_meta( $term->term_id, 'product_search_image_id', true );
        $thumb_url = $thumb_id ? wp_get_attachment_url( $thumb_id ) : false;
        $link      = get_term_link( $term );
        $desc      = term_description( $term->term_id, $taxonomy );
        $tooltip   = '<strong>' . esc_html( $term_name ) . '</strong><br>' . esc_html( wp_strip_all_tags( $desc ) );

        $html = '<a href="' . esc_url( $link ) . '" class="tooltip" data-tooltip="' . esc_attr( $tooltip ) . '"';
        if ( $thumb_url ) {
            $html .= '><img src="' . esc_url( $thumb_url ) . '" alt="' . esc_attr( $alt_text ) . '" class="icon-image"></a>';
            $with_img[ $term_name ] = $html;
        } else {
            $html .= ' class="text-link">' . esc_html( $term_name ) . '</a>';
            $without_img[] = $html;
        }
    }

    ksort( $with_img );
    sort( $without_img );
    $all = array_merge( array_values( $with_img ), $without_img );

    if ( $all ) {
        echo '<tr class="special-row"><th scope="row">' . esc_html( $title ) . '</th>'
           . '<td class="special-row-icons"><div>' . implode( ' ', $all ) . '</div></td></tr>';
    }
}

/* ==========================================================================
   5. Hauptfunktion: Meta-Daten oben auf der Produktseite
   ========================================================================== */
function sot_show_product_meta_custom() {
    if ( ! is_product() || ! function_exists( 'is_product' ) ) {
        return;
    }

    global $product;
    if ( ! $product || ! is_a( $product, 'WC_Product' ) ) {
        return;
    }

    echo '<table class="product-meta-table"><tbody>';

    // SKU
    $sku = $product->get_sku();
    if ( $sku ) {
        $tooltip = isSKU( $sku ) ? esc_attr( skuToSpelling( $sku ) ) : esc_attr__( 'SKU kopieren', 'shopofthings' );
        echo '<tr><th scope="row">' . esc_html__( 'SKU:', 'shopofthings' ) . '</th>'
           . '<td><span class="sku tooltip" data-tooltip="' . $tooltip . '" onclick="copyToClipboard(this)">' . esc_html( $sku ) . '</span></td></tr>';
    }

    // P/N
    $herstellernummer = $product->get_attribute( 'pa_herstellernummer' );
    if ( $herstellernummer ) {
        echo '<tr><th scope="row">' . esc_html__( 'P/N:', 'shopofthings' ) . '</th><td>' . wp_kses_post( $herstellernummer ) . '</td></tr>';
    }

    // Marke + Partner-Icon
    $marke = $product->get_attribute( 'pa_brand' );
    $partner_brands = [ 'elsys','rakwireless','abeeway','adnexo','atim','circuitmess','decentlab','reolink','seeedstudio','small data garden','smart aal','strega','swisscom','tektelic','ttgo','adeunis','digital matter','enginko','mclimate','milesight iot','miromico','nano sensorics','netvox','panorama','teltonika','nexelec' ];
    if ( $marke ) {
        $term = get_term_by( 'name', $marke, 'pa_brand' );
        $link = $term && ! is_wp_error( $term ) ? get_term_link( $term ) : '#';
        $output = '<a href="' . esc_url( $link ) . '">' . esc_html( $marke ) . '</a>';
        if ( in_array( strtolower( $marke ), $partner_brands, true ) ) {
            $tooltip = esc_attr__( 'Partner dieser Marke: Mengenrabatte und direkter Support verfügbar.', 'shopofthings' );
            $output .= ' <img src="' . esc_url( get_stylesheet_directory_uri() . '/images/handshake.svg' ) . '" alt="Partner" class="tooltip" data-tooltip="' . $tooltip . '" style="height:1.8em;vertical-align:middle;">';
        }
        echo '<tr><th scope="row">' . esc_html__( 'Marke:', 'shopofthings' ) . '</th><td>' . $output . '</td></tr>';
    }

    // Kategorien
    $cat_row = display_sorted_categories( $product->get_id() );
    if ( $cat_row ) {
        echo '<tr>' . $cat_row . '</tr>';
    }

    // Sensoren & Zertifizierungen
    $sensoren = $product->get_attribute( 'pa_sensores' );
    if ( $sensoren ) {
        display_icon_row( 'Sensoren: ', 'pa_sensores', $sensoren, 'Sensor' );
    }
    $kennzeichen = $product->get_attribute( 'pa_produktkennzeichen' );
    if ( $kennzeichen ) {
        display_icon_row( 'Zertifizierungen: ', 'pa_produktkennzeichen', $kennzeichen, 'Zertifizierung' );
    }

    // Lagerverfügbarkeit (nur bei einfachen Produkten)
    if ( function_exists( 'get_stock_info' ) && ! $product->is_type( 'variable' ) ) {
        $stock_info = get_stock_info( $product );
        echo '<tr id="special-row-stock"><th scope="row">' . esc_html__( 'Verfügbarkeit:', 'shopofthings' ) . '</th>'
           . '<td>' . $stock_info['lieferinfo_html'] . '</td></tr>';
    }

    echo '</tbody></table>';
}
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
add_action( 'woocommerce_single_product_summary', 'sot_show_product_meta_custom', 5 );

/* ==========================================================================
   6. CSS einbinden – nur auf Produktseiten
   ========================================================================== */
add_action( 'wp_enqueue_scripts', function() {
    if ( function_exists( 'is_product' ) && is_product() ) {
        wp_enqueue_style(
            'woocommerce-customizations',
            get_stylesheet_directory_uri() . '/woocommerce-customizations.css',
            [],
            '1.0.12' // Version hochsetzen → Cache neu laden
        );
    }
}, 20 );