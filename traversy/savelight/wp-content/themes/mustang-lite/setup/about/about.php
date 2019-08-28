<?php
/**
 * About Page
 *
 * @package     WebMan WordPress Theme Framework
 * @subpackage  About Page
 * @copyright   2014 WebMan - Oliver Juhas
 *
 * @since    1.0
 * @version  1.9.4
 *
 * CONTENT:
 *  1) Requirements check
 * 10) Actions and filters
 * 20) Styles and scripts
 * 30) Renderer
 */





/**
 * 1) Requirements check
 */

	if (
			! is_admin()
			|| wm_option( 'skin-disable-welcome' )
		) {
		return;
	}





/**
 * 10) Actions and filters
 */

	/**
	 * Actions
	 */

		//Display "About" page
			add_action( 'admin_menu', 'wm_add_about_screen' );
		//Display "About" page admin notice
			add_action( 'current_screen', 'wm_about_screen_notice' );





/**
 * 20) Styles and scripts
 */

	/**
	 * About theme page styles
	 */
	if ( ! function_exists( 'wm_about_css' ) ) {
		function wm_about_css() {
			wp_enqueue_style( 'wm-about' );
			wp_enqueue_style( 'wm-about-custom' );

			if (
					is_rtl()
					&& apply_filters( 'wmhook_wm_about_css_enable_rtl', false )
				) {
				wp_enqueue_style( 'wm-about-rtl' );
			}
		}
	} // /wm_about_css





