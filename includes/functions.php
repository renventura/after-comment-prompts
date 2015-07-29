<?php

/**
 *	Helper functions
 */

/**
 *	Get plugin settings array
 *
 *	Example: wp_auto_login_get_settings()['username'];
 */
function wp_auto_login_get_settings() {
	return get_option( 'wp_auto_login' );
}