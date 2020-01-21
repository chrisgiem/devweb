<?php
/**
 * Asset optimization: switch to basic mode modal.
 *
 * @package Hummingbird
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<div class="sui-modal sui-modal-sm">
	<div role="dialog" class="sui-modal-content" id="wphb-basic-minification-modal" aria-modal="true" aria-labelledby="switchBasic" aria-describedby="dialogDescription">
		<div class="sui-box">
			<div class="sui-box-header sui-flatten sui-content-center sui-spacing-top--60">
				<button class="sui-button-icon sui-button-float--right" id="dialog-close-div" data-modal-close="">
					<i class="sui-icon-close sui-md" aria-hidden="true"></i>
					<span class="sui-screen-reader-text"><?php esc_attr_e( 'Close this dialog window', 'wphb' ); ?></span>
				</button>

				<h3 class="sui-box-title sui-lg" id="switchBasic">
					<?php esc_html_e( 'Are you sure?', 'wphb' ); ?>
				</h3>

				<p class="sui-description" id="dialogDescription">
					<?php esc_html_e( 'Switching back to Basic mode will keep your basic compression settings, but you’ll lose any advanced configuration you have set up.', 'wphb' ); ?>
				</p>
			</div>

			<div class="sui-box-body sui-content-center">
				<button class="close sui-button sui-button-ghost" data-modal-close="">
					<?php esc_html_e( 'Go back', 'wphb' ); ?>
				</button>

				<a onclick="WPHB_Admin.minification.switchView( 'basic' )" class="sui-button">
					<?php esc_html_e( 'Switch to basic mode', 'wphb' ); ?>
				</a>
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
