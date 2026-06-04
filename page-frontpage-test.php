<?php
/*
Template Name: Startseite (ShopOfThings)
*/
/**
 * Startseite – Seiten-Template (Vorschau unter /test-startseite).
 * Rendert dieselben Sektionen wie die echte Startseite (front-page.php)
 * über das gemeinsame Partial template-parts/frontpage/render.php.
 * Inhalte werden im Admin unter „Startseite" gepflegt.
 */

get_header();
get_template_part( 'template-parts/frontpage/render' );
get_footer();
