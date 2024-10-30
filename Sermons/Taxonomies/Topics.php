<?php //phpcs:ignore Wordpress.Files.Filename
/**
 * Custom Post Type for Insights
 *
 * @since NEXT
 * @package ChurchAgency\ConnectedSermons\Sermons\Taxonomies
 */

namespace ChurchAgency\ConnectedSermons\Sermons\Taxonomies;

use ChurchAgency\ConnectedSermons\Sermons\Taxonomies\Taxonomy;

/**
 * Custom post type for Connected_Sermons Insights
 *
 * @since NEXT
 */
class Topics  extends Taxonomy
{
	/**
	 * Construct
	 *
	 * @since  0.1.0
	 * @author Scott Anderson <scott@church.agency>
	 */
	public function __construct()
	{
		parent::__construct('cs_topics', 'Topics', 'Topic');
	}
}
