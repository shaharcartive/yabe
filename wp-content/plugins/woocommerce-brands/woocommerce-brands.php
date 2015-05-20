<?php
/*
Plugin Name: WooCommerce Brands Addon
Plugin URI: http://www.woothemes.com/products/brands/
Description: Adds a brand taxonomy and several widgets and shortcodes for display on the frontend.
Version: 1.2.8
Author: Mike Jolley
Author URI: http://mikejolley.com
Requires at least: 3.3
Tested up to: 4.1

	Copyright: (c) 2009-2011 WooThemes.
	License: GNU General Public License v3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

/**
 * Required functions
 */
if ( ! function_exists( 'woothemes_queue_update' ) )
	require_once( 'woo-includes/woo-functions.php' );

/**
 * Plugin updates
 */
woothemes_queue_update( plugin_basename( __FILE__ ), '8a88c7cbd2f1e73636c331c7a86f818c', '18737' );

if ( is_woocommerce_active() ) {

	/**
	 * Localisation
	 **/
	load_plugin_textdomain( 'wc_brands', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

	/**
	 * WC_Brands classes
	 **/
	require_once( 'classes/class-wc-brands.php' );

	if ( is_admin() ) {
		require_once( 'classes/class-wc-brands-admin.php' );
		add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'plugin_action_links' );
	}

	register_activation_hook( __FILE__, array( 'WC_Brands', 'init_taxonomy' ), 10 );
	register_activation_hook( __FILE__, 'flush_rewrite_rules', 20 );
	
	/**
	 * Add custom action links on the plugin screen.
	 *
	 * @param	mixed $actions Plugin Actions Links
	 * @return	array
	 */
	function plugin_action_links( $actions ) {
	
		$custom_actions = array();
	
		// documentation url if any
		$custom_actions['docs'] = sprintf( '<a href="%s">%s</a>', 'http://docs.woothemes.com/document/wc-brands/', __( 'Docs', 'wc_brands' ) );
	
		// support url
		$custom_actions['support'] = sprintf( '<a href="%s">%s</a>', 'http://support.woothemes.com/', __( 'Support', 'wc_brands' ) );
	
		// changelog link
		$custom_actions['changelog'] = sprintf( '<a href="%s" target="_blank">%s</a>', 'http://www.woothemes.com/changelogs/extensions/woocommerce-brands/changelog.txt', __( 'Changelog', 'wc_brands' ) );
	
		// add the links to the front of the actions list
		return array_merge( $custom_actions, $actions );
	}

	/**
	 * Helper function :: get_brand_thumbnail_url function.
	 *
	 * @access public
	 * @return string
	 */
	function get_brand_thumbnail_url( $brand_id, $size = 'full' ) {
		$thumbnail_id = get_woocommerce_term_meta( $brand_id, 'thumbnail_id', true );

		if ( $thumbnail_id )
			return current( wp_get_attachment_image_src( $thumbnail_id, $size ) );
	}

	/**
	 * get_brands function.
	 *
	 * @access public
	 * @param int $post_id (default: 0)
	 * @param string $sep (default: ')
	 * @param mixed '
	 * @param string $before (default: '')
	 * @param string $after (default: '')
	 * @return void
	 */
	function get_brands( $post_id = 0, $sep = ', ', $before = '', $after = '' ) {
		global $post;

		if ( $post_id )
			$post_id = $post->ID;

		return get_the_term_list( $post_id, 'product_brand', $before, $sep, $after );
	}
}
