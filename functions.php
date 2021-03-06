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
 * Stock status in Product Loop
 *
 * $_product obejct documentation: https://www.businessbloomer.com/woocommerce-easily-get-product-info-title-sku-desc-product-object
 *
 *
 * returns array(
 *    circle: <dom> for circle,
 *    availability: <dom> for availability,
 *    onorder: <dom>
 * )
 *
 */
 function get_stock_info ($_product) {

      $_UNICODE_CIRCLE = '';
      $_UNICODE_CIRCLE_BULLET = '&#10687;';
      $_UNICODE_CIRCLE_HALF = '&#9681;';
      $_UNICODE_CIRCLE_FILLED ='&#9679;';
      $_UNICODE_CIRCLE_CROSS = '&#11199;';
      $_UNICODE_UNKNOWN = '&#65533;';

      $_HTML_AVAILABLE = '<span style="color:#73c44d;font-size:2em"> '.$_UNICODE_CIRCLE_FILLED.'</span>';
      $_HTML_AVAILABLE_PARTLY = '<span style="color:#73c44d;font-size:1.5em"> '.$_UNICODE_CIRCLE_BULLET.'</span>';
      $_HTML_BACKORDER = '<span style="color:#73c44d;font-size:1.5em">'.$_UNICODE_CIRCLE_HALF.'</span>';
      $_HTML_UNAVAILABLE = '<span style="color:rgb(0, 85, 157);font-size:1.5em">'.$_UNICODE_CIRCLE_CROSS.'</span>';
      $_HTML_UNKNOWN = '<span style="color:rgb(0, 85, 157);font-size:1.5em">'.$_UNICODE_UNKNOWN.'</span';


      // Default Values
      $DEFAULT_BIG_STOCK_THRESHOLD = 10;
      $DEFAULT_LOW_STOCK_THRESHOLD = 10;

      // Product ID
      $id = $_product->get_id();

      // return values
      $availability = '';
      $circle = '';


      // virtual products are always available
      if ($_product->get_virtual()) {
            return array(
                  'circle'      => $_HTML_AVAILABLE,
                  'availability'=> 'sofort verfügbar',
                  'onorder'     => ''
            );
      }


      // Stock Quantity of current product
      $product_stock = $_product->get_stock_quantity();

      // Backordered / on the way
      $onorder = get_post_meta($id,'shopofthings_onorder',true);
      if ($onorder == '') $onorder = 0; // default value
      if ($product_stock < 0) $onorder = $onorder + $product_stock;
      $onorder_txt = ((int) $onorder > 0) ? '<br/>'.$onorder.' Stück unterwegs von unserem Lieferanten': '';


      // if not on stock and backorder
      if($product_stock <= 0) {
            $lieferzeit = get_post_meta($id, 'shopofthings_lieferzeit', true); // returns '' (empty string) if not set
            if ($lieferzeit == '') $lieferzeit = 20; // default value

            // no stock but can backorder
            if ($_product->get_backorders() != 'no') {
                  $availability = 'Ab externem Lager. Lieferzeit ca. '.$lieferzeit. ' Tage';
                  $circle = $_HTML_BACKORDER;
            }
            // TODO: simple is not correctly displaying data for variable products
            else if ($_product->get_type() != 'simple') {
                  $availability = 'Teilweise an eigenem Lager. Bitte Option wählen.';
                  $circle = $_HTML_AVAILABLE_PARTLY;

                  // show bundles as available if on thing is available
                  if ($_product->get_type() == 'bundle') {
                      $availability = 'Sofort versandbereit ab unserem Lager';
                      $circle = $_HTML_AVAILABLE;
                  }
            }
            // no backorder and no stock
            else {
                  $availability = 'Momentan nicht an Lager';;
                  $circle = $_HTML_UNAVAILABLE;
            }
            return array(
                  'circle'      => $circle,
                  'availability'=> $availability,
                  'onorder'     => $onorder_txt
            );
      }

      // no availability or = zero return regular
      if(!$product_stock) {
            return array(
                  'circle'      => $_HTML_UNKNOWN,
                  'availability'=> 'unbekannt',
                  'onorder'     => $onorder_txt
            );
      }



      // Products that are available

      if ($product_stock > 0){
            $availability = 'Sofort versandbereit ab unserem Lager';
            $circle = $_HTML_AVAILABLE;
      }

      // retrieve thresolds
      $big_stock_available = get_post_meta($id,'product_bigstock_threshold',true);
      $low_stock_available = get_post_meta($id,'product_lowstock_threshold',true);
      if ($big_stock_available== '') $big_stock_available = $DEFAULT_BIG_STOCK_THRESHOLD;
      if ($low_stock_available== '') $low_stock_available = $DEFAULT_LOW_STOCK_THRESHOLD;


      if($product_stock >= $big_stock_available){
            $availability = $big_stock_available.'+ Stück sofort versandbereit ab unserem Lager';
      }
      else if($product_stock <= $low_stock_available){
            $availability = $product_stock.' Stück ab unserem Lager';
      }
      return array(
            'circle'      => $circle,
            'availability'=> $availability,
            'onorder'     => $onorder_txt
      );
}


