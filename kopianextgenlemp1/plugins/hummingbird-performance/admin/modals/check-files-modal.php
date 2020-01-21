<?php
/**
 * Asset optimization: checking files modal.
 *
 * @package Hummingbird
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<div class="sui-modal sui-modal-lg">
	<div role="dialog" class="sui-modal-content" id="check-files-modal" aria-modal="true" aria-labelledby="checkingFiles" aria-describedby="dialogDescription">
		<div class="sui-box">
			<div class="sui-box-header">
				<h3 class="sui-box-title" id="checkingFiles">
					<?php esc_html_e( 'Checking files', 'wphb' ); ?>
				</h3>
				<div class="sui-actions-right">
					<small class="sui-no-margin-bottom"><?php esc_html_e( 'File check in progress...', 'wphb' ); ?></small>
				</div>
			</div>

			<div class="sui-box-body">
				<p id="dialogDescription">
					<?php esc_html_e( 'Hummingbird is running a file check to see what files can be optimized.', 'wphb' ); ?>
				</p>

				<div class="sui-progress-block">
					<div class="sui-progress">
						<span class="sui-progress-icon" aria-hidden="true">
							<i class="sui-icon-loader sui-loading"></i>
						</span>
						<div class="sui-progress-text">
							<span>0%</span>
						</div>
						<div class="sui-progress-bar" aria-hidden="true">
							<span style="width: 0"></span>
						</div>
					</div>
					<button class="sui-button-icon sui-tooltip" id="cancel-minification-check" type="button" data-modal-close="" data-tooltip="<?php esc_attr_e( 'Cancel Test', 'wphb' ); ?>">
						<i class="sui-icon-close" aria-hidden="true"></i>
					</button>
				</div>

				<div class="sui-progress-state sui-margin-bottom">
					<span class="sui-progress-state-text"><?php esc_html_e( 'Looking for files...', 'wphb' ); ?></span>
				</div>

				<?php if ( ! \Hummingbird\Core\Utils::is_member() ) : ?>
					<div class="sui-notice sui-notice-info">
						<p style="font-size:13px;line-height:22px;">
							<?php
							printf(
								/* translators: %s - learn more link */
								__( 'Did you know the Pro version of Hummingbird comes up to 2x better compression and a CDN to store your assets on? Get it as part of a WPMU DEV membership. <a href="%s" target="_blank">Learn more.</a>', 'wphb' ),
								esc_url( \Hummingbird\Core\Utils::get_link( 'plugin' ) )
							);
							?>
						</p>
					</div>
				<?php endif; ?>
				<?php
				$cdn_status = \Hummingbird\Core\Utils::get_module( 'minify' )->get_cdn_status();

				if ( ! is_multisite() && \Hummingbird\Core\Utils::is_member() ) :
					?>
					<form method="post" class="sui-border-frame" id="enable-cdn-form">
						<label class="sui-toggle">
							<input type="checkbox" name="enable_cdn" id="enable_cdn" <?php checked( $cdn_status ); ?>>
							<span class="sui-toggle-slider"></span>
						</label>
						<label><?php esc_html_e( 'Store my files on the WPMU DEV CDN', 'wphb' ); ?></label>
						<span class="sui-description sui-toggle-description">
							<?php esc_html_e( 'By default your files are hosted on your own server. With this pro setting enabled we will host your files on WPMU DEV’s secure and hyper fast CDN.', 'wphb' ); ?>
						</span>
					</form>
				<?php elseif ( is_multisite() && \Hummingbird\Core\Utils::is_member() ) : ?>
					<input type="checkbox" class="sui-hidden" name="enable_cdn" id="enable_cdn" <?php checked( $cdn_status ); ?>>
				<?php endif; ?>

			</div>
			<?php if ( ! \Hummingbird\Core\Utils::hide_wpmudev_branding() ) : ?>
				<img class="sui-image"
					src="<?php echo esc_url( WPHB_DIR_URL . 'admin/assets/image/hb-graphic-minify-summary.png' ); ?>"
					srcset="<?php echo esc_url( WPHB_DIR_URL . 'admin/assets/image/hb-graphic-minify-summary@2x.png' ); ?> 2x"
					alt="<?php esc_attr_e( 'Reduce your page load time!', 'wphb' ); ?>">
			<?php endif; ?>
		</div>
	</div>

	<script type="text/javascript">
		jQuery('label[for="enable_cdn"]').on('click', function(e) {
			e.preventDefault();
			var checkbox = jQuery('input[name="enable_cdn"]');
			checkbox.prop('checked', !checkbox.prop('checked') );
		});
	</script>
</div>
