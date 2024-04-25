<?php


// https://storecustomizer.com/woocommerce-shop-page-hooks-visual-guide/
// https://www.businessbloomer.com/woocommerce-add-new-tab-account-page/


/**
 * Brigsby - ShopOfThings
 *
 * @package brigsby-shopofthings
 */


 // checks for woocommerce templates in woocommerce folder
function sot_add_woocommerce_support() {
    add_theme_support( 'woocommerce' ); // <<<< here
}
add_action( 'after_setup_theme', 'sot_add_woocommerce_support' );


// if ( ! defined( 'ABSPATH' ) ) {
// 	exit;
// }
// if ( ! function_exists( 'brigsby_shopofthings_enqueue_styles' ) ):
// 	/**
// 	 * Load CSS file.
// 	 */
//       function brigsby_shopofthings_enqueue_styles() {
//       //     wp_enqueue_style( 'brigsby-shopofthings', trailingslashit( get_stylesheet_directory_uri() ) . 'style.css', array( 'brigsby-style' ), false );
//       }
// endif;
// add_action('wp_enqueue_scripts', 'brigsby_shopofthings_enqueue_styles', 20);


/**
 *
 *
 *
 *
 *
 */
function sot_enqueue_styles() {
    // Registrieren und einbinden der zusätzlichen CSS-Datei
    wp_enqueue_style('sot-single-product', get_stylesheet_directory_uri() . '/woocommerce/single-product/styles.css', array(), '1.0.19', 'all');
    wp_enqueue_style('sot-landing-page-style', get_stylesheet_directory_uri() . '/css/template-landing-page.css', array(), '1.0.4', 'all');

}

add_action('wp_enqueue_scripts', 'sot_enqueue_styles');


function sot_custom_scripts() {
    // Überprüfen Sie, ob Sie auf einer Produktseite sind
    if (is_product()) {
        // Registrieren und Einreihen des Scripts
        wp_enqueue_script('single-product-script', get_stylesheet_directory_uri() . '/woocommerce/single-product/single-product.js', array('jquery'), '1.0.14', true);
    }
}
add_action('wp_enqueue_scripts', 'sot_custom_scripts');


// invoke landing page functions
require get_stylesheet_directory() . '/inc/template-landing-page-functions.php';



/*
 * Remove jetpack ads
 *
 */
add_filter( 'jetpack_just_in_time_msgs', '__return_false' );


/*
* Reduce the strength requirement for woocommerce registration password.
* Strength Settings:
* 0 = Nothing = Anything
* 1 = Weak
* 2 = Medium
* 3 = Strong (default)
*/

add_filter( 'woocommerce_min_password_strength', 'wpglorify_woocommerce_password_filter', 10 );
function wpglorify_woocommerce_password_filter() {
      return 1;
}



/***** Adding Facebook Pixel *****/
add_action('wp_head', 'oiw_add_fbpixel');

function oiw_add_fbpixel() {
?>
<!-- Facebook Pixel Code -->
      <script>
      !function(f,b,e,v,n,t,s)
      {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
      n.callMethod.apply(n,arguments):n.queue.push(arguments)};
      if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
      n.queue=[];t=b.createElement(e);t.async=!0;
      t.src=v;s=b.getElementsByTagName(e)[0];
      s.parentNode.insertBefore(t,s)}(window, document,'script',
      'https://connect.facebook.net/en_US/fbevents.js');
      fbq('init', '2735434730048399');
      fbq('track', 'PageView');
      </script>
      <noscript><img height="1" width="1" style="display:none"
      src="https://www.facebook.com/tr?id=2735434730048399&ev=PageView&noscript=1"
      /></noscript>
<!-- End Facebook Pixel Code -->
<?php
}



/***** Adding LinkedIn Script *****/
// add_action('wp_head', 'oiw_add_linkedin');

function oiw_add_linkedin() {
?>
<script type="text/javascript">
_linkedin_partner_id = "2806769";
window._linkedin_data_partner_ids = window._linkedin_data_partner_ids || [];
window._linkedin_data_partner_ids.push(_linkedin_partner_id);
</script><script type="text/javascript">
(function(){var s = document.getElementsByTagName("script")[0];
var b = document.createElement("script");
b.type = "text/javascript";b.async = true;
b.src = "https://snap.licdn.com/li.lms-analytics/insight.min.js";
s.parentNode.insertBefore(b, s);})();
</script>
<noscript>
<img height="1" width="1" style="display:none;" alt="" src="https://px.ads.linkedin.com/collect/?pid=2806769&fmt=gif" />
</noscript>
<?php
}





/**
 *
 * @snippet       Remove "Description" Title @ WooCommerce Single Product Tabs
 *
 * see https://njengah.com/woocommerce-hide-description-heading/
 */

