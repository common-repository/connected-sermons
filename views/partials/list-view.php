<?php

/**
 * The template for displaying sermons in a list view.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package church
 */

if (isset($_GET['cs_page'])) {
	$page_num = sanitize_text_field($_GET['cs_page']);
} else {
	$page_num = 0;
}

$total_count = absint(wp_count_posts('cs_sermons')->publish);
$offset = $page_num * $page_size;

if (isset($_GET['cs_type']) && isset($_GET['cs_value']) && !empty($_GET['cs_value'])) {
	$args = [
		'post_type'   => 'cs_sermons',
		'numberposts' => $page_size,
		'tax_query'   => [
			[
				'taxonomy' => sanitize_text_field($_GET['cs_type']),
				'field'    => 'term_id',
				'terms'    => sanitize_text_field($_GET['cs_value']),
			],
		],
		'orderby'  => 'meta_value',
		'meta_key' => 'cs_date',
		'order'    => 'DES',
		'offset' => $offset,
	];
} else {
	$args = [
		'post_type'   => 'cs_sermons',
		'numberposts' => $page_size,
		'orderby'  => 'meta_value',
		'meta_key' => 'cs_date',
		'order'    => 'DES',
		'offset' => $offset,
	];
}

$sermons = get_posts($args, -1);

?>

<main id="primary" class="ca container site-main ca-mt-10">
	<?php if ( $show_filters ) : ?>
		<?php cacs_get_part('filters'); ?>
	<?php endif; ?>
	<div class='row ca-mt-10'>
		<?php

		if (0 === count($sermons)) {
			esc_html_e('No Sermons were found.', 'connected_sermons');
		}

		foreach ($sermons as $sermon) {
			cacs_get_part('sermon', $sermon);
		}
		?>
	</div>

	<?php if (-1  != $page_size) : ?>
		<div class="row">
			<div class="col">
				<?php if (cacs_newer_content($page_num, $page_size, $total_count)) : ?>
					<a class="btn btn-outline-primary" href="?cs_page=<?php echo $page_num - 1; ?>"> <?php echo __('Newer Sermons', 'connected_sermons') ?> </a>
				<?php endif; ?>

			</div>
			<div class="col text-right">
				<?php if (cacs_older_content($page_num, $page_size, $total_count)) : ?>
					<a class="btn btn-outline-primary" href="?cs_page=<?php echo $page_num + 1; ?>"> <?php echo __('Previous Sermons', 'connected_sermons') ?> </a>
				<?php endif; ?>
			</div>
		</div>
	<?php endif; ?>

</main><!-- #main -->