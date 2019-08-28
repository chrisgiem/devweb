<?php
/**
 * Main CSS Stylesheet Generator
 *
 * @package     WebMan WordPress Theme Framework
 * @subpackage  Main CSS Stylesheet Generator
 * @copyright   2014 WebMan - Oliver Juhas
 *
 * @uses        Custom CSS Styles Generator
 *
 * @since    1.0
 * @version  1.9.3
 */





/**
 * Helper variables
 */

	$output = '';

	$wm_css_content     = array();
	$wm_theme_css_files = array(
			10   => 'reset',
			20   => 'icons-basic',
			30   => 'core',
			40   => 'columns',
			50   => 'typography',
			60   => 'wp-styles',
			70   => 'forms',
			80   => 'headings',
			90   => 'header',
			100  => 'slider',
			110  => 'content',
			120  => 'comments',
			130  => 'sidebar',
			140  => 'footer',
			150  => 'prettyphoto',
			160  => 'plugins',
			170  => 'shortcodes',
			180  => 'borders',
			190  => 'ltr-borders',
			200  => 'animate',
			210  => 'specials',
			400  => 'responsive',
			1000 => 'high-dpi',
		);

		//RTL languages support
			if ( is_rtl() ) {
				$wm_theme_css_files[190] = 'rtl-borders';
			}

		//Disable PrettyPhoto
			if ( wm_option( 'skin-disable-lightbox' ) ) {
				unset( $wm_theme_css_files[150] );
			}

		//Disable Animate.css
			if ( wm_option( 'skin-disable-animatecss' ) ) {
				unset( $wm_theme_css_files[200] );
			}



		/**
		 * Allow filtering of the CSS files array
		 */

			$wm_theme_css_files = apply_filters( 'wmhook_wm_theme_css_files', $wm_theme_css_files, 'ltr' );

			ksort( $wm_theme_css_files );





/**
 * Preparing output
 */

	//Buffer
		ob_start();

			//Start including files and editing output
				foreach ( $wm_theme_css_files as $css_file_name ) {
					if ( is_array( $css_file_name ) ) {

						/**
						 * For custom CSS file paths use this structure:
						 * array( 'CUSTOM_CSS_FILE_FOLDER_PATH', 'CUSTOM_CSS_FILE_SLUG' )
						 */
						$css_file_path = trailingslashit( $css_file_name[0] ) . $css_file_name[1] . '.css';

						//Print file URL at the beginning of its content
							echo "\r\n\r\n\r\n/* $css_file_path */\r\n\r\n";

						if ( file_exists( $css_file_path ) ) {
							require_once( $css_file_path );
						}

					} else {

						$css_file_path = 'assets/css/' . $css_file_name . '.css';

						//Print file URL at the beginning of its content
							echo "\r\n\r\n\r\n/* $css_file_path */\r\n\r\n";

						/**
						 * For basic CSS file paths use this structure:
						 * 'CUSTOM_CSS_FILE_SLUG'
						 */
						require get_theme_file_path( $css_file_path );

					}

					$wm_css_content[] = $css_file_path;
				}

		$output = trim( apply_filters( 'wmhook_generate_css_output_start', '@charset "UTF-8";' . "\r\n\r\n/**\r\n * CONTENT:\r\n *\r\n * " . implode( "\r\n * ", $wm_css_content ) . "\r\n */", $wm_css_content ) ) . "\r\n\r\n\r\n" . ob_get_clean();

	//Replace paths (do not use relative paths in stylesheets!)
		$replacements = (array) apply_filters( 'wmhook_generate_css_replacements', array() );

		if ( is_array( $replacements ) && ! empty( $replacements ) ) {
			$output = strtr( $output, $replacements );
		}





/**
 * Custom styles from skin editor
 */

	require get_theme_file_path( 'assets/css/_custom-styles.php' ); //Must be in separate file for WordPress customizer

	$output .= "\r\n\r\n\r\n/**\r\n * Skin styles\r\n */\r\n\r\n" . wm_custom_styles() . "\r\n\r\n" . '/* End of file */';





/**
 * Output
 */

	echo apply_filters( 'wmhook_esc_css', $output );
