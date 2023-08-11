<?php
/*
Template Name: Landing Pages
Template Post Type: page
*/
?>


<?php

// variables from metabox in page editor
if (is_page_template('page-templates/template-landing-page.php')) {
    $padding = get_post_meta(get_the_ID(), '_landing_page_padding', true);
    $width = get_post_meta(get_the_ID(), '_landing_page_width', true);
    $custom_css = "<style>
        #page-wrapper {
            max-width: {$width}px;
        }
        #main {
        	padding: {$padding}em;
        }
        </style>";
    echo $custom_css;
}


// Loads the header.php template.
get_header();
?>

<?php
// Dispay Loop Meta at top
hoot_display_loop_title_content( 'pre', 'single.php' );
if ( hoot_page_header_attop() ) {
	// get_template_part( 'template-parts/loop-meta' ); // Loads the template-parts/loop-meta.php template to display Title Area with Meta Info (of the loop)
	hoot_display_loop_title_content( 'post', 'single.php' );
}

// Template modification Hook
do_action( 'hoot_template_before_content_grid', 'single.php' );
?>

<div class="hgrid main-content-grid landing-page">

	<?php
	// Template modification Hook
	do_action( 'hoot_template_before_main', 'single.php' );
	?>

	<main <?php hybridextend_attr( 'content' ); ?>>

		<?php
		// Template modification Hook
		do_action( 'hoot_template_main_start', 'single.php' );

		// Checks if any posts were found.
		if ( have_posts() ) :

			// Dispay Loop Meta in content wrap
			if ( ! hoot_page_header_attop() ) {
				hoot_display_loop_title_content( 'post', 'single.php' );
				get_template_part( 'template-parts/loop-meta' ); // Loads the template-parts/loop-meta.php template to display Title Area with Meta Info (of the loop)
			}
			?>

			<div id="content-wrap">

				<?php
				// Template modification Hook
				do_action( 'hoot_loop_start', 'single.php' );

				// Display Featured Image if present
				if ( hoot_get_mod( 'post_featured_image' ) ) {
					$img_size = apply_filters( 'hoot_post_image_single', '' );
					hoot_post_thumbnail( 'entry-content-featured-img', $img_size, true );
				}

				// Begins the loop through found posts, and load the post data.
				while ( have_posts() ) : the_post();

					// Loads the template-parts/content-{$post_type}.php template.
					hybridextend_get_content_template();

				// End found posts loop.
				endwhile;

				// Template modification Hook
				do_action( 'hoot_loop_end', 'single.php' );
				?>

			</div><!-- #content-wrap -->

			<?php
			// Loads the template-parts/loop-nav.php template.
			if ( hoot_get_mod( 'post_prev_next_links' ) )
				get_template_part( 'template-parts/loop-nav' );

			// Template modification Hook
			do_action( 'hoot_template_after_content_wrap', 'single.php' );

			// Loads the comments.php template
			if ( !is_attachment() ) {
				comments_template( '', true );
			};

		// If no posts were found.
		else :

			// Loads the template-parts/error.php template.
			get_template_part( 'template-parts/error' );

		// End check for posts.
		endif;

		// Template modification Hook
		do_action( 'hoot_template_main_end', 'single.php' );
		?>

	</main><!-- #content -->

	<?php
	// Template modification Hook
	do_action( 'hoot_template_after_main', 'single.php' );
	?>

	<!-- Removed the sidebar.php template call -->

</div><!-- .hgrid -->

<?php get_footer(); // Loads the footer.php template. ?>