function sot_loop_item_stock() {
      global $product;
      // if ($product->get_id() == 4986 || $product->get_id() == 16448) {
            $info = get_stock_info($product);
            echo '<div style="float:right;position:absolute;top:7px;right:12px" title="'.$info['availability'].'">'.$info['circle'].'</div>';
      // }
}
add_action( 'woocommerce_before_shop_loop_item_title', 'sot_loop_item_stock', 20, 2);


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
      $info = get_stock_info($_product);
      $availability['availability'] = join($info, '&nbsp;');
      return $availability;
}






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
 *
 */
function shopofthings_add_b2b_script() {
      // Register js file
      wp_register_script( 'shopofthings-b2b', get_stylesheet_directory_uri().'/b2b.js', false, '1.5', true );

      // Enqueue the registered script file
      wp_enqueue_script('shopofthings-b2b');
}

// add script
add_action('wp_enqueue_scripts', 'shopofthings_add_b2b_script');



/**
 *
 * Add tracking number to order on order-view
 *
 *
 *
 *
 */

add_action( 'woocommerce_view_order', 'sot_order_view_add_tracking', 20 );
add_action( 'woocommerce_admin_order_data_after_order_details', 'sot_display_tracking' );

function sot_order_view_add_tracking( $order_id ){
    $POST_LINK = "https://service.post.ch/ekp-web/ui/entry/search/";
    $metafield = get_post_meta( $order_id, 'shopofthings_sendungsnummer', true );
    if (empty($metafield)) return;
    $metafield = json_decode($metafield, true);
    // old values from the olden days have to be turned into array
    if (!is_array($metafield)) {
          $metafield = array($metafield);
    } ?>
    <h4>Tracking Nummer</h4>
    <table class="woocommerce-table shop_table">
        <tbody>
            <?php for ($i = 0; $i < count($metafield); $i++) { ?>
            <tr>
                <td>Paket <?php echo ($i+1); ?>:</td>
                <td><a href="<?php echo $POST_LINK; echo $metafield[$i]; ?>" target="_blank"><?php echo $metafield[$i]; ?></a></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <?php
}

// display the extra data in the order admin panel
function sot_display_tracking( $order ){  ?>
    <?php $tn = get_post_meta( $order->id, 'shopofthings_sendungsnummer', true );
    $tn = json_decode($tn, true);
    if ($tn) { ?>
          <div class="order_data_column">
              <h4><?php __( 'Versand' ); ?></h4>

              <?php echo '<p><strong>' . __( 'Sendungsnummer' ) . ':</strong>' . '<a href="https://service.post.ch/ekp-web/ui/entry/search/' . $tn  .'" target="_blank">' . $tn  . '</a></p>'; ?>
          </div>
    <?php } ?>
<?php }





/**
 *
 * Add Credential link to order
 *
 *
 *
 *
 */
add_action( 'woocommerce_view_order', 'sot_order_view_add_credentials', 20 );

function sot_order_view_add_credentials( $order_id ){
    $metafield = get_post_meta( $order_id, 'shopofthings_credentials_url', true );
    if ($metafield) { ?>
    <h4>Device Credentials</h4>
    <table class="woocommerce-table shop_table">
        <tbody>
            <tr>
                <td>URL</td>
                <td><a href="<?php echo $metafield; ?>" target="_blank"><?php echo $metafield; ?></a></td>
            </tr>
        </tbody>
    </table>
    <?php }
}




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
  * Move  Meta data (categorie, sku) to top of single-product page
  *
  *
  *
  *
  */
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
add_action( 'woocommerce_single_product_summary', 'sot_show_categories_again_single_product', 1 );

function sot_show_categories_again_single_product() {
   global $product;
   ?>
<div class="product_meta">

	<?php do_action( 'woocommerce_product_meta_start' ); ?>

	<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>

		<span class="sku_wrapper"><?php esc_html_e( 'SKU:', 'woocommerce' ); ?> <span class="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'woocommerce' ); ?></span></span>

	<?php endif; ?>

	<?php echo wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in">' . _n( 'Category:', 'Categories:', count( $product->get_category_ids() ), 'woocommerce' ) . ' ', '</span>' ); ?>

	<?php echo wc_get_product_tag_list( $product->get_id(), ', ', '<span class="tagged_as">' . _n( 'Tag:', 'Tags:', count( $product->get_tag_ids() ), 'woocommerce' ) . ' ', '</span>' ); ?>

	<?php do_action( 'woocommerce_product_meta_end' ); ?>

</div>
   <?php
}



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
 *
 *
 *
 *
 */
add_action( 'sot_woocommerce_before_shop_loop_item_item', 'woocommerce_template_loop_product_link_open', 10 );




/**
 *
 * add Lorawan connectivity warning on categories for lorawan
 *
 *
 *
 *
 */
add_action( 'woocommerce_after_add_to_cart_form', 'sot_after_add_to_cart_form_connectivity' );

function sot_after_add_to_cart_form_connectivity(){
      global $product;
      $ids = $product->get_category_ids();
      if (in_array(653, $ids) && $product->get_id() !== 14069 && $product->get_id() !== 14192 && $product->get_id() !== 18505) { // lorawan, swsscom connectivity abo
            if (!in_array(1182, $ids) && !in_array(1248, $ids) && !in_array(1179, $ids) ) { // exclude antenna, gateway, zubehör
                  if ($product->get_type() != 'subscription') { // exclude
                  	?>
                  	<div class="sot_info_box">
                                    <span class="sot_kapital">!</span>
                                    Um diese Gerät zu betreiben, brauchst Du ein LoRaWAN. Dies kannst Du mittels eines <a href="https://shopofthings.ch/produkt-kategorie/typ/gateway/">LoRaWAN Gateways</a> selber erstellen, Du kannst das <a href="https://shopofthings.ch/shop/connectivity-2/connectivity-lorawan/loriot-lpn-lorawan-connectivity-abo-jaehrlicher-renewal/">LORIOT</a> oder TTN Netzwerk benutzen respektive das Schweizweit flächendeckende <a href="https://shopofthings.ch/shop/connectivity-2/connectivity-lorawan/1-jahr-swisscom-lpn-lorawan-connectivity-abo-yearly-payment">Swisscom LoRaWAN</a> verwenden. Alle Netze sind bei uns buchbar.
                        </div>
                  	<?php
                  }
            }
      }
}










/**
 * @snippet       WooCommerce Add New Tab @ My Account
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @compatible    WooCommerce 5.0
 */

// ------------------
// 1. Register new endpoint (URL) for My Account page
// Note: Re-save Permalinks or it will give 404 error

function sot_add_devices_endpoint() {
    add_rewrite_endpoint( 'devices', EP_ROOT | EP_PAGES );
}

add_action( 'init', 'sot_add_devices_endpoint' );

// ------------------
// 2. Add new query var

function sot_devices_query_vars( $vars ) {
    $vars[] = 'devices';
    return $vars;
}

add_filter( 'query_vars', 'sot_devices_query_vars', 0 );

// ------------------
// 3. Insert the new endpoint into the My Account menu
// with "YITH Customize my Account" Plugin, the link must be activated seprately

function sot_add_devices_link_my_account( $menu_links ) {
      $menu_links = array_slice( $menu_links, 0, 5, true )
	+ array( 'devices' => 'LoRaWAN Devices' )
	+ array_slice( $menu_links, 5, NULL, true );

	return $menu_links;
}

add_filter( 'woocommerce_account_menu_items', 'sot_add_devices_link_my_account', 99, 1 );

// ------------------
// 4. Add content to the new tab

function sot_devices_content() {
   $devices = get_user_meta(get_current_user_id(), 'sot_devices');
   if (!count($devices)) return;

   $devices = json_decode($devices[0]);
   echo "<h1>Under construction. Coming soon...</h1><br/>";
   echo "Du hast ".sizeof($devices). " Devices in deinem Account hinterlegt";
//    echo "<pre>".print_r($devices, 1)."</pre>";

   ?>
    <h4>Deine Devices</h4>
    <table class="woocommerce-table shop_table">
         <thead>
               <tr><th>devEUI</th><th>appEUI</th><th>appKey</th></tr>
         </thead>
        <tbody>
            <?php for ($i = 0; $i < count($devices); $i++) { ?>
            <tr>
                <td><?php echo $devices[$i]->devEui; ?></td>
                <td><?php echo $devices[$i]->appEui; ?></td>
                <td><?php echo $devices[$i]->devEui; ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <?php
}

// Note: add_action must follow 'woocommerce_account_{your-endpoint-slug}_endpoint' format
add_action( 'woocommerce_account_devices_endpoint', 'sot_devices_content' );




?>