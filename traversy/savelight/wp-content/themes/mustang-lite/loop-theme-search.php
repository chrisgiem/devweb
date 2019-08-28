<?php
/**
 * Search results
 *
 * @package    WebMan WordPress Theme Framework
 * @copyright  2014 WebMan - Oliver Juhas
 *
 * @since    1.0
 * @version  1.6
 */



if ( have_posts() ) {

	wmhook_postslist_before();

	echo '<div id="list-articles" class="list-articles list-search clearfix"' . wm_schema_org( 'item_list' ) . '>';

		wmhook_postslist_top();

		while ( have_posts() ) :

			the_post();

			$output  = '<article class="search-item"' . wm_schema_org( 'article' ) . '>';

			$output .= '<header class="entry-header"><h1 class="entry-title"' . wm_schema_org( 'name' ) . '>';
				if ( has_post_thumbnail() ) {
					$thumb_size = 'admin-thumbnail';

					$output .= '<a href="' . get_permalink() . '" title="' . esc_attr( get_the_title() ) . '">';
					$output .= get_the_post_thumbnail( get_the_ID(), $thumb_size );
					$output .= '</a>';
				}
				$output .= '<a href="' . get_permalink() . '">';
				$output .= get_the_title();
				$output .= '</a>';
			$output .= '</h1></header>';

			$output .= wm_excerpt();

			$output .= ( 'page' === get_post_type() ) ? ( wm_post_meta( apply_filters( 'wmhook_search_page_meta', array( 'meta' => array( 'permalink' ) ) ) ) ) : ( wm_post_meta() );

			$output .= '</article>';

			echo $output;

		endwhile;

		wmhook_postslist_bottom();

	echo '</div>';

	wmhook_postslist_after();

} else {

	wm_not_found();

}

wp_reset_query();
