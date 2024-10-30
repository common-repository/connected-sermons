<?php //phpcs:ignore Wordpress.Files.Filename
/**
 * Custom Post Type for Insights
 *
 * @since NEXT
 * @package ChurchAgency\ConnectedSermons\Sermons\Taxonomies
 */

namespace ChurchAgency\ConnectedSermons\Sermons\PostType;

/**
 * Custom post type for Connected_Sermons Insights
 *
 * @since NEXT
 */
class Sermons
{

	/**
	 * Permalink slug for this post type
	 *
	 * @var string $slug Permalink prefix
	 * @since NEXT
	 */
	private $slug = 'cs_sermons';


	/**
	 * Meta key for Sermon Date.
	 *
	 * @var string $slug Sermon Date Meta Key.
	 * @since NEXT
	 */
	private $date_slug = 'cs_date';

	/**
	 * Available Media Types.
	 *
	 * @var array $media_types Available Media Types.
	 * @since NEXT
	 */
	private $media_types;

	/**
	 * Post ID of this post type.
	 *
	 * @var int $post_id Id of Post.
	 * @since NEXT
	 */
	private $post_id;

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
		add_action('init', [$this, 'register_post']);
		add_action('cmb2_admin_init', [$this, 'register_post_meta']);
		add_action("save_post", [$this, 'update_meta'], 20, 2);
	}

	/**
	 * Post Labels
	 *
	 * @author Scott Anderson <scott@church.agency>
	 * @since  NEXT
	 * @return array
	 */
	private function post_labels(): array
	{
		return [
			'name'                  => _x('Sermons', 'Post type general name', 'Sermon'),
			'singular_name'         => _x('Sermon', 'Post type singular name', 'Sermon'),
			'menu_name'             => _x('Sermons', 'Admin Menu text', 'Sermon'),
			'name_admin_bar'        => _x('Sermon', 'Add New on Toolbar', 'Sermon'),
			'add_new'               => __('Add New', 'Sermon'),
			'add_new_item'          => __('Add New Sermon', 'Sermon'),
			'new_item'              => __('New Sermon', 'Sermon'),
			'edit_item'             => __('Edit Sermon', 'Sermon'),
			'view_item'             => __('View Sermon', 'Sermon'),
			'all_items'             => __('All Sermons', 'Sermon'),
			'search_items'          => __('Search Sermons', 'Sermon'),
			'parent_item_colon'     => __('Parent Sermons:', 'Sermon'),
			'not_found'             => __('No Sermons found.', 'Sermon'),
			'not_found_in_trash'    => __('No Sermons found in Trash.', 'Sermon'),
			'featured_image'        => _x('Sermon Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'Sermon'),
			'set_featured_image'    => _x('Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'Sermon'),
			'remove_featured_image' => _x('Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'Sermon'),
			'use_featured_image'    => _x('Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'Sermon'),
			'archives'              => _x('Sermon archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'Sermon'),
			'insert_into_item'      => _x('Insert into Sermon', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'Sermon'),
			'uploaded_to_this_item' => _x('Uploaded to this Sermon', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'Sermon'),
			'filter_items_list'     => _x('Filter Sermons list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'Sermon'),
			'items_list_navigation' => _x('Sermons list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'Sermon'),
			'items_list'            => _x('Sermons list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'Sermon'),
		];
	}

	/**
	 * Post Arguments
	 *
	 * @author Scott Anderson <scott@church.agency>
	 * @since  NEXT
	 * @return array
	 */
	private function post_arguments(): array
	{
		return [
			'labels'             => $this->post_labels(),
			'description'        => 'Sermon custom post type.',
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => 'connected-sermons',
			'query_var'          => true,
			'rewrite'            => array('slug' => 'cs-sermons'),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => 20,
			'supports'           => array('title', 'editor', 'author', 'thumbnail'),
			'show_in_rest'       => true,
		];
	}

	/**
	 * Register Post Type
	 *
	 * @author Scott Anderson <scott@church.agency>
	 * @since  NEXT
	 */
	public function register_post(): void
	{
		register_post_type($this->slug, $this->post_arguments());
	}

	/**
	 * Register all Sermon Meta Data
	 *
	 * @author Scott Anderson <scott@church.agency>
	 * @since  NEXT
	 * @return void
	 */
	public function register_post_meta(): void
	{
		$this->regiser_sermon_details_meta();
		$this->register_sermon_media_meta();
	}

	/**
	 * Register Sermon Details Meta Fields
	 *
	 * @author Scott Anderson <scott@church.agency>
	 * @since  NEXT
	 * @return void
	 */
	public function regiser_sermon_details_meta(): void
	{
		$sermon_details = new_cmb2_box(array(
			'id'            => 'cs_sermon_details',
			'title'         => esc_html__('Sermon Details', 'connected_sermons'),
			'object_types'  => array($this->slug),
		));

		$sermon_details->add_field(array(
			'name'       => esc_html__('Sermon Date', 'connected_sermons'),
			'desc'       => esc_html__('Date the sermon was recorded (optional). If none mentioned defaults to todays date.', 'connected_sermons'),
			'id'         => $this->date_slug,
			'type'       => 'text_date_timestamp',
		));

		$sermon_details->add_field(array(
			'name'       => esc_html__('Bible Passages', 'connected_sermons'),
			'desc'       => esc_html__('Comma Seperated (Optional)', 'connected_sermons'),
			'id'         => 'cs_bible_passages',
			'type'       => 'text',
		));

		$sermon_details->add_field(array(
			'name'       => esc_html__('Sermon Teaser', 'connected_sermons'),
			'desc'       => esc_html__('In a few words describe the sermon.', 'connected_sermons'),
			'id'         => 'cs_sermon_teaser',
			'type'       => 'textarea_small',
		));
	}

	private function register_sermon_media_meta(): void
	{
		$sermon_media = new_cmb2_box(array(
			'id'            => 'cs_sermon_media',
			'title'         => esc_html__('Sermon Details', 'connected_sermons'),
			'object_types'  => array($this->slug),
		));

		$sermon_media->add_field(array(
			'name'             => esc_html__('Media Type*', 'connected_sermons'),
			'desc'             => esc_html__('Really important select one!!! What is the source media type?', 'connected_sermons'),
			'id'               => 'cs_media_type',
			'type'             => 'select',
			'show_option_none' => true,
			'options'          => array(
				'youtube'   => esc_html__('YouTube', 'connected_sermons'),
				'facebook' => esc_html__('Facebook', 'connected_sermons'),
				'vimeo'     => esc_html__('Vimeo', 'connected_sermons'),
				'mp3'     => esc_html__('MP3', 'connected_sermons'),
				'embed_code'     => esc_html__('Embed Code', 'connected_sermons'),
				'url'     => esc_html__('Source URL', 'connected_sermons'),
			),
		));

		$sermon_media->add_field(array(
			'name'       => esc_html__('YouTube Embed URL', 'connected_sermons'),
			'id'         => 'cs_youtube_url',
			'type'       => 'text',
		));

		$sermon_media->add_field(array(
			'name'       => esc_html__('Facebook Embed Code', 'connected_sermons'),
			'id'         => 'cs_facebook_embed',
			'type'       => 'textarea_code',
			'options' => array('disable_codemirror' => true),
		));

		$sermon_media->add_field(array(
			'name'       => esc_html__('Vimeo Embed Code', 'connected_sermons'),
			'id'         => 'cs_vimeo_embed',
			'type'       => 'textarea_code',
			'options'    => array('disable_codemirror' => true),
		));

		$sermon_media->add_field(array(
			'name'       => esc_html__('Embed Code', 'connected_sermons'),
			'id'         => 'cs_embed_code',
			'type'       => 'textarea_code',
			'options'    => array('disable_codemirror' => true),
		));

		$sermon_media->add_field(array(
			'name'       => esc_html__('Source URL', 'connected_sermons'),
			'desc'             => esc_html__('Url to a self hosted .mp4 file.', 'connected_sermons'),
			'id'         => 'cs_source_url',
			'type'       => 'text',
		));

		$sermon_media->add_field(array(
			'name' => esc_html__('MP3', 'connected_sermons'),
			'desc' => esc_html__('Only add or upload MP3 files.', 'connected_sermons'),
			'id'   => 'cs_mp3',
			'type' => 'file',
		));

		$sermon_media->add_field(array(
			'name' => esc_html__('Additonal MP3', 'connected_sermons'),
			'desc' => esc_html__('Only add or upload MP3 files.', 'connected_sermons'),
			'id'   => 'cs_additional_mp3',
			'type' => 'file',
		));
	}

	/**
	 * Post Update Meta Cleanup.
	 *
	 * @author Scott Anderson <scott@church.agency>
	 * @since  NEXT
	 * @param  int  $sermon_id ID of Sermon Updated
	 * @param  POST $sermon Sermon Post Object
	 * @return void
	 */
	public function update_meta($sermon_id, $sermon): void
	{
		if ($this->slug === $sermon->post_type && $this->sermon_doesnt_have_date($sermon_id)) {
			update_post_meta($sermon_id, $this->date_slug, time(), true);
		}
	}

	/**
	 * Returns whether a sermon doesn't have a date.
	 *
	 * @author Scott Anderson <scott@church.agency>
	 * @since  NEXT
	 * @param  int $sermon_id Post ID of Sermon To Check.
	 * @return bool Whether Sermon Post has a cs_date meta field defined.
	 */
	private function sermon_doesnt_have_date(int $sermon_id): bool
	{
		return !get_post_meta($sermon_id, $this->date_slug, true);
	}
}
