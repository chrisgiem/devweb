<?php
/**
 * Single page content
 *
 * @package    WebMan WordPress Theme Framework
 * @copyright  2014 WebMan - Oliver Juhas
 *
 * @since    1.1.1
 * @version  1.7
 */



echo "\r\n\r\n" . '<div class="wrap-inner">';

	echo "\r\n\t" . '<div class="content-area site-content eight pane">' . "\r\n\r\n";

	wmhook_entry_before();

	if ( have_posts() ) {

		the_post();

		echo '<article id="post-' . get_the_ID() . '" class="' . implode( ' ', get_post_class() ) . '"' . wm_schema_org( 'article' ) . '>';

			wmhook_entry_top();

				the_content();

			wmhook_entry_bottom();

		echo '</article>';

		wp_reset_query();

	} // /have_posts()

	wmhook_entry_after();

	echo "\r\n\r\n\t" . '</div> <!-- /content-area -->';

	get_sidebar();

echo "\r\n" . '</div> <!-- /wrap-inner -->' . "\r\n\r\n";
