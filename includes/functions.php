<?php

/**
 *	Helper functions
 */

/**
 *	Get plugin settings array
 *
 *	Example: wp_auto_login_get_settings()['username'];
 */
function after_comment_prompts_get_settings() {
	return get_option( 'after_comment_prompts' );
}

function after_comment_prompts_is_enabled() {

	$option = after_comment_prompts_get_settings();

	if ( isset( $option['enable'] ) && $option['enable'] == 1 )
		return true;

	return false;
}

function after_comment_prompts_is_hidden_for_logged_in() {

	$option = after_comment_prompts_get_settings();

	if ( isset( $option['hide_for_logged_on'] ) && $option['hide_for_logged_on'] == 1 )
		return true;

	return false;
}

function after_comment_prompts_get_modal( $message = null ) {

	ob_start();

	include_once AFTER_COMMENT_PROMPTS_PLUGIN_DIR . '/templates/modal-content.php';

	$output = ob_get_clean();

	return apply_filters( 'after_comment_prompts_modal_output', $output );
}