<?php
/**
 * Startseite – Hero
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

$fp          = sot_fp();
$hero_img_id = absint( $fp['hero_image'] );
$hero_src    = $hero_img_id ? wp_get_attachment_image_url( $hero_img_id, 'large' ) : get_stylesheet_directory_uri() . '/images/hero01.png';
$hero_alt    = $hero_img_id ? get_post_meta( $hero_img_id, '_wp_attachment_image_alt', true ) : 'ShopOfThings – IoT für die Schweiz';
$badges      = array_values( array_filter( (array) $fp['hero_badges'], 'strlen' ) );
?>
<section class="sot-hero">
    <div class="hgrid hero-grid">

        <div class="hero-text hgrid-span-7 hgrid-span-tablet-12">
            <?php if ( ! empty( $fp['hero_subtitle'] ) ) : ?>
                <p class="hero-subtitle"><?php echo esc_html( $fp['hero_subtitle'] ); ?></p>
            <?php endif; ?>

            <?php if ( ! empty( $fp['hero_title'] ) ) : ?>
                <h1 class="hero-title"><?php echo wp_kses_post( $fp['hero_title'] ); ?></h1>
            <?php endif; ?>

            <div class="hero-buttons">
                <?php if ( ! empty( $fp['hero_btn1_text'] ) ) : ?>
                    <a href="<?php echo esc_url( $fp['hero_btn1_url'] ); ?>" class="btn btn-primary"><?php echo esc_html( $fp['hero_btn1_text'] ); ?></a>
                <?php endif; ?>
                <?php if ( ! empty( $fp['hero_btn2_text'] ) ) : ?>
                    <a href="<?php echo esc_url( $fp['hero_btn2_url'] ); ?>" class="btn btn-secondary"><?php echo esc_html( $fp['hero_btn2_text'] ); ?></a>
                <?php endif; ?>
            </div>

            <?php if ( ! empty( $badges ) ) : ?>
                <div class="hero-badges">
                    <?php foreach ( $badges as $i => $badge ) : ?>
                        <span class="badge">
                            <span class="badge-icon"><?php echo sot_fp_badge_icon( $i ); // statische SVGs ?></span>
                            <span class="badge-text"><?php echo esc_html( $badge ); ?></span>
                        </span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="hero-image hgrid-span-5 hgrid-span-tablet-12">
            <img src="<?php echo esc_url( $hero_src ); ?>" alt="<?php echo esc_attr( $hero_alt ); ?>" loading="eager" fetchpriority="high" width="560" height="612">
            <span class="hero-water" aria-hidden="true"></span>
            <span class="hero-bridge" aria-hidden="true">
                <span class="bm bm-car bm-lr"></span>
                <span class="bm bm-person bm-rl"></span>
                <span class="bm bm-person bm-lr"></span>
                <span class="bm bm-car bm-rl"></span>
                <span class="bm bm-person bm-lr"></span>
                <span class="bm bm-person bm-rl"></span>
            </span>
        </div>

    </div>
</section>
