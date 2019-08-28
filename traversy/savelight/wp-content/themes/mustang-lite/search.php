<?php
/**
 * Search results page template
 *
 * Have to use "theme-" prefix for search loop to retain support with plugins,
 * such as bbPress.
 *
 * @package    WebMan WordPress Theme Framework
 * @copyright  2014 WebMan - Oliver Juhas
 */



get_header(); ?>

<div class="wrap-inner">

	<div class="content-area site-content twelve pane">

		<?php

		wmhook_entry_before();

		get_template_part( 'loop', 'theme-search' );

		wmhook_entry_after();

		?>

	</div>

</div>

<?php get_footer(); ?>