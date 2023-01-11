<?php
/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @package    OpenForms
 * @subpackage OpenForms/includes
 */
class OpenForms_I18n {


	/**
	 * Load the plugin text domain for translation.
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'openforms',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

		/**
		 * TODO: This doesn't seem to work? The editor block remains 
		 * untranslated.
		 */
		wp_register_script( 'openforms-scripts', dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/build/index.js', array( 'wp-blocks', 'wp-element', 'wp-i18n', 'wp-block-editor' ) );

		wp_set_script_translations( 
			'openforms-scripts', 
			'openforms',
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

		//wp_set_script_translations( 'scripts', 'textdomain', get_template_directory() .'/languages/js' );

	}

}
