<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://www.excellgene.com
 * @since      1.0.0
 *
 * @package    Display_Last_Post
 * @subpackage Display_Last_Post/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Display_Last_Post
 * @subpackage Display_Last_Post/includes
 * @author     Excellgene <sergio.dacosta@excellgene.com>
 */
class Display_Last_Post_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'display-last-post',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
