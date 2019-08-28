<?php
/**
 * Admin pages class.
 *
 * @package Zakra
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class Airi_Onboarding
 */
class Airi_Onboarding {

	/**
	 * Airi_Onboarding constructor.
	 */
	public function __construct() {

		//$this->add_about_page();
		add_action( 'wp_loaded', array( $this, 'admin_notice' ), 20 );
		add_action( 'wp_loaded', array( $this, 'hide_notices' ), 15 );
		add_action( 'wp_ajax_import_button', array( $this, 'ajax_import_button_handler' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'ajax_enqueue_scripts' ) );
		add_action( 'init', array( $this, 'load_info_page' ) );

	}

	/**
	 * Localize array for import button AJAX request.
	 */
	public function ajax_enqueue_scripts() {

		$translation_array = array(
			'uri'      => esc_url( admin_url( '/themes.php?page=pt-one-click-demo-import' ) ),
			'btn_text' => esc_html__( 'Processing...', 'airi' ),
			'nonce'    => wp_create_nonce( 'airi_demo_import_nonce' ),
		);
		wp_localize_script( 'airi-plugin-install-helper', 'airi_redirect_demo_page', $translation_array );

	}

	/**
	 * Handle the AJAX process while import or get started button clicked.
	 */
	public function ajax_import_button_handler() {

		check_ajax_referer( 'airi_demo_import_nonce', 'security' );

		$state = '';
		if ( is_plugin_active( 'one-click-demo-import/one-click-demo-import.php' ) ) {
			$state = 'activated';
		} elseif ( file_exists( WP_PLUGIN_DIR . '/one-click-demo-import/one-click-demo-import.php' ) ) {
			$state = 'installed';
		}

		if ( 'activated' === $state ) {
			$response['redirect'] = admin_url( '/themes.php?page=pt-one-click-demo-import' );
		} elseif ( 'installed' === $state ) {
			$response['redirect'] = admin_url( '/themes.php?page=pt-one-click-demo-import' );
			if ( current_user_can( 'activate_plugin' ) ) {
				$result = activate_plugin( 'one-click-demo-import/one-click-demo-import.php' );

				if ( is_wp_error( $result ) ) {
					$response['errorCode']    = $result->get_error_code();
					$response['errorMessage'] = $result->get_error_message();
				}
			}
		} else {
			wp_enqueue_style( 'plugin-install' );
			wp_enqueue_script( 'plugin-install' );
			$response['redirect'] = admin_url( '/themes.php?page=pt-one-click-demo-import' );
			/**
			 * Install Plugin.
			 */
			include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
			include_once ABSPATH . 'wp-admin/includes/plugin-install.php';

			$api = plugins_api( 'plugin_information', array(
				'slug'   => sanitize_key( wp_unslash( 'one-click-demo-import' ) ),
				'fields' => array(
					'sections' => false,
				),
			) );

			$skin     = new WP_Ajax_Upgrader_Skin();
			$upgrader = new Plugin_Upgrader( $skin );
			$result   = $upgrader->install( $api->download_link );
			if ( $result ) {
				$response['installed'] = 'succeed';
			} else {
				$response['installed'] = 'failed';
			}

			// Activate plugin.
			if ( current_user_can( 'activate_plugin' ) ) {
				$result = activate_plugin( 'one-click-demo-import/one-click-demo-import.php' );

				if ( is_wp_error( $result ) ) {
					$response['errorCode']    = $result->get_error_code();
					$response['errorMessage'] = $result->get_error_message();
				}
			}
		}

		wp_send_json( $response );

		exit();

	}

	public function load_info_page() {
		require get_template_directory() . '/inc/onboarding/theme-info.php';
	}

	/**
	 * Add admin notice.
	 */
	public function admin_notice() {

		wp_enqueue_style( 'airi-onboarding-styles', get_template_directory_uri() . '/inc/onboarding/assets/css/onboarding.css', array(), '20190507' );

		// Let's bail on theme activation.
		$notice_nag = get_option( 'airi_admin_notice_welcome' );
		if ( !$notice_nag ) {
			add_action( 'admin_notices', array( $this, 'welcome_notice' ) );
		}
	}

