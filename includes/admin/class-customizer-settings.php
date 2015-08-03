<?php

/**
 *	Add style settings to the Customizer
 */

if ( ! class_exists( 'After_Comment_Prompts_Customizer_Settings' ) ):

class After_Comment_Prompts_Customizer_Settings {

	public function __construct() {

		add_action( 'customize_register', array( $this, 'register_customizer_fields' ) );
	}

	public function customizer_settings() {

		$settings = array(
			'panels' => array(

				// Panels
				array(
					'key' => 'after_comments_prompt_panel',
					'priority' => 99,
					'capability' => 'edit_theme_options',
					'theme_supports' => '',
					'title' => __( 'After Comments Prompt Modal', 'after_comments_prompt' ),
					'description' => __( 'Style the modal prompt users see after commenting on posts.', 'after_comments_prompt' ),
					'sections' => array(

						// Panel Sections
						array(
							'key' => 'after_comments_prompt_overlay_section',
							'priority' => 1,
							'title' => __( 'Overlay Settings', 'after_comments_prompt' ),
							'description' => __( 'Overlay color settings.', 'after_comments_prompt' ),
							'fields' => array(

								// Fields
								array(
									'type' => 'color',
									'key' => 'acp_customizer_modal_overlay_color',
									'label' => __( 'Overlay Color', 'after_comments_prompt' ),
									'default' => '#000000',
								),
								array(
									'type' => 'number',
									'key' => 'acp_customizer_modal_overlay_opacity',
									'label' => __( 'Overlay Opacity', 'after_comments_prompt' ),
									'default' => '0.5',
								),
							),
						),
						array(
							'key' => 'after_comments_prompt_modal_section',
							'priority' => 2,
							'title' => __( 'Modal Settings', 'after_comments_prompt' ),
							'description' => __( 'Modal color settings.', 'after_comments_prompt' ),
							'fields' => array(

								// Fields
								array(
									'type' => 'color',
									'key' => 'acp_customizer_modal_background_color',
									'label' => __( 'Modal Background', 'after_comments_prompt' ),
									'default' => '#ffffff',
								),
								array(
									'type' => 'color',
									'key' => 'acp_customizer_modal_close_color',
									'label' => __( 'Close Button Color', 'after_comments_prompt' ),
									'default' => '#DF0101',
								),
								array(
									'type' => 'number',
									'key' => 'acp_customizer_modal_width',
									'label' => __( 'Modal Width (pixels)', 'after_comments_prompt' ),
									'default' => '400',
								),
							),
						),
					),
				),
			),
		);

		return $settings;
	}

	/**
	 *	Add customizer controls for modal
	 */
	public function register_customizer_fields( $wp_customize ) {

		$settings = $this->customizer_settings();

		foreach ( $settings['panels'] as $panel ) {

			// Create the panel(s)
			$wp_customize->add_panel( $panel['key'], array(
				'priority'       => $panel['priority'],
				'capability'     => $panel['capability'],
				'theme_supports' => $panel['theme_supports'],
				'title'          => $panel['title'],
				'description'    => $panel['description'],
			) );

			foreach ( $panel['sections'] as $section ) {

				if ( ! isset( $section_priority ) )
					$section_priority = $section['priority'];

				$wp_customize->add_section( $section['key'], array(
					'title' => $section['title'],
					'description' => $section['description'],
					'priority' => $section_priority,
					'panel'  => $panel['key'],
				) );

				foreach ( $section['fields'] as $field ) {

					if ( ! isset( $field_priority ) )
						$field_priority = 1;

					switch ( $field['type'] ) {

						case 'color':
							$wp_customize->add_setting( $field['key'], array(
								'default' => $field['default'] ? $field['default'] : '',
							) );
							$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $field['key'], array(
								'label' => $field['label'],
								'section' => $section['key'],
								'settings' => $field['key'],
								'priority' => $field_priority,
							) ) );
							break;

						case 'number':
							$wp_customize->add_setting( $field['key'], array(
								'default' => $field['default'] ? $field['default'] : '',
								'sanitize_callback' => array( $this, 'sanitize_number' ),
						    ) );
							$wp_customize->add_control( $field['key'], array(
								'label' => $field['label'],
								'section' => $section['key'],
								'type' => 'text',
								'priority' => $field_priority,
							) );
							break;
						
						default:
							# code...
							break;
					}

					$field_priority++;
				}

				$section_priority++;
			}
		}
	}

	/**
	 *	Sanitize number fields
	 */
	public function sanitize_number( $input ) {

		$new_input = sanitize_text_field( $input );

		if ( is_numeric( $new_input ) )
			return $new_input;

		return 1;
	}
}

endif;