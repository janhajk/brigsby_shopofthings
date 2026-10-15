<?php
/**
 * Startseite – gemeinsames Rendering der Sektionen.
 * Wird von front-page.php (echte Startseite) und vom Seiten-Template
 * page-frontpage-test.php (Vorschau) genutzt.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

$multi = function_exists( 'sot_fp_langs' ) && function_exists( 'sot_lp_multi_script' );
$langs = $multi ? sot_fp_langs() : array( 'de' );
?>
<main id="main-content" class="sot-frontpage">
<?php if ( $multi ) : ?><div class="sot-lp-multi" data-langs="<?php echo esc_attr( implode( ',', $langs ) ); ?>"><?php endif; ?>
    <?php
    foreach ( $langs as $lang ) {
        $GLOBALS['sot_fp_lang'] = $lang;
        $fp    = function_exists( 'sot_fp' ) ? sot_fp() : array();
        $order = ! empty( $fp['section_order'] ) ? (array) $fp['section_order'] : array();
        if ( $multi ) {
            echo '<div class="sot-lp-variant" data-lang="' . esc_attr( $lang ) . '" lang="' . esc_attr( array( 'de' => 'de-CH', 'fr' => 'fr-CH', 'it' => 'it-CH', 'en' => 'en' )[ $lang ] ) . '"' . ( 'de' === $lang ? '' : ' hidden' ) . '>';
        }
        foreach ( $order as $slug ) {
            if ( empty( $fp['sections'][ $slug ] ) ) {
                continue; // Sektion ausgeblendet
            }
            echo '<span id="sektion-' . esc_attr( $slug ) . ( 'de' === $lang ? '' : '-' . $lang ) . '" class="sot-fp-anchor" aria-hidden="true"></span>';
            get_template_part( 'template-parts/frontpage/' . $slug );
        }
        if ( $multi ) {
            echo '</div>';
        }
    }
    unset( $GLOBALS['sot_fp_lang'] );
    ?>
<?php if ( $multi ) : ?></div><?php echo sot_lp_multi_script(); endif; ?>
</main>
