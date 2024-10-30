<?php //phpcs:ignore Wordpress.Files.Filename
/**
 * Register all template related functions.
 *
 * @since NEXT
 * @package ChurchAgency\ConnectedSermons\Includes
 */

// Exit if accessed directly.
defined('ABSPATH') || die;

/**
 * Custom post type for Connected_Sermons Insights
 *
 * @since NEXT
 */
class CS_Template
{


	/**
	 * Construct
	 *
	 * @since  0.1.0
	 * @author Scott Anderson <scott@church.agency>
	 */
	public function __construct()
	{
		$this->hooks();
	}

	/**
	 * Register Hooks
	 *
	 * @author Scott Anderson <scott@church.agency>
	 * @since  NEXT
	 */
	private function hooks(): void
	{
		add_filter('template_include', [$this, 'template_checker']);
	}

	/**
	 * Return appropriate Layout file for Custom Post Type.
	 *
	 * @author Scott Anderson <scott@church.agency>
	 * @since  NEXT
	 * @param  string $template Name of default template file.
	 * @return string
	 */
	public function template_checker(string $template)
	{

		if (is_post_type_archive('cs_sermons')) {
			return CACS_DIRECTORY . '/views/archive-sermon.php';
		}

		global $post;

		if (empty($post)) {
			return $template;
		}

		if ('cs_sermons' === $post->post_type) {
			return CACS_DIRECTORY . '/views/single-sermon.php';
		}

		return $template;
	}
}

new CS_Template();

/**
 * Display desired template part.
 *
 * @author Scott Anderson <scott@church.agency>
 * @since  NEXT
 * @param  string $part Desired Template Part
 */
function cacs_get_part(string $part, $cs_post = 0, bool $wrapper = false)
{
	set_query_var('cs_post', $cs_post);

	if ($wrapper) {
		echo '<div class="ca">';
	}

	echo load_template(CACS_DIRECTORY . '/views/partials/' . $part . '.php', false); // @codingStandardsIgnoreLine: Not this time.

	if ($wrapper) {
		echo '</div>';
	}
}


/**
 * Display desired template part.
 *
 * @author Scott Anderson <scott@church.agency>
 * @since  NEXT
 * @param  string $part Desired Template Part
 */
function cacs_get_page(string $page, bool $wrapper = true)
{

	if ($wrapper) {
		echo '<div class="ca">';
	}

	echo load_template(CACS_DIRECTORY . '/views/' . $page . '.php', false); // @codingStandardsIgnoreLine: Not this time.

	if ($wrapper) {
		echo '</div>';
	}
}

/**
 * Returns Post Meta
 *
 * @author Scott Anderson <scott@church.agency>
 * @since  NEXT
 * @param  string $key Key for desired post meta.
 * @return mix
 */
function cacs_get_post_meta(string $key, int $post_id = 0)
{

	if (0 === $post_id) {
		$post_id = get_the_ID();
	}

	return get_post_meta($post_id, $key, true);
}

/**
 * Returns Global Settings Meta
 *
 * @author Scott Anderson <scott@church.agency>
 * @since  NEXT
 * @param  string $key Key for desired post meta.
 * @return mix
 */
function cacs_get_setting(string $key)
{
	return get_post_meta(CACS_SETTNIGS_ID, $key, true);
}

/**
 * Return Sermon Published Date.
 *
 * @author Scott Anderson <scott@church.agency>
 * @since  NEXT
 * @return string
 */
function cacs_get_sermon_date($sermon)
{

	$sermon_date = cacs_get_post_meta('cs_date', $sermon->ID);

	if (empty($sermon)) {
		return the_date();
	}

	if (empty($sermon_date)) {
		return get_the_date('', $sermon->ID);
	}

	return date("F j, Y", $sermon_date);
}

/**
 * Returns all terms for a desired church taxonomy of a sermon.
 *
 * @author Scott Anderson <scott@church.agency>
 * @since  NEXT
 * @return array
 */
function cacs_get_taxonomy_list_of_sermon($sermon, string $taxonomy): array
{
	$terms = get_the_terms($sermon, $taxonomy);

	if (empty($terms)) {
		return [];
	}

	return $terms;
}

/**
 * Returns structured link for Sermon List Selector
 *
 * @author Scott Anderson <scott@church.agency>
 * @since  NEXT
 * @return string
 */
function cacs_get_sermon_list_selector_term_link($term): string
{
	global $wp;
	return home_url($wp->request) . '/?cs_type=' . $term->taxonomy . '&cs_value=' . $term->term_id;
}

/**
 * Returns a Sermons Image, if none found returns default.
 *
 * @author Scott Anderson <scott@church.agency>
 * @since  NEXT
 * @param  $sermon Sermon Custom Post Type
 * @return string URL to Sermon's Image.
 */
function cacs_get_sermon_image($sermon): string
{
	$sermon_image_url = get_the_post_thumbnail_url($sermon->ID);

	if ($sermon_image_url) {
		return $sermon_image_url;
	}
	return cacs_get_setting(CACS_PREFIX . 'default_sermon_image');
}

/**
 * Is user premium.
 *
 * @author Scott Anderson <scott@church.agency>
 * @since  NEXT
 * @return bool
 */
function cacs_is_premium(): bool
{
	return \ChurchAgency\ConnectedSermons\cs_fs()->is_plan('Pro');
}

/**
 * Is user a free version user.
 *
 * @author Scott Anderson <scott@church.agency>
 * @since  NEXT
 * @return bool
 */
function cacs_is_free(): bool
{
	return \ChurchAgency\ConnectedSermons\cs_fs()->is_not_paying();;
}

/**
 * Whether There is Old Content based on page location.
 *
 * @author Scott Anderson <scott@church.agency>
 * @since  1.0.5
 * @param  int $page_number Current Page Number
 * @param  int $page_size Page Size of Content.
 * @param  int $total_count Total Number of Content.
 * @return bool
 */
function cacs_older_content(int $page_number, int $page_size, int $total_count): bool
{
	$total_pages = cacs_total_pages($page_size, $total_count);

	if ($total_count == 0 || $page_number >= $total_pages) {
		return false;
	}

	return true;
}

/**
 * Whether There is Newer Content based on page location.
 *
 * @author Scott Anderson <scott@church.agency>
 * @since  1.0.5
 * @param  int $page_number Current Page Number
 * @param  int $page_size Page Size of Content.
 * @param  int $total_count Total Number of Content.
 * @return bool
 */
function cacs_newer_content(int $page_number, int $page_size, int $total_count): bool
{
	$total_pages = cacs_total_pages($page_size, $total_count);

	if ($total_count == 0 || $page_number == 0 || $page_number > $total_pages) {
		return false;
	}

	return true;
}

/**
 * Returns how many total pages exist for a given content type.
 *
 * @author Scott Anderson <scott@church.agency>
 * @since  1.0.5
 * @param  int $page_size Page Size of Content.
 * @param  int $total_count Total Number of Content.
 * @return bool
 */
function cacs_total_pages(int $page_size, int $total_count): int
{
	return absint(ceil($total_count / $page_size)) - 1;
}
