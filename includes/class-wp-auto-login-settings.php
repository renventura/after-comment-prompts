<?php

/**
 * Class for adding a new field to the options-general.php page
 */

if ( ! class_exists( 'WP_Auto_Login_Settings' ) ) :

class WP_Auto_Login_Settings {

	public $settings;

	/**
	 * Class constructor
	 */
	public function __construct() {

		add_action( 'admin_init' , array( $this , 'register_fields' ) );
	}

	/**
	 * Add new fields to wp-admin/options-general.php page
	 */
	public function register_fields() {

		$this->settings = get_option( 'wp_auto_login' );

		$settings = array( 'wp_auto_login_username', 'wp_auto_login_password' );

		register_setting( 'general', 'wp_auto_login' );

		add_settings_section( 'wp-auto-login-section', 'WP Auto Login Creds', array( $this, 'settings_section_callback' ), 'general' );
		add_settings_field( 'wp-auto-login-username', 'Username', array( $this, 'username_callback' ), 'general', 'wp-auto-login-section' );
		add_settings_field( 'wp-auto-login-password', 'Password', array( $this, 'password_callback' ), 'general', 'wp-auto-login-section' );
	}

	/**
	 *	Section description
	 */
	public function settings_section_callback() {

		echo 'This is the WP Auto Login Settings section';
	}

	/**
	 * HTML for username field
	 */
	public function username_callback() {

		$username = esc_attr( $this->settings['username'] );

		printf( '<p><input type="text" id="wp_auto_login_username" name="wp_auto_login[username]" value="%s" /></p>', $username );
	}

	/**
	 * HTML for password field
	 */
	public function password_callback() {

		$password = esc_attr( $this->settings['password'] );

		printf( '<p><input type="text" id="wp_auto_login_password" name="wp_auto_login[password]" value="%s" /></p>', $password );
	}
}

endif;