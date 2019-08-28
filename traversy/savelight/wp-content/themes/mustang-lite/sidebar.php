<?php
/**
 * Sidebar template
 *
 * @package    WebMan WordPress Theme Framework
 * @copyright  2014 WebMan - Oliver Juhas
 *
 * @since    1.0
 * @version  1.6
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

	$sidebar_id = 'general';

	$widgets_count = wp_get_sidebars_widgets();
	if ( is_array( $widgets_count ) && isset( $widgets_count[ $sidebar_id ] ) ) {
		$widgets_count = $widgets_count[ $sidebar_id ];
	} else {
		$widgets_count = array();
	}



/**
 * Output
 */

	echo wmhook_sidebars_before();

		echo "\r\n\r\n" . '<aside class="wm-sidebar sidebar widget-area clearfix sidebar-right pane four widgets-count-' . count( $widgets_count ) . '" data-id="' . $sidebar_id . '" data-widgets-count="' . count( $widgets_count ) . '">' . "\r\n";

			echo wmhook_sidebar_top();

			if ( is_active_sidebar( $sidebar_id ) ) {

				dynamic_sidebar( $sidebar_id );

			}

			echo wmhook_sidebar_bottom();

		echo "\r\n" . '</aside>' . "\r\n\r\n";

	echo wmhook_sidebars_after();
