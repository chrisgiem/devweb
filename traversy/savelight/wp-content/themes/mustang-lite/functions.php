<?php
/**
 * Theme loading
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package    Mustang
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0
 * @version  1.9.3
 */





/**
 * Constants
 */

	// Helper variables
		$parent_theme = get_template();
		$theme_data   = wp_get_theme( $parent_theme );

	// Basic constants

		if ( ! defined( 'WM_THEME_NAME' ) ) {
			define( 'WM_THEME_NAME', $theme_data->Name );
		}
		if ( ! defined( 'WM_THEME_SHORTNAME' ) ) {
			define( 'WM_THEME_SHORTNAME', str_replace( '-lite', '', $parent_theme ) );
		}
		if ( ! defined( 'WM_THEME_VERSION' ) ) {
			define( 'WM_THEME_VERSION', $theme_data->Version );
		}

		if ( ! defined( 'WM_THEME_SETTINGS_PREFIX' ) ) {
			define( 'WM_THEME_SETTINGS_PREFIX', 'wm-' );
		}
		if ( ! defined( 'WM_THEME_SETTINGS' ) ) {
			define( 'WM_THEME_SETTINGS', WM_THEME_SETTINGS_PREFIX . WM_THEME_SHORTNAME );
		}
		if ( ! defined( 'WM_THEME_SETTINGS_INSTALL' ) ) {
			define( 'WM_THEME_SETTINGS_INSTALL', WM_THEME_SETTINGS . '-install' );
		}
		if ( ! defined( 'WM_THEME_SETTINGS_SKIN' ) ) {
			define( 'WM_THEME_SETTINGS_SKIN', 'theme_mods_' . WM_THEME_SHORTNAME );
		}
		if ( ! defined( 'WM_THEME_SETTINGS_VERSION' ) ) {
			define( 'WM_THEME_SETTINGS_VERSION', WM_THEME_SETTINGS . '-version' );
		}

		if ( ! defined( 'WM_DEFAULT_EXCERPT_LENGTH' ) ) {
			define( 'WM_DEFAULT_EXCERPT_LENGTH', 40 );
		}
		if ( ! defined( 'WM_SCRIPTS_VERSION' ) ) {
			define( 'WM_SCRIPTS_VERSION', esc_attr( trim( WM_THEME_VERSION ) ) );
		}
		if ( ! defined( 'WM_WP_COMPATIBILITY' ) ) {
			define( 'WM_WP_COMPATIBILITY', 4.4 );
		}

	// Dir constants

		if ( ! defined( 'WM_LIBRARY_DIR' ) ) {
			define( 'WM_LIBRARY_DIR', trailingslashit( 'library' ) );
		}

	// Setup dir

		if ( ! defined( 'WM_SETUP_DIR' ) ) {
			define( 'WM_SETUP_DIR', trailingslashit( 'setup' ) );
		}
		if ( ! defined( 'WM_SETUP' ) ) {
			define( 'WM_SETUP', trailingslashit( get_template_directory() ) . WM_SETUP_DIR );
		}
		if ( ! defined( 'WM_SETUP_CHILD' ) ) {
			define( 'WM_SETUP_CHILD', trailingslashit( get_stylesheet_directory() ) . WM_SETUP_DIR );
		}
		if ( ! defined( 'WM_SKINS' ) ) {
			define( 'WM_SKINS', trailingslashit( WM_SETUP . 'skins' ) );
		}
		if ( ! defined( 'WM_SKINS_CHILD' ) ) {
			define( 'WM_SKINS_CHILD', trailingslashit( WM_SETUP_CHILD . 'skins' ) );
		}

	// URL constants

		if ( ! defined( 'WM_DEVELOPER_URL' ) ) {
			define( 'WM_DEVELOPER_URL', 'https://www.webmandesign.eu' );
		}
		if ( ! defined( 'WM_SUPPORT_URL' ) ) {
			define( 'WM_SUPPORT_URL', 'https://support.webmandesign.eu' );
		}
		if ( ! defined( 'WM_ONLINE_MANUAL_URL' ) ) {
			define( 'WM_ONLINE_MANUAL_URL', WM_DEVELOPER_URL . '/manual/' . WM_THEME_SHORTNAME . '/' );
		}

	// Theme design constants

		if ( ! defined( 'WM_DEFAULT_LOGO_SIZE' ) ) {
			define( 'WM_DEFAULT_LOGO_SIZE', '157x40' );
		}
		if ( ! defined( 'WM_DEFAULT_IMAGE_SIZE' ) ) {
			define( 'WM_DEFAULT_IMAGE_SIZE', 'ratio-169' );
		}
		if ( ! defined( 'WM_DEFAULT_SIDEBAR_POSITION' ) ) {
			define( 'WM_DEFAULT_SIDEBAR_POSITION', 'right' );
		}
		if ( ! defined( 'WM_DEFAULT_SIDEBAR_WIDTH' ) ) {
			define( 'WM_DEFAULT_SIDEBAR_WIDTH', ' pane three; pane nine' );
		}





/**
 * Global variables
 */

	// Get theme options

		$wm_theme_options = get_option( WM_THEME_SETTINGS_SKIN );

		if ( empty( $wm_theme_options ) ) {
			$wm_theme_options = array();
		}





/**
 * Required files
 */

	require get_theme_file_path( WM_LIBRARY_DIR . 'core.php' );

	require get_theme_file_path( WM_SETUP_DIR . 'setup.php' );

	require get_theme_file_path( WM_LIBRARY_DIR . 'admin.php' );

	require WM_SETUP_DIR . 'functions.php';
