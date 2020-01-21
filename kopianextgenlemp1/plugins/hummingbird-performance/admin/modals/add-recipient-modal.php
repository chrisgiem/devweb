<?php
/**
 * Add recipient modal.
 *
 * TODO: refactor to support SUI 2.5.
 *
 * @package Hummingbird
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<div class="sui-modal sui-modal-sm">
	<div role="dialog" class="sui-modal-content" id="wphb-add-recipient-modal" aria-modal="true" aria-labelledby="addRecipient" aria-describedby="dialogDescription">
		<div class="sui-box">
			<div class="sui-box-header sui-flatten sui-content-center sui-spacing-top--60">
				<button class="sui-button-icon sui-button-float--right" id="dialog-close-div" data-modal-close="">
					<i class="sui-icon-close sui-md" aria-hidden="true"></i>
					<span class="sui-screen-reader-text"><?php esc_attr_e( 'Close this dialog window', 'wphb' ); ?></span>
				</button>

				<h3 class="sui-box-title sui-lg" id="addRecipient">
					<?php esc_html_e( 'Add Recipient', 'wphb' ); ?>
				</h3>

				<p class="sui-description" id="dialogDescription">
					<?php esc_html_e( 'Add as many recipients as you like, they will receive email notifications as per your settings.', 'wphb' ); ?>
				</p>
			</div>

			<div class="sui-box-body">
				<div class="sui-form-field">
					<label for="reporting-first-name" class="sui-label"><?php esc_html_e( 'First name', 'wphb' ); ?></label>
					<input type="text" id="reporting-first-name" class="sui-form-control" placeholder="<?php esc_attr_e( 'E.g John', 'wphb' ); ?>">
				</div>
				<div class="sui-form-field">
					<label for="reporting-email" class="sui-label"><?php esc_html_e( 'Email address', 'wphb' ); ?></label>
					<input type="text" id="reporting-email" class="sui-form-control" placeholder="<?php esc_attr_e( 'E.g john@doe.com', 'wphb' ); ?>">
				</div>
			</div>

			<div class="sui-box-footer sui-flatten sui-content-separated">
				<button class="sui-button sui-button-ghost" data-modal-close="">
					<?php esc_html_e( 'Cancel', 'wphb' ); ?>
				</button>
				<a class="sui-button" id="add-recipient">
					<?php esc_html_e( 'Add', 'wphb' ); ?>
				</a>
			</div>
		</div>
	</div>
</div>
