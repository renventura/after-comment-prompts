<?php

/**
 * Class for adding a new field to the options-general.php page
 */

if ( ! class_exists( 'WP_Auto_Login_Settings' ) ) :

class WP_Auto_Login_Settings {

	public $settings;

	/**
	 *	Class constructor
	 */
	public function __construct() {

		add_action( 'admin_init' , array( $this , 'register_fields' ) );
	}

	/**
	 *	Add new fields to wp-admin/options-general.php page
	 */
	public function register_fields() {

		$this->settings = get_option( 'wp_auto_login' );

		$settings = array(
			'username' => 'wp_auto_login_username',
			'password' => 'wp_auto_login_password',
		);

		register_setting( 'general', 'wp_auto_login', array( $this, 'sanitize' ) );

		add_settings_section( 'wp-auto-login-section', 'WP Auto Login Creds', array( $this, 'settings_section_callback' ), 'general' );

		foreach( $settings as $key => $setting ) {

			add_settings_field( $setting, ucwords( $key ), array( $this, 'render_setting_input' ), 'general', 'wp-auto-login-section', array(
				$key => $setting
			) );
		}
	}

	/**
	 *	Section description
	 */
	public function settings_section_callback() {

		printf( '<p>%s<br/><strong>%s</strong></p>', __( 'Add the username and password for the account you want to be signed into. To log in automatically, navigate to:' ), get_admin_url( null, '/?wp_auto_login=true' ) );
	}

	/**
	 *	HTML for settings fields
	 *
	 *	@param array $args Data passed from add_settings_field()
	 */
	public function render_setting_input( $args ) {

		foreach( $args as $key => $value )
			printf( '<p><input type="text" id="wp_auto_login_%1$s" name="wp_auto_login[%1$s]" value="%2$s" /></p>', $key, esc_attr( $this->settings[$key] ) );
	}

	/**
	 *	Sanitize the input
	 *
	 *	@param array $input Settings
	 *	@return array $new_input Sanitized input
	 */
	public function sanitize( $input ) {

		$new_input = array();

		foreach ( $input as $key => $val )
			$new_input[ $key ] = ( isset( $input[ $key ] ) ) ? sanitize_text_field( $val ) : '';

		return $new_input;
	}
}

endif;