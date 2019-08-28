<?php
/**
 * Theme Options
 *
 * @package     WebMan WordPress Theme Framework
 * @subpackage  WebMan Options Panel
 * @copyright   2014 WebMan - Oliver Juhas
 *
 * @since    1.0
 * @version  1.9.3
 *
 * CONTENT:
 * - 10) Actions and filters
 * - 20) Array functions
 */





/**
 * 10) Actions and filters
 */

	/**
	 * Filters
	 */

		//CSS file generator replacements
			add_filter( 'wmhook_generate_css_replacements', 'wm_generate_css_replacements', 10 );
		//$wm_skin_design
			add_filter( 'wmhook_theme_options_skin_array', 'wm_theme_options_skin_array', 10 );





/**
 * 20) Array functions
 */

	/**
	 * CSS generator replacements
	 *
	 * @since    1.0
	 * @version  1.5
	 *
	 * @param  array $replacements
	 */
	if ( ! function_exists( 'wm_generate_css_replacements' ) ) {
		function wm_generate_css_replacements( $replacements = array() ) {
			//Preparing output
				$replacements = array(

						'/* End of file */'             => "\r\n\r\n",
						'/*(*/'                         => '/** ', // Open a comment
						'/*)*/'                         => ' **/', // Close a comment
						'/*//'                          => '', // Remove a comment opening
						'//*/'                          => '', // Remove a comment closing

						'___get_template_directory_uri' => str_replace( array( 'http:', 'https:' ), '', untrailingslashit( get_template_directory_uri() ) ),
						'___theme_assets_url'           => str_replace( array( 'http:', 'https:' ), '', trailingslashit( get_template_directory_uri() ) . 'assets' ),

						'___accent_color'               => '#3b5998',
						'___bg_color_brighter'          => '#f6f6f6',
						'___border_color'               => '#e3e3e3',

					);

			//Output
				return $replacements;
		}
	} // /wm_generate_css_replacements



	/**
	 * Set $wm_skin_design array
	 *
	 * @since    1.0
	 * @version  1.9.3
	 *
	 * @param  array $wm_skin_design
	 */
	if ( ! function_exists( 'wm_theme_options_skin_array' ) ) {
		function wm_theme_options_skin_array( $wm_skin_design = array() ) {
			//Preparing output

				/**
				 * Theme customizer options array
				 */

					$prefix = 'skin-';

					$wm_skin_design = array(


						/**
						 * Top Bar
						 */
						'topbar' => array(
							'type'           => 'section',
							'create_section' => __( 'Section: Top Bar', 'mustang-lite' ),
							'in_panel'       => _x( 'Theme Options', 'Customizer panel title.', 'mustang-lite' ),
						),

							'topbar' . 10 => array(
								'type'    => 'html',
								'content' => '<p class="description">' . __( 'These settings will affect both Topbar Widgets and Topbar Extra Widgets areas.', 'mustang-lite' ) . '</p>',
							),

								'topbar' . 20 => array(
									'type'  => 'color',
									'id'    => $prefix . 'topbar' . '-color',
									'label' => __( 'Text color', 'mustang-lite' ),
								),
								'topbar' . 30 => array(
									'type'  => 'color',
									'id'    => $prefix . 'topbar' . '-accent-color',
									'label' => __( 'Accent color', 'mustang-lite' ),
								),
								'topbar' . 40 => array(
									'type'  => 'color',
									'id'    => $prefix . 'topbar' . '-border-color',
									'label' => __( 'Borders color', 'mustang-lite' ),
								),
								'topbar' . 50 => array(
									'type'  => 'background',
									'id'    => $prefix . 'topbar'
								),

							'topbar-extra' . 10 => array(
								'type'    => 'html',
								'content' => '<h3>' . __( 'Topbar Extra widgets', 'mustang-lite' ) . '</h3>',
							),

								'topbar-extra' . 20 => array(
									'type'  => 'color',
									'id'    => $prefix . 'topbar-extra' . '-color',
									'label' => __( 'Text color', 'mustang-lite' ),
								),
								'topbar-extra' . 30 => array(
									'type'  => 'color',
									'id'    => $prefix . 'topbar-extra' . '-accent-color',
									'label' => __( 'Accent color', 'mustang-lite' ),
								),
								'topbar-extra' . 40 => array(
									'type'  => 'color',
									'id'    => $prefix . 'topbar-extra' . '-border-color',
									'label' => __( 'Borders color', 'mustang-lite' ),
								),
								'topbar-extra' . 50 => array(
									'type'  => 'color',
									'id'    => $prefix . 'topbar-extra' . '-bg-color',
									'label' => __( 'Background color', 'mustang-lite' ),
								),



						/**
						 * Header
						 */
						'header' => array(
							'type'           => 'section',
							'create_section' => __( 'Section: Header', 'mustang-lite' ),
							'in_panel'       => _x( 'Theme Options', 'Customizer panel title.', 'mustang-lite' ),
						),

							'header' . 10 => array(
								'type'    => 'select',
								'id'      => $prefix . 'header' . '-shadow',
								'label'   => __( 'Header shadow', 'mustang-lite' ),
								'options' => array(
										''  => __( 'No shadow', 'mustang-lite' ),
										'1' => __( 'Display shadow', 'mustang-lite' )
									),
							),
							'header' . 20 => array(
								'type'  => 'checkbox',
								'id'    => $prefix . 'header' . '-sticky',
								'label' => __( 'Sticky header', 'mustang-lite' ),
							),

							'header' . 30 => array(
								'type'    => 'html',
								'content' => '<h3>' . __( 'Design', 'mustang-lite' ) . '</h3>',
							),

								'header' . 40 => array(
									'type'  => 'color',
									'id'    => $prefix . 'header' . '-color',
									'label' => __( 'Text color', 'mustang-lite' ),
								),
								'header' . 50 => array(
									'type'  => 'color',
									'id'    => $prefix . 'header' . '-accent-color',
									'label' => __( 'Accent color', 'mustang-lite' ),
								),
								'header' . 60 => array(
									'type'  => 'color',
									'id'    => $prefix . 'header' . '-border-color',
									'label' => __( 'Borders color', 'mustang-lite' ),
								),
								'header' . 70 => array(
									'type'  => 'background',
									'id'    => $prefix . 'header',
								),

							'header' . 140 => array(
								'type'    => 'html',
								'content' => '<h3>' . __( 'Navigation design', 'mustang-lite' ) . '</h3>',
							),

								'header' . 150 => array(
									'type'    => 'html',
									'content' => '<p class="description">' . __( 'Navigation padding will affect the header height and logo position.', 'mustang-lite' ) . '</p>',
								),
									'header' . 160 => array(
										'type'    => 'range',
										'id'      => $prefix . 'nav' . '-padding',
										'label'   => __( 'Navigation padding', 'mustang-lite' ),
										'default' => 25,
										'min'     => 0,
										'max'     => 60,
										'step'    => 1,
										'zero'    => true,
									),

								'header' . 170 => array(
									'type'  => 'color',
									'id'    => $prefix . 'nav' . '-color',
									'label' => __( 'Subnav text color', 'mustang-lite' ),
								),
								'header' . 180 => array(
									'type'  => 'color',
									'id'    => $prefix . 'nav' . '-border-color',
									'label' => __( 'Borders color', 'mustang-lite' ),
								),
								'header' . 190 => array(
									'type'  => 'color',
									'id'    => $prefix . 'nav' . '-bg-color',
									'label' => __( 'Subnav background', 'mustang-lite' ),
								),
									'header' . 200 => array(
										'type'    => 'html',
										'content' => '<p class="description">' . __( 'Subnav colors will be also used to style the mobile navigation.', 'mustang-lite' ) . '</p>',
									),



						/**
						 * Special Slider
						 */
						'range' => array(
							'type'           => 'section',
							'create_section' => __( 'Section: Special Slider', 'mustang-lite' ),
							'in_panel'       => _x( 'Theme Options', 'Customizer panel title.', 'mustang-lite' ),
						),

							'range' . 10 => array(
								'type'  => 'color',
								'id'    => $prefix . 'range' . '-color',
								'label' => __( 'Text color', 'mustang-lite' ),
							),
							'range' . 20 => array(
								'type'  => 'color',
								'id'    => $prefix . 'range' . '-accent-color',
								'label' => __( 'Accent color', 'mustang-lite' ),
							),
							'range' . 30 => array(
								'type'  => 'color',
								'id'    => $prefix . 'range' . '-border-color',
								'label' => __( 'Borders color', 'mustang-lite' ),
							),
							'range' . 40 => array(
								'type'  => 'color',
								'id'    => $prefix . 'range' . '-bg-color',
								'label' => __( 'Background color', 'mustang-lite' ),
							),



						/**
						 * Main Heading
						 */
						'heading' => array(
							'type'           => 'section',
							'create_section' => __( 'Section: Main Heading', 'mustang-lite' ),
							'in_panel'       => _x( 'Theme Options', 'Customizer panel title.', 'mustang-lite' ),
						),

							'heading' . 10 => array(
								'type'  => 'color',
								'id'    => $prefix . 'heading' . '-color',
								'label' => __( 'Text color', 'mustang-lite' ),
							),
							'heading' . 20 => array(
								'type'  => 'color',
								'id'    => $prefix . 'heading' . '-accent-color',
								'label' => __( 'Accent color', 'mustang-lite' ),
							),
							'heading' . 30 => array(
								'type'  => 'color',
								'id'    => $prefix . 'heading' . '-border-color',
								'label' => __( 'Borders color', 'mustang-lite' ),
							),
							'heading' . 40 => array(
								'type'  => 'background',
								'id'    => $prefix . 'heading',
							),



						/**
						 * Content Area
						 */
						'content' => array(
							'type'           => 'section',
							'create_section' => __( 'Section: Content', 'mustang-lite' ),
							'in_panel'       => _x( 'Theme Options', 'Customizer panel title.', 'mustang-lite' ),
						),

							'content' . 10 => array(
								'type'    => 'select',
								'id'      => $prefix . 'sidebar' . '-position',
								'label'   => __( 'Sidebar position', 'mustang-lite' ),
								'options' => array(
										'left'  => __( 'Left', 'mustang-lite' ),
										'right' => __( 'Right', 'mustang-lite' )
									),
								'default' => WM_DEFAULT_SIDEBAR_POSITION,
							),
							'content' . 20 => array(
								'type'    => 'select',
								'id'      => $prefix . 'sidebar' . '-width',
								'label'   => __( 'Sidebar width', 'mustang-lite' ),
								'options' => array(
										' pane three; pane nine'                => __( '1/4 sidebar', 'mustang-lite' ),
										' pane four; pane eight'                => __( '1/3 sidebar', 'mustang-lite' ),
										' pane golden-narrow; pane golden-wide' => __( 'Golden ratio', 'mustang-lite' ),
									),
								'default' => WM_DEFAULT_SIDEBAR_WIDTH,
							),

							'content' . 30 => array(
								'type'    => 'html',
								'content' => '<h3>' . __( 'Design', 'mustang-lite' ) . '</h3>',
							),

								'content' . 40 => array(
									'type'  => 'color',
									'id'    => $prefix . 'content' . '-color',
									'label' => __( 'Text color', 'mustang-lite' ),
								),
								'content' . 50 => array(
									'type'  => 'color',
									'id'    => $prefix . 'content' . '-accent-color',
									'label' => __( 'Accent color', 'mustang-lite' ),
								),
								'content' . 60 => array(
									'type'  => 'color',
									'id'    => $prefix . 'content' . '-border-color',
									'label' => __( 'Borders color', 'mustang-lite' ),
								),
								'content' . 70 => array(
									'type'  => 'background',
									'id'    => $prefix . 'content',
								),



						/**
						 * Footer
						 */
						'footer' => array(
							'type'           => 'section',
							'create_section' => __( 'Section: Footer', 'mustang-lite' ),
							'in_panel'       => _x( 'Theme Options', 'Customizer panel title.', 'mustang-lite' ),
						),

							'footer' . 10 => array(
								'type'    => 'html',
								'content' => '<p class="description">' . __( 'Footer consists of footer widgets area and credits (copyright) widgets area. Set the footer widgets layout below and backgrounds for both footer areas.', 'mustang-lite' ) . '</p>',
							),

							'header' . 15 => array(
								'type'    => 'select',
								'id'      => $prefix . 'footer' . '-shadow',
								'label'   => __( 'Footer shadow', 'mustang-lite' ),
								'options' => array(
										''  => __( 'No shadow', 'mustang-lite' ),
										'1' => __( 'Display shadow', 'mustang-lite' )
									),
							),

							'footer' . 20 => array(
								'type'    => 'html',
								'content' => '<h3>' . __( 'Footer widgets', 'mustang-lite' ) . '</h3>',
							),

								'footer' . 30 => array(
									'type'    => 'select',
									'id'      => $prefix . 'footer-widgets' . '-layout',
									'label'   => __( 'Footer widgets layout', 'mustang-lite' ),
									'options' => array(
											1 => __( '1 column', 'mustang-lite' ),
											2 => __( '2 columns', 'mustang-lite' ),
											3 => __( '3 columns', 'mustang-lite' ),
											4 => __( '4 columns', 'mustang-lite' ),
											5 => __( '5 columns', 'mustang-lite' ),
										),
								),
									'footer' . 40 => array(
										'type'    => 'html',
										'content' => '<p class="description">' . __( 'Footer widgets will be layed out into columns using masonry script.', 'mustang-lite' ) . '</p>',
									),

								'footer' . 50 => array(
									'type'  => 'color',
									'id'    => $prefix . 'footer-widgets' . '-color',
									'label' => __( 'Text color', 'mustang-lite' ),
								),
								'footer' . 60 => array(
									'type'  => 'color',
									'id'    => $prefix . 'footer-widgets' . '-accent-color',
									'label' => __( 'Accent color', 'mustang-lite' ),
								),
								'footer' . 70 => array(
									'type'  => 'color',
									'id'    => $prefix . 'footer-widgets' . '-border-color',
									'label' => __( 'Borders color', 'mustang-lite' ),
								),
								'footer' . 80 => array(
									'type'  => 'background',
									'id'    => $prefix . 'footer-widgets',
								),

							'footer' . 150 => array(
								'type'    => 'html',
								'content' => '<h3>' . __( 'Credits', 'mustang-lite' ) . '</h3>',
							),

								'footer' . 160 => array(
									'type'  => 'color',
									'id'    => $prefix . 'credits' . '-color',
									'label' => __( 'Text color', 'mustang-lite' ),
								),
								'footer' . 170 => array(
									'type'  => 'color',
									'id'    => $prefix . 'credits' . '-accent-color',
									'label' => __( 'Accent color', 'mustang-lite' ),
								),
								'footer' . 180 => array(
									'type'  => 'color',
									'id'    => $prefix . 'credits' . '-border-color',
									'label' => __( 'Borders color', 'mustang-lite' ),
								),
								'footer' . 190 => array(
									'type'  => 'background',
									'id'    => $prefix . 'credits',
								),



						/**
						 * Website Background
						 */
						'website-background' => array(
							'type'           => 'section',
							'create_section' => __( 'Background', 'mustang-lite' ),
							'in_panel'       => _x( 'Theme Options', 'Customizer panel title.', 'mustang-lite' ),
						),

							'website-background' . 5 => array(
								'type'    => 'html',
								'content' => '<h3>' . __( 'Website background', 'mustang-lite' ) . '</h3>'
									. '<p class="description">' . __( 'Please note that this background is only visible when using boxed theme layout (set this under "Setup" section).', 'mustang-lite' ) . '</p>',
							),

								'website-background' . 10 => array(
									'type' => 'background',
									'id'   => $prefix . 'html',
								),



						/**
						 * Global colors
						 */
						'colors-global' => array(
							'type'           => 'section',
							'create_section' => __( 'Colors', 'mustang-lite' ),
							'in_panel'       => _x( 'Theme Options', 'Customizer panel title.', 'mustang-lite' ),
						),

							'colors-global' . 10 => array(
								'type'    => 'html',
								'content' => '<h3>' . __( 'Global colors', 'mustang-lite' ) . '</h3>',
							),

								'colors-global' . 20 => array(
									'type'  => 'color',
									'id'    => $prefix . 'accent-color',
									'label' => __( 'Accent color', 'mustang-lite' ),
								),
									'colors-global' . 30 => array(
										'type'    => 'html',
										'content' => '<p class="description">' . __( 'Accent color is being used globally throughout the whole theme. All of theme design colors are being calculated automatically based on this color, so if you only want the basic theme design, just set this color. If you need to tweak the design settings, feel free to explore theme sections options below.', 'mustang-lite' ) . '</p>',
									),

								//blue
									'colors-global' . 40 => array(
										'type'  => 'color',
										'id'    => $prefix . 'blue-color',
										'label' => __( 'General blue color', 'mustang-lite' ),
									),
								//gray
									'colors-global' . 50 => array(
										'type'  => 'color',
										'id'    => $prefix . 'gray-color',
										'label' => __( 'General gray color', 'mustang-lite' ),
									),
								//green
									'colors-global' . 60 => array(
										'type'  => 'color',
										'id'    => $prefix . 'green-color',
										'label' => __( 'General green color', 'mustang-lite' ),
									),
								//orange
									'colors-global' . 70 => array(
										'type'  => 'color',
										'id'    => $prefix . 'orange-color',
										'label' => __( 'General orange color', 'mustang-lite' ),
									),
								//red
									'colors-global' . 80 => array(
										'type'  => 'color',
										'id'    => $prefix . 'red-color',
										'label' => __( 'General red color', 'mustang-lite' ),
									),

							'colors-global' . 90 => array(
								'type'    => 'html',
								'content' => '<h3>' . __( 'Color treshold', 'mustang-lite' ) . '</h3>',
							),

								'colors-global' . 100 => array(
									'type'    => 'range',
									'id'      => $prefix . 'text-color-treshold',
									'label'   => __( 'Auto color treshold', 'mustang-lite' ),
									'default' => 0,
									'min'     => -50,
									'max'     => 50,
									'step'    => 1,
								),
									'colors-global' . 110 => array(
										'type'    => 'html',
										'content' => '<p class="description">' . __( 'Auto color treshold is being used to automatically calculate the additional colors in the theme (such as text color from the background color). You can tweak the calculation treshold here.', 'mustang-lite' ) . '</p>',
									),



						/**
						 * Branding
						 */
						'branding' => array(
							'type'           => 'section',
							'create_section' => __( 'Logo', 'mustang-lite' ),
							'in_panel'       => _x( 'Theme Options', 'Customizer panel title.', 'mustang-lite' ),
						),

							'branding' . 10 => array(
								'type'  => 'image',
								'id'    => $prefix . 'logo',
								'label' => __( 'Logo', 'mustang-lite' ),
							),
							'branding' . 20 => array(
								'type'  => 'image',
								'id'    => $prefix . 'logo-hidpi',
								'label' => __( 'High DPI logo', 'mustang-lite' ),
							),



						/**
						 * Images
						 */
						'images' => array(
							'type'           => 'section',
							'create_section' => __( 'Images', 'mustang-lite' ),
							'in_panel'       => _x( 'Theme Options', 'Customizer panel title.', 'mustang-lite' ),
						),

							'images' . 5 => array(
								'type'    => 'html',
								'content' => '<h3>' . __( 'Lightbox', 'mustang-lite' ) . '</h3>',
							),

								'images' . 10 => array(
									'type'    => 'html',
									'content' => '<p class="description">' . __( 'If you use a special image lightbox effect plugin, you should disable the theme native effect below.', 'mustang-lite' ) . '</p>',
								),
								'images' . 20 => array(
									'type'  => 'checkbox',
									'id'    => $prefix . 'disable-lightbox',
									'label' => __( 'Disable lightbox effect', 'mustang-lite' ),
								),

							'images' . 30 => array(
								'type'    => 'html',
								'content' => '<h3>' . __( 'Image ratios', 'mustang-lite' ) . '</h3>',
							),

								'images' . 40 => array(
									'type'    => 'html',
									'content' => '<p class="description">' . __( 'Set up image ratios for the different theme items.', 'mustang-lite' ) . '</p>',
								),
								'images' . 50 => array(
									'type'    => 'select',
									'id'      => $prefix . 'image' . '-blog',
									'label'   => __( 'Blog list image', 'mustang-lite' ),
									'options' => wm_helper_var( 'image-ratio' ),
								),
								'images' . 60 => array(
									'type'    => 'select',
									'id'      => $prefix . 'image' . '-posts',
									'label'   => __( '[wm_posts] shortcode image', 'mustang-lite' ),
									'options' => wm_helper_var( 'image-ratio' ),
								),
								'images' . 70 => array(
									'type'    => 'select',
									'id'      => $prefix . 'image' . '-gallery',
									'label'   => __( '[gallery] shortcode image', 'mustang-lite' ),
									'options' => wm_helper_var( 'image-ratio' ),
								),

							'images' . 80 => array(
								'type'    => 'html',
								'content' => '<p class="description">' . __( 'Please decide on, and set the image ratios up for different website sections right after the theme activation. If you change the image sizes later on, the settings will apply only on newly uploaded images - the images you upload after you have made an image ratio change. All previous images will keep their original sizes.', 'mustang-lite' ) . '</p><p class="description">' . __( 'If you wish to resize the previously uploaded images to conform the new image ratios, you can use a plugin for this. Recommended plugins are <a href="http://wordpress.org/extend/plugins/regenerate-thumbnails/" target="_blank">Regenerate Thumbnails</a> or <a href="http://wordpress.org/extend/plugins/ajax-thumbnail-rebuild/" target="_blank">AJAX Thumbnail Rebuild</a>.', 'mustang-lite' ) . '</p>',
							),



						/**
						 * Fonts
						 */
						'fonts' => array(
							'type'           => 'section',
							'create_section' => __( 'Fonts', 'mustang-lite' ),
							'in_panel'       => _x( 'Theme Options', 'Customizer panel title.', 'mustang-lite' ),
						),

							'fonts' . 10 => array(
								'type'    => 'html',
								'content' => '<p class="description">' . __( 'Set the Google Font to be used for website headings and body text. You can additionally set a font subset for different character lists.', 'mustang-lite' ) . '</p>',
							),

								'fonts-logo' => array(
									'type'    => 'select',
									'id'      => $prefix . 'font' . '-logo',
									'label'   => __( 'Text logo font', 'mustang-lite' ),
									'options' => wm_helper_var( 'google-fonts' ),
								),
								'fonts' . 20 => array(
									'type'    => 'select',
									'id'      => $prefix . 'font' . '-headings',
									'label'   => __( 'Headings font', 'mustang-lite' ),
									'options' => wm_helper_var( 'google-fonts' ),
								),
								'fonts' . 30 => array(
									'type'    => 'select',
									'id'      => $prefix . 'font' . '-body',
									'label'   => __( 'Body text font', 'mustang-lite' ),
									'options' => wm_helper_var( 'google-fonts' ),
								),

								'fonts' . 40 => array(
									'type'    => 'multiselect',
									'id'      => $prefix . 'font' . '-subset',
									'label'   => __( 'Font subset', 'mustang-lite' ),
									'options' => wm_helper_var( 'google-fonts-subset' ),
								),

							'fonts' . 50 => array(
								'type'    => 'html',
								'content' => '<h3>' . __( 'Font sizes', 'mustang-lite' ) . '</h3>',
							),

								'fonts' . 60 => array(
									'type'          => 'range',
									'id'            => $prefix . 'font' . '-size-body',
									'label'         => __( 'Basic font size', 'mustang-lite' ),
									'default'       => 14,
									'min'           => 10,
									'max'           => 20,
									'step'          => 1,
									'customizer_js' => array(
											'css' => array(
													'html, body' => array( array( 'font-size', 'px' ) ),
												),
										),
								),

								'fonts' . 70 => array(
									'type'    => 'html',
									'content' => '<p class="description">' . __( 'Heading font size is counted from the basic font size. Set the percentage of the basic font size for each heading.', 'mustang-lite' ) . '</p>',
								),

									'fonts' . 80 => array(
										'type'          => 'range',
										'id'            => $prefix . 'font' . '-size-h1',
										'label'         => __( 'Heading H1 font size', 'mustang-lite' ),
										'default'       => 100,
										'min'           => 75,
										'max'           => 450,
										'step'          => 5,
										'customizer_js' => array(
												'css' => array(
														'h1, .heading-style-1' => array( array( 'font-size', '%' ) ),
													),
											),
									),
									'fonts' . 90 => array(
										'type'          => 'range',
										'id'            => $prefix . 'font' . '-size-h2',
										'label'         => __( 'Heading H2 font size', 'mustang-lite' ),
										'default'       => 100,
										'min'           => 75,
										'max'           => 450,
										'step'          => 5,
										'customizer_js' => array(
												'css' => array(
														'h2, .heading-style-2' => array( array( 'font-size', '%' ) ),
													),
											),
									),
									'fonts' . 100 => array(
										'type'          => 'range',
										'id'            => $prefix . 'font' . '-size-h3',
										'label'         => __( 'Heading H3 font size', 'mustang-lite' ),
										'default'       => 100,
										'min'           => 75,
										'max'           => 450,
										'step'          => 5,
										'customizer_js' => array(
												'css' => array(
														'h3, .heading-style-3' => array( array( 'font-size', '%' ) ),
													),
											),
									),
									'fonts' . 110 => array(
										'type'          => 'range',
										'id'            => $prefix . 'font' . '-size-h4',
										'label'         => __( 'Heading H4, H5 and H6 font size', 'mustang-lite' ),
										'default'       => 100,
										'min'           => 75,
										'max'           => 450,
										'step'          => 5,
										'customizer_js' => array(
												'css' => array(
														'h4, h5, h6, .heading-style-4, .heading-style-5, .heading-style-6' => array( array( 'font-size', '%' ) ),
													),
											),
									),



						/**
						 * Layout
						 */
						'layout' => array(
							'type'           => 'section',
							'create_section' => __( 'Layout', 'mustang-lite' ),
							'in_panel'       => _x( 'Theme Options', 'Customizer panel title.', 'mustang-lite' ),
						),

							'layout' . 10 => array(
								'type'    => 'html',
								'content' => '<h3>' . __( 'Layout', 'mustang-lite' ) . '</h3>',
							),

								'layout' . 20 => array(
									'type'    => 'select',
									'id'      => $prefix . 'layout',
									'label'   => __( 'Website layout', 'mustang-lite' ),
									'options' => array(
											'fullwidth' => __( 'Fullwidth', 'mustang-lite' ),
											'boxed'     => __( 'Boxed', 'mustang-lite' )
										),
								),

								'layout' . 40 => array(
									'type'          => 'range',
									'id'            => $prefix . 'website-width',
									'label'         => __( 'Website width', 'mustang-lite' ),
									'default'       => 1020,
									'min'           => 1020,
									'max'           => 1920,
									'step'          => 20,
									'customizer_js' => array(
											'custom' => "jQuery( '.boxed .website-container, .boxed .wrap, .wrap.boxed, .boxed.post-meta-layout .wrap, .wrap-inner' ).css( 'width', newval + 'px' ); jQuery( '.fl-builder .fl-row-fixed-width' ).css( 'max-width', ( newval - 120 ) + 'px' );",
										),
								),
									'layout' . 45 => array(
										'type'    => 'html',
										'content' => '<p class="description">' . __( 'The website width is being set up for the boxed layout. The actual website content width would be the website width minus the boxed layout paddings (160px). So if you set the width of 1480, the actual website content width will be 1320px (= 1480 - 160).', 'mustang-lite' ) . '</p>',
									),



						/**
						 * Others
						 */
						'others' => array(
							'type'           => 'section',
							'create_section' => __( 'Others', 'mustang-lite' ),
							'in_panel'       => _x( 'Theme Options', 'Customizer panel title.', 'mustang-lite' ),
						),

							'others' . 10 => array(
								'type'    => 'html',
								'content' => '<h3>' . __( 'CSS3 Animations', 'mustang-lite' ) . '</h3>',
							),

								'others' . 20 => array(
									'type'  => 'checkbox',
									'id'    => $prefix . 'disable-animatecss',
									'label' => __( 'Disable Animate.css library', 'mustang-lite' ),
								),

							'others' . 30 => array(
								'type'    => 'html',
								'content' => '<h3>' . esc_html__( 'Welcome page', 'mustang-lite' ) . '</h3>',
							),

								'others' . 35 => array(
									'type'  => 'checkbox',
									'id'    => $prefix . 'disable-welcome',
									'label' => esc_html__( 'Disable Appearance &raquo; Welcome page', 'mustang-lite' ),
									'customizer_js' => array(
											'custom' => '',
										),
								),

					);

			//Output
				return $wm_skin_design;
		}
	} // /wm_theme_options_skin_array
