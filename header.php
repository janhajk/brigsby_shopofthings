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
            <div class="sot-topbar-content">

                <!-- Linke Seite: Infos -->
                <div class="sot-topbar-left">
                    <span class="sot-flag">🇨🇭</span>
                    Schweizer Lager – Versand innert 48 h
                    <span class="sot-phone">
                        <a href="tel:+41625304800">+41 62 530 48 00</a>
                    </span>
                </div>

                <!-- Rechte Seite: Icons + Buttons -->
                <div class="sot-topbar-right">
                    <a href="/suche" class="sot-icon"><i class="fas fa-search"></i></a>
                    <!--<a href="/wunschliste" class="sot-icon"><i class="far fa-heart"></i></a>-->
                    <a href="/cart" class="sot-icon sot-cart">
                        <i class="fas fa-shopping-cart"></i>
                        <?php if (function_exists('woocommerce_mini_cart') && WC()->cart->get_cart_contents_count() > 0): ?>
                            <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                        <?php endif; ?>
                    </a>
                    <span class="sot-language">DE</span>
                    <a href="/compare" class="sot-btn sot-btn-compare">Produktvergleich</a>
                    <a href="/angebot-anfordern" class="sot-btn sot-btn-request">Angebot anfordern</a>
                </div>

            </div>
        </div>
    </div>
    <!-- ENDE FIXED TOP-BAR -->

    <?php get_template_part( 'template-parts/topbar' ); // Falls du den originalen Topbar noch behalten willst – sonst entfernen ?>

    <header <?php hybridextend_attr( 'header' ); ?>>

        <?php hoot_secondary_menu( 'top' ); ?>

        <div <?php hybridextend_attr( 'header-part', 'primary' ); ?>>
            <div class="hgrid">
                <div class="table hgrid-span-12">
                    <?php hoot_header_branding(); ?>
                    <?php hoot_header_aside(); ?>
                </div>
            </div>
        </div>

        <?php hoot_secondary_menu( 'bottom' ); ?>

    </header>

    <?php hybridextend_get_sidebar( 'below-header' ); ?>

    <div <?php hybridextend_attr( 'main' ); ?>>
        <?php do_action( 'hoot_template_main_wrapper_start' ); ?>