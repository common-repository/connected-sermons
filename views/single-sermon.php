<?php

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package church
 */

get_header();
global $post;

?>

<main id="primary" class="site-main">

	<?php
	while (have_posts()) :
		the_post();
	?>
		<img class="ca-image" src="<?php the_post_thumbnail_url(); ?>" />
		<article id="post-<?php the_ID(); ?>" class="ca container" <?php post_class(); ?>>
			<div class='sermon-heading ca-text-center'>
				<h1 class='ca-bold'><?php echo get_the_title(); ?></h1>
				<div class='row'>
					<div class='col-lg'>
						<p class="card-text"><span class='ca-bold'><?php esc_html_e('Sermon Date: ', 'connected_sermons'); ?></span><?php echo cacs_get_sermon_date($post); ?></p>
					</div>
					<div class='col-lg'>
						<?php cacs_get_part('passage', $post); ?>
					</div>
				</div>
			</div>
			<div class="entry-content">
				<?php cacs_get_part('media-player', $post); ?>
				<?php
				the_content();
				?>
			</div><!-- .entry-content -->
		</article>
	<?php
	endwhile; // End of the loop.
	?>

</main><!-- #main -->

<?php

get_footer();
