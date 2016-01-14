<?php
/**
 *	Add new settings fields to the options-general.php page
 *
 *	@package After Comment Prompts
 *	@author Ren Ventura
 */

if ( ! class_exists( 'After_Comment_Prompts_Settings' ) ) :

class After_Comment_Prompts_Settings {

	public $option, $inputs;

	public function __construct() {

		$this->constants();

		require_once 'class-rv-settings-inputs.php';

		$this->inputs = new RV_Settings_Inputs;

		add_action( 'admin_init' , array( $this , 'register_fields' ) );
	}

	/**
	 *	Settings constants
	 */
	public function constants() {

		if ( ! defined( 'AFTER_COMMENT_PROMPTS_SETTING_PREFIX' ) ) {
			define( 'AFTER_COMMENT_PROMPTS_SETTING_PREFIX', 'after_comment_prompts_' );
		}

		if ( ! defined( 'AFTER_COMMENT_PROMPTS_SETTING_PREFIX_NO_UNDERSCORE' ) ) {
			define( 'AFTER_COMMENT_PROMPTS_SETTING_PREFIX_NO_UNDERSCORE', 'after_comment_prompts' );
		}

		if ( ! defined( 'AFTER_COMMENT_PROMPTS_SETTING_SECTION_NAME' ) ) {
			define( 'AFTER_COMMENT_PROMPTS_SETTING_SECTION_NAME', 'after-comment-prompts-settings-section' );
		}
	}

	/**
	 *	The settings to register
	 *
	 *	@return array $settings Settings to register in the admin
	 */
	public function settings() {

		// Directions for the message setting
		$merge_tags = array(
			'{commenter_name}' => __( 'The name of the comment author;', 'after-comment-prompts' ),
		);

		$message_directions = sprintf( __( 'The following merge tags can be used in your message:', 'after-comment-prompts' ) );
		
		$message_directions .= '<ul>';
		
		foreach ( $merge_tags as $key => $val ) {
			$message_directions .= sprintf( '<li><strong>%s</strong> - %s</li>', $key, $val );
		}
		
		$message_directions .= '</ul>';

		//* Plugin options/settings
		$settings = array(
			array(
				'key' => 'enable',
				'title' => __( 'Enable Prompts', 'after-comment-prompts' ),
				'type' => 'checkbox'
			),
			array(
				'key' => 'hide_for_logged_on',
				'title' => __( 'Hide for logged in users?', 'after-comment-prompts' ),
				'type' => 'checkbox'
			),
			array(
				'key' => 'message',
				'title' => __( 'Prompt Message', 'after-comment-prompts' ),
				'type' => 'html',
				'directions' => $message_directions
			),
			array(
				'key' => 'customize_link',
				'title' => 'Customize Design', 'after-comment-prompts',
				'type' => 'text_link',
				'directions' => __( 'Customize modal design', 'after-comment-prompts' )
			),
		);

		return $settings;
	}

	/**
	 *	Add new fields to wp-admin/options-discussion.php page
	 */
	public function register_fields() {

		//* Get the main plugin option (array)
		$this->option = get_option( 'after_comment_prompts' );

		$settings = $this->settings();

		/**
		 *	Register a setting
		 *
		 *	@param string $option_group A settings group name. Must exist prior to the register_setting call. This must match the group name in settings_fields()
		 *	@param string $option_name The name of an option to sanitize and save.
		 *	@param string $sanitize_callback A callback function that sanitizes the option's value.
		 */
		register_setting( 'discussion', AFTER_COMMENT_PROMPTS_SETTING_PREFIX_NO_UNDERSCORE, array( $this, 'sanitize' ) );

		/**
		 *	Add a settings section
		 *
		 *	@param string $id For use in the 'id' attribute of tags.
		 *	@param string $title Title of the section.
		 *	@param string $callback Function that fills the section with the desired content. The function should echo its output.
		 *	@param string $page The menu page on which to display this section. Should match $menu_slug from Function Reference/add theme page.
		 */
		add_settings_section( AFTER_COMMENT_PROMPTS_SETTING_SECTION_NAME, __( 'After Comment Prompt' ), array( $this, 'settings_section_callback' ), 'discussion' );

		foreach ( $settings as $setting ) {

			/**
			 *	Add a settings field
			 *
			 *	@param string $id For use in the 'id' attribute of tags.
			 *	@param string $title Title of the field.
			 *	@param string $callback Function that fills the field with the desired inputs as part of the larger form. Name and id of the input should match the $id given to this function. The function should echo its output.
			 *	@param string $page The menu page on which to display this field. Should match $menu_slug from add_theme_page() or from do_settings_sections().
			 *	@param string $sections The section of the settings page in which to show the box - default or a section you added with add_settings_section()
			 *	@param string $args Additional arguments that are passed to the $callback function. 
			 */
			add_settings_field( $setting['key'], $setting['title'], array( $this, 'render_setting_input' ), 'discussion', AFTER_COMMENT_PROMPTS_SETTING_SECTION_NAME, $setting );
		}
	}

	/**
	 *	Section description
	 */
	public function settings_section_callback() {

		printf( '<p>%s</p>', __( 'Create a modal prompt to display after a user comments on a post.', 'after-comment-prompts' ) );
	}

	/**
	 *	HTML for settings fields
	 *
	 *	@param array $setting Data passed from add_settings_field()
	 */
	public function render_setting_input( $setting ) {
		call_user_func( array( $this->inputs, 'input_' . $setting['type'] ), $setting, $this->option );
	}

	/**
	 *	Sanitize the input
	 *
	 *	@param array $input Settings
	 *	@return array $new_input Sanitized input
	 */
	public function sanitize( $input ) {

		$new_input = array();

		foreach ( $input as $key => $val ) {

			$new_input[$key] = ( isset( $input[$key] ) ) ? wp_kses_post( $val ) : '';
		}

		return $new_input;
	}
}

endif;