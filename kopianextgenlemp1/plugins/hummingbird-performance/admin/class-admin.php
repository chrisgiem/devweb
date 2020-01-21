<?php
/**
 * Hummingbird admin class.
 *
 * @package Hummingbird
 */

namespace Hummingbird\Admin;

use Hummingbird\Core\Settings;
use Hummingbird\Core\Utils;
use Hummingbird\WP_Hummingbird;
use WPMUDEV_Dashboard;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Admin
 *
 * Manage the admin core functionality
 */
class Admin {

	/**
	 * Plugin pages.
	 *
	 * @var array
	 */
	public $pages = array();

	/**
	 * Admin notices.
	 *
	 * @var Notices
	 */
	public $admin_notices;

	/**
	 * Whether we show the quick setup modal.
	 *
	 * @var bool
	 */
	public $show_quick_setup;

	/**
	 * Admin constructor.
	 */
	public function __construct() {
		$this->admin_notices = Notices::get_instance();

		add_action( 'admin_menu', array( $this, 'add_menu_pages' ) );
		add_action( 'network_admin_menu', array( $this, 'add_network_menu_pages' ) );

		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			new AJAX();
			new Ajax\Gzip();
		}

		add_action( 'admin_init', array( $this, 'maybe_clear_all_cache' ) );
		add_action( 'admin_init', array( 'Hummingbird\\Core\\Installer', 'maybe_upgrade' ) );
		if ( is_multisite() ) {
			add_action( 'admin_init', array( 'Hummingbird\\Core\\Installer', 'maybe_upgrade_blog' ) );
		}

		if ( Utils::is_free_installed() && Utils::can_install_pro() ) {
			$this->maybe_upgrade_to_pro();
		}


		add_action( 'admin_footer', array( $this, 'maybe_check_files' ) );

		// Check DB to see if quick setup modal is needed and store in public var.
		$this->show_quick_setup = $this->maybe_show_quick_setup();

		// Make sure plugin name is correct for adding plugin action links.
		$plugin_name = 'wp-hummingbird';
		if ( defined( 'WPHB_WPORG' ) && WPHB_WPORG && 'wp-hummingbird/wp-hummingbird.php' !== plugin_basename( __FILE__ ) ) {
			$plugin_name = 'hummingbird-performance';
		}
		add_filter( 'network_admin_plugin_action_links_' . $plugin_name . '/wp-hummingbird.php', array( $this, 'add_plugin_action_links' ) );
		add_filter( 'plugin_action_links_' . $plugin_name . '/wp-hummingbird.php', array( $this, 'add_plugin_action_links' ) );

		// Filter built-in wpmudev branding script.
		add_filter( 'wpmudev_whitelabel_plugin_pages', array( $this, 'builtin_wpmudev_branding' ) );

