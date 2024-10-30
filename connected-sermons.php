<?php

/**
 * Plugin Name: Connected Sermons
 * Plugin URI: https://church.agency/connected-sermons/
 * Description: Easily add audio and video sermons to your church's website.
 * Version: 1.2.1
 * Author: Church Agency
 * Author URI: https://church.agency/
 * Requires at least: 5.6
 * Tested up to: 5.6
 * Requires PHP: 7.3
 * 
 * License: GPL v3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.txt
 *
 * Text Domain: connected-sermons
 * Domain Path: /languages/
 *
 * @package ChurchAgency/ConnectedSermons
 */
namespace ChurchAgency\ConnectedSermons;

class ConnectedSermons
{
    private  $plugin_version = '1.2.1' ;
    /**
     * Construct
     *
     * @param string $plugin_file_path Plugin file path.
     * @since  0.1.0
     * @author Scott Anderson <scott@church.agency>
     */
    public function __construct()
    {
        $this->define_constants();
        $this->import_resources();
        $this->hooks();
        $this->blast_off();
    }
    
    /**
     * Let's get this party started!
     * All resources are loadded in start sub-pages.
     *
     * @author Scott Anderson <scott@church.agency>
     * @since  NEXT
     */
    private function blast_off() : void
    {
        $plugin = new Sermons\Sermons( __FILE__ );
        $admin = new Admin();
        $settings = new Settings();
    }
    
    /**
     * Defines constants to be used across the plugin.
     *
     * @author Scott Anderson <scott@church.agency>
     * @since  NEXT
     */
    private function define_constants() : void
    {
        define( 'CACS_DIRECTORY', __DIR__ );
        define( 'CACS_PREFIX', 'cacs_' );
        define( 'CACS_SETTNIGS_ID', 2147483647 );
        define( 'CACS_DIRECTORY_NAME', $this->get_directory_name() );
    }
    
    /**
     * Returns working directory name. Premius add premium so we need to know which one.
     *
     * @author Scott Anderson <scott@church.agency>
     * @since  NEXT
     * @return string
     */
    private function get_directory_name() : string
    {
        $parts = explode( '/', __DIR__ );
        return $parts[count( $parts ) - 1];
    }
    
    /**
     * Class Hooks.
     *
     * @author Scott Anderson <scott@church.agency>
     * @since  NEXT
     */
    private function hooks() : void
    {
        add_action( 'init', [ $this, 'enqueue_styles' ] );
    }
    
    /**
     * Load all plugin styles and scripts.
     *
     * @author Scott Anderson <scott@church.agency>
     * @since  NEXT
     */
    public function enqueue_styles() : void
    {
        if ( 'on' !== cacs_get_setting( CACS_PREFIX . 'disable_global_styles' ) ) {
            wp_enqueue_style(
                'cs-sermons-css',
                plugins_url( '/utils/css/sermons.css', __FILE__ ),
                [],
                $this->plugin_version
            );
        }
        wp_enqueue_style(
            'cs-plyr-css',
            plugins_url( '/utils/css/plyr.css', __FILE__ ),
            [],
            $this->plugin_version
        );
        wp_enqueue_style(
            'cs-bootstrap-css',
            plugins_url( '/utils/css/bootstrap.css', __FILE__ ),
            [],
            $this->plugin_version
        );
        wp_enqueue_script(
            'cs-sermons-js',
            plugins_url( '/utils/js/sermons.js', __FILE__ ),
            array( 'jquery' ),
            $this->plugin_version
        );
        wp_enqueue_script(
            'cs-sermons-archive-js',
            plugins_url( '/utils/js/sermons-archive.js', __FILE__ ),
            array( 'jquery' ),
            $this->plugin_version
        );
        wp_enqueue_script(
            'cs-plyr-js',
            plugins_url( '/utils/js/plyr.js', __FILE__ ),
            array( 'jquery' ),
            $this->plugin_version
        );
        wp_enqueue_script(
            'cs-bootstrap-js',
            plugins_url( '/utils/js/bootstrap.js', __FILE__ ),
            array( 'jquery' ),
            $this->plugin_version
        );
        $this->load_bible_version();
    }
    
    /**
     * Loads Reference Tagger with proper bible translation.
     *
     * @author Scott Anderson <scott@church.agency>
     * @since  NEXT
     */
    private function load_bible_version() : void
    {
        wp_enqueue_script( 'cs-bible-verse-js', plugins_url( '/utils/js/reftagger.js', __FILE__ ), array( 'jquery' ) );
        $reftagger_settings = [
            'bible_verse' => cacs_get_setting( CACS_PREFIX . 'bible_version' ),
        ];
        wp_localize_script( 'cs-bible-verse-js', 'reftagger_settings', $reftagger_settings );
    }
    
    /**
     * Import all external resources.
     *
     * @author Scott Anderson <scott@church.agency>
     * @since  NEXT
     */
    private function import_resources() : void
    {
        $this->load_freemius();
        $this->load_cmb2();
        require CACS_DIRECTORY . '/Includes/template-functions.php';
        // Template functions.
        require CACS_DIRECTORY . '/Includes/shortcode-functions.php';
        // Template functions.
        require __DIR__ . '/Sermons/Sermons.php';
        require __DIR__ . '/Includes/Settings.php';
        require __DIR__ . '/Includes/Admin.php';
    }
    
    /**
     * Startup CMB2
     *
     * @author Scott Anderson <scott@church.agency>
     * @since  NEXT
     */
    private function load_cmb2() : void
    {
        
        if ( file_exists( dirname( __FILE__ ) . '/cmb2/init.php' ) ) {
            require_once dirname( __FILE__ ) . '/cmb2/init.php';
        } elseif ( file_exists( dirname( __FILE__ ) . '/CMB2/init.php' ) ) {
            require_once dirname( __FILE__ ) . '/CMB2/init.php';
        }
    
    }
    
    /**
     * Configures Freemius
     *
     * @author Scott Anderson <scott@church.agency>
     * @since  NEXT
     */
    private function load_freemius() : void
    {
        
        if ( !function_exists( '\\ChurchAgency\\ConnectedSermons\\cs_fs' ) ) {
            // Create a helper function for easy SDK access.
            function cs_fs()
            {
                global  $cs_fs ;
                $freemius_key = '';
                if ( defined( 'FREEMIUS_KEY' ) ) {
                    $freemius_key = FREEMIUS_KEY;
                }
                
                if ( !isset( $cs_fs ) ) {
                    // Include Freemius SDK.
                    require_once dirname( __FILE__ ) . '/freemius/start.php';
                    $cs_fs = fs_dynamic_init( array(
                        'id'             => '7980',
                        'slug'           => 'connected-sermons',
                        'type'           => 'plugin',
                        'public_key'     => 'pk_ac13686d1fb8446ce12e08f5b4109',
                        'is_premium'     => false,
                        'has_addons'     => false,
                        'has_paid_plans' => true,
                        'menu'           => array(
                        'slug'    => 'connected-sermons',
                        'support' => false,
                    ),
                        'is_live'        => true,
                    ) );
                }
                
                return $cs_fs;
            }
            
            // Init Freemius.
            cs_fs();
            // Signal that SDK was initiated.
            do_action( 'cs_fs_loaded' );
        }
    
    }

}
/**
 * Load the Plugin
 *
 * @author Scott Anderson <scott@church.agency>
 * @since  0.1.0
 */
function load_plugin()
{
    new ConnectedSermons();
}

add_action( 'plugins_loaded', '\\ChurchAgency\\ConnectedSermons\\load_plugin' );