<?php
/**
 * Smush module.
 *
 * @package Hummingbird
 */

namespace Hummingbird\Core\Modules;

use Hummingbird\Core\Module;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Smush
 */
class Smush extends Module {

	/**
	 * Variable used to distinguish between versions of Smush.
	 * Sets true if the Pro version is installed. False in all other cases.
	 *
	 * @var bool $is_smush_pro
	 */
	public static $is_smush_pro = false;

	/**
	 * Init module.
	 */
	public function init() {}

	/**
	 * Run module specific actions.
	 */
	public function run() {}

	/**
	 * Clear cache.
	 *
	 * @return mixed|void
	 */
	public function clear_cache() {}

	/**
	 * Check if Smush is installed.
	 *
	 * @return bool
	 */
	public static function is_installed() {
		if ( ! function_exists( 'get_plugins' ) ) {
			include_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		$plugins = get_plugins();
		if ( array_key_exists( 'wp-smush-pro/wp-smush.php', $plugins ) ) {
			self::$is_smush_pro = true;
		}
		return array_key_exists( 'wp-smush-pro/wp-smush.php', $plugins ) || array_key_exists( 'wp-smushit/wp-smush.php', $plugins );
	}

	/**
	 * Check if Smush is active.
	 *
	 * @return bool
	 */
	public static function is_enabled() {
		if ( ! function_exists( 'is_plugin_active' ) ) {
			include_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		return is_plugin_active( 'wp-smush-pro/wp-smush.php' ) || is_plugin_active( 'wp-smushit/wp-smush.php' );
	}

	/**
	 * Checks whether the Smush can be configured on a site or not.
	 *
	 * @return bool
	 */
	public static function can_be_configured() {
		// If single site return true.
		if ( ! is_multisite() || is_network_admin() ) {
			return true;
		}

		return '0' !== get_site_option( 'wp-smush-networkwide' );
	}

}
