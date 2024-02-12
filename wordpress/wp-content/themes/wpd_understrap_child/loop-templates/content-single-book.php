<?php
/**
 * Single book partial template
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

    <article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

        <header class="entry-header">

            <?php echo get_the_post_thumbnail( $post->ID, 'medium'); ?>

            <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

        </header><!-- .entry-header -->

        <div class="entry-content">

            <?php
            the_content();
            understrap_link_pages();
            ?>

        </div><!-- .entry-content -->

        <footer class="entry-footer">

            <?php if ( 'post' === get_post_type() ) {
                understrap_categories_tags_list();
            } ?>

        </footer><!-- .entry-footer -->

    </article><!-- #post-<?php the_ID(); ?> -->
<?php
