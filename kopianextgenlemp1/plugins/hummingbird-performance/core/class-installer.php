<?php
/**
 * Manages activation/deactivation and upgrades of Hummingbird
 *
 * @author: WPMUDEV, Ignacio Cruz (igmoweb)
 * @package Hummingbird\Core
 */

namespace Hummingbird\Core;

use Hummingbird\WP_Hummingbird;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Installer
 */
class Installer {

	/**
	 * Plugin activation
	 */
	public static function activate() {
		if ( ! defined( 'WPHB_ACTIVATING' ) ) {
			define( 'WPHB_ACTIVATING', true );
		}

		update_site_option( 'wphb_version', WPHB_VERSION );

		// Add uptime notice.
		update_site_option( 'wphb-notice-uptime-info-show', 'yes' );
	}

	/**
	 * Plugin activation in a blog (if the site is a multisite)
	 */
	public static function activate_blog() {
		update_option( 'wphb_version', WPHB_VERSION );

		do_action( 'wphb_activate' );
	}

	/**
	 * Plugin deactivation
	 */
	public static function deactivate() {
		// Avoid to execute this over an over in same thread execution.
		if ( defined( 'WPHB_SWITCHING_VERSION' ) ) {
			return;
		}

		$settings = Settings::get_settings( 'settings' );
		WP_Hummingbird::flush_cache( $settings['remove_data'], $settings['remove_settings'] );
		do_action( 'wphb_deactivate' );
	}

	/**
	 * Plugin upgrades
	 */
	public static function maybe_upgrade() {
		// Avoid to execute this over an over in same thread execution.
		if ( defined( 'WPHB_ACTIVATING' ) ) {
			return;
		}

		if ( defined( 'WPHB_UPGRADING' ) && WPHB_UPGRADING ) {
			return;
		}

		self::upgrade();
	}

	/**
	 * Upgrade
	 */
	public static function upgrade() {
		$version = get_site_option( 'wphb_version' );

		if ( false === $version ) {
			self::activate();
		}

		if ( is_multisite() ) {
			$blog_version = get_option( 'wphb_version' );
			if ( false === $blog_version ) {
				self::activate_blog();
			}
		}

		if ( false !== $version && WPHB_VERSION !== $version ) {
			if ( ! defined( 'WPHB_UPGRADING' ) ) {
				define( 'WPHB_UPGRADING', true );
			}

			if ( version_compare( $version, '2.0.0', '<' ) ) {
				self::upgrade_2_0();
			}

			if ( version_compare( $version, '2.2.0', '<' ) ) {
				self::upgrade_2_2_0();
			}

			if ( version_compare( $version, '2.2.1', '<' ) ) {
				self::upgrade_2_2_1();
			}

			update_site_option( 'wphb_version', WPHB_VERSION );
		}
	}

	/**
	 * Upgrades a single blog in a multisite
	 */
	public static function maybe_upgrade_blog() {
		$version = get_option( 'wphb_version' );

		if ( WPHB_VERSION === $version ) {
			return;
		}

		update_option( 'wphb_version', WPHB_VERSION );
	}

	/**
	 * Upgrade to 2.0.0.
	 *
	 * @since 2.0.0
	 */
	private static function upgrade_2_0() {
		// Remove old report data.
		Utils::get_module( 'performance' )->clear_cache();

		// Add additional report options.
		$defaults = Settings::get_default_settings();
		$options  = Settings::get_setting( 'reports', 'performance' );

		$new_options = wp_parse_args( $options, $defaults['performance']['reports'] );
		Settings::update_setting( 'reports', $new_options, 'performance' );

		delete_site_option( 'wphb-pro' );
	}

	/**
	 * Upgrade to 2.2.0.
	 *
	 * @since 2.2.0
	 */
	private static function upgrade_2_2_0() {
		// Remove deprecated setting.
		$options = Settings::get_settings( 'page_cache' );
		if ( isset( $options['preload_interval'] ) ) {
			unset( $options['preload_interval'] );
			Settings::update_settings( $options, 'page_cache' );
		}
	}

	/**
	 * Upgrade to 2.2.1.
	 *
	 * We want to stop the preloader in case it's stuck or on a loop.
	 *
	 * @since 2.2.1
	 */
	private static function upgrade_2_2_1() {
		if ( ! class_exists( '\\Hummingbird\\Core\\Modules\\Caching\\Preload' ) ) {
			/* @noinspection PhpIncludeInspection */
			require_once WPHB_DIR_PATH . 'core/modules/caching/class-preload.php';
		}

		$preload = new \Hummingbird\Core\Modules\Caching\Preload();
		$preload->cancel();
	}

}
