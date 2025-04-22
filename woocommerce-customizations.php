<?php

// JavaScript zum Kopieren von Text in die Zwischenablage und für Tooltips
$translatedString = __('SKU kopiert', 'shopofthings');
define('COPY_TO_CLIPBOARD_AND_TOOLTIP_JS', <<<JS
<script>
function copyToClipboard(element) {
    var text = element.innerText;
    var textarea = document.createElement('textarea');
    textarea.value = text;
    document.body.appendChild(textarea);
    textarea.select();
    document.execCommand('copy');
    document.body.removeChild(textarea);
    alert('{$translatedString}');
}

jQuery(document).ready(function($) {
    // Tooltip erstellen
    $('.tooltip').hover(
        function() {
            // Beim Hovern
            var tooltipText = $(this).data('tooltip');
            $('<div class="tooltip-box">' + tooltipText + '</div>').appendTo('body').fadeIn('fast');
            positionTooltip($(this));
        },
        function() {
            // Beim Verlassen
            $('.tooltip-box').remove();
        }
    );

    // Tooltip-Positionierung
    function positionTooltip(element) {
        var pos = element.offset();
        var width = $('.tooltip-box').outerWidth();
        var height = $('.tooltip-box').outerHeight();
        $('.tooltip-box').css({
            top: pos.top - height - 10, // 10px Abstand über dem Element
            left: pos.left + element.outerWidth() / 2 - width / 2 // Zentriert
        });
    }

    // Tooltip bei Fenstergrößenänderung neu positionieren
    $(window).resize(function() {
        $('.tooltip').each(function() {
            if ($('.tooltip-box').length) {
                positionTooltip($(this));
            }
        });
    });
});
</script>
JS
);

/**
 * Format content on single product page before price (sku, herstellernummer, categories)
 */
function skuToSpelling($sku) {
    if (!isSKU($sku)) {
        return 'Ungültige SKU';
    }

    $mapping = array(
        '3' => 'three',
        '4' => 'four',
        '7' => 'seven',
        'A' => 'alpha',
        'E' => 'echo',
        'H' => 'hotel',
        'J' => 'juliet',
        'L' => 'lima',
        'N' => 'november',
        'Q' => 'quebec',
        'R' => 'romeo',
        'T' => 'tango',
        'U' => 'uniform',
        'Y' => 'yankee'
    );

    $characters = str_split($sku);
    $spelledOutSKU = array();

    foreach ($characters as $character) {
        if (isset($mapping[$character])) {
            $spelledOutSKU[] = $mapping[$character];
        }
    }

    return implode(' / ', $spelledOutSKU);
}

function isSKU($sku) {
    $pattern = '/^[347AEHJLNQRTUY]{4}$/';
    return preg_match($pattern, $sku);
}


/**
 * Gibt eine formatierte Zeile zurück, die alle Produktkategorien des angegebenen Produkts
 * in einer sortierten und hierarchisch strukturierten Weise als Tags darstellt.
 */
function display_sorted_categories($product_id) {
    $terms = wp_get_post_terms($product_id, 'product_cat', array("fields" => "all"));
    
    if (is_wp_error($terms)) {
        return 'Fehler beim Abrufen der Kategorien';
    }

    $brands_term = get_term_by('slug', 'brands', 'product_cat');
    $solution_package_term = get_term_by('slug', 'solution-package', 'product_cat');
    $sensorik_term = get_term_by('slug', 'sensorik', 'product_cat');

    if (is_wp_error($brands_term) || is_wp_error($solution_package_term) || is_wp_error($sensorik_term)) {
        return 'Fehler beim Abrufen der Kategorien';
    }

    $brands_term_id = $brands_term->term_id;
    $solution_package_id = $solution_package_term->term_id;
    $sensorik_term_id = $sensorik_term->term_id;
    $sensorik_children = get_term_children($sensorik_term_id, 'product_cat');

    if (is_wp_error($sensorik_children)) {
        return 'Fehler beim Abrufen der Kategorien';
    }

    $sensorik_all_terms = array_merge([$sensorik_term_id], $sensorik_children);
    $all_tags = array();

    foreach ($terms as $term) {
        if (is_wp_error($term)) {
            continue;
        }
        if ($term->term_id == $brands_term_id || $term->parent == $brands_term_id) {
            continue;
        }
        if (in_array($term->term_id, $sensorik_all_terms)) {
            continue;
        }
        if ($term->parent == 0 && !get_term_children($term->term_id, 'product_cat') && $term->term_id != $solution_package_id) {
            continue;
        }

        // Nur Blattkategorien (ohne Kinder) anzeigen
        if (!get_term_children($term->term_id, 'product_cat')) {
            $term_link = get_term_link($term, 'product_cat');
            if (is_wp_error($term_link)) {
                continue;
            }
            $all_tags[] = '<a href="' . esc_url($term_link) . '" class="category-tag">' . esc_html($term->name) . '</a>';
        }
    }

    sort($all_tags);
    
    // Füge das CSS für die farblosen Tags ein
    $output = '<style>
        .category-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
        }
        .category-tag {
            display: inline-block;
            color: #333;
            padding: 2px 10px;
            margin: 2px;
            border: 1px solid #ccc;
            border-radius: 15px;
            font-size: 0.9em;
            text-decoration: none;
            transition: color 0.3s;
        }
        .category-tag:hover {
            color: #006064;
            text-decoration: underline;
        }
    </style>';

    $output .= '<th scope="row">' . __('Kategorien:', 'textdomain') . '</th><td><div class="category-tags">' . join('', $all_tags) . '</div></td>';
    return $output;
}

