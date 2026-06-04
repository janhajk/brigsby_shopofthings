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
                                <li><a href="<?php echo esc_url( $l['url'] ); ?>"><?php echo esc_html( $l['label'] ); ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php elseif ( $has_mega ) :
                    $featured = $item['featured'] ?? array();
                    $cta      = $item['cta'] ?? array();
                    $has_feat = ! empty( $featured['title'] ) || ! empty( $featured['image'] );
                    ?>
                    <div class="sot-nav-mega">
                        <div class="mega-inner">

                            <div class="mega-groups">
                                <?php foreach ( $groups as $gi => $g ) :
                                    $icon = ! empty( $g['icon'] ) ? wp_get_attachment_image( absint( $g['icon'] ), 'thumbnail', false, array( 'alt' => '' ) ) : ''; ?>
                                    <button type="button" class="mega-group<?php echo 0 === $gi ? ' active' : ''; ?>" data-target="mega-<?php echo (int) $idx . '-' . (int) $gi; ?>">
                                        <span class="mega-group-icon"><?php echo $icon ? $icon : sot_menu_default_icon(); // phpcs:ignore ?></span>
                                        <span class="mega-group-label"><?php echo esc_html( $g['label'] ); ?></span>
                                        <span class="mega-group-arrow" aria-hidden="true">›</span>
                                    </button>
                                <?php endforeach; ?>

                                <?php if ( ! empty( $cta['label'] ) ) : ?>
                                    <a class="mega-cta" href="<?php echo esc_url( $cta['url'] ); ?>"><?php echo esc_html( $cta['label'] ); ?></a>
                                <?php endif; ?>
                            </div>

                            <div class="mega-lists">
                                <?php foreach ( $groups as $gi => $g ) : ?>
                                    <ul class="mega-list<?php echo 0 === $gi ? ' active' : ''; ?>" id="mega-<?php echo (int) $idx . '-' . (int) $gi; ?>">
                                        <?php if ( ! empty( $g['url'] ) ) : ?>
                                            <li class="mega-list-all"><a href="<?php echo esc_url( $g['url'] ); ?>"><?php echo esc_html( $g['label'] ); ?> – alle</a></li>
                                        <?php endif; ?>
                                        <?php foreach ( sot_menu_parse_links( $g['links'] ?? '' ) as $l ) : ?>
                                            <li><a href="<?php echo esc_url( $l['url'] ); ?>"><?php echo esc_html( $l['label'] ); ?></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endforeach; ?>
                            </div>

                            <?php if ( $has_feat ) : ?>
                                <a class="mega-featured" href="<?php echo esc_url( $featured['url'] ); ?>">
                                    <?php if ( ! empty( $featured['eyebrow'] ) ) : ?><span class="mega-featured-eyebrow"><?php echo esc_html( $featured['eyebrow'] ); ?></span><?php endif; ?>
                                    <?php if ( ! empty( $featured['image'] ) ) { echo wp_get_attachment_image( absint( $featured['image'] ), 'medium', false, array( 'class' => 'mega-featured-img', 'alt' => '' ) ); } ?>
                                    <?php if ( ! empty( $featured['title'] ) ) : ?><span class="mega-featured-title"><?php echo esc_html( $featured['title'] ); ?></span><?php endif; ?>
                                </a>
                            <?php endif; ?>

                        </div>
                    </div>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>
