<?php
/**
 * Asset optimization page.
 *
 * @package Hummingbird
 */

use Hummingbird\Core\Settings;
use Hummingbird\Core\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( is_multisite() && is_network_admin() ) {
	$this->do_meta_boxes( 'main' );
}

if ( $this->has_meta_boxes( 'box-enqueued-files-empty' ) ) {
	$this->do_meta_boxes( 'box-enqueued-files-empty' );
}

$this->do_meta_boxes( 'summary' );
?>

<?php if ( ! $this->has_meta_boxes( 'box-enqueued-files-empty' ) && ! is_network_admin() ) : ?>
	<div class="sui-row-with-sidenav">
		<?php $this->show_tabs(); ?>

		<?php if ( 'files' === $this->get_current_tab() ) : ?>
			<form id="wphb-minification-form" method="post">
				<?php $this->do_meta_boxes( 'main' ); ?>
			</form>
		<?php endif; ?>

		<?php if ( 'tools' === $this->get_current_tab() ) : ?>
			<form id="wphb-minification-tools-form" method="post">
				<?php $this->do_meta_boxes( 'tools' ); ?>
			</form>
		<?php endif; ?>

		<?php if ( 'settings' === $this->get_current_tab() ) : ?>
			<form id="wphb-minification-settings-form" method="post">
				<?php $this->do_meta_boxes( 'settings' ); ?>
			</form>
		<?php endif; ?>

	</div><!-- end row -->
	<?php
endif;

Utils::get_modal( 'minification-advanced' );
if ( 'advanced' === $this->mode ) {
	Utils::get_modal( 'minification-basic' );
}

Utils::get_modal( 'found-assets' );
Utils::get_modal( 'minification-tour' );

$tour = Settings::get( 'wphb-new-user-tour' );
?>

<script>
	jQuery(document).ready( function() {
		var module = window.WPHB_Admin.getModule( 'minification' );

		<?php if ( isset( $_GET['run'] ) ) : ?>
			module.$checkFilesButton.trigger( 'click' );
		<?php endif; ?>

		<?php if ( ! $tour && ! $this->has_meta_boxes( 'box-enqueued-files-empty' ) && ! is_network_admin() ) : ?>
			window.SUI.openModal('wphb-minification-tour', 'wpbody-content', undefined, false);
		<?php endif; ?>
	});
</script>
