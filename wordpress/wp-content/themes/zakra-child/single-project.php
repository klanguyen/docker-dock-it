<?php
/**
 * The template for displaying all single posts
 *
 * @link    https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package zakra
 */

get_header();
?>

	<div id="primary" class="content-area">
		<?php echo apply_filters( 'zakra_after_primary_start_filter', false ); // WPCS: XSS OK. ?>

		<?php
		while ( have_posts() ) :
			the_post();
			echo "<span class='brief-desc'>".get_post_meta(get_the_ID(), 'brief_description', true)."</span>";

			$githubUrl = get_post_meta(get_the_ID(), 'github_link', true);
			$liveUrl = get_post_meta(get_the_ID(), 'live_site_link', true);

			echo "<div class='action-links'>";
			if(!empty($githubUrl)) {
				echo "<a class='btn-link github-btn' href='$githubUrl' target='_blank'><i class='fa fa-github aria-hidden='true'></i></a>";
			}
			if(!empty($liveUrl)) {
				echo "<a class='btn-link live-btn' href='$liveUrl' target='_blank'>
						Live Demo</a>";
			}
			echo "</div>";

			get_template_part( 'template-parts/content-single', get_post_type() );

			do_action( 'zakra_after_single_post_content' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

		<?php echo apply_filters( 'zakra_after_primary_end_filter', false ); // // WPCS: XSS OK. ?>
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
