<?php
/**
 *	Helper functions
 *
 *	@package After Comment Prompts
 *	@author Ren Ventura
 */

/**
 *	Get plugin settings array
 *
 *	@example wp_auto_login_get_settings()['username'];
 *	@return array Option storing an array of the plugin's settings
 */
function after_comment_prompts_get_settings() {
	return get_option( 'after_comment_prompts' );
}

/**
 *	Check to see if plugin's functionality is enabled from the Enable setting
 *
 *	@return boolean True if setting is enabled, false otherwise
 */
function after_comment_prompts_is_enabled() {

	$option = after_comment_prompts_get_settings();

	if ( isset( $option['enable'] ) && $option['enable'] == 1 ) {
		return true;
	}

	return false;
}

/**
 *	Check to see if comment prompts are hidden for logged-in users
 *
 *	@return boolean True if setting is enabled, false otherwise
 */
function after_comment_prompts_is_hidden_for_logged_in() {

	$option = after_comment_prompts_get_settings();

	if ( isset( $option['hide_for_logged_on'] ) && $option['hide_for_logged_on'] == 1 ) {
		return true;
	}

	return false;
}

/**
 *	Get the default markup for modals
 *
 *	@return string $output Default markup
 */
function after_comment_prompts_get_modal( $message = null ) {

	ob_start();

	include_once AFTER_COMMENT_PROMPTS_PLUGIN_DIR . '/templates/modal-content.php';

	$output = ob_get_clean();

	return apply_filters( 'after_comment_prompts_modal_output', $output );
}