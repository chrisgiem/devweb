<?php
/**
 * Setting admin page.
 *
 * @package Hummingbird\Admin\Pages
 */

namespace Hummingbird\Admin\Pages;

use Hummingbird\Admin\Page;
use Hummingbird\Core\Settings as Settings_Module;
use Hummingbird\Core\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Settings extends Page
 */
class Settings extends Page {

	/**
	 * Triggered before page load.
	 */
	public function on_load() {
		$this->tabs = array(
			'general' => __( 'General', 'wphb' ),
			'data'    => __( 'Data & Settings', 'wphb' ),
			'main'    => __( 'Accessibility', 'wphb' ),
		);
	}

	/**
	 * Register meta boxes.
	 */
	public function register_meta_boxes() {
		$this->add_meta_box(
			'general',
			__( 'General', 'wphb' ),
			array( $this, 'general_metabox' ),
			null,
			null,
			'general'
		);

		$this->add_meta_box(
			'data',
			__( 'Data & Settings', 'wphb' ),
			array( $this, 'data_metabox' ),
			null,
			array( $this, 'accessibility_metabox_footer' ),
			'data'
		);

		$this->add_meta_box(
			'settings',
			__( 'Accessibility', 'wphb' ),
			array( $this, 'accessibility_metabox' ),
			null,
			array( $this, 'accessibility_metabox_footer' ),
			'main'
		);
	}

	/**
	 * Accessibility meta box.
	 */
	public function accessibility_metabox() {
		$args = array(
			'settings' => Settings_Module::get_settings( 'settings' ),
		);

		$this->view( 'settings/accessibility-meta-box', $args );
	}

	/**
	 * Accessibility meta box footer.
	 */
	public function accessibility_metabox_footer() {
		$this->view( 'settings/accessibility-meta-box-footer', array() );
	}

	/**
	 * Data & Settings meta box.
	 *
	 * @since 2.0.0
	 */
	public function data_metabox() {
		$args = array(
			'settings' => Settings_Module::get_settings( 'settings' ),
		);

		$this->view( 'settings/data-meta-box', $args );
	}

	/**
	 * General meta box settings.
	 *
	 * @since 2.2.0
	 */
	public function general_metabox() {
		$link = Utils::is_member() ? 'https://premium.wpmudev.org/translate/projects/wphb' : 'https://translate.wordpress.org/projects/wp-plugins/wp-hummingbird';

		$site_locale = get_locale();

		if ( 'en_US' === $site_locale ) {
			$site_language = 'English';
		} else {
			/* @noinspection PhpIncludeInspection */
			require_once ABSPATH . 'wp-admin/includes/translation-install.php';
			$translations  = wp_get_available_translations();
			$site_language = isset( $translations[ $site_locale ] ) ? $translations[ $site_locale ]['native_name'] : __( 'Error detecting language', 'wphb' );
		}

		$this->view(
			'settings/general-meta-box',
			array(
				'site_language'    => $site_language,
				'translation_link' => $link,
			)
		);
	}

}
