<?php
/**
 * Blog page template loop
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

	global $wm_blog_page_id;

	$wm_blog_page_id = get_the_ID();

	$blog_posts = wm_blog_page_query();



/**
 * Actual loop
 */
if ( $blog_posts->have_posts() ) {

	wmhook_postslist_before();

	echo '<div id="list-articles" class="list-articles clearfix"' . wm_schema_org( 'item_list' ) . '>';

		wmhook_postslist_top();

		while ( $blog_posts->have_posts() ) :

			$blog_posts->the_post();

			get_template_part( 'content', get_post_format() );

		endwhile;

		wmhook_postslist_bottom();

	echo '</div>';

	wmhook_postslist_after();

} else {

	wm_not_found();

}

wp_reset_query();
