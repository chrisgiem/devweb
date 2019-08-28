<?php
/**
 * Footer widget area template
 *
 * @package    WebMan WordPress Theme Framework
 * @copyright  2014 WebMan - Oliver Juhas
 *
 * @since    1.1.1
 * @version  1.9.3
 */



/**
 * Requirements check
 *
 * This is specially for plugins like WooCommerce
 *
 * @since  1.2.1
 */

	if ( function_exists( 'wma_sidebar' ) ) {
		return;
	}



/**
 * Helper variables
 */

	$sidebar_id = 'footer-widgets';

	$widgets_count = wp_get_sidebars_widgets();
	if ( is_array( $widgets_count ) && isset( $widgets_count[ $sidebar_id ] ) ) {
		$widgets_count = $widgets_count[ $sidebar_id ];
	} else {
		$widgets_count = array();
	}



/**
 * Output
 */

	echo '<div class="footer-widgets clearfix columns-4 masonry-disabled" data-columns="4"><div class="wrap-inner"><div class="pane twelve">';

		echo wmhook_sidebars_before();

			echo "\r\n\r\n" . '<aside class="wm-sidebar widget-area footer-widgets-container widgets-count-' . count( $widgets_count ) . '" data-id="' . $sidebar_id . '" data-widgets-count="' . count( $widgets_count ) . '">' . "\r\n";

				echo wmhook_sidebar_top();

				if ( is_active_sidebar( $sidebar_id ) ) {

					dynamic_sidebar( $sidebar_id );

				}

				echo wmhook_sidebar_bottom();

			echo "\r\n" . '</aside>' . "\r\n\r\n";

		echo wmhook_sidebars_after();

	echo '</div></div></div>';
