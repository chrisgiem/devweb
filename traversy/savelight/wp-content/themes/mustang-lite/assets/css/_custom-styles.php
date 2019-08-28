<?php
/**
 * Custom CSS Styles Generator
 *
 * @package     WebMan WordPress Theme Framework
 * @subpackage  Custom CSS Styles Generator
 * @copyright   2014 WebMan - Oliver Juhas
 *
 * @since    1.0
 * @version  1.9.3
 *
 * @param  boolean $visual_editor If true, will output only styles for WordPress Visual Editor.
 */
if ( ! function_exists( 'wm_custom_styles' ) ) {
	function wm_custom_styles( $visual_editor = false ) {

		//Helper variables
			$output        = '';
			$custom_styles = $helper = array();

			$helper = array(
					'border_color'   => 25,
					'brighter_color' => 9,
					'multiplier'     => 2,
					'button_color'   => 'accent', //Default button color
					'darker_color'   => -9,
					'google_fonts'   => wm_helper_var( 'google-fonts' ),
					'headings_color' => -68,
					'line_height'    => 1.62,
					'prefix'         => 'skin-',
					'elements'       => array(
							'accent'      => array(
									'base'         => '{p}a, {p}ul.hover-enlarge li:hover:before',
									'hover-active' => '{p}a:hover, {p}a:active',
								),
							'colored'     => array(
									'base'         => '{p}, .wm-button{p}, button{p}, [type="button"]{p}, [type="submit"]{p}',
									'border-left'  => '.wm-call-to-action.cta-button-{p}',
									'hover-active' => '.wm-button{p}:hover, button{p}:hover, [type="button"]{p}:hover, [type="submit"]{p}:hover, .wm-button{p}:active, button{p}:active, [type="button"]{p}:active, [type="submit"]{p}:active',
								),
							'forms'       => '{p} [type="date"], {p} [type="email"], {p} [type="file"], {p} [type="number"], {p} [type="search"], {p} [type="password"], {p} [type="text"], {p} [type="url"], {p} [type="tel"], {p} select, {p} textarea',
							'headings'    => '{p} h1, {p} h2, {p} h3, {p} h4, {p} h5, {p} h6, {p} .h1, {p} .h2, {p} .h3, {p} .h4, {p} .h5, {p} .h6, {p} [class*="heading-style-"], {p} .no-icon-background .wm-iconbox-module .wm-content-module-element.image, {p} .no-icon-bg .wm-iconbox-module .wm-content-module-element.image',
							'pagination'  => array(
									'base'   => ', .wm-pagination a, .wm-pagination span, .bbp-pagination .bbp-pagination-links a, .bbp-pagination .bbp-pagination-links span, .woocommerce-pagination a, .woocommerce-pagination span',
									'active' => ', .wm-pagination > span, .wm-pagination a:active, .wm-pagination .current, .bbp-pagination .bbp-pagination-links > span, .bbp-pagination .bbp-pagination-links a:active, .bbp-pagination .bbp-pagination-links .current, .woocommerce-pagination > span, .woocommerce-pagination a:active, .woocommerce-pagination .current',
								),
							'shortcodes'  => array(
									'brighter-bg'            => '{p} .wm-accordion .wm-item.active .wm-item-title, {p} .wm-posts-post.wm-posts-layout-default .meta, {p} .wm-posts-forum .meta, {p} .wm-posts-wm_staff .title, {p} .wm-price-header, {p} .wm-price-feature-row, {p} .wm-progress, {p} .wm-tabs .wm-tab-links li.active, {p} .wm-tabs.layout-top .wm-tab-links li.active, {p} .wm-tabs-items .wm-item, {p} .wm-table.type-striped tr.even th, {p} .wm-table.type-striped tr.even td, {p} .wm-table.type-bordered-striped tr.even th, {p} .wm-table.type-bordered-striped tr.even td, {p} .bypostauthor .comment-author .fn',
									'brighter-border-bottom' => '{p} .wm-tabs .wm-tab-links li.active, {p} .wm-tabs.layout-top .wm-tab-links li.active',
									'brighter-border-left'   => '{p} div.wm-tabs.layout-right .wm-tab-links li.active',
									'brighter-border-right'  => '{p} div.wm-tabs.layout-left .wm-tab-links li.active',
									'iconbox'                => '{p}.wm-iconbox-module .font-icon',
									'iconbox-link-color'     => '{p}.wm-iconbox-module .font-icon a',
									'iconbox-text-shadow'    => '{p}.wm-iconbox-module.wm-content-module-item:hover .image i:before',
								),
							'woocommerce' => array(
									'buttons'              => '.woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce-page a.button, .woocommerce-page button.button, .woocommerce-page input.button, .woocommerce-page #respond input#submit, .woocommerce-page a.button.alt, .woocommerce-page button.button.alt, .woocommerce-page input.button.alt, .woocommerce-page #respond input#submit.alt, .woocommerce-MyAccount-navigation .is-active a',
									'buttons-hover-active' => '.woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover, .woocommerce-page a.button:hover, .woocommerce-page button.button:hover, .woocommerce-page input.button:hover, .woocommerce-page #respond input#submit:hover, .woocommerce-page a.button.alt:hover, .woocommerce-page button.button.alt:hover, .woocommerce-page input.button.alt:hover, .woocommerce-page #respond input#submit.alt:hover, .woocommerce a.button:active, .woocommerce button.button:active, .woocommerce input.button:active, .woocommerce-page a.button:active, .woocommerce-page button.button:active, .woocommerce-page input.button:active, .woocommerce-page #respond input#submit:active, .woocommerce-page a.button.alt:active, .woocommerce-page button.button.alt:active, .woocommerce-page input.button.alt:active, .woocommerce-page #respond input#submit.alt:active',
								),
						),
					'text_color'     => 200,
					'treshold'       => ( class_exists( 'WM_Amplifier' ) ) ? ( apply_filters( 'wmhook_wmamp_' . 'wma_contrast_color' . '_default_treshold', 127 ) ) : ( 127 ),
					'visual_editor'  => $visual_editor,
				);
			$helper['google_fonts'][''] = '';

			$helper = apply_filters( 'wmhook_wm_custom_styles_helper', $helper );



		/**
		 * Array of custom styles from admin panel
		 *
		 * You can hook onto "wmhook_wm_custom_styles_use_custom_array" and disable the theme
		 * default array preparation. Then just hook onto "wmhook_wm_custom_styles_array"
		 * to create your own array.
		 */
		if ( ! apply_filters( 'wmhook_wm_custom_styles_use_custom_array', false ) ) {

			if ( ! $visual_editor ) {

				$custom_styles = array(

					/**
					 * Skin CSS
					 */

						'skin-css' => array(
								'condition' => trim( wm_option( $helper['prefix'] . 'css' ) ),
								'custom'    => '/* Custom skin styles */' . "\r\n\t\t" . wm_option( $helper['prefix'] . 'css' )
							),



					/**
					 * Layout
					 */

						'layout' => array( 'custom' => '/* Layout */' ),

						'layout-' . 10 => array(
							'selector' => '.boxed .website-container, .boxed .wrap, .wrap.boxed, .boxed.post-meta-layout .wrap, .wrap-inner',
							'styles'   => array(
								'width' => wm_option( $helper['prefix'] . 'website-width', '', 'px' ),
							)
						),
						'layout-' . 15 => array(
							'selector' => '.fl-builder .fl-row-fixed-width',
							'styles'   => array(
								'max-width' => absint( wm_option( $helper['prefix'] . 'website-width' ) - 2 * 60 ) . 'px',
							)
						),
						'layout-' . 20 => array(
							'selector' => '.nav-main > ul > li',
							'styles'   => array(
								'padding-top'    => wm_option( $helper['prefix'] . 'nav-padding', '', 'px' ),
								'padding-bottom' => wm_option( $helper['prefix'] . 'nav-padding', '', 'px' ),
							)
						),



					/**
					 * Global colors
					 *
					 * @version  1.1.1
					 */

						'colors' => array( 'custom' => '/* Accent color */' ),

						'colors-' . 10 => array(
							'selector' => array( $helper['elements']['accent']['base'] . ', .text-color-accent', '' ),
							'styles'   => array(
								'color' => wm_option( $helper['prefix'] . 'accent-color', 'color' ),
							)
						),
							'colors-' . 20 => array(
								'selector' => array( $helper['elements']['accent']['hover-active'], '' ),
								'styles'   => array(
									'color' => wma_contrast_color( wm_option( $helper['prefix'] . 'accent-color' ), 50 ),
								)
							),

							//Global backgrounds based on accent color

								'colors-bg' => array( 'custom' => '/* Colors: Global backgrounds based on accent color */' ),

								'colors-bg-' . 10 => array(
									'selector' => array( '.header, #search-container input, .mobile-nav, .footer-widgets, ol > li:before, .next-prev-post-in-tax a, .wm-posts-wm_staff .wm-posts-item:hover .title, .content-section .custom-font-color .wm-posts-wm_staff .wm-posts-item:hover .title, .wm-posts-wm_projects.wm-posts-layout-default .wm-posts-item:hover, .wm-posts-wm_projects.wm-posts-layout-simple .wm-posts-item:hover .title, .wm-posts-post.wm-posts-layout-simple .wm-posts-item:hover .title, .floating-cart-switch, .floating-cart-switch:hover, .floating-cart-switch:active, .background-color-accent, .bg-color-accent, ' . $helper['elements']['shortcodes']['iconbox'] . $helper['elements']['pagination']['active'], '' ),
									'styles'   => array(
										'background' => wm_option( $helper['prefix'] . 'accent-color', 'color' ),
										'color'      => wma_contrast_color( wm_option( $helper['prefix'] . 'accent-color' ), $helper['text_color'] ),
									)
								),
									'colors-bg-' . 15 => array(
										'selector' => '#search-container input::-webkit-input-placeholder',
										'styles'   => array(
											'color' => wma_contrast_color( wm_option( $helper['prefix'] . 'accent-color' ), $helper['text_color'] ),
										)
									),
										'colors-bg-' . 16 => array(
											'selector' => '#search-container input::-moz-placeholder',
											'styles'   => array(
												'color' => wma_contrast_color( wm_option( $helper['prefix'] . 'accent-color' ), $helper['text_color'] ),
											)
										),
										'colors-bg-' . 17 => array(
											'selector' => '#search-container input:-ms-input-placeholder',
											'styles'   => array(
												'color' => wma_contrast_color( wm_option( $helper['prefix'] . 'accent-color' ), $helper['text_color'] ),
											)
										),
									'colors-bg-' . 20 => array(
										'selector' => '.topbar, .topbar-extra, .topbar-extra .topbar-extra-switch, .credits',
										'styles'   => array(
											'background' => wma_alter_color_brightness( wm_option( $helper['prefix'] . 'accent-color' ), $helper['darker_color'] ),
											'color'      => wma_contrast_color( wm_option( $helper['prefix'] . 'accent-color' ), $helper['text_color'] ),
										)
									),
									'colors-bg-' . 30 => array(
										'selector' => '.topbar, .topbar-extra' . $helper['elements']['pagination']['active'],
										'styles'   => array(
											'border-color' => wma_alter_color_brightness( wm_option( $helper['prefix'] . 'accent-color' ), $helper['darker_color'] ),
										)
									),
									'colors-bg-' . 40 => array(
										'selector' => '.footer-widgets',
										'styles'   => array(
											'border-color' => wma_contrast_color( wm_option( $helper['prefix'] . 'accent-color' ), absint( $helper['darker_color'] + $helper['border_color'] ) ),
										)
									),
									'colors-bg-' . 50 => array(
										'selector' => '.credits',
										'styles'   => array(
											'border-color' => wma_contrast_color( wm_option( $helper['prefix'] . 'accent-color' ), absint( $helper['multiplier'] * $helper['darker_color'] + $helper['border_color'] ) ),
										)
									),
									'colors-bg-' . 60 => array(
										'selector' => '.topbar a, .topbar-extra a, .footer-widgets a, .credits a',
										'styles'   => array(
											'color' => wma_contrast_color( wm_option( $helper['prefix'] . 'accent-color' ), $helper['text_color'] - 50 ),
										)
									),

									'colors-bg-' . 70 => array(
										'selector' => array( $helper['elements']['shortcodes']['iconbox-link-color'], '' ),
										'styles'   => array(
											'color' => wma_contrast_color( wm_option( $helper['prefix'] . 'accent-color' ), $helper['text_color'] ),
										)
									),
										'colors-bg-' . 80 => array(
											'condition' => trim( wm_option( $helper['prefix'] . 'accent-color' ) ),
											'selector'  => array( $helper['elements']['shortcodes']['iconbox-text-shadow'], '' ),
											'styles'    => array(
												'text-shadow' => ( $helper['treshold'] > wma_color_brightness( wm_option( $helper['prefix'] . 'accent-color' ) ) ) ? ( '0 0 .5em rgba(0,0,0, .62)' ) : ( '0 0 .5em rgba(255,255,255, .75)' ),
											)
										),

								'colors-bg-' . 'forms' . 10 => array(
									'selector' => array( $helper['elements']['forms'], '.topbar-extra' ),
									'styles'   => array(
										'background-color' => wma_contrast_color( wma_alter_color_brightness( wm_option( $helper['prefix'] . 'accent-color' ), $helper['darker_color'] ), $helper['brighter_color'] ),
									)
								),
									'colors-bg-' . 'forms' . 20 => array(
										'selector' => array( $helper['elements']['forms'], '.footer-widgets' ),
										'styles'   => array(
											'background-color' => wma_contrast_color( wm_option( $helper['prefix'] . 'accent-color' ), $helper['brighter_color'] ),
										)
									),
									'colors-bg-' . 'forms' . 30 => array(
										'selector' => array( $helper['elements']['forms'], '.credits' ),
										'styles'   => array(
										'background-color' => wma_contrast_color( wma_alter_color_brightness( wm_option( $helper['prefix'] . 'accent-color' ), $helper['darker_color'] ), $helper['brighter_color'] ),
										)
									),



						/**
						 * Predefined colors
						 *
						 * @version  1.1.1
						 */

							//Shortcodes default colors

								'colors-shortcodes' => array( 'custom' => '/* Colors: Shortcodes default colors */' ),

								'colors-shortcodes-' . 10 => array(
									'selector' => '.wm-button, button, [type="button"], [type="submit"], .wm-marker, .wm-dropcap, .wm-progress-bar, #bbpress-forums .quicktags-toolbar input, #bbpress-forums .bbp-new-post-toggle .wm-item-title, .bbp-logged-in a.button',
									'styles'   => array(
										'text-shadow'      => ( $helper['treshold'] > wma_color_brightness( wm_option( $helper['prefix'] . $helper['button_color'] . '-color' ) ) ) ? ( '0 -1px 0 rgba(0,0,0, .6)' ) : ( '0 1px 0 rgba(255,255,255, .6)' ),
										'color'            => wma_contrast_color( wm_option( $helper['prefix'] . $helper['button_color'] . '-color' ), $helper['text_color'], ' !important' ),
										'background-color' => wm_option( $helper['prefix'] . $helper['button_color'] . '-color', 'color' ),
										'border-color'     => wma_alter_color_brightness( wm_option( $helper['prefix'] . $helper['button_color'] . '-color' ), $helper['darker_color'] ),
									)
								),
									'colors-shortcodes-' . 20 => array(
										'selector' => '.wm-button:hover, button:hover, [type="button"]:hover, [type="submit"]:hover, .wm-button:active, button:active, [type="button"]:active, [type="submit"]:active, #bbpress-forums .quicktags-toolbar input:hover, #bbpress-forums .quicktags-toolbar input:active, #bbpress-forums .bbp-new-post-toggle .wm-item-title:hover, #bbpress-forums .bbp-new-post-toggle .wm-item.active .wm-item-title, .bbp-logged-in a.button:hover, .bbp-logged-in a.button:active',
										'styles'   => array(
											'background-color' => wma_alter_color_brightness( wm_option( $helper['prefix'] . $helper['button_color'] . '-color' ), $helper['multiplier'] * $helper['brighter_color'] ),
											'border-color'     => wma_alter_color_brightness( wm_option( $helper['prefix'] . $helper['button_color'] . '-color' ), $helper['multiplier'] * $helper['darker_color'] ),
										)
									),
									'colors-shortcodes-' . 30 => array(
										'selector' => '.wm-call-to-action',
										'styles'   => array(
											'border-left-color' => wm_option( $helper['prefix'] . $helper['button_color'] . '-color', 'color' ),
										)
									),

								'colors-shortcodes-' . 40 => array(
									'condition' => function_exists( 'wm_is_woocommerce' ),
									'selector'  => $helper['elements']['woocommerce']['buttons'],
									'styles'    => array(
										'text-shadow'      => ( $helper['treshold'] > wma_color_brightness( wm_option( $helper['prefix'] . $helper['button_color'] . '-color' ) ) ) ? ( '0 -1px 0 rgba(0,0,0, .6)' ) : ( '0 1px 0 rgba(255,255,255, .6)' ),
										'color'        => wma_contrast_color( wm_option( $helper['prefix'] . $helper['button_color'] . '-color' ), $helper['text_color'], ' !important' ),
										'background'   => wm_option( $helper['prefix'] . $helper['button_color'] . '-color', 'color' ),
										'border-color' => wma_alter_color_brightness( wm_option( $helper['prefix'] . $helper['button_color'] . '-color' ), $helper['darker_color'] ),
									)
								),
									'colors-shortcodes-' . 50 => array(
										'condition' => function_exists( 'wm_is_woocommerce' ),
										'selector'  => $helper['elements']['woocommerce']['buttons-hover-active'],
										'styles'    => array(
											'background'   => wma_alter_color_brightness( wm_option( $helper['prefix'] . $helper['button_color'] . '-color' ), $helper['multiplier'] * $helper['brighter_color'] ),
											'border-color' => wma_alter_color_brightness( wm_option( $helper['prefix'] . $helper['button_color'] . '-color' ), $helper['multiplier'] * $helper['darker_color'] ),
										)
									),

							//Blue

								'colors-blue' => array( 'custom' => '/* Colors: Blue color */' ),

								'colors-blue-' . 10 => array(
									'selector' => array( $helper['elements']['colored']['base'], '.color-blue' ),
									'styles'   => array(
										'text-shadow'      => ( $helper['treshold'] > wma_color_brightness( wm_option( $helper['prefix'] . 'blue-color' ) ) ) ? ( '0 -1px 0 rgba(0,0,0, .6)' ) : ( '0 1px 0 rgba(255,255,255, .6)' ),
										'color'            => wma_contrast_color( wm_option( $helper['prefix'] . 'blue-color' ), $helper['text_color'], ' !important' ),
										'background-color' => wm_option( $helper['prefix'] . 'blue-color', 'color' ),
										'border-color'     => wma_alter_color_brightness( wm_option( $helper['prefix'] . 'blue-color' ), $helper['darker_color'] ),
									)
								),
									'colors-blue-' . 20 => array(
										'selector' => array( $helper['elements']['colored']['hover-active'], '.color-blue' ),
										'styles'   => array(
											'background-color' => wma_alter_color_brightness( wm_option( $helper['prefix'] . 'blue-color' ), $helper['multiplier'] * $helper['brighter_color'] ),
											'border-color'     => wma_alter_color_brightness( wm_option( $helper['prefix'] . 'blue-color' ), $helper['multiplier'] * $helper['darker_color'] ),
										)
									),
									'colors-blue-' . 30 => array(
										'selector' => array( $helper['elements']['colored']['border-left'], 'color-blue' ),
										'styles'   => array(
											'border-left-color' => wm_option( $helper['prefix'] . 'blue-color', 'color' ),
										)
									),

							//Gray

								'colors-gray' => array( 'custom' => '/* Colors: Gray color */' ),

								'colors-gray-' . 10 => array(
									'selector' => array( $helper['elements']['colored']['base'], '.color-gray' ),
									'styles'   => array(
										'text-shadow'      => ( $helper['treshold'] > wma_color_brightness( wm_option( $helper['prefix'] . 'gray-color' ) ) ) ? ( '0 -1px 0 rgba(0,0,0, .6)' ) : ( '0 1px 0 rgba(255,255,255, .6)' ),
										'color'            => wma_contrast_color( wm_option( $helper['prefix'] . 'gray-color' ), $helper['text_color'], ' !important' ),
										'background-color' => wm_option( $helper['prefix'] . 'gray-color', 'color' ),
										'border-color'     => wma_alter_color_brightness( wm_option( $helper['prefix'] . 'gray-color' ), $helper['darker_color'] ),
									)
								),
									'colors-gray-' . 20 => array(
										'selector' => array( $helper['elements']['colored']['hover-active'], '.color-gray' ),
										'styles'   => array(
											'background-color' => wma_alter_color_brightness( wm_option( $helper['prefix'] . 'gray-color' ), $helper['multiplier'] * $helper['brighter_color'] ),
											'border-color'     => wma_alter_color_brightness( wm_option( $helper['prefix'] . 'gray-color' ), $helper['multiplier'] * $helper['darker_color'] ),
										)
									),
									'colors-gray-' . 30 => array(
										'selector' => array( $helper['elements']['colored']['border-left'], 'color-gray' ),
										'styles'   => array(
											'border-left-color' => wm_option( $helper['prefix'] . 'gray-color', 'color' ),
										)
									),

							//Green

								'colors-green' => array( 'custom' => '/* Colors: Green color */' ),

								'colors-green-' . 10 => array(
									'selector' => array( $helper['elements']['colored']['base'], '.color-green' ),
									'styles'   => array(
										'text-shadow'      => ( $helper['treshold'] > wma_color_brightness( wm_option( $helper['prefix'] . 'green-color' ) ) ) ? ( '0 -1px 0 rgba(0,0,0, .6)' ) : ( '0 1px 0 rgba(255,255,255, .6)' ),
										'color'            => wma_contrast_color( wm_option( $helper['prefix'] . 'green-color' ), $helper['text_color'], ' !important' ),
										'background-color' => wm_option( $helper['prefix'] . 'green-color', 'color' ),
										'border-color'     => wma_alter_color_brightness( wm_option( $helper['prefix'] . 'green-color' ), $helper['darker_color'] ),
									)
								),
									'colors-green-' . 20 => array(
										'selector' => array( $helper['elements']['colored']['hover-active'], '.color-green' ),
										'styles'   => array(
											'background-color' => wma_alter_color_brightness( wm_option( $helper['prefix'] . 'green-color' ), $helper['multiplier'] * $helper['brighter_color'] ),
											'border-color'     => wma_alter_color_brightness( wm_option( $helper['prefix'] . 'green-color' ), $helper['multiplier'] * $helper['darker_color'] ),
										)
									),
									'colors-green-' . 30 => array(
										'selector' => array( $helper['elements']['colored']['border-left'], 'color-green' ),
										'styles'   => array(
											'border-left-color' => wm_option( $helper['prefix'] . 'green-color', 'color' ),
										)
									),

							//Orange

								'colors-orange' => array( 'custom' => '/* Colors: Orange color */' ),

								'colors-orange-' . 10 => array(
									'selector' => array( $helper['elements']['colored']['base'], '.color-orange' ),
									'styles'   => array(
										'text-shadow'      => ( $helper['treshold'] > wma_color_brightness( wm_option( $helper['prefix'] . 'orange-color' ) ) ) ? ( '0 -1px 0 rgba(0,0,0, .6)' ) : ( '0 1px 0 rgba(255,255,255, .6)' ),
										'color'            => wma_contrast_color( wm_option( $helper['prefix'] . 'orange-color' ), $helper['text_color'], ' !important' ),
										'background-color' => wm_option( $helper['prefix'] . 'orange-color', 'color' ),
										'border-color'     => wma_alter_color_brightness( wm_option( $helper['prefix'] . 'orange-color' ), $helper['darker_color'] ),
									)
								),
									'colors-orange-' . 20 => array(
										'selector' => array( $helper['elements']['colored']['hover-active'], '.color-orange' ),
										'styles'   => array(
											'background-color' => wma_alter_color_brightness( wm_option( $helper['prefix'] . 'orange-color' ), $helper['multiplier'] * $helper['brighter_color'] ),
											'border-color'     => wma_alter_color_brightness( wm_option( $helper['prefix'] . 'orange-color' ), $helper['multiplier'] * $helper['darker_color'] ),
										)
									),
									'colors-orange-' . 30 => array(
										'selector' => array( $helper['elements']['colored']['border-left'], 'color-orange' ),
										'styles'   => array(
											'border-left-color' => wm_option( $helper['prefix'] . 'orange-color', 'color' ),
										)
									),

							//Red

								'colors-red' => array( 'custom' => '/* Colors: Red color */' ),

								'colors-red-' . 10 => array(
									'selector' => array( $helper['elements']['colored']['base'], '.color-red' ),
									'styles'   => array(
										'text-shadow'      => ( $helper['treshold'] > wma_color_brightness( wm_option( $helper['prefix'] . 'red-color' ) ) ) ? ( '0 -1px 0 rgba(0,0,0, .6)' ) : ( '0 1px 0 rgba(255,255,255, .6)' ),
										'color'            => wma_contrast_color( wm_option( $helper['prefix'] . 'red-color' ), $helper['text_color'], ' !important' ),
										'background-color' => wm_option( $helper['prefix'] . 'red-color', 'color' ),
										'border-color'     => wma_alter_color_brightness( wm_option( $helper['prefix'] . 'red-color' ), $helper['darker_color'] ),
									)
								),
									'colors-red-' . 20 => array(
										'selector' => array( $helper['elements']['colored']['hover-active'], '.color-red' ),
										'styles'   => array(
											'background-color' => wma_alter_color_brightness( wm_option( $helper['prefix'] . 'red-color' ), $helper['multiplier'] * $helper['brighter_color'] ),
											'border-color'     => wma_alter_color_brightness( wm_option( $helper['prefix'] . 'red-color' ), $helper['multiplier'] * $helper['darker_color'] ),
										)
									),
									'colors-red-' . 30 => array(
										'selector' => array( $helper['elements']['colored']['border-left'], 'color-red' ),
										'styles'   => array(
											'border-left-color' => wm_option( $helper['prefix'] . 'red-color', 'color' ),
										)
									),

								'colors-red-' . 40 => array(
									'condition' => ( function_exists( 'wm_is_woocommerce' ) || function_exists( 'wm_is_bbpress' ) ),
									'selector'  => '.woocommerce-page .woocommerce-error, div.bbp-template-notice.error, div.bbp-template-notice.warning',
									'styles'    => array(
										'border-color' => wm_option( $helper['prefix'] . 'red-color', 'color' ),
									)
								),



					/**
					 * Backgrounds and colors
					 */

						/**
						 * HTML and body
						 */

							'html' => array( 'custom' => '/* Background: HTML and body */' ),

							'html-' . 10 => array(
								'selector' => 'html',
								'styles'   => array(
									'background' => wm_css_background( array( 'option_base' => $helper['prefix'] . 'html-' ) ),
								)
							),



						/**
						 * Topbar
						 */

							'topbar' => array( 'custom' => '/* Background: Topbar */' ),

							'topbar-' . 10 => array(
								'selector' => '.topbar, .topbar-extra',
								'styles'   => array(
									'background'   => wm_css_background( array( 'option_base' => $helper['prefix'] . 'topbar-' ) ),
									'color'        => wm_option( $helper['prefix'] . 'topbar-color', 'color' ),
									'border-color' => wm_option( $helper['prefix'] . 'topbar-border-color', 'color', ' !important' ),
								)
							),
								'topbar-' . 20 => array(
									'selector' => '.topbar-extra .topbar-extra-switch',
									'styles'   => array(
										'background' => wm_option( $helper['prefix'] . 'topbar-border-color', 'color' ),
										'color'      => wma_contrast_color( wm_option( $helper['prefix'] . 'topbar-border-color' ), $helper['text_color'] ),
									)
								),
								'topbar-' . 30 => array(
									'condition' => trim( wm_option( $helper['prefix'] . 'topbar-color' ) ),
									'selector'  => array( $helper['elements']['headings'], '.topbar-extra' ),
									'styles'    => array(
										'color' => ( $helper['treshold'] > wma_color_brightness( wm_option( $helper['prefix'] . 'topbar-color', 'color' ) ) ) ? ( wma_alter_color_brightness( wm_option( $helper['prefix'] . 'topbar-color' ), $helper['headings_color'] ) ) : ( wma_alter_color_brightness( wm_option( $helper['prefix'] . 'topbar-color' ), -$helper['headings_color'] ) ),
									)
								),

							//Brighter background

								'topbar-' . 'forms' => array(
									'selector' => array( $helper['elements']['forms'], '.topbar' ),
									'styles'   => array(
										'background-color' => wma_contrast_color( wm_option( $helper['prefix'] . 'topbar-bg-color' ), $helper['brighter_color'] ),
									)
								),

								'topbar-extra-' . 'forms' => array(
									'selector' => array( $helper['elements']['forms'], '.topbar-extra' ),
									'styles'   => array(
										'background-color' => wma_contrast_color( wm_option( $helper['prefix'] . 'topbar-bg-color' ), $helper['brighter_color'] ),
										'background-color' => wma_contrast_color( wm_option( $helper['prefix'] . 'topbar-extra-bg-color' ), $helper['brighter_color'] ),
									)
								),
								'topbar-extra-' . 10 => array(
									'selector' => array( $helper['elements']['shortcodes']['brighter-bg'], '.topbar-extra' ),
									'styles'   => array(
										'background-color' => wma_contrast_color( wm_option( $helper['prefix'] . 'topbar-bg-color' ), $helper['brighter_color'] ),
										'background-color' => wma_contrast_color( wm_option( $helper['prefix'] . 'topbar-extra-bg-color' ), $helper['brighter_color'] ),
									)
								),
									'topbar-extra-' . 20 => array(
										'selector' => array( $helper['elements']['shortcodes']['brighter-border-bottom'], '.topbar-extra' ),
										'styles'   => array(
											'border-bottom-color' => wma_contrast_color( wm_option( $helper['prefix'] . 'topbar-bg-color' ), $helper['brighter_color'] ),
											'border-bottom-color' => wma_contrast_color( wm_option( $helper['prefix'] . 'topbar-extra-bg-color' ), $helper['brighter_color'] ),
										)
									),
									'topbar-extra-' . 30 => array(
										'selector' => array( $helper['elements']['shortcodes']['brighter-border-right'], '.topbar-extra' ),
										'styles'   => array(
											'border-right-color' => wma_contrast_color( wm_option( $helper['prefix'] . 'topbar-bg-color' ), $helper['brighter_color'] ),
											'border-right-color' => wma_contrast_color( wm_option( $helper['prefix'] . 'topbar-extra-bg-color' ), $helper['brighter_color'] ),
										)
									),
									'topbar-extra-' . 40 => array(
										'selector' => array( $helper['elements']['shortcodes']['brighter-border-left'], '.topbar-extra' ),
										'styles'   => array(
											'border-left-color' => wma_contrast_color( wm_option( $helper['prefix'] . 'topbar-bg-color' ), $helper['brighter_color'] ),
											'border-left-color' => wma_contrast_color( wm_option( $helper['prefix'] . 'topbar-extra-bg-color' ), $helper['brighter_color'] ),
										)
									),

							//Accent color

								'topbar-accent-' . 10 => array(
									'selector' => array( $helper['elements']['accent']['base'], '.topbar ' ),
									'styles'   => array(
										'color' => wm_option( $helper['prefix'] . 'topbar-accent-color', 'color' ),
									)
								),
									'topbar-accent-' . 20 => array(
										'selector' => array( $helper['elements']['accent']['hover-active'], '.topbar ' ),
										'styles'   => array(
											'color' => wma_contrast_color( wm_option( $helper['prefix'] . 'topbar-accent-color' ), 50 ),
										)
									),

								'topbar-extra-accent-' . 10 => array(
									'selector' => array( $helper['elements']['accent']['base'], '.topbar-extra ' ),
									'styles'   => array(
										'color' => wm_option( $helper['prefix'] . 'topbar-accent-color', 'color' ),
										'color' => wm_option( $helper['prefix'] . 'topbar-extra-accent-color', 'color' ),
									)
								),
									'topbar-extra-accent-' . 20 => array(
										'selector' => array( $helper['elements']['accent']['hover-active'], '.topbar-extra ' ),
										'styles'   => array(
											'color' => wma_contrast_color( wm_option( $helper['prefix'] . 'topbar-accent-color' ), 50 ),
											'color' => wma_contrast_color( wm_option( $helper['prefix'] . 'topbar-extra-accent-color' ), 50 ),
										)
									),

								'topbar-extra-accent-' . 30 => array(
									'selector' => array( $helper['elements']['shortcodes']['iconbox'], '.topbar-extra ' ),
									'styles'   => array(
										'background'   => wm_option( $helper['prefix'] . 'topbar-accent-color', 'color' ),
										'background|2' => wm_option( $helper['prefix'] . 'topbar-extra-accent-color', 'color' ),
										'color'        => wma_contrast_color( wm_option( $helper['prefix'] . 'topbar-accent-color' ), $helper['text_color'] ),
										'color|2'      => wma_contrast_color( wm_option( $helper['prefix'] . 'topbar-extra-accent-color' ), $helper['text_color'] ),
									)
								),
									'topbar-extra-accent-' . 40 => array(
										'selector' => array( $helper['elements']['shortcodes']['iconbox-link-color'], '.topbar-extra ' ),
										'styles'   => array(
											'color'   => wma_contrast_color( wm_option( $helper['prefix'] . 'topbar-accent-color' ), $helper['text_color'] ),
											'color|2' => wma_contrast_color( wm_option( $helper['prefix'] . 'topbar-extra-accent-color' ), $helper['text_color'] ),
										)
									),
										'topbar-extra-accent-' . 50 => array(
											'condition' => trim( wm_option( $helper['prefix'] . 'topbar-accent-color' ) ),
											'selector'  => array( $helper['elements']['shortcodes']['iconbox-text-shadow'], '.topbar-extra ' ),
											'styles'    => array(
												'text-shadow'   => ( $helper['treshold'] > wma_color_brightness( wm_option( $helper['prefix'] . 'topbar-accent-color' ) ) ) ? ( '0 0 .5em rgba(0,0,0, .62)' ) : ( '0 0 .5em rgba(255,255,255, .75)' ),
												'text-shadow|2' => ( $helper['treshold'] > wma_color_brightness( wm_option( $helper['prefix'] . 'topbar-extra-accent-color' ) ) ) ? ( '0 0 .5em rgba(0,0,0, .62)' ) : ( '0 0 .5em rgba(255,255,255, .75)' ),
											)
										),

							//Topbar Extra

								'topbar-extra-' . 10 => array(
									'selector' => '.topbar-extra',
									'styles'   => array(
										'background'   => wm_option( $helper['prefix'] . 'topbar-extra-bg-color', 'color' ),
										'color'        => wm_option( $helper['prefix'] . 'topbar-extra-color', 'color' ),
										'border-color' => wm_option( $helper['prefix'] . 'topbar-extra-border-color', 'color', ' !important' ),
									)
								),
									'topbar-extra-' . 20 => array(
										'selector' => '.topbar-extra .topbar-extra-switch',
										'styles'   => array(
											'background' => wm_option( $helper['prefix'] . 'topbar-extra-border-color', 'color' ),
											'color'      => wma_contrast_color( wm_option( $helper['prefix'] . 'topbar-extra-border-color' ), $helper['text_color'] ),
										)
									),
									'topbar-extra-' . 30 => array(
										'condition' => trim( wm_option( $helper['prefix'] . 'topbar-extra-color' ) ),
										'selector'  => array( $helper['elements']['headings'], '.topbar-extra' ),
										'styles'    => array(
											'color' => ( $helper['treshold'] > wma_color_brightness( wm_option( $helper['prefix'] . 'topbar-extra-color', 'color' ) ) ) ? ( wma_alter_color_brightness( wm_option( $helper['prefix'] . 'topbar-extra-color' ), $helper['headings_color'] ) ) : ( wma_alter_color_brightness( wm_option( $helper['prefix'] . 'topbar-extra-color' ), -$helper['headings_color'] ) ),
										)
									),



						/**
						 * Header and navigation
						 *
						 * @version  1.1.1
						 */

							'header' => array( 'custom' => '/* Background: Header and navigation */' ),

							'header-' . 10 => array(
								'selector' => '.header, #search-container input, .mobile-nav',
								'styles'   => array(
									'background'   => wm_css_background( array( 'option_base' => $helper['prefix'] . 'header-' ) ),
									'color'        => wm_option( $helper['prefix'] . 'header-color', 'color' ),
									'border-color' => wm_option( $helper['prefix'] . 'header-border-color', 'color', ' !important' ),
								)
							),
								'header-' . 15 => array(
									'selector' => '#search-container input::-webkit-input-placeholder',
									'styles'   => array(
										'color' => wm_option( $helper['prefix'] . 'header-color', 'color' ),
									)
								),
								'header-' . 16 => array(
									'selector' => '#search-container input::-moz-placeholder',
									'styles'   => array(
										'color' => wm_option( $helper['prefix'] . 'header-color', 'color' ),
									)
								),
								'header-' . 17 => array(
									'selector' => '#search-container input:-ms-input-placeholder',
									'styles'   => array(
										'color' => wm_option( $helper['prefix'] . 'header-color', 'color' ),
									)
								),

							//Brighter background

								'header-' . 'forms' => array(
									'selector' => array( $helper['elements']['forms'], '.header' ),
									'styles'   => array(
										'background-color' => wma_contrast_color( wm_option( $helper['prefix'] . 'header-bg-color' ), $helper['brighter_color'] ),
									)
								),

							//Accent color

								'header-accent-' . 10 => array(
									'selector' => array( $helper['elements']['accent']['base'], '.header ' ),
									'styles'   => array(
										'color' => wm_option( $helper['prefix'] . 'header-accent-color', 'color' ),
									)
								),
									'header-accent-' . 20 => array(
										'selector' => array( $helper['elements']['accent']['hover-active'], '.header ' ),
										'styles'   => array(
											'color' => wma_contrast_color( wm_option( $helper['prefix'] . 'header-accent-color' ), 50 ),
										)
									),

							//Navigation

								'navigation-' . 10 => array(
									'selector' => '.nav-main li ul',
									'styles'   => array(
										'background-color' => wm_option( $helper['prefix'] . 'nav-bg-color', 'color' ),
										'color'            => wm_option( $helper['prefix'] . 'nav-color', 'color' ),
									)
								),
								'navigation-' . 20 => array(
									'selector' => '.nav-main li ul',
									'styles'   => array(
										'border-color' => wm_option( $helper['prefix'] . 'nav-border-color', 'color' ),
									)
								),
								'navigation-' . 30 => array(
									'selector' => '.nav-main li li:hover > a, .nav-main li li a:hover, .nav-main li li.active-menu-item > a',
									'styles'   => array(
										'background-color' => wma_contrast_color( wm_option( $helper['prefix'] . 'nav-bg-color' ), $helper['multiplier'] * $helper['brighter_color'] ),
									)
								),

								'navigation-' . 40 => array(
									'condition' => ( trim( wm_option( $helper['prefix'] . 'accent-color' ) ) && ! trim( wm_option( $helper['prefix'] . 'header-bg-color' ) ) ),
									'selector'  => '.nav-main > ul > li > .inner:hover, .nav-main > ul > li:hover > .inner',
									'styles'    => array(
										'-webkit-box-shadow' => 'inset 0 .15em .72em 0 rgba(0,0,0, ' . wm_nav_shadow_opacity( wma_color_brightness( wm_option( $helper['prefix'] . 'accent-color', 'color' ) ), 15 ) / 100 / 2 . ')',
										'box-shadow'         => 'inset 0 .15em .72em 0 rgba(0,0,0, ' . wm_nav_shadow_opacity( wma_color_brightness( wm_option( $helper['prefix'] . 'accent-color', 'color' ) ), 15 ) / 100 / 2 . ')',
									)
								),
									'navigation-' . 50 => array(
										'condition' => ( trim( wm_option( $helper['prefix'] . 'accent-color' ) ) && ! trim( wm_option( $helper['prefix'] . 'header-bg-color' ) ) ),
										'selector'  => '.nav-main > ul > li.active-menu-item > a' . ' /* Brightness (accent) = '. wma_color_brightness( wm_option( $helper['prefix'] . 'accent-color', 'color' ) ) . ' */',
										'styles'    => array(
											'-webkit-box-shadow' => 'inset 0 .15em 1.4em 0 rgba(0,0,0, ' . wm_nav_shadow_opacity( wma_color_brightness( wm_option( $helper['prefix'] . 'accent-color', 'color' ) ), 15 ) / 100 . ')',
											'box-shadow'         => 'inset 0 .15em 1.4em 0 rgba(0,0,0, ' . wm_nav_shadow_opacity( wma_color_brightness( wm_option( $helper['prefix'] . 'accent-color', 'color' ) ), 15 ) / 100 . ')',
										)
									),
								'navigation-' . 60 => array(
									'condition' => trim( wm_option( $helper['prefix'] . 'header-bg-color' ) ),
									'selector'  => '.nav-main > ul > li > .inner:hover, .nav-main > ul > li:hover > .inner',
									'styles'    => array(
										'-webkit-box-shadow' => 'inset 0 .15em .72em 0 rgba(0,0,0, ' . wm_nav_shadow_opacity( wma_color_brightness( wm_option( $helper['prefix'] . 'header-bg-color', 'color' ) ), 15 ) / 100 / 2 . ')',
										'box-shadow'         => 'inset 0 .15em .72em 0 rgba(0,0,0, ' . wm_nav_shadow_opacity( wma_color_brightness( wm_option( $helper['prefix'] . 'header-bg-color', 'color' ) ), 15 ) / 100 / 2 . ')',
									)
								),
									'navigation-' . 70 => array(
										'condition' => trim( wm_option( $helper['prefix'] . 'header-bg-color' ) ),
										'selector'  => '.nav-main > ul > li.active-menu-item > a' . ' /* Brightness = '. wma_color_brightness( wm_option( $helper['prefix'] . 'header-bg-color', 'color' ) ) . ' */',
										'styles'    => array(
											'-webkit-box-shadow' => 'inset 0 .15em 1.4em 0 rgba(0,0,0, ' . wm_nav_shadow_opacity( wma_color_brightness( wm_option( $helper['prefix'] . 'header-bg-color', 'color' ) ), 15 ) / 100 . ')',
											'box-shadow'         => 'inset 0 .15em 1.4em 0 rgba(0,0,0, ' . wm_nav_shadow_opacity( wma_color_brightness( wm_option( $helper['prefix'] . 'header-bg-color', 'color' ) ), 15 ) / 100 . ')',
										)
									),



						/**
						 * Special slider
						 */

							'slider' => array( 'custom' => '/* Background: Special slider */' ),

							'slider-' . 10 => array(
								'selector' => '.slider',
								'styles'   => array(
									'background-color' => wm_option( $helper['prefix'] . 'slider-bg-color', 'color' ),
									'color'            => wm_option( $helper['prefix'] . 'slider-color', 'color' ),
									'border-color'     => wm_option( $helper['prefix'] . 'slider-border-color', 'color', ' !important' ),
								)
							),

							//Brighter background

								'slider-' . 30 => array(
									'selector' => array( $helper['elements']['shortcodes']['brighter-bg'], '.slider' ),
									'styles'   => array(
										'background-color' => wma_contrast_color( wm_option( $helper['prefix'] . 'slider-bg-color' ), $helper['brighter_color'] ),
									)
								),
									'slider-' . 40 => array(
										'selector' => array( $helper['elements']['shortcodes']['brighter-border-bottom'], '.slider' ),
										'styles'   => array(
											'border-bottom-color' => wma_contrast_color( wm_option( $helper['prefix'] . 'slider-bg-color' ), $helper['brighter_color'] ),
										)
									),
									'slider-' . 50 => array(
										'selector' => array( $helper['elements']['shortcodes']['brighter-border-right'], '.slider' ),
										'styles'   => array(
											'border-right-color' => wma_contrast_color( wm_option( $helper['prefix'] . 'slider-bg-color' ), $helper['brighter_color'] ),
										)
									),
									'slider-' . 60 => array(
										'selector' => array( $helper['elements']['shortcodes']['brighter-border-left'], '.slider' ),
										'styles'   => array(
											'border-left-color' => wma_contrast_color( wm_option( $helper['prefix'] . 'slider-bg-color' ), $helper['brighter_color'] ),
										)
									),
								'slider-' . 'forms' => array(
									'selector' => array( $helper['elements']['forms'], '.slider' ),
									'styles'   => array(
										'background-color' => wma_contrast_color( wm_option( $helper['prefix'] . 'slider-bg-color' ), $helper['brighter_color'] ),
									)
								),

							//Accent color

								'slider-accent-' . 10 => array(
									'selector' => array( $helper['elements']['accent']['base'], '.slider ' ),
									'styles'   => array(
										'color' => wm_option( $helper['prefix'] . 'slider-accent-color', 'color' ),
									)
								),
									'slider-accent-' . 20 => array(
										'selector' => array( $helper['elements']['accent']['hover-active'], '.slider ' ),
										'styles'   => array(
											'color' => wma_contrast_color( wm_option( $helper['prefix'] . 'slider-accent-color' ), 50 ),
										)
									),

								'slider-accent-' . 30 => array(
									'selector' => array( $helper['elements']['shortcodes']['iconbox'], '.slider ' ),
									'styles'   => array(
										'background' => wm_option( $helper['prefix'] . 'slider-accent-color', 'color' ),
										'color'      => wma_contrast_color( wm_option( $helper['prefix'] . 'slider-accent-color' ), $helper['text_color'] ),
									)
								),
									'slider-accent-' . 40 => array(
										'selector' => array( $helper['elements']['shortcodes']['iconbox-link-color'], '.slider ' ),
										'styles'   => array(
											'color' => wma_contrast_color( wm_option( $helper['prefix'] . 'slider-accent-color' ), $helper['text_color'] ),
										)
									),
										'slider-accent-' . 50 => array(
											'condition' => trim( wm_option( $helper['prefix'] . 'slider-accent-color' ) ),
											'selector'  => array( $helper['elements']['shortcodes']['iconbox-text-shadow'], '.slider ' ),
											'styles'    => array(
												'text-shadow' => ( $helper['treshold'] > wma_color_brightness( wm_option( $helper['prefix'] . 'slider-accent-color' ) ) ) ? ( '0 0 .5em rgba(0,0,0, .62)' ) : ( '0 0 .5em rgba(255,255,255, .75)' ),
											)
										),



						/**
						 * Main heading
						 */

							'main-heading' => array( 'custom' => '/* Background: Main heading */' ),

							'main-heading-' . 10 => array(
								'selector' => '.main-heading',
								'styles'   => array(
									'background'   => wm_css_background( array( 'option_base' => $helper['prefix'] . 'heading-' ) ),
									'color'        => wm_option( $helper['prefix'] . 'heading-color', 'color' ),
									'border-color' => wm_option( $helper['prefix'] . 'heading-border-color', 'color', ' !important' ),
								)
							),

							//Brighter background

								'main-heading-' . 'forms' => array(
									'selector' => array( $helper['elements']['forms'], '.main-heading' ),
									'styles'   => array(
										'background-color' => wma_contrast_color( wm_option( $helper['prefix'] . 'heading-bg-color' ), $helper['brighter_color'] ),
									)
								),

							//Accent color

								'main-heading-accent-' . 10 => array(
									'selector' => array( $helper['elements']['accent']['base'], '.main-heading ' ),
									'styles'   => array(
										'color' => wm_option( $helper['prefix'] . 'heading-accent-color', 'color' ),
									)
								),
									'main-heading-accent-' . 20 => array(
										'selector' => array( $helper['elements']['accent']['hover-active'], '.main-heading ' ),
										'styles'   => array(
											'color' => wma_contrast_color( wm_option( $helper['prefix'] . 'heading-accent-color' ), 50 ),
										)
									),



						/**
						 * Content
						 *
						 * @version  1.1.1
						 */

							'content' => array( 'custom' => '/* Background: Content area */' ),

							'content-' . 10 => array(
								'selector' => '.content-section, .page-template-page-templateblank-php',
								'styles'   => array(
									'background'   => wm_css_background( array( 'option_base' => $helper['prefix'] . 'content-' ) ),
									'color'        => wm_option( $helper['prefix'] . 'content-color', 'color' ),
									'border-color' => wm_option( $helper['prefix'] . 'content-border-color', 'color', ' !important' ),
								)
							),
								'content-' . 20 => array(
									'selector' => array( $helper['elements']['headings'] . ', {p} pre, .single {p} blockquote, .single {p} .entry-summary', '.content-section' ),
									'styles'   => array(
										'color' => ( $helper['treshold'] < wma_color_brightness( wm_option( $helper['prefix'] . 'content-bg-color' ) ) ) ? ( wma_alter_color_brightness( wm_option( $helper['prefix'] . 'content-color' ), $helper['headings_color'] ) ) : ( wma_alter_color_brightness( wm_option( $helper['prefix'] . 'content-color' ), -$helper['headings_color'] ) ),
									)
								),
								'content-' . 30 => array(
									'condition' => function_exists( 'wm_is_woocommerce' ),
									'selector'  => '.woocommerce-page .quantity .plus, .woocommerce-page .quantity .minus',
									'styles'    => array(
										'color' => wm_option( $helper['prefix'] . 'content-color', 'color', ' !important' ),
									)
								),

							//Brighter background

								'content-' . 50 => array(
									'selector' => array( $helper['elements']['shortcodes']['brighter-bg'] . $helper['elements']['pagination']['base'] . ', .list-articles .entry-meta, .woocommerce-page .order-total th, .woocommerce-page .order-total td, .woocommerce-page #payment, .bbp-large-topic, #bbpress-forums div.bbp-reply-header, #bbpress-forums .bbp-search-results div.bbp-forum-header, #bbpress-forums .bbp-search-results div.bbp-topic-header', '.content-section' ),
									'styles'   => array(
										'background-color' => wma_contrast_color( wm_option( $helper['prefix'] . 'content-bg-color' ), $helper['brighter_color'] ),
									)
								),
									'content-' . 60 => array(
										'selector' => array( $helper['elements']['shortcodes']['brighter-border-bottom'], '.content-section' ),
										'styles'   => array(
											'border-bottom-color' => wma_contrast_color( wm_option( $helper['prefix'] . 'content-bg-color' ), $helper['brighter_color'] ),
										)
									),
									'content-' . 70 => array(
										'selector' => array( $helper['elements']['shortcodes']['brighter-border-right'], '.content-section' ),
										'styles'   => array(
											'border-right-color' => wma_contrast_color( wm_option( $helper['prefix'] . 'content-bg-color' ), $helper['brighter_color'] ),
										)
									),
									'content-' . 80 => array(
										'selector' => array( $helper['elements']['shortcodes']['brighter-border-left'], '.content-section' ),
										'styles'   => array(
											'border-left-color' => wma_contrast_color( wm_option( $helper['prefix'] . 'content-bg-color' ), $helper['brighter_color'] ),
										)
									),
								'content-' . 'forms' => array(
									'selector' => array( $helper['elements']['forms'] . ', .woocommerce .form-row .select2-container, .woocommerce-checkout .form-row .select2-container, #bbpress-forums #bbp-your-profile fieldset input, #bbpress-forums #bbp-your-profile fieldset textarea', '.content-section' ),
									'styles'   => array(
										'background-color' => wma_contrast_color( wm_option( $helper['prefix'] . 'content-bg-color' ), $helper['brighter_color'] ),
									)
								),

							//Accent color

								'content-accent-' . 10 => array(
									'selector' => array( $helper['elements']['accent']['base'], '.content-section ' ),
									'styles'   => array(
										'color' => wm_option( $helper['prefix'] . 'content-accent-color', 'color' ),
									)
								),
									'content-accent-' . 20 => array(
										'selector' => array( $helper['elements']['accent']['hover-active'], '.content-section ' ),
										'styles'   => array(
											'color' => wma_contrast_color( wm_option( $helper['prefix'] . 'content-accent-color' ), 50 ),
										)
									),
								'content-accent-' . 30 => array(
									'selector' => 'blockquote, blockquote.alignleft, blockquote.alignright',
									'styles'   => array(
										'border-color'   => wm_option( $helper['prefix'] . 'accent-color', 'color' ),
										'border-color|2' => wm_option( $helper['prefix'] . 'content-accent-color', 'color' ),
									)
								),

								'content-accent-' . 40 => array(
									'selector' => array( $helper['elements']['shortcodes']['iconbox'] . ', .floating-cart-switch, .floating-cart-switch:hover, .floating-cart-switch:active', '.content-section ' ),
									'styles'   => array(
										'background' => wm_option( $helper['prefix'] . 'content-accent-color', 'color' ),
										'color'      => wma_contrast_color( wm_option( $helper['prefix'] . 'content-accent-color' ), $helper['text_color'] ),
									)
								),
									'content-accent-' . 50 => array(
										'selector' => array( $helper['elements']['shortcodes']['iconbox-link-color'], '.content-section ' ),
										'styles'   => array(
											'color' => wma_contrast_color( wm_option( $helper['prefix'] . 'content-accent-color' ), $helper['text_color'] ),
										)
									),
										'content-accent-' . 60 => array(
											'condition' => trim( wm_option( $helper['prefix'] . 'content-accent-color' ) ),
											'selector'  => array( $helper['elements']['shortcodes']['iconbox-text-shadow'], '.content-section ' ),
											'styles'    => array(
												'text-shadow' => ( $helper['treshold'] > wma_color_brightness( wm_option( $helper['prefix'] . 'content-accent-color' ) ) ) ? ( '0 0 .5em rgba(0,0,0, .62)' ) : ( '0 0 .5em rgba(255,255,255, .75)' ),
											)
										),

								'colors-accent-' . 70 => array(
									'condition' => ( function_exists( 'wm_is_woocommerce' ) && trim( wm_option( $helper['prefix'] . 'content-accent-color' ) ) ),
									'selector'  => $helper['elements']['woocommerce']['buttons'],
									'styles'    => array(
										'text-shadow'  => ( $helper['treshold'] > wma_color_brightness( wm_option( $helper['prefix'] . 'content-accent-color' ) ) ) ? ( '0 -1px 0 rgba(0,0,0, .6)' ) : ( '0 1px 0 rgba(255,255,255, .6)' ),
										'color'        => wma_contrast_color( wm_option( $helper['prefix'] . 'content-accent-color' ), $helper['text_color'], ' !important' ),
										'background'   => wm_option( $helper['prefix'] . 'content-accent-color', 'color' ),
										'border-color' => wma_alter_color_brightness( wm_option( $helper['prefix'] . 'content-accent-color' ), $helper['darker_color'] ),
									)
								),
									'colors-accent-' . 80 => array(
										'condition' => ( function_exists( 'wm_is_woocommerce' ) && trim( wm_option( $helper['prefix'] . 'content-accent-color' ) ) ),
										'selector'  => $helper['elements']['woocommerce']['buttons-hover-active'],
										'styles'    => array(
											'background'   => wma_alter_color_brightness( wm_option( $helper['prefix'] . 'content-accent-color' ), $helper['multiplier'] * $helper['brighter_color'] ),
											'border-color' => wma_alter_color_brightness( wm_option( $helper['prefix'] . 'content-accent-color' ), $helper['multiplier'] * $helper['darker_color'] ),
										)
									),



						/**
						 * Footer
						 */

							//Footer widgets

								'footer-widgets' => array( 'custom' => '/* Background: Footer widgets */' ),

								'footer-widgets-' . 10 => array(
									'selector' => '.footer-widgets',
									'styles'   => array(
										'background'   => wm_css_background( array( 'option_base' => $helper['prefix'] . 'footer-widgets-' ) ),
										'color'        => wm_option( $helper['prefix'] . 'footer-widgets-color', 'color' ),
										'border-color' => wm_option( $helper['prefix'] . 'footer-widgets-border-color', 'color', ' !important' ),
									)
								),
									'footer-widgets-' . 20 => array(
										'selector' => array( $helper['elements']['headings'], '.footer-widgets' ),
										'styles'   => array(
											'color' => ( $helper['treshold'] < wma_color_brightness( wm_option( $helper['prefix'] . 'footer-widgets-bg-color' ) ) ) ? ( wma_alter_color_brightness( wm_option( $helper['prefix'] . 'footer-widgets-color' ), $helper['headings_color'] ) ) : ( wma_alter_color_brightness( wm_option( $helper['prefix'] . 'footer-widgets-color' ), -$helper['headings_color'] ) ),
										)
									),

								//Brighter background

									'footer-widgets-' . 30 => array(
										'selector' => array( $helper['elements']['shortcodes']['brighter-bg'], '.footer-widgets' ),
										'styles'   => array(
											'background-color' => wma_contrast_color( wm_option( $helper['prefix'] . 'footer-widgets-bg-color' ), $helper['brighter_color'] ),
										)
									),
										'footer-widgets-' . 40 => array(
											'selector' => array( $helper['elements']['shortcodes']['brighter-border-bottom'], '.footer-widgets' ),
											'styles'   => array(
												'border-bottom-color' => wma_contrast_color( wm_option( $helper['prefix'] . 'footer-widgets-bg-color' ), $helper['brighter_color'] ),
											)
										),
										'footer-widgets-' . 50 => array(
											'selector' => array( $helper['elements']['shortcodes']['brighter-border-right'], '.footer-widgets' ),
											'styles'   => array(
												'border-right-color' => wma_contrast_color( wm_option( $helper['prefix'] . 'footer-widgets-bg-color' ), $helper['brighter_color'] ),
											)
										),
										'footer-widgets-' . 60 => array(
											'selector' => array( $helper['elements']['shortcodes']['brighter-border-left'], '.footer-widgets' ),
											'styles'   => array(
												'border-left-color' => wma_contrast_color( wm_option( $helper['prefix'] . 'footer-widgets-bg-color' ), $helper['brighter_color'] ),
											)
										),
									'footer-widgets-' . 'forms' => array(
										'selector' => array( $helper['elements']['forms'], '.footer-widgets' ),
										'styles'   => array(
											'background-color' => wma_contrast_color( wm_option( $helper['prefix'] . 'footer-widgets-bg-color' ), $helper['brighter_color'] ),
										)
									),

								//Accent color

									'footer-widgets-accent-' . 10 => array(
										'selector' => array( $helper['elements']['accent']['base'], '.footer-widgets ' ),
										'styles'   => array(
											'color' => wm_option( $helper['prefix'] . 'footer-widgets-accent-color', 'color' ),
										)
									),
										'footer-widgets-accent-' . 20 => array(
											'selector' => array( $helper['elements']['accent']['hover-active'], '.footer-widgets ' ),
											'styles'   => array(
												'color' => wma_contrast_color( wm_option( $helper['prefix'] . 'footer-widgets-accent-color' ), 50 ),
											)
										),

									'footer-widgets-accent-' . 30 => array(
										'selector' => array( $helper['elements']['shortcodes']['iconbox'], '.footer-widgets ' ),
										'styles'   => array(
											'background' => wm_option( $helper['prefix'] . 'footer-widgets-accent-color', 'color' ),
											'color'      => wma_contrast_color( wm_option( $helper['prefix'] . 'footer-widgets-accent-color' ), $helper['text_color'] ),
										)
									),
										'footer-widgets-accent-' . 40 => array(
											'selector' => array( $helper['elements']['shortcodes']['iconbox-link-color'], '.footer-widgets ' ),
											'styles'   => array(
												'color' => wma_contrast_color( wm_option( $helper['prefix'] . 'footer-widgets-accent-color' ), $helper['text_color'] ),
											)
										),
											'footer-widgets-accent-' . 50 => array(
												'condition' => trim( wm_option( $helper['prefix'] . 'footer-widgets-accent-color' ) ),
												'selector'  => array( $helper['elements']['shortcodes']['iconbox-text-shadow'], '.footer-widgets ' ),
												'styles'    => array(
													'text-shadow' => ( $helper['treshold'] > wma_color_brightness( wm_option( $helper['prefix'] . 'footer-widgets-accent-color' ) ) ) ? ( '0 0 .5em rgba(0,0,0, .62)' ) : ( '0 0 .5em rgba(255,255,255, .75)' ),
												)
											),

							//Credits

								'credits' => array( 'custom' => '/* Background: Credits */' ),

								'credits-' . 10 => array(
									'selector' => '.credits',
									'styles'   => array(
										'background'   => wm_css_background( array( 'option_base' => $helper['prefix'] . 'credits-' ) ),
										'color'        => wm_option( $helper['prefix'] . 'credits-color', 'color' ),
										'border-color' => wm_option( $helper['prefix'] . 'credits-border-color', 'color', ' !important' ),
									)
								),
									'credits-' . 20 => array(
										'selector' => array( $helper['elements']['headings'], '.credits' ),
										'styles'   => array(
											'color' => ( $helper['treshold'] < wma_color_brightness( wm_option( $helper['prefix'] . 'credits-bg-color' ) ) ) ? ( wma_alter_color_brightness( wm_option( $helper['prefix'] . 'credits-color' ), $helper['headings_color'] ) ) : ( wma_alter_color_brightness( wm_option( $helper['prefix'] . 'credits-color' ), -$helper['headings_color'] ) ),
										)
									),

								//Brighter background

									'credits-' . 30 => array(
										'selector' => array( $helper['elements']['shortcodes']['brighter-bg'], '.credits' ),
										'styles'   => array(
											'background-color' => wma_contrast_color( wm_option( $helper['prefix'] . 'credits-bg-color' ), $helper['brighter_color'] ),
										)
									),
										'credits-' . 40 => array(
											'selector' => array( $helper['elements']['shortcodes']['brighter-border-bottom'], '.credits' ),
											'styles'   => array(
												'border-bottom-color' => wma_contrast_color( wm_option( $helper['prefix'] . 'credits-bg-color' ), $helper['brighter_color'] ),
											)
										),
										'credits-' . 50 => array(
											'selector' => array( $helper['elements']['shortcodes']['brighter-border-right'], '.credits' ),
											'styles'   => array(
												'border-right-color' => wma_contrast_color( wm_option( $helper['prefix'] . 'credits-bg-color' ), $helper['brighter_color'] ),
											)
										),
										'credits-' . 60 => array(
											'selector' => array( $helper['elements']['shortcodes']['brighter-border-left'], '.credits' ),
											'styles'   => array(
												'border-left-color' => wma_contrast_color( wm_option( $helper['prefix'] . 'credits-bg-color' ), $helper['brighter_color'] ),
											)
										),
									'credits-' . 'forms' => array(
										'selector' => array( $helper['elements']['forms'], '.credits' ),
										'styles'   => array(
											'background-color' => wma_contrast_color( wm_option( $helper['prefix'] . 'credits-bg-color' ), $helper['brighter_color'] ),
										)
									),

								//Accent color

									'credits-accent-' . 10 => array(
										'selector' => array( $helper['elements']['accent']['base'], '.credits ' ),
										'styles'   => array(
											'color' => wm_option( $helper['prefix'] . 'credits-accent-color', 'color' ),
										)
									),
										'credits-accent-' . 20 => array(
											'selector' => array( $helper['elements']['accent']['hover-active'], '.credits ' ),
											'styles'   => array(
												'color' => wma_contrast_color( wm_option( $helper['prefix'] . 'credits-accent-color' ), 50 ),
											)
										),

									'credits-accent-' . 30 => array(
										'selector' => array( $helper['elements']['shortcodes']['iconbox'], '.credits ' ),
										'styles'   => array(
											'background' => wm_option( $helper['prefix'] . 'credits-accent-color', 'color' ),
											'color'      => wma_contrast_color( wm_option( $helper['prefix'] . 'credits-accent-color' ), $helper['text_color'] ),
										)
									),
										'credits-accent-' . 40 => array(
											'selector' => array( $helper['elements']['shortcodes']['iconbox-link-color'], '.credits ' ),
											'styles'   => array(
												'color' => wma_contrast_color( wm_option( $helper['prefix'] . 'credits-accent-color' ), $helper['text_color'] ),
											)
										),
											'credits-accent-' . 50 => array(
												'condition' => trim( wm_option( $helper['prefix'] . 'credits-accent-color' ) ),
												'selector'  => array( $helper['elements']['shortcodes']['iconbox-text-shadow'], '.credits ' ),
												'styles'    => array(
													'text-shadow' => ( $helper['treshold'] > wma_color_brightness( wm_option( $helper['prefix'] . 'credits-accent-color' ) ) ) ? ( '0 0 .5em rgba(0,0,0, .62)' ) : ( '0 0 .5em rgba(255,255,255, .75)' ),
												)
											),



					/**
					 * Typography
					 *
					 * @version  1.2
					 */

						'typography' => array( 'custom' => '/* Typography */' ),

						'fonts-body' => array(
							'selector' => 'body',
							'styles'   => array(
								'font-family' => '"' . $helper['google_fonts'][ wm_option( $helper['prefix'] . 'font-body' ) ] . '", Helvetica, Arial, Verdana, sans-serif',
								'font-size'   => wm_option( $helper['prefix'] . 'font-size-body', '', 'px' ),
							)
						),
							'fonts-body-' . 10 => array(
								'selector' => '.sidebar',
								'styles'   => array(
									'font-size' => ( 12 < wm_option( $helper['prefix'] . 'font-size-body' ) ) ? ( '.9em' ) : ( '' ),
								)
							),
						'fonts-headings' => array(
							'condition' => wm_option( $helper['prefix'] . 'font-headings' ),
							'selector'  => '.logo.type-text, h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6, [class*="heading-style-"], blockquote',
							'styles'    => array(
								'font-family' => '"' . $helper['google_fonts'][ wm_option( $helper['prefix'] . 'font-headings' ) ] . '", Helvetica, Arial, Verdana, sans-serif',
							)
						),
						'fonts-logo' => array(
							'condition' => ( ! wm_option( $helper['prefix'] . 'logo' ) && wm_option( $helper['prefix'] . 'font-logo' ) ),
							'selector'  => '.logo.type-text',
							'styles'    => array(
								'font-family' => '"' . $helper['google_fonts'][ wm_option( $helper['prefix'] . 'font-logo' ) ] . '", Helvetica, Arial, Verdana, sans-serif',
							)
						),

						'fonts-size-h1' => array(
							'selector' => 'h1, .h1, .heading-style-1, #bbpress-forums h1',
							'styles'   => array(
								'font-size' => wm_option( $helper['prefix'] . 'font-size-h1', '', '%' ),
							)
						),
						'fonts-size-h2' => array(
							'selector' => 'h2, .h2, .heading-style-2, #bbpress-forums h2',
							'styles'   => array(
								'font-size' => wm_option( $helper['prefix'] . 'font-size-h2', '', '%' ),
							)
						),
						'fonts-size-h3' => array(
							'selector' => 'h3, .h3, .heading-style-3, #bbpress-forums h3',
							'styles'   => array(
								'font-size' => wm_option( $helper['prefix'] . 'font-size-h3', '', '%' ),
							)
						),
						'fonts-size-h4' => array(
							'selector' => 'h4, h5, h6, .h4, .h5, .h6, .heading-style-4, .heading-style-5, .heading-style-6, #bbpress-forums h4, #bbpress-forums h5, #bbpress-forums h6',
							'styles'   => array(
								'font-size' => wm_option( $helper['prefix'] . 'font-size-h4', '', '%' ),
							)
						),



					/**
					 * High DPI / Retina styles
					 *
					 * @version  1.2
					 */

						'highdpi' => array( 'custom' => '/* High DPI/Retina displays styles */' ),

						'highdpi-' . 10 => array(
							'custom' => "@media only screen and (-webkit-min-device-pixel-ratio: 1.5), \r\n\t\tonly screen and (min--moz-device-pixel-ratio: 1.5), \r\n\t\tonly screen and (-moz-min-device-pixel-ratio: 1.5), \r\n\t\tonly screen and (-o-min-device-pixel-ratio: 3/2), \r\n\t\tonly screen and (min-device-pixel-ratio: 1.5), \r\n\t\tonly screen and (min-resolution: 144dpi), \r\n\t\tonly screen and (min-resolution: 1.5dppx) {"
						),

							/**
							 * HTML and body
							 */

								'highdpi-' . 'html-' . 10 => array(
									'selector' => 'html',
									'styles'   => array(
										'background' => wm_css_background( array( 'option_base' => $helper['prefix'] . 'html-', 'high_dpi' => true ) ),
									)
								),

							/**
							 * Topbar
							 */

								'highdpi-' . 'topbar-' . 10 => array(
									'selector' => '.topbar, .topbar-extra',
									'styles'   => array(
										'background' => wm_css_background( array( 'option_base' => $helper['prefix'] . 'topbar-', 'high_dpi' => true ) ),
									)
								),

							/**
							 * Header
							 */

								'highdpi-' . 'header-' . 10 => array(
									'selector' => '.header, #search-container input, .mobile-nav',
									'styles'   => array(
										'background' => wm_css_background( array( 'option_base' => $helper['prefix'] . 'header-', 'high_dpi' => true ) ),
									)
								),

							/**
							 * Main heading
							 */

								'highdpi-' . 'main-heading-' . 10 => array(
									'selector' => '.main-heading',
									'styles'   => array(
										'background' => wm_css_background( array( 'option_base' => $helper['prefix'] . 'heading-', 'high_dpi' => true ) ),
									)
								),

							/**
							 * Content
							 */

								'highdpi-' . 'content-' . 10 => array(
									'selector' => '.content-section',
									'styles'   => array(
										'background' => wm_css_background( array( 'option_base' => $helper['prefix'] . 'content-', 'high_dpi' => true ) ),
									)
								),

							/**
							 * Footer
							 */

								//Footer widgets

									'highdpi-' . 'footer-widgets-' . 10 => array(
										'selector' => '.footer-widgets',
										'styles'   => array(
											'background' => wm_css_background( array( 'option_base' => $helper['prefix'] . 'footer-widgets-', 'high_dpi' => true ) ),
										)
									),

								//Credits

									'highdpi-' . 'credits-' . 10 => array(
										'selector' => '.credits',
										'styles'   => array(
											'background' => wm_css_background( array( 'option_base' => $helper['prefix'] . 'credits-', 'high_dpi' => true ) ),
										)
									),

						'highdpi-' . 20 => array( 'custom' => '} /* /High DPI */' ), // /High DPI / Retina styles

				); // /$custom_styles



				/**
				 * Logo centering
				 */

					if ( wm_option( 'skin-logo' ) ) {
						$logo_id = wm_get_image_id_from_url( wm_option( 'skin-logo' ) );

						if ( $logo_id ) {
							$logo_height = wp_get_attachment_image_src( $logo_id, 'full' );
							$logo_height = $logo_height[2];
						} else {
							$logo_height = explode( 'x', WM_DEFAULT_LOGO_SIZE );
							$logo_height = $logo_height[1];
						}

						$logo_padding = ( wm_option( $helper['prefix'] . 'font-size-body' ) ) ? ( absint( wm_option( $helper['prefix'] . 'font-size-body' ) ) ) : ( 14 );
						$logo_padding = floor( $logo_padding * ( $helper['line_height'] + .6 + .6 ) / 2 + wm_option( $helper['prefix'] . 'nav-padding' ) ) - ( $logo_height / 2 ) . 'px';


						$custom_styles['layout-' . 29] = array( 'custom' => '/* Logo padding - centering logo in header */' );
						$custom_styles['layout-' . 30] = array(
								'selector' => '.logo, h1.logo',
								'styles'   => array(
									'padding-top' => $logo_padding,
								)
							);
					}

			} else {
			//Visual editor styles

				$custom_styles = array(

					/**
					 * Global colors
					 */

						've-' . 'colors' => array( 'custom' => '/* Global colors */' ),

						've-' . 'colors-' . 10 => array(
							'selector' => 'a',
							'styles'   => array(
								'color'   => wm_option( $helper['prefix'] . 'accent-color', 'color' ),
								'color|2' => wma_contrast_color( wm_option( $helper['prefix'] . 'content-bg-color' ), $helper['text_color'] - 50 ),
								'color|3' => wm_option( $helper['prefix'] . 'content-accent-color', 'color' ),
							)
						),
							've-' . 'colors-' . 20 => array(
								'selector' => 'a:hover, a:active',
								'styles'   => array(
									'color'   => wma_contrast_color( wm_option( $helper['prefix'] . 'accent-color' ), 50 ),
									'color|2' => wma_contrast_color( wm_option( $helper['prefix'] . 'content-bg-color' ), $helper['text_color'] - 50 ),
									'color|3' => wma_contrast_color( wm_option( $helper['prefix'] . 'content-accent-color' ), 50 ),
								)
							),
							've-' . 'colors-' . 30 => array(
								'selector' => 'blockquote, blockquote.alignleft, blockquote.alignright',
								'styles'   => array(
									'border-color'   => wm_option( $helper['prefix'] . 'accent-color', 'color' ),
									'border-color|2' => wm_option( $helper['prefix'] . 'content-accent-color', 'color' ),
								)
							),



					/**
					 * Backgrounds and colors
					 */

						/**
						 * HTML and body
						 */

							've-' . 'html' => array( 'custom' => '/* Background: HTML and body */' ),

							've-' . 'html-' . 10 => array(
								'selector' => 'html, body',
								'styles'   => array(
									'background'     => wm_css_background( array( 'option_base' => $helper['prefix'] . 'content-' ) ),
									'color'          => wma_contrast_color( wm_option( $helper['prefix'] . 'content-bg-color' ), $helper['text_color'] ),
									'color|2'        => wm_option( $helper['prefix'] . 'content-color', 'color' ),
									'border-color'   => wma_contrast_color( wm_option( $helper['prefix'] . 'content-bg-color' ), $helper['border_color'] ),
									'border-color|2' => wm_option( $helper['prefix'] . 'content-border-color', 'color' ),
								)
							),



					/**
					 * Typography
					 */

						've-' . 'typography' => array( 'custom' => '/* Typography */' ),

						've-' . 'fonts-body' => array(
							'condition' => wm_option( $helper['prefix'] . 'font-body' ),
							'selector'  => 'body',
							'styles'    => array(
								'font-family' => '"' . $helper['google_fonts'][ wm_option( $helper['prefix'] . 'font-body' ) ] . '", Helvetica, Arial, Verdana, sans-serif',
							)
						),
						've-' . 'fonts-headings' => array(
							'condition' => wm_option( $helper['prefix'] . 'font-headings' ),
							'selector'  => 'h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6, [class*="heading-style-"]',
							'styles'    => array(
								'font-family' => '"' . $helper['google_fonts'][ wm_option( $helper['prefix'] . 'font-headings' ) ] . '", Helvetica, Arial, Verdana, sans-serif',
							)
						),

						've-' . 'fonts-size-h1' => array(
							'selector' => 'h1, .h1, .heading-style-1, .no-sidebar.list-articles-short .list-articles .entry-title',
							'styles'   => array(
								'font-size' => wm_option( $helper['prefix'] . 'font-size-h1', '', '%' ),
							)
						),
						've-' . 'fonts-size-h2' => array(
							'selector' => 'h2, .h2, .heading-style-2',
							'styles'   => array(
								'font-size' => wm_option( $helper['prefix'] . 'font-size-h2', '', '%' ),
							)
						),
						've-' . 'fonts-size-h3' => array(
							'selector' => 'h3, .h3, .heading-style-3',
							'styles'   => array(
								'font-size' => wm_option( $helper['prefix'] . 'font-size-h3', '', '%' ),
							)
						),
						've-' . 'fonts-size-h4' => array(
							'selector' => 'h4, h5, h6, .h4, .h5, .h6, .heading-style-4, .heading-style-5, .heading-style-6',
							'styles'   => array(
								'font-size' => wm_option( $helper['prefix'] . 'font-size-h4', '', '%' ),
							)
						),

				); // /$custom_styles for visual editor

			}



			/**
			 * Theme version
			 */

				$custom_styles['version'] = array( 'custom' => '/* Using ' . WM_THEME_NAME . ' theme by WebMan - Oliver Juhas (' . WM_DEVELOPER_URL . '), version ' . WM_THEME_VERSION . '. CSS generated on ' . date( 'Y/m/d H:i, e' ) . '. */' );

		} // /wmhook_wm_custom_styles_use_custom_array



		//Filter custom styles array
			$custom_styles = apply_filters( 'wmhook_wm_custom_styles_array', $custom_styles, $helper );



		//Preparing output
			if ( ! empty( $custom_styles ) ) {
				foreach ( $custom_styles as $selector ) {
					if (
							isset( $selector['condition'] )
							&& ! trim( $selector['condition'] )
						) {
						continue;
					}

					if (
							isset( $selector['selector'] )
							&& $selector['selector']
							&& isset( $selector['styles'] )
							&& is_array( $selector['styles'] )
							&& ! empty( $selector['styles'] )
						) {

						$selector_styles = $prepend = '';

						$prepend = ( ! isset( $selector['prepend'] ) ) ? ( "\t\t" ) : ( $selector['prepend'] );

						if ( is_array( $selector['selector'] ) ) {
							//Replace placeholders in selector string
							//array( 'selector string with {p}', 'placeholder' )
							$selector['selector'] = str_replace( '{p}', $selector['selector'][1], $selector['selector'][0] );
						}

						$selector['selector'] = str_replace( ', ', ",\r\n" . $prepend, $selector['selector'] );

						foreach ( $selector['styles'] as $property => $style ) {
							if ( trim( $style ) ) {
								if ( strpos( $property, '|' ) ) {
								//This is for multiple overriden properties
									$property = explode( '|', $property );
									$property = $property[0];
								}

								//RTL languages property swap
									if ( is_rtl() ) {
										$replacements_rtl = apply_filters( 'wmhook_wm_custom_styles_replacements_rtl', array(
												'border-left-color'  => 'border-right-color',
												'border-right-color' => 'border-left-color',
											) );
										$property = strtr( $property, $replacements_rtl );
									}

								$selector_styles .= $prepend . "\t" . $property . ': ' . trim( $style ) . ';' . "\r\n";
							}
						}

						if ( $selector_styles ) {
							$output .= $prepend . $selector['selector'] . ' {' . "\r\n" . $selector_styles . $prepend . '}' . "\r\n\r\n";
						}

					} elseif (
							isset( $selector['custom'] )
							&& $selector['custom']
						) {

						$output .= "\r\n\t" . $selector['custom'] . "\r\n\r\n";

					}
				}
			}

		//Output
			return apply_filters( 'wmhook_wm_custom_styles_output', $output );

	}
} // /wm_custom_styles
