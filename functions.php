<?php

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


// // Right Sidebar
// function shopofthings_register_sidebars() {

//     /* Register first sidebar name Primary Sidebar */
//     register_sidebar(
//         array(
//             'name'          => __( 'Right Shop Sidebar' ),
//             'id'            => 'shop-sidebar-right',
//             'description' => __( 'Shop Sidebar right' ),
//             'before_widget' => '<section id="%1$s" class="widget %2$s">',
//             'after_widget' => '</section>',
//             'before_title' => '<h2 class="widget-title">',
//             'after_title' => '</h2>'
//         )
//     );
// }
// add_action( 'widgets_init', 'shopofthings_register_sidebars' );


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



add_filter( 'woocommerce_get_availability', 'wcs_custom_get_availability', 1, 2);
function wcs_custom_get_availability( $availability, $_product ) {
  $DEFAULT_BIG_STOCK_THRESHOLD = 20;
  $DEFAULT_LOW_STOCK_THRESHOLD = 2;
  $id = $_product->get_id();
    $product_stock = $_product->get_stock_quantity();
    if($product_stock){
      $big_stock_available = get_post_meta($id,'product_bigstock_threshold',true);
      $low_stock_available = get_post_meta($id,'product_lowstock_threshold',true);
      if(($big_stock_available != '' && $product_stock > $big_stock_available)){
         $availability['availability'] = __('>'.$big_stock_available.' sofort versandbereit', 'woocommerce');
      }
      else if(($lowstock_available != '' && $product_stock <= $lowstock_available)){
         $availability['availability'] = __('Nur noch '.$product_stock.' auf Lager', 'woocommerce');
      }
      else if ($product_stock >= $DEFAULT_BIG_STOCK_THRESHOLD) {
            $availability['availability'] = __('>'.$DEFAULT_BIG_STOCK_THRESHOLD.' sofort versandbereit', 'woocommerce');
      }
      else if ($product_stock < $DEFAULT_LOW_STOCK_THRESHOLD) {
            $availability['availability'] = __('Nur noch '.$product_stock.' auf Lager', 'woocommerce');
      }
    }
    return $availability;
}


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
   echo '<h3 class="' . esc_attr( apply_filters( 'woocommerce_product_loop_title_classes', 'woocommerce-loop-product__title' ) ) . '" style="height:55px"><a href="' . esc_url( $link ) . '" class="woocommerce-LoopProduct-link-title woocommerce-loop-product__title_ink">' . $title . '</a></h3>';
}

?>