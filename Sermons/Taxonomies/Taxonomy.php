<?php //phpcs:ignore Wordpress.Files.Filename
/**
 * Custom Post Type for Insights
 *
 * @since NEXT
 * @package ChurchAgency\ConnectedSermons\Sermons\Taxonomies
 */

namespace ChurchAgency\ConnectedSermons\Sermons\Taxonomies;

/**
 * Custom post type for Connected_Sermons Insights
 *
 * @since NEXT
 */
class Taxonomy
{

	/**
	 * Permalink slug for this taxonomy.
	 *
	 * @var string $slug Permalink prefix
	 * @since NEXT
	 */
	private $slug = '';

	/**
	 * Plural label for this taxonomy.
	 *
	 * @var string $slug Permalink prefix
	 * @since NEXT
	 */
	private $plural_label = '';
	
	/**
	 * Singular label for this taxonomy.
	 *
	 * @var string $slug Permalink prefix
	 * @since NEXT
	 */
	private $singular_label = '';

	/**
	 * Construct
	 *
	 * @since  0.1.0
	 * @author Scott Anderson <scott@church.agency>
	 * @param $slug  Slug of Taxonomy to register.
	 * @param $plural_label Plural label of Taxonomy to register.
	 * @param $singular_label Singular Label of Taxonomy to register.
	 */
	public function __construct(string $slug, string $plural_label, string $singular_label)
	{
		$this->slug = $slug;
		$this->plural_label = $plural_label;
		$this->singular_label = $singular_label;
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
		add_action('init', [$this, 'register_taxonomy']);
		add_action('admin_menu', [$this, 'register_submenu_page']);
		add_action('parent_file', [$this, 'register_submenu_page_highlight']);
	}

	/**
	 * Register Taxonomy
	 *
	 * @author Scott Anderson <scott@church.agency>
	 * @since  NEXT
	 */
	public function register_taxonomy(): void
	{
		$labels = array(
			'add_new_item'      => __( 'Add New '. $this->singular_label , 'textdomain' ),
		);

		$args = array(
			'label'        => __($this->plural_label, 'cs_conneted_sermons'),
			'labels'       => $labels,
			'show_in_rest' => true,
		);

		register_taxonomy($this->slug, 'cs_sermons', $args);
	}

	/**
	 * Registers submenu for Taxonomy.
	 *
	 * @author Scott Anderson <scott@church.agency>
	 * @since  NEXT
	 */
	public function register_submenu_page(): void
	{
		add_submenu_page('connected-sermons', __($this->plural_label, 'cs_conneted_sermons'), __($this->plural_label, 'cs_conneted_sermons'), 'publish_posts', "edit-tags.php?taxonomy={$this->slug}");
	}

	public function register_submenu_page_highlight()
	{
		global $current_screen;

		if ($current_screen->taxonomy == $this->slug) {
			return 'connected-sermons';
		}

		return '';
	}
}