add_filter( 'woocommerce_product_description_heading', '__return_null' );






/**
 *
 * Auto shorten long titles in product loop
 *
 *
 *
 *
 *
 */
remove_action('woocommerce_shop_loop_item_title','woocommerce_template_loop_product_title',10);
add_action('woocommerce_shop_loop_item_title','sot_custom_loop_title',10);
function sot_custom_loop_title() {
   $MAX_LEN = 60;
   global $product;
   $title = get_the_title();
   $len = strlen($title);
   $link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );
   $title = substr($title, 0, $MAX_LEN);
      if ($len >= $MAX_LEN) {
         $title .= '...';
   }
   echo '<h3 class="' . esc_attr( apply_filters( 'woocommerce_product_loop_title_classes', 'woocommerce-loop-product__title' ) ) . '" style="height:55px;overflow-y:hidden"><a href="' . esc_url( $link ) . '" class="woocommerce-LoopProduct-link-title woocommerce-loop-product__title_ink">' . $title . '</a></h3>';
}




/**
 * Overwrite the 'narrow-left-right' from 6/3/3 to 8/2/2
 * defined in theme brigsby
 *
 *
 *
 *
 */
function hoot_set_current_layout( $sidebar ) {
	$spans = apply_filters( 'hoot_main_layout_spans', array(
		'none' => array(
			'content' => 9,
			'sidebar' => 0,
		),
		'full' => array(
			'content' => 12,
			'sidebar' => 0,
		),
		'full-width' => array(
			'content' => 12,
			'sidebar' => 0,
		),
		'narrow-right' => array(
			'content' => 9,
			'sidebar' => 3,
		),
		'wide-right' => array(
			'content' => 8,
			'sidebar' => 4,
		),
		'narrow-left' => array(
			'content' => 9,
			'sidebar' => 3,
		),
		'wide-left' => array(
			'content' => 8,
			'sidebar' => 4,
		),
		'narrow-left-left' => array(
			'content' => 6,
			'sidebar' => 3,
		),
		'narrow-left-right' => array(
			'content' => 8,
			'sidebar' => 2,
		),
		'narrow-right-left' => array(
			'content' => 6,
			'sidebar' => 3,
		),
		'narrow-right-right' => array(
			'content' => 6,
			'sidebar' => 3,
		),
		'default' => array(
			'content' => 8,
			'sidebar' => 4,
		),
	) );

	/* Set the layout for current view */
	global $hoot_theme;
	$hoot_theme->currentlayout['layout'] = $sidebar;
	if ( isset( $spans[ $sidebar ] ) ) {
		$hoot_theme->currentlayout['content'] = $spans[ $sidebar ]['content'];
		$hoot_theme->currentlayout['sidebar'] = $spans[ $sidebar ]['sidebar'];
	} else {
		$hoot_theme->currentlayout['content'] = $spans['default']['content'];
		$hoot_theme->currentlayout['sidebar'] = $spans['default']['sidebar'];
	}

}



// Change the Number of Columns Displayed Per Page
add_filter( 'loop_shop_columns', 'lw_loop_shop_columns' );

function lw_loop_shop_columns( $columns ) {
 $columns = 4;
 return $columns;
}



//add_filter('woocommerce_get_price_html', 'sot_custom_price_exkl_mwst', $price, 10, 2);
// function sot_custom_price_exkl_mwst($price, $instance) {
//     return $price . '<br/><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">CHF</span>'.round(wc_get_price_excluding_tax($instance),2).' </bdi></span><small class="woocommerce-price-suffix">exkl. MWST</small>';
// }




/**
 *
 *
 * Show number of items in cart
 *
 *
 *
 *
 *
 */





add_shortcode ('woo_cart_but', 'woo_cart_but' );
/**
 * Create Shortcode for WooCommerce Cart Menu Item
 */
function woo_cart_but() {
        ob_start();

        $cart_count = WC()->cart->cart_contents_count; // Set variable for cart item count
        $cart_url = wc_get_cart_url();  // Set Cart URL

        ?>
        <li><a class="menu-item cart-contents" href="<?php echo $cart_url; ?>" title="Warenkorb">
            <?php
        if ( $cart_count > 0 ) {
       ?>
            <span class="cart-contents-count"><?php echo $cart_count; ?></span>
        <?php
        }
        ?>
        </a></li>
        <?php

    return ob_get_clean();

}

add_filter( 'woocommerce_add_to_cart_fragments', 'woo_cart_but_count' );
/**
 * Add AJAX Shortcode when cart contents update
 */
