<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

$container = get_theme_mod( 'understrap_container_type' );
$greetings = get_option(\KN\BookPlugin\BookSettings::HOMEPAGE_GREETINGS);
?>
<?php
if(is_front_page()) {
    ?>
    <header class="front-page-hero">
        <div class="container">
            <h1><?= $greetings ?></h1>
            <a class="btn btn-primary" href="<?php echo get_permalink( get_page_by_path( 'Bio' ) ); ?>">
                Get to know John
            </a><br>
            <a class="btn btn-secondary" href="<?php echo get_permalink( get_page_by_path( 'Books' ) ); ?>">
                John's Library
            </a>
        </div>
    </header>
    <?php
}
?>

<div class="wrapper" id="page-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<?php
			// Do the left sidebar check and open div#primary.
			get_template_part( 'global-templates/left-sidebar-check' );
			?>

			<main class="site-main" id="main">

				<?php
				while ( have_posts() ) {
					the_post();
					get_template_part( 'loop-templates/content', 'page' );

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
				}
				?>

			</main>

			<?php
			// Do the right sidebar check and close div#primary.
			get_template_part( 'global-templates/right-sidebar-check' );
			?>

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #page-wrapper -->

<?php
get_footer();
