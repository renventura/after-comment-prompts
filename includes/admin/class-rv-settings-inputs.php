<?php

if ( ! class_exists( 'RV_Settings_Inputs' ) ):

class RV_Settings_Inputs {

	/**
	 *	HTML field (WYSIWYG)
	 *
	 *	@param array $setting Setting from $this->render_setting_input()
	 *	@param array $option Global plugin option
	 */
	public function input_html( $setting, $option ) {

		if ( isset( $option[$setting['key']] ) )
			$default_value = $option[$setting['key']];

		else $default_value = '';

		$settings = array(
			'textarea_name' => AFTER_COMMENT_PROMPTS_SETTING_PREFIX_NO_UNDERSCORE . '[' . $setting['key'] . ']',
			'wpautop' => true,
			'media_buttons' => true,
			'teeny' => false,
			'quicktags' => true,
			'textarea_rows' => 15,
			'tinymce' => true // array( 'plugins' => 'inlinepopups, fullscreen, wordpress, wplink, wpdialogs' )
		);

		wp_editor( $default_value, AFTER_COMMENT_PROMPTS_SETTING_PREFIX . $setting['key'], $settings );

		if ( isset( $setting['directions'] ) )
			printf( '<p>%s</p>', $setting['directions'] );
	}

	/**
	 *	Text field
	 *
	 *	@param array $setting Setting from $this->render_setting_input()
	 *	@param array $option Global plugin option
	 */
	public function input_text( $setting, $option ) {

		printf( '<p><input type="text" class="regular-text" id="%s" name="%s" value="%s" /></p>', AFTER_COMMENT_PROMPTS_SETTING_PREFIX . $setting['key'], AFTER_COMMENT_PROMPTS_SETTING_PREFIX_NO_UNDERSCORE . '[' . $setting['key'] . ']', esc_attr( $option[$setting['key']] ) );

		if ( isset( $setting['directions'] ) )
			printf( '<p>%s</p>', $setting['directions'] );
	}

	/**
	 *	Checkbox field
	 *
	 *	@param array $setting Setting from $this->render_setting_input()
	 *	@param array $option Global plugin option
	 */
	public function input_checkbox( $setting, $option ) {

		if ( isset( $option[$setting['key']] ) )
			$value = $option[$setting['key']];

		else $value = '';

		?><input type="checkbox" id="<?php echo AFTER_COMMENT_PROMPTS_SETTING_PREFIX . $setting['key']; ?>" name="<?php echo AFTER_COMMENT_PROMPTS_SETTING_PREFIX_NO_UNDERSCORE . '[' . $setting['key'] . ']'; ?>" value="1" <?php checked( intval( $value ), 1 ); ?> /><?php

		if ( isset( $setting['directions'] ) )
			printf( '<p>%s</p>', $setting['directions'] );
	}


	/**
	 *	Text link (no input)
	 *
	 *	@param array $setting Setting from $this->render_setting_input()
	 *	@param array $option Global plugin option
	 */
	public function input_text_link( $setting, $option ) {

		// Get most recent comment
		$recent_comment = get_comments()[0];

		$post_url = get_permalink( $recent_comment->comment_post_ID );

		$with_query_args = add_query_arg( 'comment_added', $recent_comment->comment_ID, $post_url );

		$url = add_query_arg( array(

			'url' => urlencode( $with_query_args ),
			'return' => urlencode( $with_query_args ),

		), get_admin_url( null, 'customize.php' ) );

		printf( '<p><a href="%s" target="_blank">%s</a></p>', esc_url( $url ), $setting['directions'] );
	}
}

endif;