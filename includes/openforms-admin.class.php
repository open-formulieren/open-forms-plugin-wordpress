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
class OpenForms_Admin {

	/**
	 * Register settings form section.
	 */
	public function openforms_settings() {
		$this->register_section();
	}

	/**
	 * Register menu page.
	 */
	public function openforms_settings_page() {
		$this->register_menu();
	}


	/**
	 * Register section.
	 */
	public function register_section() {
		// Register settings for openforms plugin settings page.
		register_setting( 'openforms', 'openforms_api_root' );
		register_setting( 'openforms', 'openforms_api_token' );
		register_setting( 'openforms', 'openforms_sdk_css_url' );
		register_setting( 'openforms', 'openforms_sdk_js_url' );
		register_setting( 'openforms', 'openforms_sentry_dsn' );
		register_setting( 'openforms', 'openforms_sentry_env' );

		// Register a new section in the openforms page.
		add_settings_section(
			'openforms_api',
			__( '', 'openforms' ),
			'OpenForms_Admin::openforms_settings_section_title',
			'openforms'
		);

		add_settings_field(
			'openforms_api_root',
			__( 'API root URL', 'openforms' ),
			'OpenForms_Admin::openforms_char_field',
			'openforms',
			'openforms_api',
			array(
				"key"=>"openforms_api_root",
				"help_text"=>
				__( "The root URL of the Open Forms API. Example: https://forms.example.com/api/v1/", 'openforms' )
			)
		);

		add_settings_field(
			'openforms_api_token',
			__( 'Token', 'openforms' ),
			'OpenForms_Admin::openforms_char_field',
			'openforms',
			'openforms_api',
			array(
				"key"=>"openforms_api_token",
				"help_text"=>
				__( "The Open Forms API token value. Example: 7ab84e80b3d68d52a5f9e1712e3d0eda27d21e58", 'openforms' )
			)
		);

		// Register a new section in the openforms page.
		add_settings_section(
			'openforms_sdk',
			__( 'SDK', 'openforms' ),
			'OpenForms_Admin::openforms_settings_section_title',
			'openforms'
		);

		add_settings_field(
			'openforms_sdk_css_url',
			__( 'SDK CSS URL', 'openforms' ),
			'OpenForms_Admin::openforms_char_field',
			'openforms',
			'openforms_sdk',
			array(
				"key"=>"openforms_sdk_css_url",
				"help_text"=>
				__( "The Open Forms SDK stylesheet URL. Example: https://forms.example.com/static/sdk/open-forms-sdk.css", 'openforms' )
			)
		);

		add_settings_field(
			'openforms_sdk_js_url',
			__( 'SDK JS URL', 'openforms' ),
			'OpenForms_Admin::openforms_char_field',
			'openforms',
			'openforms_sdk',
			array(
				"key"=>"openforms_sdk_js_url",
				"help_text"=>
				__( "The Open Forms SDK JavaScript URL. Example: https://forms.example.com/static/sdk/open-forms-sdk.js", 'openforms' )
			)
		);

		// Register a new section in the openforms page.
		add_settings_section(
			'openforms_advanced',
			__( 'Advanced', 'openforms' ),
			'OpenForms_Admin::openforms_settings_section_title',
			'openforms'
		);

		add_settings_field(
			'openforms_sentry_dsn',
			__( 'Sentry DSN', 'openforms' ),
			'OpenForms_Admin::openforms_char_field',
			'openforms',
			'openforms_advanced',
			array(
				"key"=>"openforms_sentry_dsn",
				"help_text"=>
				__( 'The Sentry DSN (see Sentry.io).', 'openforms' )
			)
		);

		add_settings_field(
			'openforms_sentry_env',
			__( 'Sentry environment', 'openforms' ),
			'OpenForms_Admin::openforms_char_field',
			'openforms',
			'openforms_advanced',
			array(
				"key"=>"openforms_sentry_env",
				"help_text"=>
				__( "The environment name to register Sentry errors in. Example: production", 'openforms' )
			)
		);
	}

	/**
	 * Register menu for settings form page.
	 */
	private function register_menu() {
		// Add entry in settings menu
		add_options_page(
			__( 'Open Forms client configuration', 'openforms' ),
			__( 'Open Forms', 'openforms' ),
			'manage_options',
			'openforms',
			'OpenForms_Admin::openforms_settings_form'
		);
	}

	/**
	 * Section title.
	 *
	 * @param mixed $args Section title arguments.
	 * @return void
	 */
	public static function openforms_settings_section_title( $args ) {
	}

	/**
	 * Form fields
	 *
	 * @param mixed $args Field Arguments.
	 * @return void
	 */
	public static function openforms_char_field( $args ) {
		$field_name = $args['key'];
		$field_id = $field_name . "_field";
		$field_value = get_option( $field_name );
		$field_help_text = $args['help_text'];

		?>

			<input type="text" id="<?php echo esc_attr( $field_id ); ?>" name="<?php echo esc_attr( $field_name ); ?>" value="<?php echo esc_attr( $field_value ); ?>" size="50" />
			<?php if ( $field_help_text ): ?><p class="description" id="tagline-description"><?php echo esc_html( $field_help_text ); ?></p><?php endif; ?>
		<?php
	}

	/**
	 * Create settings form.
	 * 
	 */
	public static function openforms_settings_form() {
		// Check access.
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		require_once plugin_dir_path( __FILE__ ) . 'openformsutils.class.php';
		$client = OpenFormsUtils::get_client();
		
		// Check if the plugin is configured.
		if ( $client->has_config() ) {
			// If configured, check if the server can be accessed.
			// TODO: This should probably be an AJAX-call.
			$status = $client->is_healthy();
			if ( $status[0] === 'false' ) {
				add_settings_error( 'openforms_messages', 'openforms_settings_invalid_error', $status[1] );
			} else {
				add_settings_error( 'openforms_messages', 'openforms_settings_ok', __( 'Connection to Open Forms succeeded.' ), 'info' );
			}
		}

		settings_errors( 'openforms_messages' );
		?>
		<div class="wrap">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
			<form action="options.php" method="post">
				<?php
				// Display settings fields.
				settings_fields( 'openforms' );
				do_settings_sections( 'openforms' );

				// Submit button.
				submit_button( __( 'Save', 'openforms' ) );
				?>
			</form>
		</div>
			<?php
	}
}
