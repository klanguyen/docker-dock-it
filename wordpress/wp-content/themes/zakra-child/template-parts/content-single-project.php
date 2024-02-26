<?php
/**
 * Template part for displaying posts
 *
 * @link    https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package zakra
 */

$content_orders = get_theme_mod(
	'zakra_single_post_content_structure', array(
		'featured_image',
		'title',
		'meta',
		'content',
	)
);

$meta_orders = get_theme_mod(
	'zakra_single_blog_post_meta_structure', array(
		'comments',
		'categories',
		'author',
		'date',
		'tags',
	)
);

$meta_style = get_theme_mod( 'zakra_blog_archive_meta_style', 'tg-meta-style-one' );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $meta_style ); ?>>
	<?php do_action( 'zakra_before_single_post' ); ?>

	<?php
	foreach ( $content_orders as $key => $content_order ) :
		if ( 'featured_image' === $content_order ) :
			zakra_post_thumbnail();

		elseif ( 'title' === $content_order ) :

			if ( 'page-header' !== zakra_is_page_title_enabled() ) : ?>
				<header class="entry-header">
					<h1 class="entry-title tg-page-content__title">
						<?php echo wp_kses_post( zakra_get_title() ); ?>
					</h1>
				</header><!-- .entry-header -->
			<?php endif;

		elseif ( 'meta' === $content_order && 'post' === get_post_type() ) : ?>
			<div class="entry-meta">
				<?php
				foreach ( $meta_orders as $key => $meta_order ) {
					if ( 'comments' === $meta_order ) {
						zakra_post_comments();
					} elseif ( 'categories' === $meta_order ) {
						zakra_posted_in();
					} elseif ( 'author' === $meta_order ) {
						zakra_posted_by();
					} elseif ( 'date' === $meta_order ) {
						zakra_posted_on();
					} elseif ( 'tags' === $meta_order ) {
						zakra_post_tags();
					}
				}
				?>
			</div><!-- .entry-meta -->

		<?php elseif ( 'content' === $content_order ) : ?>
			<div class="entry-content">
				<h2 class="project-subtitles">Description</h2>
				<p class="project-description"><?= get_the_content(); ?></p>
				<h2 class="project-subtitles">Technologies Used</h2>
				<ul class="technologies-list">
					<?php
					$techs = get_post_meta(get_the_ID(), 'project_technologies', true);
					foreach($techs as $item){
						echo "<li class='tech-item'>$item</li>";
					}
					?>
				</ul>
				<h2 class="project-subtitles">Screenshots</h2>
				<div class='col'>
				<?php
				$images = acf_photo_gallery('project_screenshots', get_the_ID());
				if(count($images)):
					$i = 0;
					foreach($images as $image):
						$i = $i + 1;
						$id = $image['id'];
						$title = $image['title'];
						$caption= $image['caption'];
						$full_image_url= $image['full_image_url']; //Full size image url
						$medium_image_url = acf_photo_gallery_resize_image($full_image_url, 262, 160); //Resized size to 262px width by 160px height image url
						$thumbnail_image_url= $image['thumbnail_image_url']; //Get the thumbnail size image url 150px by 150px
						$url= $image['url']; //Goto any link when clicked
						$target= $image['target']; //Open normal or new tab
						echo "<a href='#modal-$i' id='modal-closed'>
								<img class='project-screenshot' src='$medium_image_url' alt='$title'>
							  </a>
							  <div class='modal-container' id='modal-$i'>
							  	<div class='modal'>
									<div class='modal-content'>
										<img src='$full_image_url' alt='$title' />
									</div>
									<span></span>
									<a href='#modal-closed' class='close-btn'></a>
								</div>
							  </div>";

					endforeach;
				endif;
				?>
				</div>
				<?php
				wp_link_pages(
					array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'zakra' ),
						'after'  => '</div>',
					)
				);
				?>
			</div><!-- .entry-content -->

		<?php
		endif;
	endforeach;
	?>

	<?php do_action( 'zakra_after_single_post' ); ?>
</article><!-- #post-<?php the_ID(); ?> -->

