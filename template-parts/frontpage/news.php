<?php
/**
 * Startseite – Aktuelles aus dem Blog
 * Layout: erster Beitrag gross links, weitere rechts gestapelt.
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

$total = $news->post_count;
$idx   = 0;
?>
<section class="sot-news">
    <div class="hgrid">
        <?php if ( ! empty( $fp['news_heading'] ) ) : ?><p class="section-eyebrow news-eyebrow"><?php echo esc_html( $fp['news_heading'] ); ?></p><?php endif; ?>

        <div class="news-grid<?php echo $total > 1 ? ' has-rest' : ''; ?>">
            <?php while ( $news->have_posts() ) : $news->the_post(); ?>

                <?php if ( 0 === $idx ) : ?>
                    <article class="news-item news-featured">
                        <a class="news-thumb" href="<?php the_permalink(); ?>">
                            <?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'large', array( 'loading' => 'lazy' ) ); } ?>
                        </a>
                        <div class="news-body">
                            <time><?php echo esc_html( get_the_date() ); ?></time>
                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 24 ) ); ?></p>
                            <a class="news-more" href="<?php the_permalink(); ?>">Mehr lesen →</a>
                        </div>
                    </article>
                    <?php if ( $total > 1 ) : ?><div class="news-rest"><?php endif; ?>
                <?php else : ?>
                    <article class="news-item">
                        <div class="news-body">
                            <time><?php echo esc_html( get_the_date() ); ?></time>
                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22 ) ); ?></p>
                            <a class="news-more" href="<?php the_permalink(); ?>">Mehr lesen →</a>
                        </div>
                    </article>
                <?php endif; ?>

                <?php $idx++; ?>
            <?php endwhile; wp_reset_postdata(); ?>

            <?php if ( $total > 1 ) : ?></div><?php endif; // .news-rest ?>
        </div>
    </div>
</section>
