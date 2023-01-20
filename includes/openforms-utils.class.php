<?php
/**
 * Global utilities class used throughout the plugin
 *
 * @package    OpenForms
 * @subpackage OpenForms/includes
 */
class OpenForms_Utils {

	/**
	 * Return OpenForms client.
	 * 
	 * @return	Client	The instantiated OpenForms client.
	 */
	public static function get_client() {
		$api_root = get_option( 'openforms_api_root' );
		$api_token = get_option( 'openforms_api_token' );

		require_once plugin_dir_path( __FILE__ ) . 'openforms-client.class.php';

		return new OpenForms_Client( $api_root, $api_token );
	}

    /**
	 * Return a rendered template as string.
	 * 
	 * @param	template_file	The absolute file path to the template.
	 * @param	context			An array of attributes available in the template.
	 * 
	 * @return	string	The rendered template.
	 */
	public function render_to_string( $template_file, $context ) {
		ob_start();
		extract( $context, EXTR_SKIP );
		include( $template_file );
		$buffer = ob_get_contents();
		ob_end_clean();
		return $buffer;
	}

	/**
	 * Raises an exception if a response status is returned other than 2xx.
	 *
	 * Inspired by Python requests library.
	 *
	 * @param	response	The response array returned by wp_remote_request.
	 */
	public function raise_for_status( $response ) {
		if ( ! $response ) {
			throw new Exception( __( 'No response.', 'openforms' ) );
		}

		$response_code = wp_remote_retrieve_response_code( $response );

		if ( $response_code < 200 || $response_code > 299 ) {
			throw new Exception( __( 'Invalid response.', 'openforms' ) );
		}
	}

	/**
	 * Retrun the JSON object from a response object.
	 *
	 * @param 	response	The response array returned by wp_remote_request
	 *
	 * @return	object|bool	The JSON object or false when no data could be parsed.
	 */
	public function json( $response ) {
		$data = wp_remote_retrieve_body( $response );

		if ( ! empty( $data ) ) {
			return json_decode( $data );
		}

		return false;
	}

}
