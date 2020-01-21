<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<div class="sui-modal sui-modal-sm wphb-database-cleanup-modal">
	<div role="dialog" class="sui-modal-content" id="wphb-database-cleanup-modal" aria-modal="true" aria-labelledby="databaseCleanup" aria-describedby="dialogDescription">
		<div class="sui-box">
			<div class="sui-box-header sui-flatten sui-content-center sui-spacing-top--60">
				<button class="sui-button-icon sui-button-float--right" id="dialog-close-div" data-modal-close="">
					<i class="sui-icon-close sui-md" aria-hidden="true"></i>
					<span class="sui-screen-reader-text"><?php esc_attr_e( 'Close this dialog window', 'wphb' ); ?></span>
				</button>

				<h3 class="sui-box-title sui-lg" id="databaseCleanup">
					<?php esc_html_e( 'Are you sure?', 'wphb' ); ?>
				</h3>

				<p class="sui-description" id="dialogDescription"></p>
			</div>

			<div class="sui-box-body sui-content-center">
				<a class="sui-button sui-button-ghost" data-modal-close="">
					<?php esc_html_e( 'Cancel', 'wphb' ); ?>
				</a>
				<a class="sui-button sui-button-ghost sui-button-red wphb-delete-db-row" onclick="WPHB_Admin.advanced.confirmDelete( jQuery(this).attr('data-type') )">
					<i class="sui-icon-trash" aria-hidden="true"></i>
					<?php esc_html_e( 'Delete entries', 'wphb' ); ?>
				</a>
			</div>
		</div>
	</div>
</div>
