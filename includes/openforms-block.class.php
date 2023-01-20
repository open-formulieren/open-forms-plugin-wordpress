<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    OpenForms
 * @subpackage OpenForms/includes
 */
class OpenForms_Block {

	/**
	 * Register the frontend block.
	 */
	public function openforms_frontend_block() {
		$this->register_frontend_block();
	}

	/**
	 * TODO: Currently not needed I think but we do if it's a dynamic block?
	 */
	public function openforms_editor_block() {
	}


	/**
	 * Register the API used in the block.
	 */
    public function openforms_api() {
        $this->register_api();
    }

    /**
     * Registers the block using the metadata loaded from the `block.json` file.
     * Behind the scenes, it registers also all assets so they can be enqueued
     * through the block editor in the corresponding context.
     *
     * @see https://developer.wordpress.org/reference/functions/register_block_type/
     */
    public function register_frontend_block() {

        register_block_type( plugin_dir_path( __DIR__ ) . 'build', array(
            'attributes'      => [
                'formId' => [
                    'default' => '',
                    'type'    => 'string',
                ],
            ],
            'render_callback' => function( $attributes, $content ) {

                // TODO: Adding this here loads it only when needed but might
                // be nicer in the loader.
                // Enqueue block style
                wp_enqueue_style(
                    'openforms-sdk',
                    get_option('openforms_sdk_css_url')
                );
                
                // Enqueue block scripts
                wp_enqueue_script(
                    'openforms-sdk',
                    get_option('openforms_sdk_js_url')
                );

                $context = array(
                    'html_id' => 'openforms-root',
                    'base_url' => get_option( 'openforms_api_root' ),
                    'form_id' => $attributes['formId'],
                    # TODO: Maybe make configurable
                    'base_path' => '',
                    'csp_nonce' => '',
                    'lang' => '',
                    'sentry_dsn' => get_option( 'openforms_sentry_dsn' ),
                    'sentry_env' => get_option( 'openforms_sentry_env' ),
                );

                return OpenForms_Utils::render_to_string( 
                    plugin_dir_path( __DIR__ ) . 'templates/openforms_form.tpl.php',
                    $context
                );
            },
        ) );

    }

    /**
     * Register our custom API.
     * 
     * @see https://developer.wordpress.org/reference/functions/register_rest_route/
     */
    public function register_api() {

        register_rest_route( 'openforms/v1', '/forms', [
            'method'   => WP_REST_Server::READABLE,
            'callback' => 'OpenForms_Block::rest_api_get_forms',
        ] );
    }

    /**
     * Return a simple array of tuples (<id>, <form name>).
     * 
     * @return WP_REST_Response
     * 
     * @see https://developer.wordpress.org/reference/functions/rest_ensure_response/
     */
    public static function rest_api_get_forms( $request ) {

		// TODO: Pass nonce from the edit block to get the user.
        // Check access.
        // if( ! current_user_can( 'editor' ) ) {
        //     return wp_send_json_error( '', 403, [] );
        // }

		$client = OpenForms_Utils::get_client();
        $response = $client->get_forms();

        // array_map seems so nice for this but turns out to be very slow...
        $data = array();
        foreach ( $response as $form ) {
            $data[] = array( 
                'slug' => $form->slug, 
                'name' => empty( $form->name ) ? $form->slug : $form->name 
            );
        }

        // Sort the data on name.
        function build_sorter($key) {
            return function( $a, $b ) use ( $key ) {
                return strnatcmp( $a[$key], $b[$key] );
            };
        }
        usort( $data, build_sorter( 'name' ) );

        return rest_ensure_response( $data );
    }
}

