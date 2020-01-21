<?php
/**
 * Caching page layout.
 *
 * @package Hummingbird
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $this->has_meta_boxes( 'summary' ) ) {
	$this->do_meta_boxes( 'summary' );
}

if ( $this->has_meta_boxes( 'box-caching' ) ) {
	$this->do_meta_boxes( 'box-caching' );
} ?>

<div class="sui-row-with-sidenav">
	<?php $this->show_tabs(); ?>

	<?php if ( 'page_cache' === $this->get_current_tab() ) : ?>
		<form id="page-caching-form" method="post">
			<?php $this->do_meta_boxes( 'page_cache' ); ?>
		</form>
	<?php elseif ( 'rss' === $this->get_current_tab() ) : ?>
		<form id="rss-caching-settings" method="post">
			<?php $this->do_meta_boxes( 'rss' ); ?>
		</form>
	<?php elseif ( 'settings' === $this->get_current_tab() ) : ?>
		<form id="other-caching-settings" method="post">
			<?php $this->do_meta_boxes( 'settings' ); ?>
		</form>
	<?php else : ?>
		<div>
			<?php $this->do_meta_boxes( $this->get_current_tab() ); ?>
		</div>
	<?php endif; ?>
</div>

<script>
	jQuery(document).ready( function() {
		if ( window.WPHB_Admin ) {
			window.WPHB_Admin.getModule( 'caching' );
		}
	});
</script>
