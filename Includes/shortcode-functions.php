<?php

//phpcs:ignore Wordpress.Files.Filename
/**
 * Register all shortcodes.
 *
 * @since NEXT
 * @package ChurchAgency\ConnectedSermons\Includes
 */
// Exit if accessed directly.
defined( 'ABSPATH' ) || die;
/**
 * Custom post type for Connected_Sermons Insights
 *
 * @since NEXT
 */
class CS_Shortcodes
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
    private function hooks() : void
    {
        add_shortcode( 'cs-sermons-list', [ $this, 'sermons_list' ] );
        
        if ( cacs_is_premium() ) {
            add_shortcode( 'cs-latest-sermon', [ $this, 'latest_sermon__premium_only' ] );
            add_shortcode( 'cs-sermons-filter', [ $this, 'sermons_filter__premium_only' ] );
            add_shortcode( 'cs-series-list', [ $this, 'series_list__premium_only' ] );
        }
    
    }
    
    /**
     * Displays Sermons List.
     *
     * @author Scott Anderson <scott@church.agency>
     * @since  1.1.5
     */
    public function sermons_list( $args )
    {
        $show_filters = true;
        if ( !empty($args['show_filters']) ) {
            $show_filters = rest_sanitize_boolean( $args['show_filters'] );
        }
        $page_size = 10;
        if ( !empty($args['num_sermons']) ) {
            $page_size = absint( sanitize_text_field( $args['num_sermons'] ) );
        }
        if ( 0 === $page_size ) {
            $page_size = 10;
        }
        set_query_var( 'page_size', $page_size );
        set_query_var( 'show_filters', $show_filters );
        ob_start();
        cacs_get_part( 'list-view' );
        return ob_get_clean();
    }
    
    /**
     * Display a Specific sermon
     *
     * @author Scott Anderson <scott@church.agency>
     * @since  NEXT
     * @param  array $args Shortcode arguments.
     */
    public function single_sermon( $args )
    {
        if ( empty($args['id']) ) {
            return __( 'No sermon id was provided.', 'ConnectedSermons' );
        }
        return $this->display_sermon_by_id( $args['id'] );
    }
    
    /**
     * Returns a Particular Sermon by ID
     *
     * @author Scott Anderson <scott@church.agency>
     * @since  NEXT
     * @param  string $id ID Of sermon to display.
     * @return
     */
    public function display_sermon_by_id( $id )
    {
        $sermon = get_post( $id );
        if ( empty($sermon) ) {
            return __( 'No sermon found by that id.', 'ConnectedSermons' );
        }
        ob_start();
        $this->opening_layout_container();
        cacs_get_part( 'sermon', $sermon, true );
        $this->closing_layout_container();
        return ob_get_clean();
    }
    
    /**
     * Provides Additional Styling for Layout Displays
     *
     * @author Scott Anderson <scott@church.agency>
     * @since  1.0.3
     */
    private function opening_layout_container() : void
    {
        echo  '<div class="ca container site-main ca-mt-10">' ;
    }
    
    /**
     * Provides Additional Styling for Layout Displays
     *
     * @author Scott Anderson <scott@church.agency>
     * @since  NEXT
     */
    private function opening_bootstrap_container() : void
    {
        echo  '<div class="ca">' ;
    }
    
    /**
     * Closes Additional Styling for Layout Displays
     *
     * @author Scott Anderson <scott@church.agency>
     * @since  1.0.3
     */
    private function closing_layout_container() : void
    {
        echo  '</div>' ;
    }

}
new CS_Shortcodes();