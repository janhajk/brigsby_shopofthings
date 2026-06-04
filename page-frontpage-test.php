<?php
/*
Template Name: Startseite (ShopOfThings)
*/
/**
 * Startseite – Theme-gesteuert.
 *
 * Inhalte werden im Admin unter „Startseite" gepflegt (siehe
 * inc/frontpage/frontpage-settings.php). Die Sektionen liegen als
 * Partials in template-parts/frontpage/ und werden hier in der im
 * Admin festgelegten Reihenfolge und Sichtbarkeit ausgegeben.
 *
 * Als echte Startseite verwenden: Einstellungen → Lesen →
 * „Eine statische Seite" → diese Seite wählen.
 */

get_header();

$fp    = function_exists( 'sot_fp' ) ? sot_fp() : array();
$order = ! empty( $fp['section_order'] ) ? (array) $fp['section_order'] : array();
?>

<main id="main-content" class="sot-frontpage">
    <?php
    foreach ( $order as $slug ) {
        if ( empty( $fp['sections'][ $slug ] ) ) {
            continue; // Sektion ausgeblendet
        }
        // Anker-Ziel für seiteninterne Links (#sektion-<slug>)
        echo '<span id="sektion-' . esc_attr( $slug ) . '" class="sot-fp-anchor" aria-hidden="true"></span>';
        get_template_part( 'template-parts/frontpage/' . $slug );
    }
    ?>
</main>

<?php get_footer(); ?>
