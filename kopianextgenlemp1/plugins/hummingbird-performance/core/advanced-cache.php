<?php
/**
 * Hummingbird Advanced Tools module
 *
 * @package Hummingbird
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Load necessary modules for caching.
 */

if ( ! class_exists( 'Hummingbird\\Core\\Modules\\Page_Cache' ) ) {
	if ( is_dir( WP_CONTENT_DIR . '/plugins/wp-hummingbird/' ) ) {
		$plugin_path = WP_CONTENT_DIR . '/plugins/wp-hummingbird/';
	} else {
		$plugin_path = WP_CONTENT_DIR . '/plugins/hummingbird-performance/';
	}

	/* @noinspection PhpIncludeInspection */
	include_once $plugin_path . 'core/class-utils.php';
	/* @noinspection PhpIncludeInspection */
	include_once $plugin_path . 'core/class-module.php';
	/* @noinspection PhpIncludeInspection */
	include_once $plugin_path . 'core/modules/class-page-cache.php';

	if ( ! method_exists( 'Hummingbird\\Core\\Modules\\Page_Cache', 'serve_cache' ) ) {
		return;
	}

	define( 'WPHB_ADVANCED_CACHE', true );
	\Hummingbird\Core\Modules\Page_Cache::serve_cache();
}
