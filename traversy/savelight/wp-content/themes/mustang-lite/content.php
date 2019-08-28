<?php
/**
 * Standard post format content
 *
 * @package     WebMan WordPress Theme Framework
 * @subpackage  Post Formats
 * @copyright   2014 WebMan - Oliver Juhas
 *
 * @since    1.0
 * @version  1.3
 */



$is_single         = ( is_home() && apply_filters( 'wmhook_enable_blog_full_posts', false ) ) ? ( true ) : ( is_single( get_the_ID() ) || is_page( get_the_ID() ) );
$pagination_suffix = wm_paginated_suffix( 'small', 'post' );

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); echo wm_schema_org( 'article' ); ?>>

	<?php
	/**
	 * Post media
	 */
	if ( has_post_thumbnail() && ! $pagination_suffix ) {
		$image_size = apply_filters( 'wmhook_post_thumbnail_image_size', wm_option( 'skin-image-blog' ) );
		if ( ! $image_size ) {
			$image_size = WM_DEFAULT_IMAGE_SIZE;
		}

		if (
				$is_single
				&& ! apply_filters( 'wmhook_disable_single_featured_image', false )
				&& ! ( function_exists( 'wma_meta_option' ) && wma_meta_option( 'disable-featured-image' ) )
			) {
			echo '<div class="post-media"' . wm_schema_org( 'image' ) . '>' . wm_thumb( array(
					'class' => 'image-container post-thumbnail scale-rotate',
					'link'  => 'bigimage',
					'size'  => 'content-width',
				) ) . '</div>';
		} elseif ( ! $is_single ) {
			echo '<div class="post-media"' . wm_schema_org( 'image' ) . '>' . wm_thumb( array(
					'class' => 'image-container post-thumbnail scale-rotate',
					'link'  => get_permalink(),
					'size'  => $image_size,
				) ) . '</div>';
		}
	}



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

			the_content();

			wmhook_entry_bottom();

	} else {

		//Outputs excerpt or content until <!--more--> tag
			echo wm_content_or_excerpt( $post );

	}
	?>

</article>