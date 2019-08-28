<?php
/**
 * Skinning System
 *
 * @package     WebMan WordPress Theme Framework
 * @subpackage  Skinning System
 * @copyright   2014 WebMan - Oliver Juhas
 * @uses        Theme Customizer Options Array
 * @uses        Custom CSS Styles Generator
 *
 * @since       3.0
 * @version     3.4
 * @version  1.9.3
 *
 * CONTENT:
 * - 1) Required files
 * - 10) Actions and filters
 * - 20) Helpers
 * - 30) Main customizer function
 * - 40) Saving skins
 */





/**
 * 1) Required files
 */

	//Include function to generate the WordPress Customizer CSS
		require get_theme_file_path( 'assets/css/_custom-styles.php' );
	//Include sanitizing functions
		require get_theme_file_path( WM_LIBRARY_DIR . 'includes/sanitize.php' );





/**
 * 10) Actions and filters
 */

	/**
	 * Actions
	 */

		//Register customizer
			add_action( 'customize_register', 'wm_theme_customizer' );
		//Enqueue styles and scripts
			add_action( 'customize_controls_enqueue_scripts', 'wm_theme_customizer_assets' );
		//Regenerating main stylesheet
			add_action( 'customize_save_after', 'wm_generate_all_css', 100 );





/**
 * 20) Helpers
 */

	/**
	 * Enqueue styles and scripts to main customizer window
	 *
	 * You can actually control the customizer option fields here.
	 *
	 * @version  1.5
	 */
	if ( ! function_exists( 'wm_theme_customizer_assets' ) ) {
		function wm_theme_customizer_assets() {
			/**
			 * Styles
			 */

				//Styles
					wp_enqueue_style( 'wm-theme-customizer' );

			/**
			 * Scripts
			 */

				wp_localize_script( 'jquery', 'wmCustomizerHelper', array( 'wmThemeShortname' => WM_THEME_SHORTNAME ) );

				wp_enqueue_script( 'wm-customizer' );
		}
	} // /wm_theme_customizer_assets



	/**
	 * Outputs styles in customizer preview head
	 *
	 * @version  1.5
	 */
	if ( ! function_exists( 'wm_theme_customizer_css' ) ) {
		function wm_theme_customizer_css() {

			// Helper variables

				$output = wm_custom_styles();


			// Output

				if ( $output ) {
					wp_add_inline_style( 'stylesheet-global', apply_filters( 'wmhook_esc_css', $output ) );
				}

		}
	} // /wm_theme_customizer_css



	/**
	 * Outputs customizer JavaScript in footer
	 *
	 * Use this structure for customizer_js property:
	 * 'customizer_js' => array(
	 * 			'css'    => array(
	 * 					'.selector'         => array( 'css-property-name' ),
	 * 					'.another-selector' => array( array( 'padding-left', 'px' ) ),
	 * 				),
	 * 			'custom' => 'your_custom_JavaScript_here',
	 * 		)
	 */
	if ( ! function_exists( 'wm_theme_customizer_js' ) ) {
		function wm_theme_customizer_js() {
			//Helper variables
				$wm_skin_design = apply_filters( 'wmhook_theme_options_skin_array', array() );

				$output = $output_single = '';

			//Preparing output
				if ( is_array( $wm_skin_design ) && ! empty( $wm_skin_design ) ) {
					foreach ( $wm_skin_design as $skin_option ) {
						if ( isset( $skin_option['customizer_js'] ) ) {
							$output_single  = "wp.customize( '" . WM_THEME_SETTINGS_SKIN . "[" . WM_THEME_SETTINGS_PREFIX . $skin_option['id'] . "]" . "', function( value ) {"  . "\r\n";
							$output_single .= "\t" . 'value.bind( function( newval ) {' . "\r\n";

							if ( ! isset( $skin_option['customizer_js']['custom'] ) ) {
								foreach ( $skin_option['customizer_js']['css'] as $selector => $properties ) {
									if ( is_array( $properties ) ) {
										$output_single_css = '';

										foreach ( $properties as $property ) {
											if ( ! is_array( $property ) ) {
												$property = array( $property, '' );
											}
											if ( ! isset( $property[1] ) ) {
												$property[1] = '';
											}
											if ( trim( $property[1] ) ) {
												$property[1] = ' + "' . $property[1] . '"';
											}

											$output_single_css .= '.css( "' . $property[0] . '", newval' . $property[1] . ' )';
										}
									}

									$output_single .= "\t\t" . '$( "' . $selector . '" )' . $output_single_css . ";\r\n";
								}
							} else {
								$output_single .= "\t\t" . $skin_option['customizer_js']['custom'] . "\r\n";
							}

							$output_single .= "\t" . '} );' . "\r\n";
							$output_single .= '} );'. "\r\n";
							$output_single  = apply_filters( 'wmhook_wm_theme_customizer_js_option_' . $skin_option['id'], $output_single );

							$output .= $output_single;
						}
					}
				}

			//Output
				if ( trim( $output ) ) {
					echo apply_filters( 'wmhook_wm_theme_customizer_js_output', '<!-- Theme custom scripts -->' . "\r\n" . '<script type="text/javascript"><!--' . "\r\n" . '( function( $ ) {' . "\r\n\r\n" . $output . "\r\n\r\n" . '} )( jQuery );' . "\r\n" . '//--></script>' );
				}
		}
	} // /wm_theme_customizer_js





