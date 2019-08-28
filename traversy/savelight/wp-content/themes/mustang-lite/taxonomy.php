<?php
/**
 * Taxonomies template
 *
 * @package    WebMan WordPress Theme Framework
 * @copyright  2014 WebMan - Oliver Juhas
 *
 * @since    1.0
 * @version  1.7
 */



//Get the taxonomy name
	$taxonomy_name = get_query_var( 'taxonomy' );

//Redirect taxonomies
	$redirects = apply_filters( 'wmhook_taxonomy_redirects', array(
			'home_page'      => array( 'logo_category', 'testimonial_category', 'staff_department', 'staff_position', 'module_tag' ),
			'portfolio_page' => array( 'project_category', 'project_tag' ),
		) );

//Get Portfolio page ID
	if ( class_exists( 'breadcrumb_navxt' ) ) {

		$portfolio_page_ID = get_option( 'bcn_options' );
		$portfolio_page_ID = ( isset( $portfolio_page_ID['apost_wm_projects_root'] ) ) ? ( $portfolio_page_ID['apost_wm_projects_root'] ) : ( 0 );

	} else {

		$portfolio_page_ID = get_option( 'page_on_front' );

	}

	$portfolio_page_ID = absint( apply_filters( 'wmhook_taxonomy_portfolio_page_ID', get_option( 'page_on_front' ) ) );

//Set redirect rules
	if (
			in_array( $taxonomy_name, $redirects['portfolio_page'] )
			&& $portfolio_page_ID
		) {

		wp_redirect( get_permalink( $portfolio_page_ID ), 301 );
		exit;

	} elseif (
			in_array( $taxonomy_name, $redirects['home_page'] )
		) {

		wp_redirect( home_url(), 301 );
		exit;

	}

//Fallback
	get_template_part( 'index' );
