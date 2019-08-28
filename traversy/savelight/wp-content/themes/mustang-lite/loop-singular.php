<?php
/**
 * Single page/post/custom post content
 *
 * This template file provides HTML output for post, custom post and page
 * content.
 *
 * Content can be created with split Section shortcodes, which inserts
 * a horizontal fullwidth content area that can be styled separately from
 * others. The processing of this functionality is managed in this file.
 * (Page layout option must be set to "Fullwidth sections".)
 *
 * It outputs a sidebar according to the theme default sidebar layout, except
 * for specific post types set in $sidebar_none_posts variable. These post
 * types will get fullwidth page layout by default, with no sidebar.
 * Also, sidebar is disabled when "Fullwidth sections" page layout used. You
 * can lay out the sidebar in Sections shortcodes (rows) with columns and
 * widget area shortcodes (set class of "sidebar" for widget area shortcode).
 *
 * @package    WebMan WordPress Theme Framework
 * @copyright  2014 WebMan - Oliver Juhas
 *
 * @since    1.0
 * @version  1.7
 */



/**
 * Helper variables
 */

	$content_area_class = '';

	$sidebar_none_posts = apply_filters( 'wmhook_sidebar_none_posts', array(
			'wm_projects',
			'page',
		) );
	$sidebar_none_posts = is_singular( $sidebar_none_posts );

	if (
			function_exists( 'wma_meta_option' )
			&& 'sections' == wma_meta_option( 'sidebar' )
		) {
		$sections_layout = true;
	} else {
		$sections_layout = false;
	}



/**
 * Sidebar implementation
 *
 * Variables setup
 */

	$sidebar = wm_sidebar_setup();



/**
 * Actual page/post output
 */

	if ( ! $sections_layout ) {
		echo "\r\n\r\n" . '<div class="wrap-inner">';

		$content_area_class = $sidebar['class_main'];
	}



		echo "\r\n\t" . '<div class="content-area site-content' . $content_area_class . '">' . "\r\n\r\n";



		wmhook_entry_before();

		if ( have_posts() ) {

			the_post();

			if ( $sidebar_none_posts ) {

				/**
				 * Remove JetPack sharing when Sections used
				 */

					if ( $sections_layout ) {
						remove_filter( 'the_content', 'sharing_display', 19 );
					}

				echo '<article id="post-' . get_the_ID() . '" class="' . implode( ' ', get_post_class() ) . '"' . wm_schema_org( 'article' ) . '>';

						wmhook_entry_top();

						the_content();

						wmhook_entry_bottom();

				echo '</article>';

			} else {

				$content_type = '';

				if ( is_singular( 'post' ) ) {
					$content_type = get_post_format();
				} elseif ( get_post_type() ) {
					$content_type = 'type-' . get_post_type();
				}

				get_template_part( 'content', apply_filters( 'wmhook_loop_singular_content_type', $content_type ) );

			}

			wp_reset_query();

		} // /have_posts()

		wmhook_entry_after();



		echo "\r\n\r\n\t" . '</div> <!-- /content-area -->';



	if ( ! $sections_layout ) {
		/**
		 * Sidebar implementation
		 *
		 * Output
		 */

			echo $sidebar['output'];

		echo "\r\n" . '</div> <!-- /wrap-inner -->' . "\r\n\r\n";
	}
