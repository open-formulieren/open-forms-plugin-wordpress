<?php
/**
 * Plugin Name:       Open Forms
 * Description:       Easily integrate Open Forms in your Wordpress website.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            The WordPress Contributors
 * License:           MIT
 * Text Domain:       openforms
 *
 * @package           openforms
 */

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function openforms_open_forms_block_init() {
	register_block_type( __DIR__ . '/build' );
}
add_action( 'init', 'openforms_open_forms_block_init' );
