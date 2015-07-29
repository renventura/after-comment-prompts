<?php
/**
 * Plugin Name: WP Auto Login
 * Plugin URI: http://www.engagewp.com/
 * Description: Avoid login screens and automatically log a user in with a special URL. Use this plugin only on local development installations and delete it if moving the installation to a live server. THIS PLUGIN SHOULD NOT BE USED ON LIVE INSTALLATIONS.
 * Version: 1.0
 * Author: Ren Ventura
 * Author URI: http://www.engagewp.com/
 *
 * License: GPL 2.0+
 * License URI: http://www.opensource.org/licenses/gpl-license.php
 */

 /*
	Copyright 2015  Ren Ventura, EngageWP.com

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as
	published by the Free Software Foundation.

	Permission is hereby granted, free of charge, to any person obtaining a copy of this
	software and associated documentation files (the "Software"), to deal in the Software
	without restriction, including without limitation the rights to use, copy, modify, merge,
	publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons
	to whom the Software is furnished to do so, subject to the following conditions:

	The above copyright notice and this permission notice shall be included in all copies or
	substantial portions of the Software.

	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
	IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
	FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
	AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
	LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
	OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
	THE SOFTWARE.
*/

if ( ! class_exists( 'WP_Auto_Login' ) ) :

class WP_Auto_Login {

	/**
	 *	@since 1.0
	 */
	private static $instance;

	private static $signon;

	public static $settings;

	public static function instance() {

		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof WP_Auto_Login ) ) {

			self::$instance = new WP_Auto_Login;

			self::$instance->constants();
			self::$instance->includes();
			self::$instance->hooks();

			self::$signon = new WP_Auto_Login_Set_Current_User;
			self::$settings = new WP_Auto_Login_Settings;
		}

		return self::$instance;
	}

	public function constants() {

		if ( ! defined( 'WP_AUTO_LOGIN_PLUGIN_DIR' ) )
			define( 'WP_AUTO_LOGIN_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

		if ( ! defined( 'WP_AUTO_LOGIN_PLUGIN_URL' ) )
			define( 'WP_AUTO_LOGIN_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

		if ( ! defined( 'WP_AUTO_LOGIN_PLUGIN_FILE' ) )
			define( 'WP_AUTO_LOGIN_PLUGIN_FILE', __FILE__ );

		if ( ! defined( 'WP_AUTO_LOGIN_VERSION' ) )
			define( 'WP_AUTO_LOGIN_VERSION', 1.0 );
	}

	/**
	 *	Include all PHP files
	 */
	public function includes() {

		foreach ( glob( WP_AUTO_LOGIN_PLUGIN_DIR . '/includes/*.php' ) as $file )
			include_once $file;
	}

	/**
	 *	Kick everything off
	 */
	public function hooks() {

		register_activation_hook( WP_AUTO_LOGIN_PLUGIN_FILE, array( $this, 'plugin_activate' ) );
	}

	/**
	 *	Make sure users know what they're getting into
	 */
	public function plugin_activate() {

		add_action( 'activated_plugin', array( $this, 'useage_warning' ), 10, 2 );
	}

	/**
	 *	Display a message to the user after plugin activation
	 *	@param $plugin Plugin basename
	 */
	public function useage_warning( $plugin, $network_activation ) {

		if ( $plugin !== plugin_basename( WP_AUTO_LOGIN_PLUGIN_FILE ) ) return;

		$message = __( 'The WP Auto Login should only be used on local, development sites because it creates a major security hole on live installations.' );
		$message .= ' ';
		$message .= sprintf( '<a href="%s">%s</a>', esc_url( get_admin_url( null, 'plugins.php' ) ), __( 'Understood, proceed.' ) );

		wp_die( $message );
	}
}

endif;

/**
 *	Main function
 *
 *	@since 1.0
 *	@return object WP_Auto_Login instance
 */
function WP_Auto_Login() {
	return WP_Auto_Login::instance();
}

//* Start the engine
WP_Auto_Login();
