<?php
/**
 * Plugin Name:       Open Forms
 * Plugin URI:        https://github.com/open-formulieren/open-forms-plugin-wordpress
 * Description:       Easily integrate Open Forms in your Wordpress website.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            Maykin
 * License:           GPLv2 or later
 * License URI:       https://github.com/open-formulieren/open-forms-plugin-wordpress/LICENSE
 * Text Domain:       openforms
 *
 * @package           OpenForms
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Include OpenFormsUtils class.
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/openformsutils.class.php';

/**
 * The core plugin class that is used to define internationalization
 * and admin-specific hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/openforms.class.php';

/**
 * Begins execution of the plugin.
 */
function run_openforms() {
	$plugin = new OpenForms();
	$plugin->run();
}

run_openforms();
