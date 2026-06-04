<!DOCTYPE html>
<html <?php language_attributes( 'html' ); ?> class="no-js">

<head>
<?php wp_head(); ?>
</head>

<body <?php hybridextend_attr( 'body' ); ?>>

<?php wp_body_open(); ?>

<a href="#main" class="screen-reader-text"><?php _e( 'Skip to content', 'brigsby' ); ?></a>

<div <?php hybridextend_attr( 'page-wrapper' ); ?>>

    <?php do_action( 'hoot_template_site_start' ); ?>

    <!-- DEIN NEUER FIXED TOP-BAR -->
    <div class="sot-topbar-fixed">
        <div class="hgrid">
            <div class="sot-topbar-content hgrid-span-12">

                <!-- Linke Seite: Infos -->
                <div class="sot-topbar-left">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24" height="24" viewBox="0 0 30 30" preserveAspectRatio="xMidYMid meet" version="1.0" class="sot-flag-svg">
                        <defs><clipPath id="id1"><path d="M 2.054688 6.183594 L 27.460938 6.183594 L 27.460938 22.875 L 2.054688 22.875 Z M 2.054688 6.183594 " clip-rule="nonzero"/></clipPath></defs>
                        <g clip-path="url(#id1)"><path fill="rgb(91.369629%, 29.40979%, 20.779419%)" d="M 2.066406 9.3125 C 2.066406 7.585938 3.484375 6.183594 5.242188 6.183594 L 24.273438 6.183594 C 26.03125 6.183594 27.453125 7.585938 27.453125 9.3125 L 27.453125 19.746094 C 27.453125 21.476562 26.03125 22.875 24.273438 22.875 L 5.242188 22.875 C 3.488281 22.875 2.066406 21.476562 2.066406 19.746094 Z M 2.066406 9.3125 " fill-opacity="1" fill-rule="evenodd"/></g>
                        <path fill="rgb(100%, 100%, 100%)" d="M 13.171875 9.835938 L 16.34375 9.835938 L 16.34375 19.226562 L 13.171875 19.226562 Z M 13.171875 9.835938 " fill-opacity="1" fill-rule="evenodd"/>
                        <path fill="rgb(100%, 100%, 100%)" d="M 10 12.964844 L 19.519531 12.964844 L 19.519531 16.09375 L 10 16.09375 Z M 10 12.964844 " fill-opacity="1" fill-rule="evenodd"/>
                    </svg>
                    <?php echo esc_html( sot_topbar( 'info_text' ) ); ?>
                    <?php if ( sot_topbar( 'phone' ) ) : ?>
                    <span class="sot-phone">
                        <a href="tel:<?php echo esc_attr( sot_topbar_tel( sot_topbar( 'phone' ) ) ); ?>"><?php echo esc_html( sot_topbar( 'phone' ) ); ?></a>
                    </span>
                    <?php endif; ?>
                </div>

                <!-- Rechts: Icons + Buttons + Toggle-Suche -->
                <div class="sot-topbar-right">
                    <!-- Lupe: Toggle für dein Search-Widget -->
                    <a href="#" class="sot-icon sot-search-toggle" aria-label="Suche" data-tooltip="<?php echo esc_attr( sot_topbar( 'tt_search' ) ); ?>">
                        <i class="fas fa-search"></i>
                        <i class="fas fa-times sot-search-close" style="display:none;"></i>
                    </a>

                    <!-- DROPDOWN SUCHE: Nur aus unserem neuen dedizierten Bereich -->
                    <div class="sot-search-dropdown">
                        <?php if (function_exists('dynamic_sidebar') && is_active_sidebar('sot-topbar-search')): ?>
                            <?php dynamic_sidebar('sot-topbar-search'); ?>
                        <?php endif; ?>
                    </div>

                    <!-- Wunschliste -->
                    <!--<a href="<?php echo wc_get_cart_url(); ?>?wishlist" class="sot-icon">
                        <i class="far fa-heart"></i>
                    </a>-->

                    <!-- WooCommerce Mini-Cart (dynamisch mit Count) -->
                    <a href="<?php echo wc_get_cart_url(); ?>" class="sot-icon sot-cart" aria-label="<?php echo esc_attr( sot_topbar( 'tt_cart' ) ); ?>" data-tooltip="<?php echo esc_attr( sot_topbar( 'tt_cart' ) ); ?>">
                        <i class="fas fa-shopping-cart"></i>
                        <?php if (WC()     ->cart->get_cart_contents_count() > 0): ?>
                            <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                        <?php endif; ?>
                    </a>
                    <a href="/my-account" class="sot-icon" aria-label="<?php echo esc_attr( sot_topbar( 'tt_account' ) ); ?>" data-tooltip="<?php echo esc_attr( sot_topbar( 'tt_account' ) ); ?>"><i class="far fa-user"></i></a>

                    <!-- Sprache -->
                    <span class="sot-language" data-tooltip="<?php echo esc_attr( sot_topbar( 'tt_language' ) ); ?>">DE</span>

                    <!-- Buttons -->
                    <a href="<?php echo esc_url( sot_topbar( 'compare_url' ) ); ?>" class="sot-btn sot-btn-compare" data-tooltip="<?php echo esc_attr( sot_topbar( 'compare_tooltip' ) ); ?>"><?php echo esc_html( sot_topbar( 'compare_text' ) ); ?></a>
                    <a href="<?php echo esc_url( sot_topbar( 'request_url' ) ); ?>" class="sot-btn sot-btn-request" data-tooltip="<?php echo esc_attr( sot_topbar( 'request_tooltip' ) ); ?>"><?php echo esc_html( sot_topbar( 'request_text' ) ); ?></a>
                </div>

            </div>
        </div>
    </div>
    <!-- ENDE TOP-BAR -->

    <!-- Rest des Brigsby-Headers (unverändert) -->
    <?php get_template_part( 'template-parts/topbar' ); ?>

    <header <?php hybridextend_attr( 'header' ); ?>>
        <div <?php hybridextend_attr( 'header-part', 'primary' ); ?>>
            <div class="hgrid">
                <div class="sot-header-row">
                    <?php hoot_header_branding(); ?>
                    <?php get_template_part( 'template-parts/menu/mega-menu' ); ?>
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile: Suchfeld unterhalb des Headers (Search-Widget wird per JS hierher verschoben) -->
    <div id="sot-mobile-search" aria-label="Suche"></div>

    <?php hybridextend_get_sidebar( 'below-header' ); ?>

    <div <?php hybridextend_attr( 'main' ); ?>>
        <?php do_action( 'hoot_template_main_wrapper_start' ); ?>