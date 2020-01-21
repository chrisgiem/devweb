<?php
/**
 * Render page.
 *
 * @package Hummingbird
 *
 * @var array|wp_error $report  Report, set in render_inner_content().
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $this->has_meta_boxes( 'summary' ) ) {
	$this->do_meta_boxes( 'summary' );
} ?>

<?php if ( $report ) : ?>
	<div class="sui-row-with-sidenav">
		<?php $this->show_tabs(); ?>
		<div>
			<?php $this->do_meta_boxes( $this->get_current_tab() ); ?>
		</div>
	</div><!-- end row -->
<?php else : ?>
	<?php $this->do_meta_boxes( 'main' ); ?>
<?php endif; ?>

<?php \Hummingbird\Core\Utils::get_modal( 'add-recipient' ); ?>

<script>
	jQuery(document).ready( function() {
		window.WPHB_Admin.getModule( 'performance' );
	});
</script>