	/**
	 * Hide a notice if the GET variable is set.
	 */
	public static function hide_notices() {

		if ( isset( $_GET['airi-hide-notice'] ) && isset( $_GET['_airi_notice_nonce'] ) ) { // WPCS: input var ok.
			if ( ! wp_verify_nonce( wp_unslash( $_GET['_airi_notice_nonce'] ), 'airi_hide_notices_nonce' ) ) { // phpcs:ignore WordPress.VIP.ValidatedSanitizedInput.InputNotSanitized
				wp_die( __( 'Action failed. Please refresh the page and retry.', 'airi' ) ); // WPCS: xss ok.
			}

			if ( ! current_user_can( 'manage_options' ) ) {
				wp_die( __( 'Cheatin&#8217; huh?', 'airi' ) ); // WPCS: xss ok.
			}

			$hide_notice = sanitize_text_field( wp_unslash( $_GET['airi-hide-notice'] ) );
			update_option( 'airi_admin_notice_' . $hide_notice, 1 );

			// Hide.
			if ( 'welcome' === $_GET['airi-hide-notice'] ) {
				update_option( 'airi_admin_notice_' . $hide_notice, 1 );
			} else { // Show.
				delete_option( 'airi_admin_notice_' . $hide_notice );
			}
		}

	}

	/**
	 * Return or echo `Get started/Import button` HTML.
	 *
	 * @param bool   $return    Return or echo.
	 * @param string $slug      PLugin slug to install.
	 * @param string $text      Text string for button.
	 * @param string $css_class CSS class list for button link.
	 *
	 */
	public static function import_button_html( $return = false, $slug = '', $text, $css_class = 'btn-get-started button button-primary button-hero' ) {

		$slug = 'one-click-demo-import';

		if ( true === $return ) {
			return '<a class="' . esc_attr( $css_class ) . '"
		   href="#" data-name="' . esc_attr( $slug ) . '" data-slug="' . esc_attr( $slug ) . '" aria-label="' . esc_attr__( 'Get started with Airi', 'airi' ) . '">' . esc_html( $text ) . '</a>';
		} else {
			echo '<a class="' . esc_attr( $css_class ) . '"
					href="#" data-name="' . esc_attr( $slug ) . '" data-slug="' . esc_attr( $slug ) . '" aria-label="' . esc_attr__( 'Get started with Airi', 'airi' ) . '">' . esc_html( $text ) . '</a>';
		}

	}

	public function enqueue() {

		$current_screen = get_current_screen();

		wp_enqueue_script( 'airi-plugin-install-helper', get_template_directory_uri() . '/inc/onboarding/assets/js/onboarding.js', array( 'jquery' ), '20190507', true );
		wp_localize_script(
			'airi-plugin-install-helper', 'airi_plugin_helper',
			array(
				'activating' => esc_html__( 'Activating ', 'airi' ),
			)
		);

		if ( ! isset( $current_screen->id ) ) {
			return;
		}

		wp_enqueue_script( 'updates' );

	}


	/**
	 * Show welcome notice.
	 */
	public function welcome_notice() {

		$user = wp_get_current_user();

		?>

		<div id="airi-onboarding" class="updated airi-onboarding-message">
			<a class="airi-message-close notice-dismiss"
			   href="<?php echo esc_url( wp_nonce_url( remove_query_arg( array( 'activated' ), add_query_arg( 'airi-hide-notice', 'welcome' ) ), 'airi_hide_notices_nonce', '_airi_notice_nonce' ) ); ?>">
				<?php esc_html_e( 'Dismiss', 'airi' ); ?>
			</a>
			<div class="airi-onboarding-styles-wrapper">
				<div class="airi-logo">
					<img style="max-width:100px;" src="<?php echo get_template_directory_uri(); ?>/images/airi-logo.png" alt="<?php esc_html_e( 'Airi', 'airi' ); ?>" /><?php // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped, Squiz.PHP.EmbeddedPhp.SpacingBeforeClose ?>
				</div>
				<h3><?php echo sprintf( __( 'Hello, %s, and welcome to Airi', 'airi' ), '<span>' . esc_html( ucfirst( $user->display_name ) ) . '</span>' ); ?></h3>
				<p class="welcome-text"><?php echo esc_html__( 'Thank you for choosing our theme! Check out the links below to get started.', 'airi' ); ?></p>

				<div class="submit">
					<?php self::import_button_html( false, '', esc_html__( 'Import a demo site', 'airi' ) ); ?>
					<?php echo '<a href="' . esc_url( admin_url( 'themes.php?page=airi-info' ) ) . '">' . esc_html__( 'or visit the welcome page', 'airi' ) . '</a>'; ?>
				</div>
			</div>
		</div>
		<?php
	}

}

$admin = new Airi_Onboarding();
