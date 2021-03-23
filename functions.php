<?php


// https://storecustomizer.com/woocommerce-shop-page-hooks-visual-guide/


/**
 * Brigsby - ShopOfThings
 *
 * @package brigsby-shopofthings
 */


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



// require_once '/var/www/vhosts/jan/shopofthings/wordpress/wp-content/geoip/vendor/autoload.php';
// use GeoIp2\Database\Reader;
function createAdsenseBlogResponsive() {
    $ad = '';

    // // This creates the Reader object, which should be reused across
    // // lookups.
    // $reader = new Reader('/var/www/vhosts/jan/shopofthings/wordpress/wp-content/geoip/GeoLite2-Country_20190205/GeoLite2-Country.mmdb');


    // if (!isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    //     $IP = $_SERVER['REMOTE_ADDR'];
    // }
    // else {
    //     $IP = $_SERVER['HTTP_X_FORWARDED_FOR'];
    // }
    // $record = $reader->country($IP);
    // $ISO = $record->country->isoCode;

    // if (!in_array($ISO, array('CH', 'LI'))) {
        $ad = '<div align="center">
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Blog_Ad -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-9031640881990657"
     data-ad-slot="1335518191"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script></div>
             ';
    // }
    $ad = '';
    return $ad;
}
add_shortcode('adsenseBlogResponsive', 'createAdsenseBlogResponsive');



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


/***** Adding Facebook Pixel *****/
add_action('wp_head', 'oiw_add_linkedin');

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
 * Woocommerce Availability
 *
 *
 * $_product obejct documentation: https://www.businessbloomer.com/woocommerce-easily-get-product-info-title-sku-desc-product-object
 *
 */
add_filter( 'woocommerce_get_availability', 'wcs_custom_get_availability', 1, 2);
function wcs_custom_get_availability( $availability, $_product ) {

      $_UNICODE_CIRCLE_BULLET = '&#10687;';
      $_UNICODE_CIRCLE_HALF = '&#9681;';
      $_UNICODE_CIRCLE_FILLED ='&#9679;';
      $_UNICODE_CIRCLE_CROSS = '&#11199;';

      $_HTML_AVAILABLE = '<span style="color:#73c44d;font-size:1.5em"> '.$_UNICODE_CIRCLE_FILLED.'</span>&nbsp;';
      $_HTML_BACKORDER = '<span style="color:#73c44d;font-size:1.5em">'.$_UNICODE_CIRCLE_HALF.'</span>&nbsp;';
      $_HTML_UNAVAILABLE = '<span style="color:rgb(0, 85, 157);font-size:1.5em">'.$_UNICODE_CIRCLE_CROSS.'</span>&nbsp;';

      // Default Values
      $DEFAULT_BIG_STOCK_THRESHOLD = 10;
      $DEFAULT_LOW_STOCK_THRESHOLD = 10;

      // Product ID
      $id = $_product->get_id();

      // Stock Quantity of current product
      $product_stock = $_product->get_stock_quantity();

      // Backordered / on the way
      $onorder = get_post_meta($id,'shopofthings_onorder',true);
      if ($product_stock < 0) $onorder = $onorder + $product_stock;
      $onorder_txt = ($onorder != '' && (int) $onorder > 0) ? '<br/>'.$onorder.' Stück unterwegs von unserem Lieferanten': '';

      // don't change anything for virtual products
      if ($_product->get_virtual()) {
            return $availability;
      }


      // if not on stock and backorder
      if($product_stock <= 0) {
            $lieferzeit = get_post_meta($id,'shopofthings_lieferzeit',true);
            // no stock but can backorder
            if ($_product->get_backorders() != 'no') {
                  $availability['availability'] = $_HTML_BACKORDER.__('Ab externem Lager', 'woocommerce').'. Lieferzeit ca. '.(($lieferzeit == '') ? '20' : $lieferzeit). ' Tage';
            }
            // no backorder and no stock
            else {
                  $availability['availability'] = $_HTML_UNAVAILABLE.__('Momentan nicht an Lager', 'woocommerce');
            }
            // also if negative do nothing (prevents from returning negative stock)

            $availability['availability'] .= $onorder_txt;
            return $availability;
      }

      // no availability or = zero return regular
      if(!$product_stock) return $availability;

      // retrieve thresolds
      $big_stock_available = get_post_meta($id,'product_bigstock_threshold',true);
      $low_stock_available = get_post_meta($id,'product_lowstock_threshold',true);


      if(($big_stock_available != '' && $product_stock >= $big_stock_available)){
            $availability['availability'] = $_HTML_AVAILABLE.__($big_stock_available.'+ Stück sofort versandbereit ab unserem Lager', 'woocommerce');
      }
      else if(($lowstock_available != '' && $product_stock <= $lowstock_available)){
            $availability['availability'] = $_HTML_AVAILABLE.__($product_stock.' Stück ab unserem Lager', 'woocommerce');
      }
      else if ($product_stock >= $DEFAULT_BIG_STOCK_THRESHOLD) {
            $availability['availability'] = $_HTML_AVAILABLE.__($DEFAULT_BIG_STOCK_THRESHOLD.'+ Stück sofort versandbereit ab unserem Lager', 'woocommerce');
      }
      else if ($product_stock < $DEFAULT_LOW_STOCK_THRESHOLD) {
            $availability['availability'] = $_HTML_AVAILABLE.__($product_stock.' Stück ab unserem Lager', 'woocommerce');
      }
      else if ($product_stock > 0){
                        $availability['availability'] = $_HTML_AVAILABLE.__('Sofort versandbereit ab unserem Lager', 'woocommerce');
      }
      $availability['availability'] .= $onorder_txt;
    return $availability;
}



/**
 * 
 * Stock status in Product Loop
 * 
 * 
 * 
 * 
 */
functin sot_loop_item_stock($params, $product) {
      if ($product->get_id() == 4986) {
            print_r($params);
      }
      return $params;
}
add_filter( 'woocommerce_before_shop_loop_item_title', 'sot_loop_item_stock', 20, 2);





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
 * OVerwrite the 'narrow-left-right' from 6/3/3 to 8/2/2
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
function sot_custom_price_exkl_mwst($price, $instance) {
    return $price . '<br/><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">CHF</span>'.round(wc_get_price_excluding_tax($instance),2).' </bdi></span><small class="woocommerce-price-suffix">exkl. MWST</small>';
}




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
 *
 */
function shopofthings_add_b2b_script() {
      // Register js file
      wp_register_script( 'shopofthings-b2b', get_stylesheet_directory_uri().'/b2b.js', false, '1.2', true );

      // Enqueue the registered script file
      wp_enqueue_script('shopofthings-b2b');
}

// add script
add_action('wp_enqueue_scripts', 'shopofthings_add_b2b_script');




?>