<?php
/**
 * Error 404 page template
 *
 * @package    WebMan WordPress Theme Framework
 * @copyright  2014 WebMan - Oliver Juhas
 *
 * @since    1.0
 * @version  1.6
 */



get_header(); ?>

<div class="wrap-inner">

	<div class="content-area site-content twelve pane">

		<?php wmhook_entry_before(); ?>

		<article id="error-404" class="error-404">

			<?php

			wmhook_entry_top();

			$output  = '<h1>' . __( 'Page not found', 'mustang-lite' ) . '</h1>';
			$output .= '<p>' . __( 'The page you are looking for was moved, deleted or does not exist. Maybe try searching:', 'mustang-lite' ) . '</p>';
			$output .= '<div class="error-404-search">' . get_search_form( false ) . '</div>';
			$output .= '<p>' . sprintf( '<a href="%s" class="wm-button">' . __( 'Return to homepage', 'mustang-lite' ) . '</a>', home_url() ) . '</p>';

			echo do_shortcode( $output );

			wmhook_entry_bottom();

			?>

		</article>

		<?php wmhook_entry_after(); ?>

	</div>

</div>

<?php get_footer(); ?>