function display_icon_row($title, $taxonomy, $attribute, $alt_text) {
    $terms = explode(', ', $attribute);
    $thumbnail_elements = [];
    $no_thumbnail_elements = [];

    foreach ($terms as $term_name) {
        $term = get_term_by('name', $term_name, $taxonomy);
        if ($term) {
            $thumbnail_id = get_term_meta($term->term_id, 'product_search_image_id', true);
            $thumbnail_url = wp_get_attachment_url($thumbnail_id);
            $term_link = get_term_link($term);
            // Hole die Beschreibung des Terms
            $term_description = term_description($term->term_id, $taxonomy);
            // Entferne HTML-Tags aus der Beschreibung für den Tooltip
            $clean_description = wp_strip_all_tags($term_description);
            // Erstelle den Tooltip-Inhalt: Term-Name als Titel (fett) und Beschreibung
            $tooltip_content = '<strong>' . esc_html($term_name) . '</strong><br>' . esc_html($clean_description);

            if ($thumbnail_url) {
                $thumbnail_elements[$term_name] = '<a href="' . esc_url($term_link) . '" class="icon-link text-link tooltip" data-tooltip="' . esc_attr($tooltip_content) . '"><img src="' . esc_url($thumbnail_url) . '" alt="' . esc_attr($alt_text) . '" class="icon-image"></a>';
            } else {
                $no_thumbnail_elements[] = '<a href="' . esc_url($term_link) . '" class="text-link tooltip" data-tooltip="' . esc_attr($tooltip_content) . '">' . esc_html($term_name) . '</a>';
            }
        }
    }

    ksort($thumbnail_elements);
    sort($no_thumbnail_elements);
    $all_elements = array_merge(array_values($thumbnail_elements), $no_thumbnail_elements);

    if (!empty($all_elements)) {
        echo '<tr class="special-row"><th scope="row">' . esc_html($title) . '</th><td class="special-row-icons"><div>' . implode(' ', $all_elements) . '</div></td></tr>';
    }
}

/**
 * Move Meta data (categorie, sku) to top of single-product page
 */
