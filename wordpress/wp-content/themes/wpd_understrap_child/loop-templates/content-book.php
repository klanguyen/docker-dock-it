<?php
/**
 * Post rendering content according to caller of get_template_part
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

    <div class="card mb-3"">
        <div class="row g-0">
            <div class="col-md-4">
                <img src="<?php echo get_the_post_thumbnail_url($post->ID) ?>" class="img-fluid rounded-start" alt="<?php the_title() ?>">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <?php the_title(
                        sprintf( '<h5 class="card-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ),
                        '</a></h5>'
                    ); ?>
                    <p class="card-text"><?php echo get_the_excerpt();?></p>
                </div>
            </div>
        </div>
    </div>

</article><!-- #post-<?php the_ID(); ?> -->