function woo_cart_but_count( $fragments ) {

    ob_start();

    $cart_count = WC()->cart->cart_contents_count;
    $cart_url = wc_get_cart_url();

    ?>
    <a class="cart-contents menu-item" href="<?php echo $cart_url; ?>" title="<?php _e( 'Warenkorb' ); ?>">
        <?php
    if ( $cart_count > 0 ) {
        ?>
        <span class="cart-contents-count"><?php echo $cart_count; ?></span>
        <?php
    }

    $fragments['a.cart-contents'] = ob_get_clean();

    return $fragments;
}
add_filter( 'wp_nav_menu_primary_items', 'woo_cart_but_icon', 10, 2 ); // Change menu to suit - example uses 'top-menu'




/**
 * Add WooCommerce Cart Menu Item Shortcode to particular menu
 */
function woo_cart_but_icon ( $items, $args ) {
       $items .=  '[woo_cart_but]'; // Adding the created Icon via the shortcode already created

       return $items;
}



/**
 *
 * Add B2B Javascript
 *
 * inkl. MWST / exkl. MWST Buttons
 *
 *
 */
function shopofthings_add_b2b_script() {
      // Register js file
      wp_register_script( 'shopofthings-b2b', get_stylesheet_directory_uri().'/b2b.js', false, '1.10', true );

      // Enqueue the registered script file
      wp_enqueue_script('shopofthings-b2b');
}

// add script
// add_action('wp_enqueue_scripts', 'shopofthings_add_b2b_script');






/**
 *
 * Titel vor Bundled Items
 *
 *
 *
 */

//  add_action('woocommerce_before_bundled_items', 'sot_bundled_options_title', 20);
//  function sot_bundled_options_title() {
//        echo '<h3 style="border-bottom:1px solid rgba(0,0,0,0.1);padding-bottom:10px;">Zusätzliche Optionen</h3>';
//  }


/**
 * hide similar products
 *
 */
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );




// define the woocommerce_product_upsells_products_heading callback
// function sot_woocommerce_product_upsells_products_heading( $__ ){
//     return $__; //'Wird of zusammen gekauft';
// }

//add the action
// add_filter('woocommerce_product_upsells_products_heading', 'sot_woocommerce_product_upsells_products_heading', 10, 1)





/**
 *
 * Change add to cart icon
 *
 *
 *
 *
 */

add_filter('woocommerce_product_add_to_cart_text','sot_customize_add_to_cart_button_woocommerce');
function sot_customize_add_to_cart_button_woocommerce(){
      return '&#128722;';
      // return __('Add to cart', 'woocommer');
}




/**
 *
 * ??
 *
 *
 *
 */
add_action( 'sot_woocommerce_before_shop_loop_item_item', 'woocommerce_template_loop_product_link_open', 10 );










// YITH Scrolling Bug Fix
// See: https://wordpress.org/support/topic/problem-with-product-filters-for-woocommerce/
if ( ! function_exists( 'yith_infs_customization_wc_product_filters' ) ) {
	add_action( 'wp_enqueue_scripts', 'yith_infs_customization_wc_product_filters', 99 );
	function yith_infs_customization_wc_product_filters() {
		$js = "( function( $ ){
				$( window ).on( 'wcpf_before_ajax_filtering', function(){
					$( window ).unbind( 'yith_infs_start' );
				});

				$( window ).on( 'wcpf_after_ajax_filtering', function(){
					$( yith_infs.contentSelector ).yit_infinitescroll( infinite_scroll );
				});
                   } )( jQuery );";
		wp_add_inline_script( 'yith-infs', $js );
	}
}



/**
 * Log database queries to the /wp-content/sql.log file.
 *
 * @link https://wordpress.stackexchange.com/a/144353/90061
 */
// add_filter( 'query', function( $query ){

// 	// Filter out everything that shouldn't be logged.
// // 	if (
// // 		stripos( $query, 'SELECT' ) !== FALSE ||
// // 		stripos( $query, 'SHOW' ) !== FALSE ||
// // 		stripos( $query, '_transient_' ) !== FALSE ||
// // 		stripos( $query, 'iap517_yoast_notifications' ) !== FALSE ||
// // 		stripos( $query, "WHERE `option_name` = 'cron'" ) !== FALSE ||
// // 		stripos( $query, 'iap517_actionscheduler' ) !== FALSE ||
// // 		stripos( $query, 'action_scheduler' ) !== FALSE
// // 	) {
// // 		return $query;
// // 	}

// 	$file =  WP_CONTENT_DIR . '/sql.log'; // Edit this filepath.
// 	@file_put_contents(
// 		$file,
// 		date( 'c' ) . ' - ' . $query . PHP_EOL,
// 		FILE_APPEND | LOCK_EX
// 	);

//     return $query;
// }, PHP_INT_MAX );



require get_stylesheet_directory() . '/woocommerce-customizations.php';




// disable lazy loading
add_filter('wp_lazy_loading_enabled', '__return_false');
