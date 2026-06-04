<?php
/**
 * Startseite – Aktuelles aus dem Blog
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
$fp = sot_fp();

$news = new WP_Query( array(
    'post_type'           => 'post',
    'post_status'         => 'publish',
    'posts_per_page'      => max( 1, absint( $fp['news_count'] ) ),
    'ignore_sticky_posts' => true,
    'no_found_rows'       => true,
) );

if ( ! $news->have_posts() ) { return; }
?>
<section class="sot-news">
    <div class="hgrid">
        <?php if ( ! empty( $fp['news_heading'] ) ) : ?><h2><?php echo esc_html( $fp['news_heading'] ); ?></h2><?php endif; ?>
        <div class="news-grid">
            <?php while ( $news->have_posts() ) : $news->the_post(); ?>
                <article class="news-item">
                    <a class="news-thumb" href="<?php the_permalink(); ?>">
                        <?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'medium', array( 'loading' => 'lazy' ) ); } ?>
                    </a>
                    <time><?php echo esc_html( get_the_date() ); ?></time>
                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <a class="news-more" href="<?php the_permalink(); ?>">Mehr lesen →</a>
                </article>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
    </div>
</section>
