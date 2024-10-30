<?php // @codingStandardsIgnoreLine: Class name okay, PSR4.
/**
 * Plugin
 *
 * @package ConnectedChurch/ConnectedSermons/Sermons
 * @since   0.1.0
 */

namespace ChurchAgency\ConnectedSermons\Sermons;

require __DIR__ . '/PostType/Sermons.php';
require __DIR__ . '/Taxonomies/Taxonomy.php';
require __DIR__ . '/Taxonomies/Books.php';
require __DIR__ . '/Taxonomies/Preachers.php';
require __DIR__ . '/Taxonomies/Series.php';
require __DIR__ . '/Taxonomies/Topics.php';


/**
 * Plugin
 *
 * Loads the services this plugin offers.
 *
 * @since 0.1.0
 */
class Sermons
{

	/**
	 * Construct
	 *
	 * @param string $plugin_file_path Plugin file path.
	 * @since  0.1.0
	 * @author Scott Anderson <scott@church.agency>
	 */
	public function __construct(string $plugin_file_path)
	{
		$this->register_post_types();
	}

	/**
	 * Load Custom Sermon Custom Post Types.
	 *
	 * @author Scott Anderson <scott@church.agency>
	 * @since  NEXT
	 */
	private function register_post_types(): void
	{

		new Taxonomies\Books();
		new Taxonomies\Preachers();
		new Taxonomies\Series();
		new Taxonomies\Topics();
		new PostType\Sermons();
	}
}
