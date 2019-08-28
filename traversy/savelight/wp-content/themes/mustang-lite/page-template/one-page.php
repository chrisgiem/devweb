<?php
/**
 * Custom page template
 *
 * Template Name: One page with anchor navigation
 *
 * @package     WebMan WordPress Theme Framework
 * @subpackage  Page Templates
 * @copyright   2014 WebMan - Oliver Juhas
 *
 * @since    1.0
 * @version  1.8.1
 */



get_header();

if ( class_exists( 'WM_Amplifier' ) ) {
	get_template_part( 'loop', 'singular' );
}

get_footer();
