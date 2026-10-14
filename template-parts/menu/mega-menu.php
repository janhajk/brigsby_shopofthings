<?php
/**
 * Hauptnavigation – eigenes Mega-Menü
 * Inhalte aus der Admin-Seite „Menü" (Option sot_menu).
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

$menu  = sot_menu();
$items = ! empty( $menu['items'] ) ? (array) $menu['items'] : array();
if ( empty( $items ) ) { return; }
?>
<nav class="sot-nav" aria-label="Hauptnavigation">
    <button type="button" class="sot-nav-toggle" aria-label="Menü" aria-expanded="false">
        <span></span><span></span><span></span>
    </button>

    <ul class="sot-nav-list">
        <?php foreach ( $items as $idx => $item ) :
            if ( array_key_exists( 'enabled', $item ) && empty( $item['enabled'] ) ) {
                continue; // Punkt deaktiviert
            }
            $type     = $item['type'] ?? 'dropdown';
            $label    = $item['label'] ?? '';
            $url      = $item['url'] ?? '';
            $links    = ( 'dropdown' === $type ) ? sot_menu_parse_links( $item['links'] ?? '' ) : array();
            $groups   = ( 'mega' === $type ) ? array_values( (array) ( $item['groups'] ?? array() ) ) : array();
            $has_drop = ( 'dropdown' === $type && ! empty( $links ) );
            $has_mega = ( 'mega' === $type && ! empty( $groups ) );
            $has_panel = $has_drop || $has_mega;
            ?>
            <li class="sot-nav-item type-<?php echo esc_attr( $type ); ?><?php echo $has_panel ? ' has-panel' : ''; ?>">
                <a class="sot-nav-link" href="<?php echo $url ? esc_url( $url ) : '#'; ?>"<?php echo $has_panel ? ' aria-haspopup="true" aria-expanded="false"' : ''; ?>>
                    <?php echo esc_html( $label ); ?>
                    <?php if ( $has_panel ) : ?><span class="sot-nav-caret" aria-hidden="true"></span><?php endif; ?>
                </a>

                <?php if ( $has_drop ) : ?>
                    <div class="sot-nav-dropdown">
                        <ul>
                            <?php foreach ( $links as $l ) : ?>
                                <?php if ( 0 === strpos( $l['label'], '## ' ) ) : // Zwischenüberschrift, Eingabe im Admin: "## Software" ?>
                                <li class="sot-nav-heading" style="padding:10px 16px 4px;margin-top:6px;border-top:1px solid #e3e9f4;font-size:11px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#8a93a5;"><?php echo esc_html( substr( $l['label'], 3 ) ); ?></li>
                                <?php else : ?>
                                <li><a href="<?php echo esc_url( $l['url'] ); ?>"><?php echo esc_html( $l['label'] ); ?></a></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php elseif ( $has_mega ) :
                    $cta            = $item['cta'] ?? array();
                    $featured_items = function_exists( 'sot_menu_featured_items' ) ? sot_menu_featured_items( $item ) : array();
                    $brand_feats    = function_exists( 'sot_menu_featured_brands' ) ? sot_menu_featured_brands() : array();
                    $has_feat       = ! empty( $featured_items );
                    $has_feat_col   = $has_feat || ! empty( $brand_feats );
                    $feat_eyebrow  = '';
                    foreach ( $featured_items as $ff ) {
                        if ( ! empty( $ff['eyebrow'] ) ) {
                            $feat_eyebrow = $ff['eyebrow'];
                            break;
                        }
                    }
                    if ( '' === $feat_eyebrow || 0 === strcasecmp( $feat_eyebrow, 'Top Seller' ) ) {
                        $feat_eyebrow = 'Bestseller';
                    }
                    ?>
                    <div class="sot-nav-mega">
                        <div class="mega-inner<?php echo $has_feat_col ? ' has-featured' : ''; ?>">

                            <div class="mega-groups">
                                <?php foreach ( $groups as $gi => $g ) :
                                    $gpanel = ( 'brands' === sot_menu_category_slug_from_url( $g['url'] ?? '' ) ) ? 'brands' : 'products';
                                    ?>
                                    <button type="button" class="mega-group<?php echo 0 === $gi ? ' active' : ''; ?>" data-target="mega-<?php echo (int) $idx . '-' . (int) $gi; ?>" data-panel="<?php echo esc_attr( $gpanel ); ?>">
                                        <span class="mega-group-icon"><?php echo sot_menu_group_icon_html( $g ); // phpcs:ignore ?></span>
                                        <span class="mega-group-label"><?php echo esc_html( $g['label'] ); ?></span>
                                        <span class="mega-group-arrow" aria-hidden="true">›</span>
                                    </button>
                                <?php endforeach; ?>

                                <?php if ( ! empty( $cta['label'] ) ) : ?>
                                    <a class="mega-cta" href="<?php echo esc_url( $cta['url'] ); ?>"><?php echo esc_html( $cta['label'] ); ?></a>
                                <?php endif; ?>
                            </div>

                            <div class="mega-lists">
                                <?php foreach ( $groups as $gi => $g ) :
                                    $glinks = sot_menu_group_links( $g );
                                    $gcount = count( $glinks );
                                    $gslug  = function_exists( 'sot_menu_category_slug_from_url' ) ? sot_menu_category_slug_from_url( $g['url'] ?? '' ) : '';
                                    $gcols  = 1;
                                    if ( in_array( $gslug, array( 'brands', 'sensorik' ), true ) || $gcount > 8 ) {
                                        $gcols = 2;
                                    }
                                    ?>
                                    <div class="mega-list cols-<?php echo (int) $gcols; ?><?php echo 0 === $gi ? ' active' : ''; ?>" id="mega-<?php echo (int) $idx . '-' . (int) $gi; ?>">
                                        <div class="mega-list-head"><?php echo esc_html( $g['label'] ); ?></div>
                                        <?php if ( ! empty( $g['url'] ) ) : ?>
                                            <a class="mega-list-all" href="<?php echo esc_url( $g['url'] ); ?>"><?php echo esc_html( $g['label'] ); ?> – alle</a>
                                        <?php endif; ?>
                                        <?php
                                        $chunks = ( 2 === $gcols && $gcount > 1 )
                                            ? array_chunk( $glinks, (int) ceil( $gcount / 2 ) )
                                            : array( $glinks );
                                        ?>
                                        <div class="mega-list-grid">
                                            <?php foreach ( $chunks as $chunk ) : ?>
                                                <ul>
                                                    <?php foreach ( $chunk as $l ) : ?>
                                                        <?php sot_menu_echo_sublink( $l ); ?>
                                                    <?php endforeach; ?>
                                                </ul>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <?php if ( $has_feat_col ) : ?>
                                <div class="mega-featured-slot">
                                <?php if ( $has_feat ) : ?>
                                    <div class="mega-featured is-active" data-panel="products">
                                        <div class="mega-featured-head">
                                            <span class="mega-featured-mark" aria-hidden="true"></span>
                                            <span class="mega-featured-eyebrow"><?php echo esc_html( $feat_eyebrow ); ?></span>
                                        </div>
                                        <?php
                                        $fi = 0;
                                        foreach ( $featured_items as $ff ) :
                                            $fsrc = sot_menu_featured_image_url( $ff );
                                            if ( empty( $ff['title'] ) && ! $fsrc ) {
                                                continue;
                                            }
                                            $ftag    = sot_menu_featured_tag( $ff );
                                            $is_lead = ( 0 === $fi );
                                            $fi++;
                                            ?>
                                            <a class="<?php echo $is_lead ? 'mega-featured-lead' : 'mega-featured-item'; ?>" href="<?php echo esc_url( $ff['url'] ?? '' ); ?>">
                                                <?php if ( $fsrc ) : ?>
                                                    <span class="mega-featured-photo">
                                                        <img src="<?php echo esc_url( $fsrc ); ?>" alt="" width="<?php echo $is_lead ? 200 : 48; ?>" height="<?php echo $is_lead ? 160 : 48; ?>" loading="lazy">
                                                    </span>
                                                <?php endif; ?>
                                                <span class="mega-featured-copy">
                                                    <?php if ( ! empty( $ff['title'] ) ) : ?>
                                                        <span class="mega-featured-title"><?php echo esc_html( $ff['title'] ); ?></span>
                                                    <?php endif; ?>
                                                    <?php if ( $ftag ) : ?>
                                                        <span class="mega-featured-tag"><?php echo esc_html( $ftag ); ?></span>
                                                    <?php endif; ?>
                                                </span>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ( $brand_feats ) : ?>
                                    <div class="mega-featured mega-featured-brands" data-panel="brands">
                                        <div class="mega-featured-head">
                                            <span class="mega-featured-mark" aria-hidden="true"></span>
                                            <span class="mega-featured-eyebrow">Bestseller Hersteller</span>
                                        </div>
                                        <?php foreach ( $brand_feats as $bf ) : ?>
                                            <a class="mega-featured-brand is-brand-<?php echo esc_attr( $bf['slug'] ); ?>" href="<?php echo esc_url( $bf['url'] ); ?>">
                                                <?php if ( ! empty( $bf['icon'] ) ) : ?>
                                                    <img src="<?php echo esc_url( $bf['icon'] ); ?>" alt="<?php echo esc_attr( $bf['title'] ); ?>" width="180" height="48" loading="lazy">
                                                <?php else : ?>
                                                    <span class="mega-featured-title"><?php echo esc_html( $bf['title'] ); ?></span>
                                                <?php endif; ?>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>

        <?php /* Nur Mobile: Top-Bar-Inhalte als Links im Hamburger-Menü (oben, vor den Menüpunkten) */ ?>
        <li class="sot-nav-extra"><a href="<?php echo esc_url( function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : '/cart/' ); ?>"><?php echo esc_html( sot_topbar( 'tt_cart', 'Warenkorb' ) ); ?></a></li>
        <li class="sot-nav-extra"><a href="/my-account"><?php echo esc_html( sot_topbar( 'tt_account', 'Mein Konto' ) ); ?></a></li>
        <li class="sot-nav-extra"><a href="<?php echo esc_url( sot_topbar( 'compare_url' ) ); ?>"><?php echo esc_html( sot_topbar( 'compare_text' ) ); ?></a></li>
        <li class="sot-nav-extra"><a href="<?php echo esc_url( sot_topbar( 'request_url' ) ); ?>"><?php echo esc_html( sot_topbar( 'request_text' ) ); ?></a></li>
        <li class="sot-nav-extra sot-nav-extra-lang"><span>Sprache: DE</span></li>
    </ul>
</nav>
