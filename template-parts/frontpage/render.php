<?php
/**
 * Startseite – gemeinsames Rendering der Sektionen.
 * Wird von front-page.php (echte Startseite) und vom Seiten-Template
 * page-frontpage-test.php (Vorschau) genutzt.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

$fp    = function_exists( 'sot_fp' ) ? sot_fp() : array();
$order = ! empty( $fp['section_order'] ) ? (array) $fp['section_order'] : array();
?>
<main id="main-content" class="sot-frontpage">
    <?php
    foreach ( $order as $slug ) {
        if ( empty( $fp['sections'][ $slug ] ) ) {
            continue; // Sektion ausgeblendet
        }
        echo '<span id="sektion-' . esc_attr( $slug ) . '" class="sot-fp-anchor" aria-hidden="true"></span>';
        get_template_part( 'template-parts/frontpage/' . $slug );
    }
    ?>
</main>
