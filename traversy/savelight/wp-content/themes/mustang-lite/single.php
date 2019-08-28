<?php
/**
 * Post template
 *
 * @package    WebMan WordPress Theme Framework
 * @copyright  2014 WebMan - Oliver Juhas
 *
 * @since    1.0
 * @version  1.8.1
 */



/**
 * Homepage redirect
 *
 * Applies on custom posts that don't need a single post view.
 */

	$redirects = (array) apply_filters( 'wmhook_custom_post_redirects', array(
			'wm_logos'        => home_url(),
			'wm_modules'      => home_url(),
			'wm_staff'        => home_url(),
			'wm_testimonials' => home_url(),
		) );
	if ( in_array( get_post_type( $post->ID ), array_keys( $redirects ) ) ) {
		wp_redirect( $redirects[ get_post_type( $post->ID ) ], 301 );
		exit;
	}



/**
 * Redirect Projects with custom link applied
 *
 * @since  1.1
 */

	if (
			function_exists( 'wma_meta_option' )
			&& 'wm_projects' == get_post_type( $post->ID )
			&& wma_meta_option( 'link-action', $post->ID )
		) {
		wp_redirect( esc_url( wma_meta_option( 'link', $post->ID ) ), 301 );
		exit;
	}



/**
 * Actual single post content
 */

	get_header();

	if ( class_exists( 'WM_Amplifier' ) ) {
		get_template_part( 'loop', 'singular' );
	} else {
		get_template_part( 'loop', 'post' );
	}

	get_footer();