/**
 * 30) Renderer
 */

	/**
	 * Add "About" screen notice
	 *
	 * @since    1.0.0
	 * @version  1.8.2
	 */
	if ( ! function_exists( 'wm_about_screen_notice' ) ) {
		function wm_about_screen_notice() {

			// Requirements check

				if ( ! function_exists( 'get_current_screen' ) ) {
					return;
				}


			// Processing

				if (
						3 > absint( get_option( WM_THEME_SETTINGS_INSTALL ) )
						&& ! isset( $wp_customize )
					) {
						$screen = get_current_screen();

						if (
								isset( $screen->id )
								&& 'themes' === $screen->id
							) {
							$message = '<a href="' . admin_url( 'themes.php?page=' . WM_THEME_SHORTNAME . '-about' ) . '" class="button button-primary button-hero" style="text-decoration: none; float: right;" title="Go to the ' . WM_THEME_NAME . ' about page">' . WM_THEME_NAME . ' setup &raquo;</a><span style="font-size: 1.25em;">Thank you for <a href="' . admin_url( 'themes.php?page=' . WM_THEME_SHORTNAME . '-about' ) . '">installing <strong>' . WM_THEME_NAME . '</strong></a> WordPress theme by <a href="' . WM_DEVELOPER_URL . '" target="_blank">WebMan</a>!</span><br /><strong>Please, set the theme up according to "<a href="' . admin_url( 'themes.php?page=' . WM_THEME_SHORTNAME . '-about' ) . '"><em>' . sprintf( 'About %s', WM_THEME_NAME ) . '</em></a>" page first.</strong>';

							set_transient( 'wm-admin-notice', array( $message, '', 'switch_themes' ), ( 60 * 60 * 24 ) );
						}
				}

		}
	} // /wm_about_screen_notice



	/**
	 * Add "About" screen to WordPress menu
	 *
	 * @version  1.6
	 */
	if ( ! function_exists( 'wm_add_about_screen' ) ) {
		function wm_add_about_screen() {

			// Processing

				$page_title = esc_html__( 'Welcome', 'mustang-lite' );
				$screen     = add_theme_page(
						$page_title,
						$page_title,
						'switch_themes',
						WM_THEME_SHORTNAME . '-about',
						'wm_about_screen'
					);

				add_action( 'admin_print_styles-' . $screen, 'wm_about_css' );

		}
	} // /wm_add_about_screen



	/**
	 * Render the "About" screen content
	 *
	 * @since    1.0
	 * @version  1.9.3
	 */
	if ( ! function_exists( 'wm_about_screen' ) ) {
		function wm_about_screen() {

			// Output

				?>

				<div class="wrap welcome-wrap about-wrap">

					<!-- Header -->

						<h1>
							<?php

							printf(
								esc_html_x( 'Welcome to %1$s %2$s', '1: theme name, 2: theme version number.', 'mustang-lite' ),
								'<strong>' . WM_THEME_NAME . '</strong>',
								'<small>' . WM_THEME_VERSION . '</small>'
							);

							?>
						</h1>

						<div class="welcome-text about-text">
							<?php

							printf(
								esc_html_x( 'Thank you for using %1$s WordPress theme by %2$s!', '1: theme name, 2: theme developer link.', 'mustang-lite' ),
								'<strong>' . WM_THEME_NAME . '</strong>',
								'<a href="https://www.webmandesign.eu" target="_blank"><strong>WebMan Design</strong></a>'
							);

							?>
							<br>
							<?php esc_html_e( 'Please take time to read the steps below to set up your website.', 'mustang-lite' ); ?>
						</div>

						<!-- Action links / buttons -->

							<p class="wm-actions">

								<a href="https://webmandesign.github.io/docs/mustang/" class="button button-primary button-hero" target="_blank"><?php esc_html_e( 'Theme Documentation', 'mustang-lite' ); ?></a>

								<a href="https://support.webmandesign.eu" class="button button-hero" target="_blank"><?php esc_html_e( 'Support Forum', 'mustang-lite' ); ?></a>

							</p>

					<!-- Content -->

						<div class="welcome-content">

						<!-- Quickstart steps -->

							<hr />

							<h2 class="screen-reader-text"><?php esc_html_e( 'Quickstart Guide', 'mustang-lite' ); ?></h2>

							<div class="feature-section three-col has-3-columns" style="max-width: none;">

								<div class="first-feature col column">

									<span class="dropcap">1</span>

									<h3><?php esc_html_e( 'WebMan Amplifier', 'mustang-lite' ); ?></h3>

									<p>
										<?php printf( esc_html_x( 'To make the theme highly flexible, open and future-proof, it uses the %s plugin.', '%s: plugin name.', 'mustang-lite' ), '<a href="https://wordpress.org/plugins/webman-amplifier/" target="_blank"><strong>WebMan Amplifier</strong></a>' ); ?>
										<?php esc_html_e( 'Please, install and activate this plugin to unveil the additional functionality.', 'mustang-lite' ); ?>
									</p>

									<?php if ( ! class_exists( 'WM_Amplifier' ) ) : ?>

										<a href="<?php echo esc_url( admin_url( 'themes.php?page=tgmpa-install-plugins' ) ); ?>" class="button button-hero"><?php printf( esc_html_x( 'Install %s &raquo;', '%s: plugin name.', 'mustang-lite' ), '<strong>WebMan Amplifier</strong>' ); ?></a>

									<?php endif; ?>

								</div>

								<div class="feature col column">

									<span class="dropcap">2</span>

									<h3><?php esc_html_e( 'The WordPress settings', 'mustang-lite' ); ?></h3>

									<p>
										<?php esc_html_e( 'Do not forget to set up your WordPress in "Settings" section of the WordPress dashboard.', 'mustang-lite' ); ?>
										<?php esc_html_e( 'Please go through all the subsections and options.', 'mustang-lite' ); ?>
										<?php esc_html_e( 'This step is required for all WordPress websites.', 'mustang-lite' ); ?>
									</p>

									<a class="button button-hero" href="<?php echo esc_url( admin_url( 'options-general.php' ) ); ?>"><?php esc_html_e( 'Set Up WordPress &raquo;', 'mustang-lite' ); ?></a>

								</div>

								<div class="last-feature col column">

									<span class="dropcap">3</span>

									<h3><?php esc_html_e( 'Customize the theme', 'mustang-lite' ); ?></h3>

									<p>
										<?php esc_html_e( 'You can customize the theme using live-preview editor.', 'mustang-lite' ); ?>
										<?php esc_html_e( 'Customization changes will go live only after you save them!', 'mustang-lite' ); ?>
									</p>

									<a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" class="button button-primary button-hero"><?php esc_html_e( 'Customize the Theme &raquo;', 'mustang-lite' ); ?></a>

								</div>

							</div>

						<!-- Filesystem notice -->

							<hr />

							<h3>
								<em>
									<strong>
										<?php esc_html_e( 'Important:', 'mustang-lite' ); ?>
									</strong>
								</em>
							</h3>

							<p>
								<em>
									<?php esc_html_e( 'For the best performance, the theme generates a single CSS stylesheet file using WordPress native filesystem API.', 'mustang-lite' ); ?>
									<?php esc_html_e( 'The file is being generated after saving theme customizer settings.', 'mustang-lite' ); ?>
									<?php esc_html_e( 'If you notice an error message in WordPress dashboard after leaving the theme customizer, please check whether you should set up the FTP credentials in your "wp-config.php" file.', 'mustang-lite' ); ?>
									<a href="http://codex.wordpress.org/Editing_wp-config.php#WordPress_Upgrade_Constants" target="_blank"><?php esc_html_e( 'In that case please read the instructions &raquo;', 'mustang-lite' ); ?></a>
								</em>
							</p>

						<!-- Special note -->

							<div class="wm-notes special">

								<h2 class="mt0"><strong><?php esc_html_e( 'Installing the theme demo content', 'mustang-lite' ); ?></strong></h2>

								<p>
									<?php esc_html_e( 'You can install the theme demo content including pages, posts, custom post types, layouts, menus and widgets directly from your WordPress dashboard by clicking the button bellow.', 'mustang-lite' ); ?>
								</p>

								<p>
									<?php esc_html_e( 'Alternatively (such as when the automated installation fails) you can follow theme documentation instructions for manual demo content installation.', 'mustang-lite' ); ?>
									<a href="https://webmandesign.github.io/docs/mustang/#demo-content" target="_blank"><?php esc_html_e( 'Read the instructions &raquo;', 'mustang-lite' ); ?></a>
								</p>

								<?php if ( ! ( class_exists( 'OCDI_Plugin' ) || class_exists( 'PT_One_Click_Demo_Import' ) ) ) : ?>

									<a href="<?php echo esc_url( admin_url( 'themes.php?page=tgmpa-install-plugins' ) ); ?>" class="button button-hero"><strong><?php esc_html_e( 'Install and run "One Click Demo Import" plugin', 'mustang-lite' ); ?></strong></a>

								<?php else : ?>

									<a href="<?php echo esc_url( 'themes.php?page=pt-one-click-demo-import' ); ?>" class="button button-hero button-primary"><strong><?php esc_html_e( 'Install theme demo content', 'mustang-lite' ); ?></strong></a>

									<br>
									<small><em>
										<?php esc_html_e( 'Or head over to Appearance &raquo; Import Demo Data to start the import process.', 'mustang-lite' ); ?>
									</em></small>

								<?php endif; ?>

							</div>

						</div>

					<!-- Footer note -->

						<p><small><em><?php esc_html_e( 'You can disable this page in Appearance &raquo; Customize &raquo; Theme &raquo; Others.', 'mustang-lite' ); ?></em></small></p>

				</div>

				<?php

		}
	} // /wm_about_screen
