<?php
/**
 * Comments list template
 *
 * @package    WebMan WordPress Theme Framework
 * @copyright  2014 WebMan - Oliver Juhas
 *
 * @since    1.0
 * @version  1.8.1
 */



/**
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}


/**
 * Display comments container only if comments open
 * and there are some comments to display
 */
if (
		( is_single( get_the_ID() ) || is_singular( 'wm_project' ) || is_page( get_the_ID() ) )
		&& ( comments_open() || have_comments() )
		&& ! is_attachment()
	) {

	$output = '';

	$output .= '<div id="comments" class="comments-area">';

		$output .= '<h2 id="comments-title" class="comments-title" title="' . sprintf( __( 'Comments: %s', 'mustang-lite' ), get_comments_number() ) . '"><span class="screen-reader-text">' . __( 'Comments:', 'mustang-lite' ) . '</span><span class="comments-count">' . get_comments_number() . '</span></h2>';


		if ( have_comments() ) {

			if ( ! comments_open() ) {
				$output .= '<h3 class="comments-closed">' . __( 'Comments are closed. You can not add new comments.', 'mustang-lite' ) . '</h3>';
			}

			//Paginated comments
				if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) {
					$output .= wm_comments_navigation( 'comment-nav-above' );
				}

			//Actual comments list
				$output .= '<ol class="comment-list">';
				$output .=  wp_list_comments( array(
						'avatar_size' => 120,
						'short_ping'  => true,
						'style'       => 'ol',
						'echo'        => false,
					) );
				$output .= '</ol>';

			//Paginated comments
				if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) {
					$output .= wm_comments_navigation( 'comment-nav-below' );
				}

		} // /have_comments()

		//Comments form only if comments open
			if ( comments_open() ) {
				ob_start();
				comment_form( apply_filters( 'wmhook_comment_form_args', array(
						'comment_notes_after' => '',
					) ) );
				$output .= ob_get_clean();
			}

	$output .= '</div><!-- #comments -->';

	wmhook_comments_before();

	if ( ! class_exists( 'WM_Amplifier' ) ) {
		echo '<div class="wm-row clearfix row-shortcode">' . $output . '</div>';
	} else {
		echo do_shortcode( '[wm_row]' . $output . '[/wm_row]' );
	}

	wmhook_comments_after();

}