function sot_show_product_meta_custom() {
    global $product;

    echo COPY_TO_CLIPBOARD_AND_TOOLTIP_JS; // Das JS-Script einfügen

    // Start der Tabelle
    echo '<table class="product-meta-table"><tbody>';

    // SKU Anzeige
    $sku = $product->get_sku();
    if ($sku) {
        if (isSKU($sku)) {
            echo '<tr><th scope="row">' . __('SKU:', 'shopofthings') . '</th><td><span class="sku tooltip" data-tooltip="' . esc_attr(skuToSpelling($sku)) . '" onclick="copyToClipboard(this)">' . $sku . '</span></td></tr>';
        } else {
            echo '<tr><th scope="row">' . __('SKU:', 'shopofthings') . '</th><td><span class="sku tooltip" data-tooltip="' . esc_attr__('SKU kopieren', 'shopofthings') . '" onclick="copyToClipboard(this)">' . $sku . '</span></td></tr>';
        }
    }

    // Herstellernummer Anzeige
    $herstellernummer = $product->get_attribute('pa_herstellernummer');
    if ($herstellernummer) {
        echo '<tr><th scope="row">' . __('P/N:', 'shopofthings') . '</th><td>' . $herstellernummer . '</td></tr>';
    }

    // Marke Anzeige
    $marke = $product->get_attribute('pa_brand');
    $partner_brands = array(
        'elsys', 'rakwireless', 'abeeway', 'adnexo', 'atim', 'circuitmess', 'decentlab',
        'reolink', 'seeedstudio', 'small data garden', 'smart aal', 'strega', 'swisscom',
        'tektelic', 'ttgo', 'adeunis', 'digital matter', 'enginko', 'mclimate', 'milesight iot',
        'miromico', 'nano sensorics', 'netvox', 'panorama', 'teltonika', 'nexelec'
    );

    if ($marke) {
        $marke_link = get_term_link($marke, 'pa_brand');
        echo '<tr><th scope="row">' . __('Marke:', 'shopofthings') . '</th><td><a href="' . esc_url($marke_link) . '">' . $marke . '</a>';

        // Überprüfen, ob die Marke in der Partner-Liste ist
        if (in_array(strtolower($marke), $partner_brands)) {
            $tooltip_text = __('Partner dieser Marke: Mengenrabatte und direkter Support verfügbar.', 'shopofthings');
            echo ' <img src="' . esc_url(get_stylesheet_directory_uri() . '/images/handshake.svg') . '" alt="Partner" class="tooltip" data-tooltip="' . esc_attr($tooltip_text) . '" style="height:1.8em; vertical-align:middle;">';
        }

        echo '</td></tr>';
    }

    // Kategorien Anzeige
    echo '<tr>' . display_sorted_categories($product->get_id()) . '</tr>';

    // Sensoren Anzeige (mit icon)
    $sensoren = $product->get_attribute('pa_sensores');
    if ($sensoren) {
        display_icon_row('Sensoren: ', 'pa_sensores', $sensoren, "Sensoren Thumbnail");
    }

    // Produktkennzeichen Anzeige (mit icon)
    $produktkennzeichen = $product->get_attribute('pa_produktkennzeichen');
    if ($produktkennzeichen) {
        display_icon_row('Zertifizierungen: ', 'pa_produktkennzeichen', $produktkennzeichen, "Produktkennzeichen Thumbnail");
    }

    // Lagerverfügbarkeit
    $stock_info = get_stock_info($product);

    if (!$product->is_type('variable')) {
        echo '<tr id="special-row-stock"><th scope="row">' . __('Verfügbarkeit:', 'shopofthings') . '</th><td>' . $stock_info['lieferinfo_html'] . '</td></tr>';
    }

    // Ende der Tabelle
    echo '</tbody></table>';
}

// Filter für Verfügbarkeitsanzeige
add_filter('woocommerce_get_availability', 'remove_default_stock_display', 1, 2);
function remove_default_stock_display($availability, $_product) {
    if ($_product->is_type('variation')) {
        $stock_info = get_stock_info($_product);
        $availability['availability'] = $stock_info['lieferinfo_html'];
    }
    return $availability;
}

remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
add_action('woocommerce_single_product_summary', 'sot_show_product_meta_custom', 5);

function enqueue_custom_styles() {
    if (is_product()) {
        wp_enqueue_style('woocommerce-customizations', get_stylesheet_directory_uri() . '/woocommerce-customizations.css', array(), '1.0.10');
        // Inline-CSS für Tooltips hinzufügen
        wp_add_inline_style('woocommerce-customizations', '
            .tooltip {
                position: relative;
                cursor: pointer;
                display: inline-block;
            }
            .tooltip-box {
                position: absolute;
                background: #69b3e7; /* Mittel-hellblau */
                color: var(--wc-primary-text, #fff);
                padding: 10px 14px;
                border-radius: 4px;
                font-size: 13px;
                z-index: 1000;
                display: none;
                max-width: 250px;
                text-align: left;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
                line-height: 1.4;
            }
            .tooltip-box strong {
                font-size: 14px;
                display: block;
                margin-bottom: 5px;
            }
            .tooltip-box::after {
                content: "";
                position: absolute;
                top: 100%;
                left: 50%;
                margin-left: -5px;
                border: 5px solid transparent;
                border-top-color: #69b3e7; /* Mittel-hellblau für den Pfeil */
            }
        ');
    }
}
add_action('wp_enqueue_scripts', 'enqueue_custom_styles');