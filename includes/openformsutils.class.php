<?php
/**
 * Global utilities class used throughout the plugin
 *
 * @package    OpenForms
 * @subpackage OpenForms/includes
 */
class OpenFormsUtils {

	/**
	 * Return OpenForms client.
	 * 
	 * @return	Client	The instantiated OpenForms client.
	 */
	public static function get_client() {
		$api_root = get_option( 'openforms_api_root' );
		$api_token = get_option( 'openforms_api_token' );

		require_once plugin_dir_path( __FILE__ ) . 'openforms-client.class.php';

		return new Client( $api_root, $api_token );
	}

    /**
	 * Return a rendered template as string.
	 * 
	 * @param	template_file	The absolute file path to the template.
	 * @param	context			An array of attributes available in the template.
	 * 
	 * @return	string	The rendered template.
	 */
	function render_to_string( $template_file, $context ) {
		ob_start();
		extract( $context, EXTR_SKIP );
		include( $template_file );
		$buffer = ob_get_contents();
		ob_end_clean();
		return $buffer;
	}
}
