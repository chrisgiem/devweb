<?php
/**
 * Custom page template
 *
 * Template Name: Blank page
 *
 * @package     WebMan WordPress Theme Framework
 * @subpackage  Page Templates
 * @copyright   2014 WebMan - Oliver Juhas
 *
 * @since    1.0
 * @version  1.9.0
 */



get_header();

if ( class_exists( 'WM_Amplifier' ) ) {
	get_template_part( 'loop', 'singular' );
}

get_footer();
