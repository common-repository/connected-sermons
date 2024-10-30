<?php // @codingStandardsIgnoreLine: Class name okay, PSR4.
/**
 * Plugin
 *
 * @package ConnectedChurch/ConnectedSermons/Settings
 * @since   1.0.4
 */

namespace ChurchAgency\ConnectedSermons;

/**
 * Plugin
 *
 * Loads the services this plugin offers.
 *
 * @since 1.0.4
 */
class Admin
{

	/**
	 * Construct
	 *
	 * @param string $plugin_file_path Plugin file path.
	 * @since  1.0.4
	 * @author Scott Anderson <scott@church.agency>
	 */
	public function __construct()
	{
		add_action('admin_menu', [$this, 'register_menu_pages']);
	}

	/**
	 * Registers top level menu page and sub-menu page.
	 *
	 * @author Scott Anderson <scott@church.agency>
	 * @since  1.0.4
	 */
	public function register_menu_pages()
	{
		add_menu_page(
			__('Connected Sermons', 'connected_sermons'),
			__('Sermons', 'connected_sermons'),
			'manage_options',
			'connected-sermons',
			[$this, 'admin'],
			plugins_url(CACS_DIRECTORY_NAME . '/utils/images/icon.svg'),
			6
		);

		add_submenu_page(
			'connected-sermons',
			__('Connected Sermons - Settings', 'connected_sermons'),
			__('Home', 'connected_sermons'),
			'manage_options',
			'cs-admin',
			[$this, 'admin'],
			0
		);
	}


	/**
	 * Renders settings page.
	 * CMB2 Doc: https://github.com/CMB2/CMB2-Snippet-Library/blob/master/options-and-settings-pages/add-cmb2-settings-to-other-settings-pages.php
	 * @author Scott Anderson <scott@church.agency>
	 * @since  1.0.4
	 */
	public function admin()
	{
		cacs_get_page('admin');
	}
}
