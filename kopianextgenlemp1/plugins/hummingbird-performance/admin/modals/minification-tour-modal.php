<?php
/**
 * Asset optimization tour modal.
 *
 * @since 2.1.0
 * @package Hummingbird
 */

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

use Hummingbird\Core\Utils;

?>

<div class="sui-modal sui-modal-sm">
	<div role="dialog" class="sui-modal-content" id="wphb-minification-tour" aria-live="polite" aria-modal="true" aria-labelledby="dialogTitle" aria-describedby="dialogDescription">
		<div id="tour-slide-one" class="sui-modal-slide sui-active sui-loaded" data-modal-size="sm">
			<div class="sui-box">
				<div class="sui-box-header sui-flatten sui-content-center sui-spacing-top--60">
					<button class="sui-button-icon sui-button-float--right" id="dialog-close-div" data-modal-close="">
						<i class="sui-icon-close sui-md" aria-hidden="true"></i>
						<span class="sui-screen-reader-text"><?php esc_attr_e( 'Close this dialog window', 'wphb' ); ?></span>
					</button>

					<h3 id="dialogTitle" class="sui-box-title sui-lg">
						<?php esc_html_e( 'Take a Quick Tour', 'wphb' ); ?>
					</h3>

					<p id="dialogDescription" class="sui-description">
						<?php esc_html_e( "Asset optimization is a complex feature for optimizing your files, if it's your first time we recommend you take a quick tour of the configuration options.", 'wphb' ); ?>
					</p>
				</div>

				<div class="sui-box-body sui-content-center">
					<button class="sui-button sui-button-blue" id="take-the-tour" data-modal-slide="tour-slide-two" data-modal-slide-focus="slide-next" data-modal-slide-intro="next">
						<?php esc_html_e( 'Take the tour', 'wphb' ); ?>
					</button>
				</div>

				<?php if ( ! Utils::hide_wpmudev_branding() ) : ?>
					<img class="sui-image sui-margin-top"
						src="<?php echo esc_url( WPHB_DIR_URL . 'admin/assets/image/graphic-minify-modal-warning@1x.png' ); ?>"
						srcset="<?php echo esc_url( WPHB_DIR_URL . 'admin/assets/image/graphic-minify-modal-warning@2x.png' ); ?> 2x"
						alt="<?php esc_attr_e( 'Hummingbird', 'wphb' ); ?>">
				<?php endif; ?>
			</div>

			<a class="sui-modal-skip" onclick="WPHB_Admin.minification.skipTour()" data-modal-close="">
				<?php esc_html_e( 'Skip this', 'wphb' ); ?>
			</a>
		</div>

		<div id="tour-slide-two" class="sui-box sui-modal-slide" data-modal-size="sm">
			<div class="sui-box-header sui-flatten sui-content-center sui-spacing-top--60">
				<button class="sui-button-icon sui-button-float--left" data-modal-slide="tour-slide-one" data-modal-slide-focus="take-the-tour" data-modal-slide-intro="back">
					<i class="sui-icon-chevron-left" aria-hidden="true"></i>
					<span class="sui-screen-reader-text"><?php esc_attr_e( 'Go to previous slide', 'wphb' ); ?></span>
				</button>

				<button class="sui-button-icon sui-button-float--right" data-modal-close="">
					<i class="sui-icon-close sui-md" aria-hidden="true"></i>
					<span class="sui-screen-reader-text"><?php esc_attr_e( 'Close this dialog window', 'wphb' ); ?></span>
				</button>

				<figure class="sui-box-banner" aria-hidden="true">
					<img src="<?php echo esc_url( WPHB_DIR_URL . 'admin/assets/image/tour/tour-grey-compress.png' ); ?>"
						srcset="<?php echo esc_url( WPHB_DIR_URL . 'admin/assets/image/tour/tour-grey-compress@2x.png' ); ?> 2x"/>
				</figure>

				<p id="dialogDescription" class="sui-description">
					<?php esc_html_e( "Greyed-out icons like this mean that the file has already been optimized (like *.min.js and *.min.css.), we can't compress these files any further so it's safe to ignore them.", 'wphb' ); ?>
				</p>
			</div>

			<div class="sui-box-body sui-flatten sui-content-center">
				<button class="sui-button" id="slide-next" data-modal-slide="tour-slide-three" data-modal-slide-focus="slide-next" data-modal-slide-intro="next">
					<?php esc_html_e( 'Next', 'wphb' ); ?>
				</button>
			</div>
		</div>

		<div id="tour-slide-three" class="sui-box sui-modal-slide" data-modal-size="sm">
			<div class="sui-box-header sui-flatten sui-content-center sui-spacing-top--60">
				<button class="sui-button-icon sui-button-float--left" data-modal-slide="tour-slide-two" data-modal-slide-focus="slide-next" data-modal-slide-intro="back">
					<i class="sui-icon-chevron-left" aria-hidden="true"></i>
					<span class="sui-screen-reader-text"><?php esc_attr_e( 'Go to previous slide', 'wphb' ); ?></span>
				</button>

				<button class="sui-button-icon sui-button-float--right" data-modal-close="">
					<i class="sui-icon-close sui-md" aria-hidden="true"></i>
					<span class="sui-screen-reader-text"><?php esc_attr_e( 'Close this dialog window', 'wphb' ); ?></span>
				</button>

				<figure class="sui-box-banner" aria-hidden="true">
					<img src="<?php echo esc_url( WPHB_DIR_URL . 'admin/assets/image/tour/tour-white-compress.png' ); ?>"
						srcset="<?php echo esc_url( WPHB_DIR_URL . 'admin/assets/image/tour/tour-white-compress@2x.png' ); ?> 2x">
				</figure>

				<p id="dialogDescription" class="sui-description">
					<?php esc_html_e( "For files that can be compressed, click the 'Compress' icon and when you save your changes we'll do our best to optimize and reduce its file size.", 'wphb' ); ?>
				</p>
			</div>

			<div class="sui-box-body sui-flatten sui-content-center">
				<button class="sui-button" id="slide-next" data-modal-slide="tour-slide-four" data-modal-slide-focus="slide-next" data-modal-slide-intro="next">
					<?php esc_html_e( 'Next', 'wphb' ); ?>
				</button>
			</div>
		</div>

		<div id="tour-slide-four" class="sui-box sui-modal-slide" data-modal-size="sm">
			<div class="sui-box-header sui-flatten sui-content-center sui-spacing-top--60">
				<button class="sui-button-icon sui-button-float--left" data-modal-slide="tour-slide-three" data-modal-slide-focus="slide-next" data-modal-slide-intro="back">
					<i class="sui-icon-chevron-left" aria-hidden="true"></i>
					<span class="sui-screen-reader-text"><?php esc_attr_e( 'Go to previous slide', 'wphb' ); ?></span>
				</button>

				<button class="sui-button-icon sui-button-float--right" data-modal-close="">
					<i class="sui-icon-close sui-md" aria-hidden="true"></i>
					<span class="sui-screen-reader-text"><?php esc_attr_e( 'Close this dialog window', 'wphb' ); ?></span>
				</button>

				<figure class="sui-box-banner" aria-hidden="true">
					<img src="<?php echo esc_url( WPHB_DIR_URL . 'admin/assets/image/tour/tour-blue-compress.png' ); ?>"
						srcset="<?php echo esc_url( WPHB_DIR_URL . 'admin/assets/image/tour/tour-blue-compress@2x.png' ); ?> 2x">
				</figure>

				<p id="dialogDescription" class="sui-description">
					<?php esc_html_e( "When an optimization option is active you'll see a blue icon (like the above). Note: compressing files can take a few minutes before they will be appear optimized on your web pages.", 'wphb' ); ?>
				</p>
			</div>

			<div class="sui-box-body sui-flatten sui-content-center">
				<button class="sui-button" id="slide-next" data-modal-slide="tour-slide-five" data-modal-slide-focus="slide-next" data-modal-slide-intro="next">
					<?php esc_html_e( 'Next', 'wphb' ); ?>
				</button>
			</div>
		</div>

		<div id="tour-slide-five" class="sui-box sui-modal-slide" data-modal-size="sm">
			<div class="sui-box-header sui-flatten sui-content-center sui-spacing-top--60">
				<button class="sui-button-icon sui-button-float--left" data-modal-slide="tour-slide-four" data-modal-slide-focus="slide-next" data-modal-slide-intro="back">
					<i class="sui-icon-chevron-left" aria-hidden="true"></i>
					<span class="sui-screen-reader-text"><?php esc_attr_e( 'Go to previous slide', 'wphb' ); ?></span>
				</button>

				<button class="sui-button-icon sui-button-float--right" data-modal-close="">
					<i class="sui-icon-close sui-md" aria-hidden="true"></i>
					<span class="sui-screen-reader-text"><?php esc_attr_e( 'Close this dialog window', 'wphb' ); ?></span>
				</button>

				<figure class="sui-box-banner" aria-hidden="true">
					<img src="<?php echo esc_url( WPHB_DIR_URL . 'admin/assets/image/tour/tour-advanced-mode.png' ); ?>"
						srcset="<?php echo esc_url( WPHB_DIR_URL . 'admin/assets/image/tour/tour-advanced-mode@2x.png' ); ?> 2x">
				</figure>

				<p id="dialogDescription" class="sui-description">
					<?php esc_html_e( 'We also offer combining files, moving files to the footer, inlining CSS, deferring scripts and removing them completely. Switch to advanced mode to take full control of your assets.', 'wphb' ); ?>
				</p>
			</div>

			<div class="sui-box-body sui-flatten sui-content-center">
				<button class="sui-button" data-modal-close="" onclick="WPHB_Admin.minification.skipTour()">
					<?php esc_html_e( 'Got it, thanks', 'wphb' ); ?>
				</button>
			</div>

			<img width="120" class="sui-image" src="<?php echo esc_url( WPHB_DIR_URL . 'admin/assets/image/graphic-caching-top.png' ); ?>"
				srcset="<?php echo esc_url( WPHB_DIR_URL . 'admin/assets/image/graphic-caching-top@2x.png' ); ?> 2x" style="margin: 0 auto;">
		</div>
	</div>
</div>
