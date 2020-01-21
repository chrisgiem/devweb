<?php
/**
 * Class responsible for GDPR compliance: GDPR class
 *
 * Class GDPR
 *
 * @since 1.9.2
 * @package Hummingbird\Core
 */

namespace Hummingbird\Core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class GDPR
 */
class GDPR {

	/**
	 * Singleton class instance.
	 *
	 * @var GDPR|null
	 */
	private static $instance = null;

	/**
	 * Get class instance.
	 *
	 * @return GDPR|null
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * GDPR constructor.
	 */
	private function __construct() {
		// Register private policy text.
		add_action( 'admin_init', array( $this, 'privacy_policy_content' ) );
	}

	/**
	 * Register private policy text.
	 */
	public function privacy_policy_content() {
		if ( ! function_exists( 'wp_add_privacy_policy_content' ) ) {
			return;
		}

		$content = sprintf(
			'<h3>%s</h3><p>%s</p>',
			__( 'Third parties', 'wphb' ),
			sprintf(
				/* translators: %s: start of a href tag, %s: end of a tag */
				__(
					'Hummingbird uses the Stackpath Content Delivery Network (CDN). Stackpath may store web log information
				of site visitors, including IPs, UA, referrer, Location and ISP info of site visitors for 7 days.
				Files and images served by the CDN may be stored and served from countries other than your own.
				Stackpath’s privacy policy can be found %1$shere%2$s.',
					'wphb'
				),
				'<a href="https://www.stackpath.com/legal/privacy-statement/" target="_blank">',
				'</a>'
			)
		);

		wp_add_privacy_policy_content(
			__( 'Hummingbird', 'wphb' ),
			wp_kses_post( wpautop( $content, false ) )
		);
	}

}
