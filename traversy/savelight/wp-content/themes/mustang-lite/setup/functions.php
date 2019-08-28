<?php
/**
 * Additional functions
 *
 * @package    Mustang
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.8.2
 * @version  1.8.2
 */





/**
 * WebMan Amplifier legacy functions
 */

	/**
	 * Color brightness detection
	 *
	 * @since    1.8.2
	 * @version  1.8.2
	 *
	 * @param  string $hex
	 *
	 * @return  integer (0-255)
	 */
	if ( ! function_exists( 'wma_color_brightness' ) ) {
		function wma_color_brightness( $hex ) {

			// Helper variables

				$output = '';


			// Processing

				if ( function_exists( 'wma_color_hex_to_rgb' ) ) {

					$rgb = wma_color_hex_to_rgb( $hex );

					if ( ! empty( $rgb ) ) {
						$output = absint( ( ( $rgb['r'] * 299 ) + ( $rgb['g'] * 587 ) + ( $rgb['b'] * 114 ) ) / 1000 );
					}

				}


			// Output

				return apply_filters( 'wmhook_wmamp_wma_color_brightness_output', $output, $hex );

		}
	} // /wma_color_brightness



	/**
	 * Alter color brightness
	 *
	 * @since    1.8.2
	 * @version  1.8.2
	 *
	 * @param  string $hex
	 * @param  integer $step
	 *
	 * @return  string Hex color.
	 */
	if ( ! function_exists( 'wma_alter_color_brightness' ) ) {
		function wma_alter_color_brightness( $hex, $step ) {

			// Helper variables

				$output = '';


			// Processing

				if ( function_exists( 'wma_color_hex_to_rgb' ) ) {

					$rgb = wma_color_hex_to_rgb( $hex );

					if ( ! empty( $rgb ) ) {
						foreach ( $rgb as $key => $value ) {
							$new_hex_part = dechex( max( 0, min( 255, $value + intval( $step ) ) ) );
							$rgb[ $key ]  = ( 1 == strlen( $new_hex_part ) ) ? ( '0' . $new_hex_part ) : ( $new_hex_part );
						}

						$output = '#' . implode( '', $rgb );
					}

				}


			// Output

				return apply_filters( 'wmhook_wmamp_wma_alter_color_brightness_output', $output, $hex, $step );

		}
	} // /wma_alter_color_brightness



	/**
	 * Modifying input color by changing brightness in response to treshold
	 *
	 * @since    1.8.2
	 * @version  1.8.2
	 *
	 * @param  string $color  Hex color
	 * @param  integer $dark_light  Brightness modification when below treshold (array or number) [-255,255]
	 * @param  string $addons  Additional CSS rules (such as "!important")
	 * @param  integer $treshold  [0,255]
	 *
	 * @return  string Hex color.
	 */
	if ( ! function_exists( 'wma_contrast_color' ) ) {
		function wma_contrast_color( $color, $dark_light, $addons = '', $treshold = 0 ) {

			// Requirements check

				if ( ! trim( $color ) ) {
					return;
				}


			// Helper variables

				$output = '';

				if ( ! $treshold && defined( 'WMAMP_COLOR_BRIGHTNESS_TRESHOLD' ) ) {
					$treshold = apply_filters( 'wmhook_wmamp_wma_contrast_color_default_treshold', WMAMP_COLOR_BRIGHTNESS_TRESHOLD );
				}
				$treshold = apply_filters( 'wmhook_wmamp_color_brightness_treshold', $treshold );

				if ( is_array( $dark_light ) ) {
					$dark  = intval( $dark_light[0] );
					$light = ( isset( $dark_light[1] ) ) ? ( intval( $dark_light[1] ) ) : ( -$dark );
				} else {
					$dark  = intval( $dark_light );
					$light = -$dark;
				}


			//  Processing

				$output = ( $treshold > wma_color_brightness( $color ) ) ? ( wma_alter_color_brightness( $color, $dark ) ) : ( wma_alter_color_brightness( $color, $light ) );

				if ( $output ) {
					$output .= $addons;
				}


			// Output

				return apply_filters( 'wmhook_wmamp_wma_contrast_color_output', $output, $color, $dark_light, $addons, $treshold );

		}
	} // /wma_contrast_color



	/**
	 * Hex color to RGB
	 *
	 * @since    1.8.2
	 * @version  1.8.2
	 *
	 * @param  string $hex
	 *
	 * @return  array( 'r' => [0-255], 'g' => [0-255], 'b' => [0-255] )
	 */
	if ( ! function_exists( 'wma_color_hex_to_rgb' ) ) {
		function wma_color_hex_to_rgb( $hex ) {

			// Helper variables

				$rgb = array();

				$hex = trim( $hex, '#' );
				$hex = preg_replace( '/[^0-9A-Fa-f]/', '', $hex );
				$hex = substr( $hex, 0, 6 );

			// Processing

				$color = (int) hexdec( $hex );

				$rgb['r'] = (int) 0xFF & ( $color >> 0x10 );
				$rgb['g'] = (int) 0xFF & ( $color >> 0x8 );
				$rgb['b'] = (int) 0xFF & $color;


			// Output

				return (array) apply_filters( 'wmhook_wmamp_wma_color_hex_to_rgb_output', $rgb, $hex );

		}
	} // /wma_color_hex_to_rgb



	/**
	 * Taxonomy list
	 *
	 * @since    1.8.2
	 * @version  1.8.2
	 *
	 * @param  array $args
	 *
	 * @return  array Array of taxonomy slug => name.
	 */
	if ( ! function_exists( 'wma_taxonomy_array' ) ) {
		function wma_taxonomy_array( $args = array() ) {

			// Helper variables

				$output = array();

				$args = wp_parse_args( $args, array(

					// "All" option

						// Display "all" option?
						'all' => true,
						// Post type to count posts for "all" option. Not displayed if left empty.
						'all_post_type' => 'post',
						// "All" option text.
						'all_text' => '- ' . esc_html__( 'All posts', 'mustang-lite' ),

					// Query settings

						'order_by'   => 'name',
						'hide_empty' => 0,
						// Is taxonomy hierarchical?
						'hierarchical' => '1',
						// Should return parent (highest level) terms only?
						'parents_only' => false,

					// Default returns

						'tax_name' => 'category',
						// What should be returned from the term, `slug` or `term_id`?
						'return' => 'slug',

				) );


			// Requirements check

				if ( ! taxonomy_exists( $args['tax_name'] ) ) {
					return (array) apply_filters( 'wmhook_wmamp_taxonomy_array', $output, $args );
				}


			// Processing

				// Get terms

					$terms = get_terms(
						$args['tax_name'],
						array(
							'orderby'      => $args['order_by'],
							'hide_empty'   => $args['hide_empty'],
							'hierarchical' => $args['hierarchical'],
						)
					);

				// Set "All" option

					if ( $args['all'] ) {

						if ( ! $args['all_post_type'] ) {
							$all_count = '';
						} else {
							$readable  = ( in_array( $args['all_post_type'], array( 'post', 'page' ) ) ) ? ( 'readable' ) : ( null );
							$all_count = wp_count_posts( $args['all_post_type'], $readable );
							$all_count = ' (' . absint( $all_count->publish ) . ')';
						}

						$output[''] = (string) apply_filters( 'wmhook_wmamp_taxonomy_array_all', $args['all_text'] . $all_count, $args, $all_count );

					}

				// Adding actual terms into output array

					if ( ! is_wp_error( $terms ) && is_array( $terms ) && ! empty( $terms ) ) {
						foreach ( $terms as $term ) {

							// Converting object to array to prevent PHP issues with passing the `$args['return']` value.
							$term = (array) $term;

							if ( ! $args['parents_only'] ) {
							// All terms including children

								$output[ $term[ $args['return'] ] ]  = $term['name'];
								$output[ $term[ $args['return'] ] ] .= ( ! $args['all_post_type'] ) ? ( '' ) : ( (string) apply_filters( 'wmhook_wmamp_taxonomy_array_count', ' (' . $term['count'] . ')', $args, $term['count'] ) );

							} elseif ( $args['parents_only'] && empty( $term['parent'] ) ) {
							// Get only parent terms and no children

								$output[ $term[ $args['return'] ] ]  = $term['name'];
								$output[ $term[ $args['return'] ] ] .= ( ! $args['all_post_type'] ) ? ( '' ) : ( (string) apply_filters( 'wmhook_wmamp_taxonomy_array_count', ' (' . $term['count'] . ')', $args, $term['count'] ) );

							}

						}
					}

				// Sort the array alphabetically

					if ( ! $args['hierarchical'] ) {
						asort( $output );
					}


			// Output

				return (array) apply_filters( 'wmhook_wmamp_wma_taxonomy_array_output', $output, $args );

		}
	} // /wma_taxonomy_array



	/**
	 * Sidebar (display widget area)
	 *
	 * @since    1.8.2
	 * @version  1.8.2
	 *
	 * @param  array $atts  Setup attributes.
	 *
	 * @return  Sidebar HTML (with a special class of number of included widgets).
	 */
	if ( ! function_exists( 'wma_sidebar' ) ) {
		function wma_sidebar( $atts = array() ) {

			// Helper variables

				$output = '';

				$atts = wp_parse_args( $atts, array(
					'attributes'        => '',
					'class'             => 'widget-area',
					'max_widgets_count' => 0,
					'sidebar'           => 'sidebar-1',
					'tag'               => 'div',
					'wrapper'           => array(
						'open'  => '',
						'close' => '',
					),
				) );

				// Validation

					$atts['class'] = trim( 'wm-sidebar ' . trim( $atts['class'] ) );

					$atts['max_widgets_count'] = absint( $atts['max_widgets_count'] );

					$atts['sidebar'] = trim( $atts['sidebar'] );
					if ( ! $atts['sidebar'] ) {
						$atts['sidebar'] = 'sidebar-1';
					}

					$atts['widgets'] = wp_get_sidebars_widgets();
					if ( ! is_array( $atts['widgets'] ) ) {
						$atts['widgets'] = array();
					}
					if ( isset( $atts['widgets'][ $atts['sidebar'] ] ) ) {
						$atts['widgets'] = $atts['widgets'][ $atts['sidebar'] ];
						$atts['class']  .= ' widgets-count-' . count( $atts['widgets'] );
					} else {
						$atts['widgets'] = array();
					}

					if (
						! is_array( $atts['wrapper'] )
						&& ! isset( $atts['wrapper']['open'] )
						&& ! isset( $atts['wrapper']['close'] )
					) {
						$atts['wrapper'] = array(
							'open'  => '',
							'close' => '',
						);
					}

					$atts['class'] = (string) apply_filters( 'wmhook_wmamp_sidebar_classes', $atts['class'] );
					$atts['class'] = (string) apply_filters( 'wmhook_wmamp_sidebar_classes_' . $atts['sidebar'], $atts['class'] );

					if ( in_array( 'sidebar', explode( ' ', $atts['class'] ) ) ) {
						$atts['tag'] = 'aside';
					}

					$atts = (array) apply_filters( 'wmhook_wmamp_sidebar_atts', $atts );
					$atts = (array) apply_filters( 'wmhook_wmamp_sidebar_atts_' . $atts['sidebar'], $atts );


			// Processing

				if (
					is_active_sidebar( $atts['sidebar'] )
					&& (
						0 === $atts['max_widgets_count']
						|| $atts['max_widgets_count'] >= count( $atts['widgets'] )
					)
				) {

					$output .= $atts['wrapper']['open'];

						// Action: Sidebar before
						if ( function_exists( 'wmhook_sidebars_before' ) ) {
							$output .= wmhook_sidebars_before();
						}

						$output .= "\r\n\r\n";
						$output .= '<'
						         . tag_escape( $atts['tag'] )
						         . ' class="' . esc_attr( $atts['class'] ) . '"'
						         . ' data-id="' . esc_attr( $atts['sidebar'] ) . '"'
						         . ' data-widgets-count="' . count( $atts['widgets'] ) . '"'
						         . $atts['attributes']
						         . '>';
						$output .= "\r\n";

							$output .= (string) apply_filters( 'wmhook_wmamp_sidebar_widgets_pre', '', $atts );

							// Action: Sidebar top
							if ( function_exists( 'wmhook_sidebar_top' ) ) {
								$output .= wmhook_sidebar_top();
							}

							ob_start();
							dynamic_sidebar( $atts['sidebar'] );
							$output .= ob_get_clean();

							// Action: Sidebar bottom
							if ( function_exists( 'wmhook_sidebar_bottom' ) ) {
								$output .= wmhook_sidebar_bottom();
							}

							$output .= (string) apply_filters( 'wmhook_wmamp_sidebar_widgets_post', '', $atts );

						$output .= "\r\n";
						$output .= '</' . tag_escape( $atts['tag'] ) . '>';
						$output .= "\r\n\r\n";

						// Action: Sidebar after
						if ( function_exists( 'wmhook_sidebars_after' ) ) {
							$output .= wmhook_sidebars_after();
						}

					$output .= $atts['wrapper']['close'];

				}

				$output = (string) apply_filters( 'wmhook_wmamp_sidebar', $output, $atts );
				$output = (string) apply_filters( 'wmhook_wmamp_sidebar_' . $atts['sidebar'], $output, $atts );


			// Output

				return (string) apply_filters( 'wmhook_wmamp_wma_sidebar_output', $output, $atts );

		}
	} // /wma_sidebar
