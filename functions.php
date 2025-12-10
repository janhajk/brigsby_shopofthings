<?php
/**
 * Brigsby - ShopOfThings Child Theme
 * Kompatibel mit WordPress 6.9 + WooCommerce 10.4+ (Dezember 2025)
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/* ==========================================================================
   1. WooCommerce Support + Grundlagen
   ========================================================================== */
add_action( 'after_setup_theme', function() {
    add_theme_support( 'woocommerce' );
} );

/* ==========================================================================
   2. CSS & JS einbinden
   ========================================================================== */
add_action( 'wp_enqueue_scripts', function() {
    // Allgemeine Styles (immer laden)
    wp_enqueue_style(
        'sot-single-product',
        get_stylesheet_directory_uri() . '/woocommerce/single-product/styles.css',
        [],
        '1.0.21'
    );

    wp_enqueue_style(
        'sot-landing-page-style',
        get_stylesheet_directory_uri() . '/css/template-landing-page.css',
        [],
        '1.0.5'
    );

    // Nur auf Produktseiten: Custom JS
    if ( function_exists( 'is_product' ) && is_product() ) {
        wp_enqueue_script(
            'single-product-script',
            get_stylesheet_directory_uri() . '/woocommerce/single-product/single-product.js',
            [ 'jquery' ],
            '1.0.15',
            true
        );
    }

    // B2B Script (falls du es wieder aktivieren willst)
    // wp_enqueue_script( 'shopofthings-b2b', get_stylesheet_directory_uri() . '/b2b.js', [], '1.10', true );

}, 20 );

/* ==========================================================================
   3. Landing Page Functions einbinden
   ========================================================================== */
if ( file_exists( get_stylesheet_directory() . '/inc/template-landing-page-functions.php' ) ) {
    require_once get_stylesheet_directory() . '/inc/template-landing-page-functions.php';
}

/* ==========================================================================
   4. Diverse WooCommerce Anpassungen
   ========================================================================== */

// Jetpack Werbung deaktivieren
add_filter( 'jetpack_just_in_time_msgs', '__return_false' );

// Schwächere Passwortstärke bei Registrierung
add_filter( 'woocommerce_min_password_strength', function() { return 1; } );

// Beschreibung-Titel auf Produktseite entfernen
add_filter( 'woocommerce_product_description_heading', '__return_null' );

// Titel in Shop-Loop kürzen
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
add_action( 'woocommerce_shop_loop_item_title', 'sot_custom_loop_title', 10 );
function sot_custom_loop_title() {
    global $product;
    $title = get_the_title();
    $max   = 60;

    if ( strlen( $title ) > $max ) {
        $title = substr( $title, 0, $max ) . '...';
    }

    $link = apply_filters( 'woocommerce_loop_product_link', get_permalink(), $product );

    echo '<h3 class="' . esc_attr( apply_filters( 'woocommerce_product_loop_title_classes', 'woocommerce-loop-product__title' ) ) . '" style="height:55px;overflow-y:hidden">'
       . '<a href="' . esc_url( $link ) . '" class="woocommerce-LoopProduct-link-title woocommerce-loop-product__title_ink">'
       . esc_html( $title )
       . '</a></h3>';
}

// 4 Spalten im Shop
add_filter( 'loop_shop_columns', function() { return 4; } );

// Warenkorb-Icon im Menü (Shortcode + AJAX)
add_shortcode( 'woo_cart_but', 'woo_cart_but' );
function woo_cart_but() {
    $count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
    $url   = wc_get_cart_url();

    ob_start(); ?>
    <li><a class="menu-item cart-contents" href="<?php echo esc_url( $url ); ?>" title="Warenkorb">
        <?php if ( $count > 0 ) : ?>
            <span class="cart-contents-count"><?php echo (int) $count; ?></span>
        <?php endif; ?>
    </a></li>
    <?php
    return ob_get_clean();
}

add_filter( 'woocommerce_add_to_cart_fragments', 'woo_cart_but_count' );
function woo_cart_but_count( $fragments ) {
    ob_start(); ?>
    <a class="cart-contents menu-item" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="Warenkorb">
        <?php if ( WC()->cart && WC()->cart->get_cart_contents_count() > 0 ) : ?>
            <span class="cart-contents-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
        <?php endif; ?>
    </a>
    <?php
    $fragments['a.cart-contents'] = ob_get_clean();
    return $fragments;
}

add_filter( 'wp_nav_menu_primary_items', function( $items ) {
    return $items . '[woo_cart_but]';
}, 10, 2 );

// Add-to-Cart-Button Text → Warenkorb-Symbol
add_filter( 'woocommerce_product_add_to_cart_text', function() {
    return '🛒';
});
add_filter( 'woocommerce_product_single_add_to_cart_text', function() {
    return '🛒 In den Warenkorb';
});

// Related Products ausblenden
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

/* ==========================================================================
   5. YITH Infinite Scroll + Product Filters Fix (wichtig!)
   ========================================================================== */
add_action( 'wp_enqueue_scripts', 'yith_infs_customization_wc_product_filters', 99 );
function yith_infs_customization_wc_product_filters() {
    if ( ! class_exists( 'YITH_WCAN' ) || ! function_exists( 'yith_infs_init' ) ) {
        return;
    }

    $js = "(function($){
        $(window).off('wcpf_before_ajax_filtering yith_infs_start');
        $(window).on('wcpf_before_ajax_filtering', function(){
            $(window).off('yith_infs_start');
        });
        $(window).on('wcpf_after_ajax_filtering', function(){
            if (typeof yith_infs !== 'undefined') {
                $(yith_infs.contentSelector).yit_infinitescroll(yith_infs);
            }
        });
    })(jQuery);";

    wp_add_inline_script( 'yith-infs', $js );
}

/* ==========================================================================
   6. Lazy Loading komplett deaktivieren (wie gewünscht)
   ========================================================================== */
add_filter( 'wp_lazy_loading_enabled', '__return_false' );

/* ==========================================================================
   7. WooCommerce Customizations einbinden (deine große Datei von vorhin)
   ========================================================================== */
if ( file_exists( get_stylesheet_directory() . '/woocommerce-customizations.php' ) ) {
    require_once get_stylesheet_directory() . '/woocommerce-customizations.php';
}