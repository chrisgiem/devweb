<?php
/**
 * Plugin integration
 *
 * Beaver Builder
 *
 * @link  https://www.wpbeaverbuilder.com/
 *
 * @package    Mustang
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.6
 * @version  1.9.3
 *
 * Contents:
 *
 *  1) Requirements check
 * 10) Plugin integration
 */





/**
 * 1) Requirements check
 */


	if ( ! class_exists( 'FLBuilder' ) ) {
		return;
	}





/**
 * 10) Plugin integration
 */

	/**
	 * Upgrade link URL
	 *
	 * @since    1.6
	 * @version  1.6
	 *
	 * @param  string $url
	 */
	if ( ! function_exists( 'wm_bb_upgrade_url' ) ) {
		function wm_bb_upgrade_url( $url ) {

			// Output

				return esc_url( add_query_arg( 'fla', '67', $url ) );

		}
	} // /wm_bb_upgrade_url

	add_filter( 'fl_builder_upgrade_url', 'wm_bb_upgrade_url' );



	/**
	 * Is page builder used on the post?
	 *
	 * @since    1.6
	 * @version  1.6
	 */
	if ( ! function_exists( 'wm_bb_is_active' ) ) {
		function wm_bb_is_active() {

			// Requirements check

				if ( ! class_exists( 'FLBuilderModel' ) ) {
					return false;
				}


			// Helper variables

				$post_id = get_the_ID();


			// Processing

				if ( is_page( $post_id ) || is_single( $post_id ) ) {
					return ( FLBuilderModel::is_builder_active() || get_post_meta( $post_id, '_fl_builder_enabled', true ) );
				}


			// Output

				return false;

		}
	} // /wm_bb_is_active



	/**
	 * Global settings
	 *
	 * @since    1.6
	 * @version  1.9.3
	 *
	 * @param  array  $defaults
	 * @param  string $form_type
	 */
	if ( ! function_exists( 'wm_bb_global_settings' ) ) {
		function wm_bb_global_settings( $defaults, $form_type ) {

			// Processing

				if ( 'global' === $form_type ) {

					// "Default Page Heading" section

						$defaults->show_default_heading     = '1';
						$defaults->default_heading_selector = '.main-heading';

					// "Rows" section

						$defaults->row_padding = 0;
						$defaults->row_margins = 0;
						$defaults->row_width   = $GLOBALS['content_width']; // This will get overrode via custom CSS

					// "Modules" section

						$defaults->module_margins = 0;

					// "Responsive Layout" section

						$defaults->auto_spacing          = 0;
						$defaults->medium_breakpoint     = 1024;
						$defaults->responsive_breakpoint = 800;

				}


			// Output

				return $defaults;

		}
	} // /wm_bb_global_settings

	add_filter( 'fl_builder_settings_form_defaults', 'wm_bb_global_settings', 10, 2 );



	/**
	 * Late load layout assets
	 *
	 * @since    1.8.4
	 * @version  1.8.4
	 */
	if ( ! function_exists( 'wm_bb_assets_layout' ) ) {
		function wm_bb_assets_layout() {

			// Helper variables

				$priority  = 120;
				$callbacks = (array) apply_filters( 'wmhook_mustang_beaver_builder_assets_late_load_callbacks', array(
					'FLBuilder::enqueue_all_layouts_styles_scripts'     => 10,
					'FLBuilder::enqueue_ui_styles_scripts'              => 11,
					'FLBuilderUISettingsForms::enqueue_settings_config' => 11,
				) );

				$order = 0;


			// Processing

				foreach ( $callbacks as $callback => $default_priority ) {
					if ( is_callable( $callback ) ) {
						remove_action( 'wp_enqueue_scripts', $callback, $default_priority );
						   add_action( 'wp_enqueue_scripts', $callback, $priority + $order++ );
					}
				}

		}
	} // /wm_bb_assets_layout

	add_filter( 'init', 'wm_bb_assets_layout', 900 );



	/**
	 * Assets
	 *
	 * @since    1.6
	 * @version  1.6
	 */
	if ( ! function_exists( 'wm_bb_assets' ) ) {
		function wm_bb_assets() {

			// Processing

				if ( wm_bb_is_active() ) {

					// Styles

						wp_enqueue_style(
								'mustang-bb',
								wm_get_stylesheet_directory_uri( 'assets/css/beaver-builder.css' ),
								false,
								esc_attr( trim( WM_SCRIPTS_VERSION ) ),
								'screen'
							);

				}

				if ( class_exists( 'FLBuilderModel' ) && FLBuilderModel::is_builder_active() ) {

					// Styles

						wp_enqueue_style(
								'mustang-bb-editor',
								wm_get_stylesheet_directory_uri( 'assets/css/beaver-builder-editor.css' ),
								false,
								esc_attr( trim( WM_SCRIPTS_VERSION ) ),
								'screen'
							);

				}

		}
	} // /wm_bb_assets

	add_filter( 'wp_enqueue_scripts', 'wm_bb_assets', 100 );



	/**
	 * Add predefined classes helper dropdown
	 *
	 * @since    1.6
	 * @version  1.9.0
	 */
	if ( ! function_exists( 'wm_bb_predefined_classes_dropdown' ) ) {
		function wm_bb_predefined_classes_dropdown($field, $name ) {

			// Processing

				if ( 'class' == $name ) {

					$field['options'] = array(

							'' => esc_html__( '- Choose from predefined classes -', 'mustang-lite' ),

							// Layout classes

								'optgroup-layout' => array(
									'label'   => esc_html__( 'Layout:', 'mustang-lite' ),
									'options' => array(

										'masonry'     => esc_html__( 'Masonry items layout', 'mustang-lite' ),

										'text-center' => esc_html__( 'Text center', 'mustang-lite' ),
										'text-right'  => esc_html__( 'Text right', 'mustang-lite' ),

										'fullwidth'   => esc_html__( 'Fullwidth elements', 'mustang-lite' ),

									),
								),

							// Content Module layouts classes

								'optgroup-content-module' => array(
									'label'   => esc_html__( 'Content Module specific:', 'mustang-lite' ),
									'options' => array(

										'text-center '       => esc_html__( 'Content Module: Icon above, text centered', 'mustang-lite' ),
										'small-icons'        => esc_html__( 'Content Module: Small icons', 'mustang-lite' ),
										'no-icon-background' => esc_html__( 'Content Module: No icon background', 'mustang-lite' ),

									),
								),

							// Decoration classes

								'optgroup-decoration' => array(
									'label'   => esc_html__( 'Decoration:', 'mustang-lite' ),
									'options' => array(

										'frame-items'         => esc_html__( 'Border around items (working with Posts and Testimonials)', 'mustang-lite' ),
										'bottom-shadow-items' => esc_html__( 'Bottom shadow on items (working with Posts and Testimonials)', 'mustang-lite' ),

									),
								),

						);

				}


			// Output

				return $field;

		}
	} // /wm_bb_predefined_classes_dropdown

	add_filter( 'fl_builder_field_js_config', 'wm_bb_predefined_classes_dropdown', 10, 2 );
