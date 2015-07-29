<?php

/**
 *	Log in process
 *
 *	When the admin is accessed with the wp_auto_login query arg,
 *	check to see if the current user is logged in.
 *	If not, set the current user to the defined account (username and password)
 */
if ( ! class_exists( 'WP_Auto_Login_Set_Current_User' ) ) :

class WP_Auto_Login_Set_Current_User {

	public function __construct() {

		add_action( 'init', array( $this, 'set_current_user' ) );
	}

	/**
	 *	Set current user session
	 */
	public function set_current_user() {

		$settings = wp_auto_login_get_settings();

		if ( ! is_admin() || is_user_logged_in() ) return;

		if ( ! isset( $_GET['wp_auto_login'] ) || $_GET['wp_auto_login'] !== 'true' ) return;

		$creds = array();
		$creds['user_login'] = $settings['username'];
		$creds['user_password'] = $settings['password'];
		$creds['remember'] = true;

		$user = wp_signon( $creds );

		if ( is_wp_error( $user ) )
			echo $user->get_error_message();

		wp_redirect( esc_url( get_admin_url() ) ); exit;
	}
}

endif;