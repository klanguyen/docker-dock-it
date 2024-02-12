<?php
/**
 * Post rendering content according to caller of get_template_part
 *
 * @package Understrap
 */

// Exit if accessed directly.
use KN\BookPlugin\ReviewMeta;

defined( 'ABSPATH' ) || exit;

$reviewContent = get_post_field('post_content', get_the_ID());
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

    <div class="card mb-3" style="max-width: 600px;">
        <div class="card-body">
            <?php the_title(
                sprintf( '<h5 class="card-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ),
                '</a></h5>'
            ); ?>
            <p class="card-text"><?php echo $reviewContent;?></p>
            <p><a class="btn btn-secondary understrap-read-more-link" href="<?php echo get_permalink(); ?>">
                    Read More
                <span class="screen-reader-text"> from <?php get_the_title( get_the_ID() ) ?></span></a></p>
        </div>
    </div>

</article><!-- #post-<?php the_ID(); ?> -->