/**
 * 30) Main customizer function
 */

	/**
	 * Registering sections and options for WP Customizer
	 *
	 * @version  1.9.3
	 *
	 * @param  object $wp_customize WP customizer object.
	 */
	if ( ! function_exists( 'wm_theme_customizer' ) ) {
		function wm_theme_customizer( $wp_customize ) {
			/**
			 * Custom customizer controls
			 *
			 * @link  https://github.com/bueltge/Wordpress-Theme-Customizer-Custom-Controls
			 * @link  http://ottopress.com/2012/making-a-custom-control-for-the-theme-customizer/
			 */

				require get_theme_file_path( WM_LIBRARY_DIR . 'includes/controls/class-WM_Customizer_Hidden.php' );
				require get_theme_file_path( WM_LIBRARY_DIR . 'includes/controls/class-WM_Customizer_HTML.php' );
				require get_theme_file_path( WM_LIBRARY_DIR . 'includes/controls/class-WM_Customizer_Multiselect.php' );
				require get_theme_file_path( WM_LIBRARY_DIR . 'includes/controls/class-WM_Customizer_Radiocustom.php' );
				require get_theme_file_path( WM_LIBRARY_DIR . 'includes/controls/class-WM_Customizer_Range.php' );



			//Helper variables
				$wm_skin_design = (array) apply_filters( 'wmhook_theme_options_skin_array', array() );

				$allowed_option_types = apply_filters( 'wmhook_wm_theme_customizer_allowed_option_types', array(
						'background',
						'checkbox',
						'color',
						'email',
						'hidden',
						'html',
						'image',
						'multiselect',
						'password',
						'radio',
						'radiocustom',
						'range',
						'select',
						'text',
						'textarea',
						'url',
					) );

				//To make sure our customizer sections start after WordPress default ones
					$priority = apply_filters( 'wmhook_wm_theme_customizer_priority', 0 );
				//Default section name in case not set (should be overwritten anyway)
					$customizer_panel   = '';
					$customizer_section = WM_THEME_SHORTNAME;

			//Generate customizer options
				if ( is_array( $wm_skin_design ) && ! empty( $wm_skin_design ) ) {

					foreach ( $wm_skin_design as $skin_option ) {

						if (
								is_array( $skin_option )
								&& isset( $skin_option['type'] )
								&& (
										in_array( $skin_option['type'], $allowed_option_types )
										|| isset( $skin_option['create_section'] )
									)
							) {

							//Helper variables
								$priority++;

								$option_id = $default = $description = '';

								if ( isset( $skin_option['id'] ) ) {
									$option_id = WM_THEME_SETTINGS_PREFIX . $skin_option['id'];
								}
								if ( isset( $skin_option['default'] ) ) {
									$default = $skin_option['default'];
								}
								if ( isset( $skin_option['description'] ) ) {
									$description = $skin_option['description'];
								}

								$transport = ( isset( $skin_option['customizer_js'] ) ) ? ( 'postMessage' ) : ( 'refresh' );



							/**
							 * Panels
							 *
							 * Panels are wrappers for customizer sections.
							 * Note that the panel will not display unless sections are assigned to it.
							 * Set the panel name in the section declaration with `in_panel`.
							 * Panel has to be defined for each section to prevent all sections within a single panel.
							 *
							 * @link  http://make.wordpress.org/core/2014/07/08/customizer-improvements-in-4-0/
							 */
							if ( isset( $skin_option['in_panel'] ) ) {

								$panel_id = sanitize_title( trim( $skin_option['in_panel'] ) );

								if ( $customizer_panel !== $panel_id ) {

									$wp_customize->add_panel(
											$panel_id,
											array(
												'title'       => $skin_option['in_panel'], // Panel title
												'description' => ( isset( $skin_option['in_panel-description'] ) ) ? ( $skin_option['in_panel-description'] ) : ( '' ), // Hidden at the top of the panel
												'priority'    => $priority,
											)
										);

									$customizer_panel = $panel_id;
								}

							}



							/**
							 * Sections
							 */
							if ( isset( $skin_option['create_section'] ) && trim( $skin_option['create_section'] ) ) {

								if ( empty( $option_id ) ) {
									$option_id = sanitize_title( trim( $skin_option['create_section'] ) );
								}

								$customizer_section = array(
										'id'    => $option_id,
										'setup' => array(
												'title'       => $skin_option['create_section'], // Section title
												'description' => ( isset( $skin_option['create_section-description'] ) ) ? ( $skin_option['create_section-description'] ) : ( '' ), // Displayed at the top of section
												'priority'    => $priority,
											)
									);

								if ( ! isset( $skin_option['in_panel'] ) ) {
									$customizer_panel = '';
								} else {
									$customizer_section['setup']['panel'] = $customizer_panel;
								}

								$wp_customize->add_section(
										$customizer_section['id'],
										$customizer_section['setup']
									);

								$customizer_section = $customizer_section['id'];

							}



							/**
							 * Options
							 *
							 * With add_setting() use a 'type' => 'option' (available: 'option' and 'theme_mod').
							 * Read more at @link  http://wordpress.stackexchange.com/questions/155072/get-option-vs-get-theme-mod-why-is-one-slower
							 */
							switch ( $skin_option['type'] ) {

								/**
								 * Background combo options
								 */
								case 'background':

									$wp_customize->add_setting(
											WM_THEME_SETTINGS_SKIN . '[' . $option_id . '-bg-color]',
											array(
												'type'                 => 'option',
												'default'              => ( isset( $default['color'] ) ) ? ( $default['color'] ) : ( null ),
												'transport'            => $transport,
												'sanitize_callback'    => 'sanitize_hex_color_no_hash',
												'sanitize_js_callback' => 'maybe_hash_hex_color',
											)
										);

										$wp_customize->add_control( new WP_Customize_Color_Control(
												$wp_customize,
												WM_THEME_SETTINGS_SKIN . '[' . $option_id . '-bg-color]',
												array(
													'label'    => __( 'Background color', 'mustang-lite' ),
													'section'  => $customizer_section,
													'priority' => $priority,
												)
											) );

									$wp_customize->add_setting(
											WM_THEME_SETTINGS_SKIN . '[' . $option_id . '-bg-url]',
											array(
												'type'                 => 'option',
												'default'              => ( isset( $default['url'] ) ) ? ( $default['url'] ) : ( null ),
												'transport'            => $transport,
												'sanitize_callback'    => 'wm_sanitize_return_value',
												'sanitize_js_callback' => 'wm_sanitize_return_value',
											)
										);

										$wp_customize->add_control( new WP_Customize_Image_Control(
												$wp_customize,
												WM_THEME_SETTINGS_SKIN . '[' . $option_id . '-bg-url]',
												array(
													'label'    => __( 'Background image', 'mustang-lite' ),
													'section'  => $customizer_section,
													'priority' => ++$priority,
													'context'  => WM_THEME_SETTINGS_SKIN . '[' . $option_id . '-bg-url]',
												)
											) );

									$wp_customize->add_setting(
											WM_THEME_SETTINGS_SKIN . '[' . $option_id . '-bg-url-hidpi]',
											array(
												'type'                 => 'option',
												'default'              => ( isset( $default['url-hidpi'] ) ) ? ( $default['url-hidpi'] ) : ( null ),
												'transport'            => $transport,
												'sanitize_callback'    => 'wm_sanitize_return_value',
												'sanitize_js_callback' => 'wm_sanitize_return_value',
											)
										);

										$wp_customize->add_control( new WP_Customize_Image_Control(
												$wp_customize,
												WM_THEME_SETTINGS_SKIN . '[' . $option_id . '-bg-url-hidpi]',
												array(
													'label'           => __( 'High DPI background image', 'mustang-lite' ),
													'section'         => $customizer_section,
													'priority'        => ++$priority,
													'context'         => WM_THEME_SETTINGS_SKIN . '[' . $option_id . '-bg-url-hidpi]',
													'active_callback' => 'wm_active_callback_background_image',
												)
											) );

									if ( function_exists( 'wm_helper_var' ) ) {

										$wp_customize->add_setting(
												WM_THEME_SETTINGS_SKIN . '[' . $option_id . '-bg-position]',
												array(
													'type'                 => 'option',
													'default'              => ( isset( $default['position'] ) ) ? ( $default['position'] ) : ( '50% 0' ),
													'transport'            => $transport,
													'sanitize_callback'    => 'esc_attr',
													'sanitize_js_callback' => 'esc_attr',
												)
											);

											$wp_customize->add_control( new WM_Customizer_Radiocustom(
													$wp_customize,
													WM_THEME_SETTINGS_SKIN . '[' . $option_id . '-bg-position]',
													array(
														'label'           => __( 'Background position', 'mustang-lite' ),
														'section'         => $customizer_section,
														'priority'        => ++$priority,
														'choices'         => wm_helper_var( 'bg-css', 'position' ),
														'class'           => 'matrix',
														'active_callback' => 'wm_active_callback_background_image',
													)
												) );

										$wp_customize->add_setting(
												WM_THEME_SETTINGS_SKIN . '[' . $option_id . '-bg-repeat]',
												array(
													'type'                 => 'option',
													'default'              => ( isset( $default['repeat'] ) ) ? ( $default['repeat'] ) : ( 'no-repeat' ),
													'transport'            => $transport,
													'sanitize_callback'    => 'esc_attr',
													'sanitize_js_callback' => 'esc_attr',
												)
											);

											$wp_customize->add_control(
													WM_THEME_SETTINGS_SKIN . '[' . $option_id . '-bg-repeat]',
													array(
														'label'           => __( 'Background repeat', 'mustang-lite' ),
														'section'         => $customizer_section,
														'priority'        => ++$priority,
														'type'            => 'select',
														'choices'         => wm_helper_var( 'bg-css', 'repeat' ),
														'active_callback' => 'wm_active_callback_background_image',
													)
												);

										$wp_customize->add_setting(
												WM_THEME_SETTINGS_SKIN . '[' . $option_id . '-bg-attachment]',
												array(
													'type'                 => 'option',
													'default'              => ( isset( $default['attachment'] ) ) ? ( $default['attachment'] ) : ( 'scroll' ),
													'transport'            => $transport,
													'sanitize_callback'    => 'esc_attr',
													'sanitize_js_callback' => 'esc_attr',
												)
											);

											$wp_customize->add_control(
													WM_THEME_SETTINGS_SKIN . '[' . $option_id . '-bg-attachment]',
													array(
														'label'           => __( 'Background attachment', 'mustang-lite' ),
														'section'         => $customizer_section,
														'priority'        => ++$priority,
														'type'            => 'select',
														'choices'         => wm_helper_var( 'bg-css', 'scroll' ),
														'active_callback' => 'wm_active_callback_background_image',
													)
												);

										$wp_customize->add_setting(
												WM_THEME_SETTINGS_SKIN . '[' . $option_id . '-bg-size]',
												array(
													'type'                 => 'option',
													'default'              => ( isset( $default['size'] ) ) ? ( $default['size'] ) : ( '' ),
													'transport'            => $transport,
													'sanitize_callback'    => 'esc_attr',
													'sanitize_js_callback' => 'esc_attr',
												)
											);

											$wp_customize->add_control(
													WM_THEME_SETTINGS_SKIN . '[' . $option_id . '-bg-size]',
													array(
														'label'           => __( 'CSS3 background size', 'mustang-lite' ),
														'section'         => $customizer_section,
														'priority'        => ++$priority,
														'type'            => 'select',
														'choices'         => wm_helper_var( 'bg-css', 'size' ),
														'active_callback' => 'wm_active_callback_background_image',
													)
												);

									}

								break;

								/**
								 * Color
								 */
								case 'color':

									$wp_customize->add_setting(
											WM_THEME_SETTINGS_SKIN . '[' . $option_id . ']',
											array(
												'type'                 => 'option',
												'default'              => $default,
												'transport'            => $transport,
												'sanitize_callback'    => 'sanitize_hex_color_no_hash',
												'sanitize_js_callback' => 'maybe_hash_hex_color',
											)
										);

									$wp_customize->add_control( new WP_Customize_Color_Control(
											$wp_customize,
											WM_THEME_SETTINGS_SKIN . '[' . $option_id . ']',
											array(
												'label'       => $skin_option['label'],
												'description' => $description,
												'section'     => $customizer_section,
												'priority'    => $priority,
											)
										) );

								break;

								/**
								 * Email
								 *
								 * @since  3.2, WordPress 4.0
								 */
								case 'email':

									if ( wm_check_wp_version( 4 ) ) {

										$wp_customize->add_setting(
												WM_THEME_SETTINGS_SKIN . '[' . $option_id . ']',
												array(
													'type'                 => 'option',
													'default'              => $default,
													'transport'            => $transport,
													'sanitize_callback'    => 'wm_sanitize_email',
													'sanitize_js_callback' => 'wm_sanitize_email',
												)
											);

										$wp_customize->add_control(
												WM_THEME_SETTINGS_SKIN . '[' . $option_id . ']',
												array(
													'type'        => 'email',
													'label'       => $skin_option['label'],
													'description' => $description,
													'section'     => $customizer_section,
													'priority'    => $priority,
												)
											);

									}

								break;

								/**
								 * Hidden
								 */
								case 'hidden':

									$wp_customize->add_setting(
											WM_THEME_SETTINGS_SKIN . '[' . $option_id . ']',
											array(
												'type'                 => 'option',
												'default'              => $default,
												'transport'            => $transport,
												'sanitize_callback'    => ( isset( $skin_option['validate'] ) ) ? ( $skin_option['validate'] ) : ( 'esc_attr' ),
												'sanitize_js_callback' => ( isset( $skin_option['validate'] ) ) ? ( $skin_option['validate'] ) : ( 'esc_attr' ),
											)
										);

									$wp_customize->add_control( new WM_Customizer_Hidden(
											$wp_customize,
											WM_THEME_SETTINGS_SKIN . '[' . $option_id . ']',
											array(
												'label'    => 'HIDDEN FIELD',
												'section'  => $customizer_section,
												'priority' => $priority,
											)
										) );

								break;

								/**
								 * HTML
								 */
								case 'html':

									$wp_customize->add_setting(
											WM_THEME_SETTINGS_SKIN . '[custom-title-' . $priority . ']',
											array(
												'sanitize_callback'    => 'wm_sanitize_return_value',
												'sanitize_js_callback' => 'wm_sanitize_return_value',
											)
										);

									$wp_customize->add_control( new WM_Customizer_HTML(
											$wp_customize,
											WM_THEME_SETTINGS_SKIN . '[custom-title-' . $priority . ']',
											array(
												'label'    => $skin_option['content'],
												'section'  => $customizer_section,
												'priority' => $priority,
											)
										) );

								break;

								/**
								 * Image
								 */
								case 'image':

									$wp_customize->add_setting(
											WM_THEME_SETTINGS_SKIN . '[' . $option_id . ']',
											array(
												'type'                 => 'option',
												'default'              => $default,
												'transport'            => $transport,
												'sanitize_callback'    => ( isset( $skin_option['validate'] ) ) ? ( $skin_option['validate'] ) : ( 'wm_sanitize_return_value' ),
												'sanitize_js_callback' => ( isset( $skin_option['validate'] ) ) ? ( $skin_option['validate'] ) : ( 'wm_sanitize_return_value' ),
											)
										);

									$wp_customize->add_control( new WP_Customize_Image_Control(
											$wp_customize,
											WM_THEME_SETTINGS_SKIN . '[' . $option_id . ']',
											array(
												'label'       => $skin_option['label'],
												'description' => $description,
												'section'     => $customizer_section,
												'priority'    => $priority,
												'context'     => WM_THEME_SETTINGS_SKIN . '[' . $option_id . ']',
											)
										) );

								break;

								/**
								 * Checkbox, radio & select
								 */
								case 'checkbox':
								case 'radio':
								case 'select':

									$wp_customize->add_setting(
											WM_THEME_SETTINGS_SKIN . '[' . $option_id . ']',
											array(
												'type'                 => 'option',
												'default'              => $default,
												'transport'            => $transport,
												'sanitize_callback'    => ( isset( $skin_option['validate'] ) ) ? ( $skin_option['validate'] ) : ( 'esc_attr' ),
												'sanitize_js_callback' => ( isset( $skin_option['validate'] ) ) ? ( $skin_option['validate'] ) : ( 'esc_attr' ),
											)
										);

									$wp_customize->add_control(
											WM_THEME_SETTINGS_SKIN . '[' . $option_id . ']',
											array(
												'label'       => $skin_option['label'],
												'description' => $description,
												'section'     => $customizer_section,
												'priority'    => $priority,
												'type'        => $skin_option['type'],
												'choices'     => ( isset( $skin_option['options'] ) ) ? ( $skin_option['options'] ) : ( '' ),
											)
										);

								break;

								/**
								 * Multiselect
								 */
								case 'multiselect':

									$wp_customize->add_setting(
											WM_THEME_SETTINGS_SKIN . '[' . $option_id . ']',
											array(
												'type'                 => 'option',
												'default'              => $default,
												'transport'            => $transport,
												'sanitize_callback'    => ( isset( $skin_option['validate'] ) ) ? ( $skin_option['validate'] ) : ( 'wm_sanitize_return_value' ),
												'sanitize_js_callback' => ( isset( $skin_option['validate'] ) ) ? ( $skin_option['validate'] ) : ( 'wm_sanitize_return_value' ),
											)
										);

									$wp_customize->add_control( new WM_Customizer_Multiselect(
											$wp_customize,
											WM_THEME_SETTINGS_SKIN . '[' . $option_id . ']',
											array(
												'label'       => $skin_option['label'],
												'description' => $description,
												'section'     => $customizer_section,
												'priority'    => $priority,
												'choices'     => ( isset( $skin_option['options'] ) ) ? ( $skin_option['options'] ) : ( '' ),
											)
										) );

								break;

								/**
								 * Password
								 *
								 * @since  3.2, WordPress 4.0
								 */
								case 'password':

									if ( wm_check_wp_version( 4 ) ) {

										$wp_customize->add_setting(
												WM_THEME_SETTINGS_SKIN . '[' . $option_id . ']',
												array(
													'type'                 => 'option',
													'default'              => $default,
													'transport'            => $transport,
													'sanitize_callback'    => ( isset( $skin_option['validate'] ) ) ? ( $skin_option['validate'] ) : ( 'esc_attr' ),
													'sanitize_js_callback' => ( isset( $skin_option['validate'] ) ) ? ( $skin_option['validate'] ) : ( 'esc_attr' ),
												)
											);

										$wp_customize->add_control(
												WM_THEME_SETTINGS_SKIN . '[' . $option_id . ']',
												array(
													'type'        => 'password',
													'label'       => $skin_option['label'],
													'description' => $description,
													'section'     => $customizer_section,
													'priority'    => $priority,
												)
											);

									}

								break;

								/**
								 * Radio custom labels
								 */
								case 'radiocustom':

									$wp_customize->add_setting(
											WM_THEME_SETTINGS_SKIN . '[' . $option_id . ']',
											array(
												'type'                 => 'option',
												'default'              => $default,
												'transport'            => $transport,
												'sanitize_callback'    => ( isset( $skin_option['validate'] ) ) ? ( $skin_option['validate'] ) : ( 'esc_attr' ),
												'sanitize_js_callback' => ( isset( $skin_option['validate'] ) ) ? ( $skin_option['validate'] ) : ( 'esc_attr' ),
											)
										);

									$wp_customize->add_control( new WM_Customizer_Radiocustom(
											$wp_customize,
											WM_THEME_SETTINGS_SKIN . '[' . $option_id . ']',
											array(
												'label'       => $skin_option['label'],
												'description' => $description,
												'section'     => $customizer_section,
												'priority'    => $priority,
												'choices'     => ( isset( $skin_option['options'] ) ) ? ( $skin_option['options'] ) : ( '' ),
												'class'       => ( isset( $skin_option['class'] ) ) ? ( $skin_option['class'] ) : ( '' ),
											)
										) );

								break;

								/**
								 * Slider
								 *
								 * Since WP4.0 there is also a "range" native input field. This will output
								 * HTML5 <input type="range" /> element - thus still using custom one.
								 */
								case 'range':

									$wp_customize->add_setting(
											WM_THEME_SETTINGS_SKIN . '[' . $option_id . ']',
											array(
												'type'                 => 'option',
												'default'              => $default,
												'transport'            => $transport,
												'sanitize_callback'    => ( isset( $skin_option['validate'] ) ) ? ( $skin_option['validate'] ) : ( 'wm_sanitize_intval' ),
												'sanitize_js_callback' => ( isset( $skin_option['validate'] ) ) ? ( $skin_option['validate'] ) : ( 'wm_sanitize_intval' ),
											)
										);

									$wp_customize->add_control( new WM_Customizer_Range(
											$wp_customize,
											WM_THEME_SETTINGS_SKIN . '[' . $option_id . ']',
											array(
												'label'       => $skin_option['label'],
												'description' => $description,
												'section'     => $customizer_section,
												'priority'    => $priority,
												'json'        => array( $skin_option['min'], $skin_option['max'], $skin_option['step'] ),
											)
										) );

								break;

								/**
								 * Text
								 */
								case 'text':

									$wp_customize->add_setting(
											WM_THEME_SETTINGS_SKIN . '[' . $option_id . ']',
											array(
												'type'                 => 'option',
												'default'              => $default,
												'transport'            => $transport,
												'sanitize_callback'    => ( isset( $skin_option['validate'] ) ) ? ( $skin_option['validate'] ) : ( 'esc_textarea' ),
												'sanitize_js_callback' => ( isset( $skin_option['validate'] ) ) ? ( $skin_option['validate'] ) : ( 'esc_textarea' ),
											)
										);

									$wp_customize->add_control(
											WM_THEME_SETTINGS_SKIN . '[' . $option_id . ']',
											array(
												'type'        => 'text',
												'label'       => $skin_option['label'],
												'description' => $description,
												'section'     => $customizer_section,
												'priority'    => $priority,
											)
										);

								break;

								/**
								 * Textarea
								 *
								 * Since WordPress 4.0 this is native input field.
								 */
								case 'textarea':

									$wp_customize->add_setting(
											WM_THEME_SETTINGS_SKIN . '[' . $option_id . ']',
											array(
												'type'                 => 'option',
												'default'              => $default,
												'transport'            => $transport,
												'sanitize_callback'    => ( isset( $skin_option['validate'] ) ) ? ( $skin_option['validate'] ) : ( 'esc_textarea' ),
												'sanitize_js_callback' => ( isset( $skin_option['validate'] ) ) ? ( $skin_option['validate'] ) : ( 'esc_textarea' ),
											)
										);

									$wp_customize->add_control(
											WM_THEME_SETTINGS_SKIN . '[' . $option_id . ']',
											array(
												'type'        => 'textarea',
												'label'       => $skin_option['label'],
												'description' => $description,
												'section'     => $customizer_section,
												'priority'    => $priority,
											)
										);

								break;

								/**
								 * URL
								 *
								 * @since  3.2, WordPress 4.0
								 */
								case 'url':

									if ( wm_check_wp_version( 4 ) ) {

										$wp_customize->add_setting(
												WM_THEME_SETTINGS_SKIN . '[' . $option_id . ']',
												array(
													'type'                 => 'option',
													'default'              => $default,
													'transport'            => $transport,
													'sanitize_callback'    => ( isset( $skin_option['validate'] ) ) ? ( $skin_option['validate'] ) : ( 'esc_url' ),
													'sanitize_js_callback' => ( isset( $skin_option['validate'] ) ) ? ( $skin_option['validate'] ) : ( 'esc_url' ),
												)
											);

										$wp_customize->add_control(
												WM_THEME_SETTINGS_SKIN . '[' . $option_id . ']',
												array(
													'type'        => 'url',
													'label'       => $skin_option['label'],
													'description' => $description,
													'section'     => $customizer_section,
													'priority'    => $priority,
												)
											);

									}

								break;

								/**
								 * Default
								 */
								default:
								break;

							} // /switch

						} // /if suitable option array

					} // /foreach

				} // /if skin options are non-empty array

			//Assets needed for customizer preview
				if ( $wp_customize->is_preview() ) {
					add_action( 'wp_enqueue_scripts', 'wm_theme_customizer_css' );
					add_action( 'wp_footer', 'wm_theme_customizer_js', 99 );
				}
		}
	} // /wm_theme_customizer



	/**
	 * Active callback: Is the background image set?
	 *
	 * @since    1.5
	 * @version  1.5.2
	 *
	 * @param  obj $control
	 */
	function wm_active_callback_background_image( $control ) {

		// Requirements check

			if ( ! isset( $control->id ) ) {
				return true;
			}


		// Helper variables

			$output = true;

			$control_image = '';

			if ( $pos = strpos( $control->id, '-bg-' ) ) {
				$control_image = substr( $control->id, 0, $pos ) . '-bg-url]';
			}


		// Processing

			if (
					$control_image
					&& $control->manager->get_setting( $control_image )
				) {
				$value  = $control->manager->get_setting( $control_image )->value();
				$output = ! empty( $value );
			}


		// Output

			return $output;

	} // /wm_active_callback_background_image
