<?php
/**
 * Quote post format content
 *
 * @package     WebMan WordPress Theme Framework
 * @subpackage  Post Formats
 * @copyright   2014 WebMan - Oliver Juhas
 */



?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); echo wm_schema_org( 'article' ); ?>>

	<?php
	wm_post_title( false );

	wmhook_entry_top();

	//Featured image
		if ( has_post_thumbnail() ) {
			$image_size = apply_filters( 'wmhook_quote_post_thumbnail_image_size', 'admin-thumbnail' );

			echo '<div class="quote-container has-thumbnail">';

			echo wm_thumb( array(
					'attr-link' => wm_schema_org( 'image' ),
					'link'      => '',
					'size'      => $image_size,
				) );
		} else {
			echo '<div class="quote-container">';
		}

	echo apply_filters( 'wmhook_content_filters', get_the_content() );

	echo '</div>';

	wmhook_entry_bottom();
	?>

</article>