		// Triggered when Hummingbird Admin is loaded.
		do_action( 'wphb_admin_loaded' );
	}

	/**
	 * Plugin action on plugin page.
	 *
	 * @param array $actions  Current actions.
	 *
	 * @return mixed
	 */
	public function add_plugin_action_links( $actions ) {
		// Settings link.
		if ( current_user_can( Utils::get_admin_capability() ) ) {
			if ( is_multisite() && ! is_network_admin() ) {
				$url = network_admin_url( 'admin.php?page=wphb' );
			} else {
				$url = Utils::get_admin_menu_url();
			}
			$actions['dashboard'] = '<a href="' . $url . '" aria-label="' . esc_attr( __( 'Go to Hummingbird Dashboard', 'wphb' ) ) . '">' . esc_html__( 'Settings', 'wphb' ) . '</a>';
		}

		// Documentation link.
		$actions['docs'] = '<a href="' . Utils::get_link( 'docs' ) . '" aria-label="' . esc_attr( __( 'View Hummingbird Documentation', 'wphb' ) ) . '" target="_blank">' . esc_html__( 'Docs', 'wphb' ) . '</a>';

		// Upgrade link.
		if ( ! Utils::is_member() ) {
			$actions['upgrade'] = '<a href="' . Utils::get_link( 'plugin', 'hummingbird_pluginlist_upgrade' ) . '" aria-label="' . esc_attr( __( 'Upgrade to Hummingbird Pro', 'wphb' ) ) . '" target="_blank" style="color: #1ABC9C;">' . esc_html__( 'Upgrade', 'wphb' ) . '</a>';
		}

		return $actions;
	}

	/**
	 * Add all the menu pages in admin for the plugin.
	 */
	public function add_menu_pages() {
		$hb_title = __( 'Hummingbird', 'wphb' );
		if ( Utils::is_member() ) {
			$hb_title = __( 'Hummingbird Pro', 'wphb' );
		}

		$current_page = filter_input( INPUT_GET, 'page', FILTER_SANITIZE_STRING );

		$this->pages['wphb']           = new Pages\Dashboard( 'wphb', $hb_title, $hb_title, false, false );
		$this->pages['wphb-dashboard'] = new Pages\Dashboard( 'wphb', __( 'Dashboard', 'wphb' ), __( 'Dashboard', 'wphb' ), 'wphb' );

		if ( ! is_multisite() || ( is_super_admin() || true === Settings::get_setting( 'subsite_tests', 'performance' ) ) ) {
			$this->pages['wphb-performance'] = new Pages\Performance( 'wphb-performance', __( 'Performance Test', 'wphb' ), __( 'Performance Test', 'wphb' ), 'wphb' );
		} elseif ( is_multisite() && isset( $current_page ) && 'wphb-performance' === $current_page ) {
			// Subsite performance reporting is off, and is a network, let's redirect to network admin.
			$url = add_query_arg( 'view', 'settings', network_admin_url( 'admin.php?page=wphb-performance' ) );
			wp_safe_redirect( $url );
			exit;
		}

		$caching = Settings::get_setting( 'enabled', 'page_cache' );
		if ( ! is_multisite() || ( is_super_admin() && $caching ) || 'blog-admins' === $caching ) {
			$this->pages['wphb-caching'] = new Pages\Caching( 'wphb-caching', __( 'Caching', 'wphb' ), __( 'Caching', 'wphb' ), 'wphb' );
		}

		if ( ! is_multisite() ) {
			$this->pages['wphb-react-gzip'] = new Pages\React\Gzip( 'wphb-react', __( 'Gzip Compression', 'wphb' ), __( 'Gzip Compression', 'wphb' ), 'wphb' );
		}

		if ( Utils::can_execute_php() ) {
			$minify = Settings::get_setting( 'enabled', 'minify' );

			if ( ! is_multisite() || ( ( 'super-admins' === $minify && is_super_admin() ) || ( true === $minify ) ) ) {
				$this->pages['wphb-minification'] = new Pages\Minification( 'wphb-minification', __( 'Asset Optimization', 'wphb' ), __( 'Asset Optimization', 'wphb' ), 'wphb' );
			} elseif ( isset( $current_page ) && 'wphb-minification' === $current_page ) {
				// Asset optimization is off, and is a network, let's redirect to network admin.
				$url = add_query_arg( 'minify-instructions', 'true', network_admin_url( 'admin.php?page=wphb#wphb-box-dashboard-minification-network-module' ) );
				wp_safe_redirect( $url );
				exit;
			}
		}

		$this->pages['wphb-advanced'] = new Pages\Advanced( 'wphb-advanced', __( 'Advanced Tools', 'wphb' ), __( 'Advanced Tools', 'wphb' ), 'wphb' );

		if ( ! is_multisite() ) {
			$this->pages['wphb-uptime']   = new Pages\Uptime( 'wphb-uptime', __( 'Uptime', 'wphb' ), __( 'Uptime', 'wphb' ), 'wphb' );
			$this->pages['wphb-settings'] = new Pages\Settings( 'wphb-settings', __( 'Settings', 'wphb' ), __( 'Settings', 'wphb' ), 'wphb' );
		}

		if ( ! Utils::is_member() && ! is_multisite() ) {
			$this->pages['wphb-upgrade'] = new Pages\Upgrade( 'wphb-upgrade', __( 'Hummingbird Pro', 'wphb' ), __( 'Hummingbird Pro', 'wphb' ), 'wphb' );
		}
	}

	/**
	 * Network menu pages.
	 */
	public function add_network_menu_pages() {
		if ( Utils::is_member() ) {
			$hb_title = __( 'Hummingbird Pro', 'wphb' );
		} else {
			$hb_title = __( 'Hummingbird', 'wphb' );
		}

		$this->pages['wphb']             = new Pages\Dashboard( 'wphb', $hb_title, $hb_title, false, false );
		$this->pages['wphb-dashboard']   = new Pages\Dashboard( 'wphb', __( 'Dashboard', 'wphb' ), __( 'Dashboard', 'wphb' ), 'wphb' );
		$this->pages['wphb-performance'] = new Pages\Performance( 'wphb-performance', __( 'Performance Test', 'wphb' ), __( 'Performance Test', 'wphb' ), 'wphb' );
		$this->pages['wphb-caching']     = new Pages\Caching( 'wphb-caching', __( 'Caching', 'wphb' ), __( 'Caching', 'wphb' ), 'wphb' );
		$this->pages['wphb-react-gzip']  = new Pages\React\Gzip( 'wphb-react', __( 'Gzip Compression', 'wphb' ), __( 'Gzip Compression', 'wphb' ), 'wphb' );
		if ( Utils::can_execute_php() ) {
			$this->pages['wphb-minification'] = new Pages\Minification( 'wphb-minification', __( 'Asset Optimization', 'wphb' ), __( 'Asset Optimization', 'wphb' ), 'wphb' );
		}
		$this->pages['wphb-advanced'] = new Pages\Advanced( 'wphb-advanced', __( 'Advanced Tools', 'wphb' ), __( 'Advanced Tools', 'wphb' ), 'wphb' );
		$this->pages['wphb-uptime']   = new Pages\Uptime( 'wphb-uptime', __( 'Uptime', 'wphb' ), __( 'Uptime', 'wphb' ), 'wphb' );
		$this->pages['wphb-settings'] = new Pages\Settings( 'wphb-settings', __( 'Settings', 'wphb' ), __( 'Settings', 'wphb' ), 'wphb' );

		if ( ! Utils::is_member() ) {
			$this->pages['wphb-upgrade'] = new Pages\Upgrade( 'wphb-upgrade', __( 'Hummingbird Pro', 'wphb' ), __( 'Hummingbird Pro', 'wphb' ), 'wphb' );
		}
	}

	/**
	 * Return an instance of a WP Hummingbird Admin Page
	 *
	 * @param string $page_slug  Page slug.
	 *
	 * @return bool|Page
	 */
	public function get_admin_page( $page_slug ) {
		if ( isset( $this->pages[ $page_slug ] ) ) {
			return $this->pages[ $page_slug ];
		}

		return false;
	}

	/**
	 * This will continue running the minification scan on every page update, even if the user leaves the asset
	 * optimization page.
	 * Uses 3 db queries.
	 */
	public function maybe_check_files() {
		if ( ! is_user_logged_in() ) {
			return;
		}

		$minify_module = Utils::get_module( 'minify' );
		// Only continue if we are checking files.
		if ( ! Utils::can_execute_php() || ! $minify_module->is_active() || ! $minify_module->is_scanning() ) {
			return;
		}

		if ( ! wp_script_is( 'wphb-admin', 'enqueued' ) ) {
			Utils::enqueue_admin_scripts( WPHB_VERSION );
		}

		// If we are in minification page, we should redirect when checking files is finished.
		$screen           = get_current_screen();
		$minify_screen_id = isset( $this->pages['wphb-minification']->page_id ) ? $this->pages['wphb-minification']->page_id : false;

		// The minification screen will do it for us.
		if ( $screen->id === $minify_screen_id ) {
			return;
		}

		?>
		<script>
			jQuery( document ).ready( function() {
				window.WPHB_Admin.getModule( 'minification' ).scanner.scan();
				window.WPHB_Admin.getModule( 'minification' ).minificationStarted = true;
			});
		</script>
		<?php
	}

	/**
	 * Show quick setup modal.
	 *
	 * @since 1.5.0
	 */
	public function maybe_show_quick_setup() {
		// Only if in admin or user is logged in.
		if ( ! is_admin() || ! is_user_logged_in() ) {
			return false;
		}

		// If setup has already ran - exit.
		$quick_setup = get_option( 'wphb-quick-setup' );
		return ! ( isset( $quick_setup['finished'] ) && true === $quick_setup['finished'] );
	}

	/**
	 * Add more pages to builtin wpmudev branding.
	 *
	 * @since 1.9.3
	 *
	 * @param array $plugin_pages  Plugin pages.
	 *
	 * @return array
	 */
	public function builtin_wpmudev_branding( $plugin_pages ) {
		foreach ( $this->pages as $key => $value ) {
			$plugin_pages[ "hummingbird-pro_page_{$key}" ] = array(
				'wpmudev_whitelabel_sui_plugins_branding',
				'wpmudev_whitelabel_sui_plugins_footer',
				'wpmudev_whitelabel_sui_plugins_doc_links',
			);
		}

		return $plugin_pages;
	}

	/**
	 * Clear all cache?
	 */
	public function maybe_clear_all_cache() {
		$wphb_clear = filter_input( INPUT_GET, 'wphb-clear' );
		if ( ! $wphb_clear || ! current_user_can( Utils::get_admin_capability() ) ) {
			return;
		}

		WP_Hummingbird::flush_cache();

		if ( 'all' === $wphb_clear ) {
			Settings::reset_to_defaults();
			delete_option( 'wphb-quick-setup' );
			delete_option( 'wphb-new-user-tour' );

			// Clean all cron.
			wp_clear_scheduled_hook( 'wphb_performance_report' );
			wp_clear_scheduled_hook( 'wphb_uptime_report' );
			wp_clear_scheduled_hook( 'wphb_minify_clear_files' );

			if ( is_multisite() ) {
				global $wpdb;
				$offset = 0;
				$limit  = 100;
				while ( $blogs = $wpdb->get_results( "SELECT blog_id FROM {$wpdb->blogs} LIMIT {$offset}, {$limit}", ARRAY_A ) ) { // Db call ok; no-cache ok.
					if ( $blogs ) {
						foreach ( $blogs as $blog ) {
							switch_to_blog( $blog['blog_id'] );

							Settings::reset_to_defaults();
							delete_option( 'wphb-quick-setup' );
							delete_option( 'wphb-new-user-tour' );

							// Clean all cron.
							wp_clear_scheduled_hook( 'wphb_minify_clear_files' );
						}
						restore_current_blog();
					}
					$offset += $limit;
				}
			}
		}

		wp_safe_redirect( remove_query_arg( 'wphb-clear' ) );
		exit;
	}

	/**
	 * Try to update to pro version is user can do that.
	 */
	private function maybe_upgrade_to_pro() {
		// Add upgrade schedule.
		add_action( 'wphb_upgrade_to_pro', array( $this, 'upgrade_to_pro' ) );

		$running_cron_update = get_site_option( 'wphb_cron_update_running' );
		if ( empty( $running_cron_update ) ) {
			// Schedule upgrade.
			wp_schedule_single_event( time(), 'wphb_upgrade_to_pro' );
			update_site_option( 'wphb_cron_update_running', true );
		}
	}

	/**
	 * Upgrade free version to pro.
	 *
	 * @since 1.7.0
	 */
	public function upgrade_to_pro() {
		/**
		 * If pro is already installed - exit.
		 *
		 * If ( WPMUDEV_Dashboard::$upgrader->is_project_installed( $project_id ) ) {
		 * //return uninstall_plugin( 'hummingbird-performance/wp-hummingbird.php' );
		 * }
		 */

		if ( WPMUDEV_Dashboard::$upgrader->install( WP_Hummingbird::get_project_id() ) ) {
			delete_site_option( 'wphb_cron_update_running' );
			activate_plugin( 'wp-hummingbird/wp-hummingbird.php' );
			// Do we need to deactivate?
			deactivate_plugins( 'hummingbird-performance/wp-hummingbird.php', true );
			delete_plugins( array( 'hummingbird-performance/wp-hummingbird.php' ) );
		}
	}

}
