<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.excellgene.com
 * @since             1.0.0
 * @package           Display_Last_Post
 *
 * @wordpress-plugin
 * Plugin Name:       Display Last Post
 * Plugin URI:        https://www.excellgene.com
 * Description:       Display last post by category
 * Version:           1.0.0
 * Author:            Excellgene
 * Author URI:        https://www.excellgene.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       display-last-post
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'DISPLAY_LAST_POST_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-display-last-post-activator.php
 */
function activate_display_last_post() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-display-last-post-activator.php';
	Display_Last_Post_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-display-last-post-deactivator.php
 */
function deactivate_display_last_post() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-display-last-post-deactivator.php';
	Display_Last_Post_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_display_last_post' );
register_deactivation_hook( __FILE__, 'deactivate_display_last_post' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-display-last-post.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_display_last_post() {

	$plugin = new Display_Last_Post();
	$plugin->run();

}
run_display_last_post();
