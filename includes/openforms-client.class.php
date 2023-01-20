<?php
/**
 * Open Forms Client
 *
 * @package    OpenForms
 * @subpackage OpenForms/includes
 */


class OpenForms_Client {
    private $api_root;
    private $api_token;
  
    function __construct( $api_root, $api_token ) {
        $this->api_root = $api_root;
        $this->api_token = $api_token;
    }

    /**
     * Request a URL with the configured token.
     * 
     * @see https://developer.wordpress.org/reference/functions/wp_remote_request/
     */
	private function request( $method, $relative_url ) {

        $headers = array( 
            'Accept' => 'application/json',
            'Authorization' => 'Token ' . $this->api_token,
        );

        $url = $this->api_root . $relative_url;
        $response = wp_remote_request( 
            $url, 
            array( 
                'method' => strtoupper( $method ), 
                'headers' => $headers,
                'timeout' => 2.0,
            ) 
        );

        return $response;
	}

    /**
     * Return a boolean to indicate if the plugin is configured. This can still
     * be an invalid configuration.
     * 
     * @return bool True if the plugin is configured.
     */
    public function has_config() {
        return ( ! empty( $this->api_root ) && ! empty( $this->api_token ) );
    }

    /**
     * Return a boolean to indicate if the configuration is valid and the 
     * Open Forms server is available.
     * 
     * @return bool True if we can properly connect to the Open Forms server.
     */
    public function is_healthy() {
        try {
            # We do a head request to actually hit a protected endpoint without
            # getting a whole bunch of data.
            $response = $this->request("head", "forms");
            OpenForms_Utils::raise_for_status( $response );
            return array( 'true', "" );
        }
        catch (Exception $e) {
            # If something is wrong, we might get more information from the
            # error message provided by Open Forms.
            try {
                $response = $this->request("get", "forms");
                $data = OpenForms_Utils::json( $response );

                if ( ! empty( $data->detail ) ) {
                    $message = $data->detail;
                }
                elseif ( ! empty( $data->title ) ) {
                    $message = $data->title;
                }
                else {
                    $message = sprintf(
                        /* translators: %s: Error message */
                        __("Server error: %s", "openforms" ),
                        $e->getMessage()
                    );
                }
            }
            catch (Exception $e) {
                $message = sprintf(
                    /* translators: %s: Error message */
                    __("Server error: %s", "openforms" ),
                    $e->getMessage()
                );
            }
        }

        return array( 'false', $message );
    }

    /**
     * Retrieve all available forms in Open Forms API.
     *
     * @return object The API response content as object.
     */        
    public function get_forms() {
        $response = $this->request("get", "forms");
        OpenForms_Utils::raise_for_status( $response );

        return OpenForms_Utils::json( $response );
    }

    /**
     * Retrieve a specific form from the Open Forms API.
     *
     * @param uuid_or_slug The UUID or the slug that identifies the form.
     * @return object The API response content as object.
     */
    public function get_form( $uuid_or_slug ) {
        $response = $this->request("get", "forms/" . $uuid_or_slug);
        OpenForms_Utils::raise_for_status( $response );

        return OpenForms_Utils::json( $response );
    }

}
