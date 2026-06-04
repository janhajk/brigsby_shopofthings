<?php
/**
 * front-page.php – echte Startseite (statische Front-Page).
 *
 * Muss im Child-Theme existieren, sonst nutzt WordPress die front-page.php
 * des Parent-Themes (brigsby) und unser Startseiten-Design erscheint nicht.
 * Rendert dieselben Sektionen wie das Seiten-Template (siehe render.php),
 * gesteuert über die Admin-Seite „Startseite" (Option sot_frontpage).
 */

get_header();
get_template_part( 'template-parts/frontpage/render' );
get_footer();
