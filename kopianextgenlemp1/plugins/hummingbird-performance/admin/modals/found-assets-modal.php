<?php
/**
 * Modal window that is shown right after the asset optimization scan is finished.
 *
 * @since 1.9.2
 * @package Hummingbird
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$tour = \Hummingbird\Core\Settings::get( 'wphb-new-user-tour' );
?>

<div class="sui-modal sui-modal-sm">
	<div role="dialog" class="sui-modal-content wphb-assets-modal" id="wphb-assets-modal" aria-modal="true" aria-labelledby="assetsFound">
		<div class="sui-box">
			<div class="sui-box-header sui-flatten sui-content-center sui-spacing-top--60">
				<button class="sui-button-icon sui-button-float--right" id="dialog-close-div" onclick="WPHB_Admin.minification.goToSettings(<?php echo (bool) $tour; ?>)">
					<i class="sui-icon-close sui-md" aria-hidden="true"></i>
					<span class="sui-screen-reader-text"><?php esc_attr_e( 'Close this dialog window', 'wphb' ); ?></span>
				</button>

				<h3 class="sui-box-title sui-lg" id="assetsFound">
					<?php
					printf(
						/* translators: %s - number of assets */
						esc_html__( '%s assets found', 'wphb' ),
						0
					);
					?>
				</h3>

				<p class="sui-description">
					<?php
					esc_html_e( 'Next, optimize your file structure by turning on compression, and moving files in order to speed up your page load times.', 'wphb' );
					?>
				</p>
			</div>

			<div class="sui-box-body">
				<div class="sui-notice sui-notice-warning">
					<p>
						<?php
						esc_html_e( 'This is an advanced feature and can break themes easily. We recommend modifying each file individually and checking your frontend regularly for issues.', 'wphb' );
						?>
					</p>
				</div>

				<div class="sui-block-content-center">
					<a class="sui-button" onclick="WPHB_Admin.minification.goToSettings(<?php echo (bool) $tour; ?>)">
						<?php esc_html_e( 'Got It', 'wphb' ); ?>
					</a>
				</div>
			</div>

			<?php if ( ! \Hummingbird\Core\Utils::hide_wpmudev_branding() ) : ?>
				<img class="sui-image"
					src="<?php echo esc_url( WPHB_DIR_URL . 'admin/assets/image/graphic-minify-modal-warning@1x.png' ); ?>"
					srcset="<?php echo esc_url( WPHB_DIR_URL . 'admin/assets/image/graphic-minify-modal-warning@2x.png' ); ?> 2x"
					alt="<?php esc_attr_e( 'Hummingbird', 'wphb' ); ?>">
			<?php endif; ?>
		</div>
	</div>
</div>
