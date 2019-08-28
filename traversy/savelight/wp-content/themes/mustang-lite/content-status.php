<?php
/**
 * Status post format content
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

	echo get_avatar( get_the_author_meta( 'ID' ), 120 );

	echo apply_filters( 'wmhook_content_filters', get_the_content() );

	wmhook_entry_bottom();
	?>

</article>