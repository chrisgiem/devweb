<?php
/**
 * Theme info page
 *
 * @package Airi
 */

//Add the theme page
add_action('admin_menu', 'airi_add_theme_info');
function airi_add_theme_info(){

	if ( !current_user_can('install_plugins') ) {
		return;
	}

	$theme_info = add_theme_page( __('Airi Info','airi'), __('Airi Info','airi'), 'manage_options', 'airi-info.php', 'airi_info_page' );
	add_action( 'load-' . $theme_info, 'airi_info_hook_styles' );
}

//Callback
function airi_info_page() {
	$user = wp_get_current_user();
?>
	<div class="info-container">
		<p class="hello-user"><?php echo sprintf( __( 'Hello, %s,', 'airi' ), '<span>' . esc_html( ucfirst( $user->display_name ) ) . '</span>' ); ?></p>
		<h1 class="info-title"><?php echo sprintf( __( 'Welcome to Airi version %s', 'airi' ), esc_html( wp_get_theme()->version ) ); ?></h1>
		<p class="welcome-desc"><?php esc_html_e( 'Airi is now installed and ready to go. To help you with the next step, we’ve gathered together on this page all the resources you might need. We hope you enjoy using Airi. ', 'airi' ); ?>
	

		<div class="airi-theme-tabs">

			<div class="airi-tab-nav nav-tab-wrapper">
				<a href="#begin" data-target="begin" class="nav-button nav-tab begin active"><?php esc_html_e( 'Getting started', 'airi' ); ?></a>
				<a href="#actions" data-target="actions" class="nav-button actions nav-tab"><?php esc_html_e( 'Recommended Actions', 'airi' ); ?></a>
				<a href="#support" data-target="support" class="nav-button support nav-tab"><?php esc_html_e( 'Support', 'airi' ); ?></a>
				<a href="#changelog" data-target="changelog" class="nav-button changelog nav-tab"><?php esc_html_e( 'Changelog', 'airi' ); ?></a>
				<a href="#table" data-target="table" class="nav-button table nav-tab"><?php esc_html_e( 'Free vs Pro', 'airi' ); ?></a>
			</div>

			<div class="airi-tab-wrapper">

				<div id="begin" class="airi-tab begin show">
					<h3><?php esc_html_e( 'Step 1 - Implement recommended actions', 'airi' ); ?></h3>
					<p><?php esc_html_e( 'We\'ve made a list of steps for you to follow to get the most of Airi.', 'airi' ); ?></p>
					<p><a class="actions" href="#actions"><?php esc_html_e( 'Check recommended actions', 'airi' ); ?></a></p>
					<hr>
					<h3><?php esc_html_e( 'Step 2 - Read documentation', 'airi' ); ?></h3>
					<p><?php esc_html_e( 'Our documentation will have you up and running in no time.', 'airi' ); ?></p>
					<p><a href="https://docs.athemes.com/category/260-airi" target="_blank"><?php esc_html_e( 'Documentation', 'airi' ); ?></a></p>
					<hr>
					<h3><?php esc_html_e( 'Step 3 - Customize', 'airi' ); ?></h3>
					<p><?php esc_html_e( 'Use the Customizer to make Airi your own.', 'airi' ); ?></p>
					<p><a class="button button-primary button-large" href="<?php echo admin_url( 'customize.php' ); ?>"><?php esc_html_e( 'Go to Customizer', 'airi' ); ?></a></p>
				</div>

				<div id="actions" class="airi-tab actions">
					<h3><?php esc_html_e( 'Install: Elementor', 'airi' ); ?></h3>
					<p><?php esc_html_e( 'It is highly recommended that you install Elementor. It will enable you to create pages by adding widgets to them using drag and drop.', 'airi' ); ?></p>
					
					<?php if ( !defined( 'ELEMENTOR_PATH' ) ) : ?>
					<?php $so_url = wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=elementor'), 'install-plugin_elementor'); ?>
					<p>
						<a target="_blank" class="install-now button" href="<?php echo esc_url( $so_url ); ?>"><?php esc_html_e( 'Install and Activate', 'airi' ); ?></a>
					</p>
					<?php else : ?>
						<p style="color:#23d423;font-style:italic;font-size:14px;"><?php esc_html_e( 'Plugin installed and active!', 'airi' ); ?></p>
					<?php endif; ?>

					<hr>
					<h3><?php esc_html_e( 'Install: Kirki (theme options)', 'airi' ); ?></h3>
					<p><?php esc_html_e( 'The theme options are built with the awesome Kirki framework. Click to install it.', 'airi' ); ?></p>
					<?php if ( !class_exists('Kirki') ) : ?>
					<?php $st_url = wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=kirki'), 'install-plugin_kirki'); ?>
					<p>
						<a target="_blank" class="install-now button" href="<?php echo esc_url( $st_url ); ?>"><?php esc_html_e( 'Install and Activate', 'airi' ); ?></a>
					</p>
					<?php else : ?>
						<p style="color:#23d423;font-style:italic;font-size:14px;"><?php esc_html_e( 'Plugin installed and active!', 'airi' ); ?></p>
					<?php endif; ?>
					<hr>					
					<h3><?php esc_html_e( 'Demo content', 'airi' ); ?></h3>
					
					<div class="column-wrapper">
						<p><?php esc_html_e( 'Use the button below to import any of our demo sites.', 'airi' ); ?></p>
						<p class="hello"><?php Airi_Onboarding::import_button_html( false, '', esc_html__( 'Import a demo site', 'airi' ) ); ?></p>
					</div>
				</div>

				<div id="support" class="airi-tab support">
					<div class="column-wrapper">
						<div class="tab-column">
						<span class="dashicons dashicons-sos"></span>
						<h3><?php esc_html_e( 'Visit our forums', 'airi' ); ?></h3>
						<p><?php esc_html_e( 'Need help? Go ahead and visit our support forums and we\'ll be happy to assist you with any theme related questions you might have', 'airi' ); ?></p>
							<a href="https://forums.athemes.com/" target="_blank"><?php esc_html_e( 'Visit the forums', 'airi' ); ?></a>				
							</div>
						<div class="tab-column">
						<span class="dashicons dashicons-book-alt"></span>
						<h3><?php esc_html_e( 'Documentation', 'airi' ); ?></h3>
						<p><?php esc_html_e( 'Our documentation can help you learn how to use the theme and also provides you with premade code snippets and answers to FAQs.', 'airi' ); ?></p>
						<a href="https://docs.athemes.com/category/260-airi" target="_blank"><?php esc_html_e( 'See the Documentation', 'airi' ); ?></a>
						</div>
					</div>
				</div>

				<div id="changelog" class="airi-tab changelog">
					<div class="column-wrapper">

						<h3><?php esc_html_e( 'Visit our website to read the full changelog:', 'airi' ); ?></h3>
						<h3><a href="https://athemes.com/changelog/airi/" target="_blank"><?php esc_html_e( 'See the changelog', 'airi' ); ?></a></h3>
					</div>
				</div>


				<div id="table" class="airi-tab table">
				<table class="widefat fixed featuresList"> 
				   <thead> 
					<tr> 
					 <td><strong><h3><?php esc_html_e( 'Feature', 'airi' ); ?></h3></strong></td>
					 <td style="width:20%;"><strong><h3><?php esc_html_e( 'Airi', 'airi' ); ?></h3></strong></td>
					 <td style="width:20%;"><strong><h3><?php esc_html_e( 'Airi Pro', 'airi' ); ?></h3></strong></td>
					</tr> 
				   </thead> 
				   <tbody> 
				   <tr> 
					 <td><?php esc_html_e( 'Elementor support', 'airi' ); ?></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					</tr> 
					<tr> 
					 <td><?php esc_html_e( 'Access to all Google Fonts', 'airi' ); ?></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					</tr> 
					<tr> 
					 <td><?php esc_html_e( 'Responsive', 'airi' ); ?></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					</tr> 
					<tr> 
					 <td><?php esc_html_e( 'Parallax backgrounds', 'airi' ); ?></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					</tr> 
					<tr> 
					 <td><?php esc_html_e( 'Social Icons', 'airi' ); ?></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					</tr> 
					<tr> 
					 <td><?php esc_html_e( 'Custom Elementor blocks', 'airi' ); ?></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					</tr> 
					<tr> 
					 <td><?php esc_html_e( 'Translation ready', 'airi' ); ?></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					</tr> 
					<tr> 
					 <td><?php esc_html_e( 'Color options', 'airi' ); ?></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					</tr> 
					<tr> 
					 <td><?php esc_html_e( 'Blog options', 'airi' ); ?></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					</tr> 
					<tr> 
					 <td><?php esc_html_e( 'Widgetized footer', 'airi' ); ?></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					</tr> 
					<tr> 
					 <td><?php esc_html_e( 'Background image support', 'airi' ); ?></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					</tr> 	
					<td><?php esc_html_e( 'WooCommerce compatible', 'airi' ); ?></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					</tr>
					<tr> 
					 <td><?php esc_html_e( 'Growing collection of premium demos', 'airi' ); ?></td>
					 <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					</tr> 
					<tr> 
					 <td><?php esc_html_e( 'Footer Credits option', 'airi' ); ?></td>
					 <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					</tr> 
					<tr> 
					 <td><?php esc_html_e( 'Footer background image', 'airi' ); ?></td>
					 <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					</tr> 
					<tr> 
					 <td><?php esc_html_e( 'Extra Elementor blocks (portfolio, shop categories, slider)', 'airi' ); ?></td>
					 <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					</tr> 
					<tr> 
					 <td><?php esc_html_e( 'Two extra menu types', 'airi' ); ?></td>
					 <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					</tr> 
					<tr> 
					 <td><?php esc_html_e( 'Extra blog layouts (list, masonry)', 'airi' ); ?></td>
					 <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					</tr> 
					<tr> 
					 <td><?php esc_html_e( 'Extended WooCommerce options', 'airi' ); ?></td>
					 <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					</tr> 
					<tr> 
					 <td><?php esc_html_e( 'Priority support', 'airi' ); ?></td>
					 <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					</tr> 
				   </tbody> 
				  </table>
				  <p style="text-align: right;"><a class="button button-primary button-large" href="https://athemes.com/theme/airi-pro"><?php esc_html_e('Buy Airi Pro ', 'airi'); ?></a></p>
				</div>		
			</div>
		</div>
	</div>
<?php
}

//Styles
function airi_info_hook_styles(){
	add_action( 'admin_enqueue_scripts', 'airi_info_page_styles' );
}
function airi_info_page_styles() {
	wp_enqueue_style( 'airi-info-style', get_template_directory_uri() . '/inc/onboarding/assets/css/info-page.css', array(), true );

	wp_enqueue_script( 'airi-info-script', get_template_directory_uri() . '/inc/onboarding/assets/js/info-page.js', array('jquery'),'', true );

}