<?php
/**
 * Admin Functions
 *
 * @package     WebMan WordPress Theme Framework
 * @subpackage  Admin Functions
 * @copyright   2014 WebMan - Oliver Juhas
 *
 * @since    3.0
 * @version  1.9.3
 *
 * CONTENT:
 * - 1) Required files
 * - 10) Actions and filters
 * - 20) Styles and scripts
 * - 30) Visual editor improvements
 * - 40) Other functions
 */





/**
 * 1) Required files
 */

	//Widgets areas
		if (
				file_exists( WM_SETUP . 'widgets.php' )
				|| file_exists( WM_SETUP_CHILD . 'widgets.php' )
			) {
			require get_theme_file_path( WM_SETUP_DIR . 'widgets.php' );
		}

	//Load the theme introduction page
		if (
				is_admin()
				&& (
					file_exists( WM_SETUP . 'about/about.php' )
					|| file_exists( WM_SETUP_CHILD . 'about/about.php' )
				)
			) {
			require get_theme_file_path( WM_SETUP_DIR . 'about/about.php' );
		}

	//Skinning functionality
		if ( class_exists( 'WM_Amplifier' ) ) {
			require get_theme_file_path( WM_LIBRARY_DIR . 'skinning.php' );
		}





/**
 * 10) Actions and filters
 */

	/**
	 * Actions
	 */

		//Admin customization
			add_action( 'admin_enqueue_scripts', 'wm_admin_include', 998 );

		//Display admin notice
			add_action( 'admin_notices', 'wm_admin_notice' );



	/**
	 * Filters
	 */

		//TinyMCE customization
			if ( is_admin() ) {
				add_filter( 'tiny_mce_before_init', 'wm_custom_mce_format' );
				add_filter( 'mce_buttons', 'wm_add_buttons_row1' );
			}





/**
 * 20) Styles and scripts
 */

	/**
	 * Admin assets
	 */
	if ( ! function_exists( 'wm_admin_include' ) ) {
		function wm_admin_include() {
			//Styles
				wp_enqueue_style( 'wm-admin' );

				//RTL languages support
					if ( is_rtl() ) {
						wp_enqueue_style( 'wm-admin-rtl' );
						if ( function_exists( 'wm_is_woocommerce' ) ) {
							wp_enqueue_style( 'wm-admin-wc-rtl' );
						}
					}

			//Scripts
				wp_enqueue_script( 'wm-wp-admin' );
		}
	} // /wm_admin_include





/**
 * 30) Visual editor improvements
 */

	/**
	 * Add buttons to visual editor
	 *
	 * First row.
	 *
	 * @param  array $buttons
	 */
	if ( ! function_exists( 'wm_add_buttons_row1' ) ) {
		function wm_add_buttons_row1( $buttons ) {
			//Inserting buttons after "more" button
				$pos = array_search( 'wp_more', $buttons, true );
				if ( $pos != false ) {
					$add     = array_slice( $buttons, 0, $pos + 1 );
					$add[]   = 'wp_page';
					$buttons = array_merge( $add, array_slice( $buttons, $pos + 1 ) );
				}

			//Output
				return apply_filters( 'wmhook_wm_add_buttons_row1_output', $buttons );
		}
	} // /wm_add_buttons_row1



	/**
	 * Customizing format dropdown items
	 *
	 * @param  array $init
	 */
	if ( ! function_exists( 'wm_custom_mce_format' ) ) {
		function wm_custom_mce_format( $init ) {
			//Format buttons, default = 'p,address,pre,h1,h2,h3,h4,h5,h6'
				$init['theme_advanced_blockformats'] = apply_filters( 'wmhook_wm_custom_mce_format_theme_advanced_blockformats', 'p,h1,h2,h3,h4,h5,h6,address,div' );

			//Command separated string of extended elements
				$ext = apply_filters( 'wmhook_wm_custom_mce_format_extended_valid_elements', 'pre[id|name|class|style]' );
				if ( isset( $init['extended_valid_elements'] ) ) {
					$init['extended_valid_elements'] .= ',' . $ext;
				} else {
					$init['extended_valid_elements'] = $ext;
				}

			//Output
				return apply_filters( 'wmhook_wm_custom_mce_format_output', $init );
		}
	} // /wm_custom_mce_format





/**
 * 40) Other functions
 */

	/**
	 * WordPress admin notices
	 *
	 * Displays the message stored in "wm-admin-notice" transient cache
	 * once or multiple times, than deletes the message cache.
	 * Transient structure:
	 * set_transient(
	 *   'wm-admin-notice',
	 *   array( $text, $class, $capability, $number_of_displays )
	 * );
	 *
	 * @since    3.0
	 * @version  3.4
	 */
	if ( ! function_exists( 'wm_admin_notice' ) ) {
		function wm_admin_notice() {
			//Requirements check
				if ( ! is_admin() ) {
					return;
				}

			//Helper variables
				$output     = '';
				$class      = 'updated';
				$repeat     = 0;
				$capability = apply_filters( 'wmhook_wm_admin_notice_capability', 'switch_themes' );
				$message    = get_transient( 'wm-admin-notice' );

			//Requirements check
				if ( empty( $message ) ) {
					return;
				}

			//Preparing output
				if ( ! is_array( $message ) ) {
					$message = array( $message, $class, $capability, $repeat );
				}
				if ( ! isset( $message[1] ) || empty( $message[1] ) ) {
					$message[1] = $class;
				}
				if ( ! isset( $message[2] ) || empty( $message[2] ) ) {
					$message[2] = $capability;
				}
				if ( ! isset( $message[3] ) ) {
					$message[3] = $repeat;
				}

				if ( $message[0] && current_user_can( $message[2] ) ) {
					$output .= '<div class="' . trim( 'wm-notice ' . $message[1] ) . '"><p>' . $message[0] . '</p></div>';
					delete_transient( 'wm-admin-notice' );
				}

				//Delete the transient cache after specific number of displays
					if ( 1 < intval( $message[3] ) ) {
						$message[3] = intval( $message[3] ) - 1;
						set_transient( 'wm-admin-notice', $message, ( 60 * 60 * 48 ) );
					}

			//Output
				if ( $output ) {
					echo apply_filters( 'wmhook_wm_admin_notice_output', $output, $message );
				}
		}
	} // /wm_admin_notice
