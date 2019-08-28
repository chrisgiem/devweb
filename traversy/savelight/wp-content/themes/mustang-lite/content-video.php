<?php
/**
 * Video post format content
 *
 * @package     WebMan WordPress Theme Framework
 * @subpackage  Post Formats
 * @copyright   2014 WebMan - Oliver Juhas
 *
 * @since    1.0
 * @version  1.1
 */



$is_single         = ( is_home() && apply_filters( 'wmhook_enable_blog_full_posts', false ) ) ? ( true ) : ( is_single() );
$pagination_suffix = wm_paginated_suffix( 'small', 'post' );
$content           = get_the_content();

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); echo wm_schema_org( 'article' ); ?>>

	<?php if ( ! $pagination_suffix ) : ?>

	<div class="post-media">
		<?php
		/**
		 * Post media
		 */
		$media_shortcode = '';

		//Search for the shortcode
			$pattern = '/\[[video,playlist](.*)\]/';
			preg_match( $pattern, strip_tags( $content ), $matches );
			if ( isset( $matches[0] ) ) {
				$media_shortcode = trim( $matches[0] );
			}
			if ( ! $media_shortcode ) {
				$pattern = '/\[wm_video(.*)\]/';
				preg_match( $pattern, strip_tags( $content ), $matches );
				if ( isset( $matches[0] ) ) {
					$media_shortcode = trim( $matches[0] );
				}
			}

		//Preparing content output
			if ( ! $is_single ) {
				$content = wm_content_or_excerpt( $post );
			}

			//Remove the shortcode from content
				if ( $media_shortcode ) {
					$content = str_replace( $media_shortcode, '', $content );
				}

		//Output media
			if ( $media_shortcode ) {
				echo do_shortcode( $media_shortcode );
			}

		//If no video display featured image
			if (
					! $is_single
					&& ! $media_shortcode
				) {
				$image_size = apply_filters( 'wmhook_post_thumbnail_image_size', wm_option( 'skin-image-blog' ) );
				if ( ! $image_size ) {
					$image_size = WM_DEFAULT_IMAGE_SIZE;
				}

				echo wm_thumb( array(
						'attr-link' => wm_schema_org( 'image' ),
						'link'      => get_permalink(),
						'size'      => $image_size,
					) );
			}
		?>
	</div>

	<?php
	endif;



	/**
	 * Post title
	 */

		wm_post_title();



	/**
	 * Post content
	 */
	if ( $is_single ) {

		//Outputs full post content including excerpt at the top
			wmhook_entry_top();

			if (
					has_excerpt()
					&& ! $pagination_suffix
					&& ! wm_option( 'blog-disable-single-post-excerpt' )
				) {
				echo wm_excerpt();
			}

			//Content is stripped out fo media
				echo apply_filters( 'the_content', $content );

			wmhook_entry_bottom();

	} else {

		//Outputs excerpt or content until <!--more--> tag
			echo $content; //filters already applied in wm_content_or_excerpt()

	}
	?>

</article>