<?php
/**
 * Plugin Name: After Comment Prompts
 * Plugin URI: http://www.engagewp.com/
 * Description: Display a modal prompt after a user succesfully posts a comment. Great for calls to action like social follows, product views, etc.
 * Version: 1.0
 * Author: Ren Ventura
 * Author URI: http://www.engagewp.com/
 *
 * Text Domain: after_comments_prompt
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

if ( ! class_exists( 'After_Comment_Prompts' ) ) :

class After_Comment_Prompts {

	private $set_user, $settings, $customizer;

	public function __construct() {

		$this->constants();
		$this->includes();
		$this->hooks();

		$this->settings = new After_Comment_Prompts_Settings;
		$this->customizer = new After_Comment_Prompts_Customizer_Settings;
	}

	/**
	 *	Define plugin constants
	 */
	public function constants() {

		if ( ! defined( 'AFTER_COMMENT_PROMPTS_PLUGIN_DIR' ) )
			define( 'AFTER_COMMENT_PROMPTS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

		if ( ! defined( 'AFTER_COMMENT_PROMPTS_PLUGIN_URL' ) )
			define( 'AFTER_COMMENT_PROMPTS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

		if ( ! defined( 'AFTER_COMMENT_PROMPTS_PLUGIN_FILE' ) )
			define( 'AFTER_COMMENT_PROMPTS_PLUGIN_FILE', __FILE__ );

		if ( ! defined( 'AFTER_COMMENT_PROMPTS_VERSION' ) )
			define( 'AFTER_COMMENT_PROMPTS_VERSION', 1.0 );
	}

	/**
	 *	Include PHP files
	 */
	public function includes() {

		foreach ( glob( AFTER_COMMENT_PROMPTS_PLUGIN_DIR . '/includes/*.php' ) as $file )
			include_once $file;

		foreach ( glob( AFTER_COMMENT_PROMPTS_PLUGIN_DIR . '/includes/admin/*.php' ) as $file )
			include_once $file;
	}

	/**
	 *	Kick everything off
	 */
	public function hooks() {

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueues' ) );

		add_action( 'wp_footer', array( $this, 'add_prompt_content' ) );

		add_filter( 'comment_post_redirect', array( $this, 'comment_post_redirect' ), 10, 2 );
	}

	/**
	 *	Enqueue the assets
	 */
	public function enqueues() {

		// Bail if the functionality is not enabled
		if ( ! after_comment_prompts_is_enabled() ) return;

		wp_enqueue_style( 'popup-overlay-style', AFTER_COMMENT_PROMPTS_PLUGIN_URL . 'assets/css/style.min.css', '', AFTER_COMMENT_PROMPTS_VERSION );
		wp_enqueue_script( 'popup-overlay-script', AFTER_COMMENT_PROMPTS_PLUGIN_URL . 'assets/js/popup-overlay.min.js', array( 'jquery' ), AFTER_COMMENT_PROMPTS_VERSION, true );
		wp_enqueue_script( 'popup-overlay-script-init', AFTER_COMMENT_PROMPTS_PLUGIN_URL . 'assets/js/popup-overlay-init.min.js', array( 'jquery' ), AFTER_COMMENT_PROMPTS_VERSION, true );
	}

	/**
	 *	Add the content for the prompt modal
	 */
	public function add_prompt_content() {

		// Bail if the functionality is not enabled
		if ( ! after_comment_prompts_is_enabled() ) return;

		// Bail if comment_added query arg is not set or is something other than a number
		if ( ! isset( $_GET['comment_added'] ) || ! is_numeric( $_GET['comment_added'] ) ) return;

		// Bail if the modal is disable for logged-in users
		if ( after_comment_prompts_is_hidden_for_logged_in() && is_user_logged_in() ) return;

		// Comment object
		$comment = get_comment( $_GET['comment_added'] );

		// Commenter's first name
		$author_names = explode( ' ', $comment->comment_author );
		$author_fname = $author_names[0];

		// Message setting value
		$message = after_comment_prompts_get_settings()['message'];

		// Replace merge tags
		$message = str_replace( '{commenter_name}', $author_fname, $message );

		// Final output
		$output = after_comment_prompts_get_modal( $message );

		echo apply_filters( 'after_comment_prompts_modal_output_comments', $output, $comment, $message );
	}

	/**
	 *	Redirect to a custom URL after a comment is submitted
	 *	Added query arg used for displaying prompt
	 *
	 *	@param string $location Redirect URL
	 *	@param object $comment Comment object
	 *	@return string $location New redirect URL
	 */
	function comment_post_redirect( $location, $comment ) {

		$location = add_query_arg( array(

			'comment_added' => $comment->comment_ID

		), $location );

		return $location;
	}
}

endif;

/**
 *	Main function
 *
 *	@return object After_Comment_Prompts instance
 */
function After_Comment_Prompts() {
	return new After_Comment_Prompts;
}

//* Start the engine
After_Comment_Prompts();
