<?php
/**
 * Template modification Hooks
 */
$display_loop_meta = apply_filters( 'hoot_display_loop_meta', true );
do_action ( 'hoot_default_loop_meta', 'start' );

if ( !$display_loop_meta )
	return;

/**
 * If viewing a single post/page (including frontpage not using Widgetized Template :redundant)
 */
if ( is_singular() ) :

	if ( have_posts() ) :

		// Begins the loop through found posts, and load the post data.
		while ( have_posts() ) : the_post();

			$display_title = apply_filters( 'hoot_loop_meta_display_title', '', 'singular' );
			if ( $display_title !== 'hide' ) :
			?>

				<div <?php hybridextend_attr( 'loop-meta-wrap', 'singular' ); ?>>
					<div class="hgrid">

						<div <?php hybridextend_attr( 'loop-meta', '', 'hgrid-span-12' ); ?>>
							<div class="entry-header">

								<?php
								global $post;
								$pretitle = ( !isset( $post->post_parent ) || empty( $post->post_parent ) ) ? '' : '<span class="loop-pretitle">' . get_the_title( $post->post_parent ) . ' &raquo; </span>';
								$pretitle = apply_filters( 'hoot_loop_pretitle_singular', $pretitle );
								?>
								<h1 <?php hybridextend_attr( 'loop-title' ); ?>><?php the_title( $pretitle ); ?></h1>

							</div><!-- .entry-header -->
						</div><!-- .loop-meta -->

					</div>
				</div>

			<?php
			global $hoot_theme;
			$hoot_theme->loop_meta_displayed = true;
			endif;

		endwhile;
		rewind_posts();

	endif;

endif;

/**
 * Template modification Hooks
 */
do_action ( 'hoot_default_loop_meta', 'end' );
