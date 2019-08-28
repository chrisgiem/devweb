<?php
/**
 * Default WordPress loop content
 *
 * @package    WebMan WordPress Theme Framework
 * @copyright  2014 WebMan - Oliver Juhas
 *
 * @since    1.0
 * @version  1.7
 */



if ( have_posts() ) {

	wmhook_postslist_before();

	echo '<div id="list-articles" class="list-articles clearfix"' . wm_schema_org( 'item_list' ) . '>';

		wmhook_postslist_top();

		while ( have_posts() ) :

			the_post();

			get_template_part( 'content', get_post_format() );

		endwhile;

		wmhook_postslist_bottom();

	echo '</div>';

	wmhook_postslist_after();

} else {

	wm_not_found();

}

wp_reset_query();
