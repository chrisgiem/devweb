<?php
/**
 * Blog page template
 * Custom page template
 *
 * Template Name: Blog
 *
 * @package     WebMan WordPress Theme Framework
 * @subpackage  Page Templates
 * @copyright   2014 WebMan - Oliver Juhas
 *
 * @since    1.0
 * @version  1.8.1
 */



/**
 * Sidebar implementation
 *
 * Variables setup
 */

	$page_id = ( is_home() ) ? ( get_option( 'page_for_posts' ) ) : ( null );
	$sidebar = wm_sidebar_setup( false, array( 'page_id' => $page_id ) );

	if ( ! class_exists( 'WM_Amplifier' ) ) {
		$sidebar['class_main'] = ' eight pane';
	}



/**
 * Actual output
 */

get_header();

?>

<div class="wrap-inner">

	<div class="content-area site-content<?php echo $sidebar['class_main']; ?>">

		<?php

		wmhook_entry_before();

		//Blog page content
			$content = get_post( $page_id );
			if ( is_home() && ! $page_id ) {
				$content = false;
			}

			if (
					$content
					&& ( isset( $paged ) && 2 > $paged && $content )
				) {

					$content = $content->post_content;
					$content = apply_filters( 'the_content', $content );
					$content = str_replace( ']]>', ']]&gt;', $content );

					if ( $content ) {
						echo '<article id="post-' . $page_id . '" class="' . implode( ' ', get_post_class( '', $page_id ) ) . '"' . wm_schema_org( 'article' ) . '>';

							wmhook_entry_top();

							echo $content;

							wmhook_entry_bottom();

						echo '</article>';
					}

			}

		wmhook_entry_after();

		//Blog posts list
			if ( class_exists( 'WM_Amplifier' ) ) {
				$loop_type = ( is_page_template( 'home.php' ) && ! is_home() ) ? ( 'blog' ) : ( 'index' );
				get_template_part( 'loop', $loop_type );
			} else {
				get_template_part( 'loop', 'index' );
			}

		?>

	</div>

	<?php
	/**
	 * Sidebar implementation
	 *
	 * Output
	 */

		if ( ! class_exists( 'WM_Amplifier' ) ) {
			get_sidebar();
		} else {
			echo $sidebar['output'];
		}
	?>

</div>

<?php get_footer(); ?>
