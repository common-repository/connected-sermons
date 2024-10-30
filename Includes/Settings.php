<?php

// @codingStandardsIgnoreLine: Class name okay, PSR4.
/**
 * Plugin
 *
 * @package ConnectedChurch/ConnectedSermons/Settings
 * @since   0.1.0
 */
namespace ChurchAgency\ConnectedSermons;

/**
 * Plugin
 *
 * Loads the services this plugin offers.
 *
 * @since 0.1.0
 */
class Settings
{
    /**
     * Initial Form Settings Slug. Glue for sub fields.
     *
     * @author Scott Anderson <scott@church.agency>
     * @since  NEXT
     * @param  string $settings_box_slug
     */
    private  $settings_box_slug = 'cs_settings' ;
    /**
     * Construct
     *
     * @param string $plugin_file_path Plugin file path.
     * @since  0.1.0
     * @author Scott Anderson <scott@church.agency>
     */
    public function __construct()
    {
        add_action( 'admin_menu', [ $this, 'register_menu_pages' ], 10 );
        add_action( 'cmb2_admin_init', [ $this, 'register_settings_meta' ] );
    }
    
    /**
     * Registers top level menu page and sub-menu page.
     *
     * @author Scott Anderson <scott@church.agency>
     * @since  NEXT
     */
    public function register_menu_pages()
    {
        add_submenu_page(
            'connected-sermons',
            __( 'Connected Sermons - Settings', 'connected_sermons' ),
            __( 'Settings', 'connected_sermons' ),
            'manage_options',
            'cs-settings',
            [ $this, 'settings_page' ]
        );
    }
    
    /**
     * Register Settings Meta Fields
     *
     * @author Scott Anderson <scott@church.agency>
     * @since  NEXT
     * @return void
     */
    public function register_settings_meta() : void
    {
        $settings = new_cmb2_box( array(
            'id'           => $this->settings_box_slug,
            'title'        => esc_html__( 'Connected Sermons Settings', 'connected_sermons' ),
            'object_types' => [],
        ) );
        $settings->add_field( array(
            'name' => esc_html__( 'Disable Sermon Styles', 'connected_sermons' ),
            'desc' => esc_html__( 'Disables all frontend CSS and will break sermons displays. Only activate if you intend to write your own styles.', 'connected_sermons' ),
            'id'   => CACS_PREFIX . 'disable_global_styles',
            'type' => 'checkbox',
        ) );
        $settings->add_field( array(
            'name' => esc_html__( 'Default Sermon Image.', 'connected_sermons' ),
            'desc' => esc_html__( 'Default image that is used in sermon templates when a featured image hasnt been defined.', 'connected_sermons' ),
            'id'   => CACS_PREFIX . 'default_sermon_image',
            'type' => 'file',
        ) );
        $settings->add_field( array(
            'name'    => esc_html__( 'Bible Version', 'connected_sermons' ),
            'desc'    => $this->get_bible_verses_description(),
            'id'      => CACS_PREFIX . 'bible_version',
            'type'    => 'select',
            'options' => $this->get_bible_verses(),
        ) );
    }
    
    /**
     * Returns Bible Verse Description based on Plan.
     *
     * @author Scott Anderson <scott@church.agency>
     * @since  NEXT
     * @return string
     */
    private function get_bible_verses_description() : string
    {
        if ( cacs_is_premium() ) {
            return esc_html__( 'Versions highlight bible version.', 'connected_sermons' );
        }
        return esc_html__( 'Versions highlight bible version. Upgrade to PRO to unlock additional translation including (ASV, DAR, ESV, GW, HCSB, LEB, MESSAGE, NASB, NVC, NIRV, NJKV, NLT, DOUAYRHEIMS, and YLT', 'connected_sermons' );
    }
    
    /**
     * Returns available bible verses based on plan type.
     *
     * @author Scott Anderson <scott@church.agency>
     * @since  NEXT
     * @return array Of all available bible versions.
     */
    private function get_bible_verses() : array
    {
        if ( cacs_is_premium() ) {
            return $this->get_premium_verses__premium_only();
        }
        return $this->get_free_verses();
    }
    
    /**
     * All Free Bible Verses
     *
     * @author Scott Anderson <scott@church.agency>
     * @since  NEXT
     * @return array
     */
    private function get_free_verses() : array
    {
        return array(
            'KJV' => esc_html__( 'King James Version (KJV)', 'connected_sermons' ),
            'NIV' => esc_html__( 'New International Version (NIV)', 'connected_sermons' ),
        );
    }
    
    /**
     * Renders settings page.
     * CMB2 Doc: https://github.com/CMB2/CMB2-Snippet-Library/blob/master/options-and-settings-pages/add-cmb2-settings-to-other-settings-pages.php
     * @author Scott Anderson <scott@church.agency>
     * @since  NEXT
     */
    public function settings_page()
    {
        cacs_get_page( 'settings' );
    }

}