<?php
/**
 * Posts shortcode item template
 *
 * Simple wm_projects item template
 * Consist of:
 * 		image,
 * 		title
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 *
 * @since    1.0
 * @version  1.9.1
 *
 * @uses        array $helper  Contains shortcode $atts array plus additional helper variables.
 */



$link_output = array( '', '' );

if ( $helper['link'] ) {
	$link_output = array( '<a' . $helper['link'] . wm_schema_org( 'bookmark' ) . '>', '</a>' );
}

$project_preview = trim( wma_meta_option( 'slider' ) );
?>

<article class="<?php echo esc_attr( $helper['item_class'] ); ?>"<?php echo wm_schema_org( 'creative_work' ); ?>>

	<?php
	if ( $project_preview ) {
		echo '<div class="wm-posts-element wm-html-element slider">';

			echo $link_output[0] . do_shortcode( $project_preview ) . $link_output[1];

		echo '</div>';
	} elseif ( has_post_thumbnail( $helper['post_id'] ) ) {
		echo '<div class="wm-posts-element wm-html-element image image-container scale-rotate"' . wm_schema_org( 'image' ) . '>';

			echo $link_output[0];

			the_post_thumbnail( $helper['image_size'], array( 'title' => esc_attr( get_the_title( get_post_thumbnail_id( $helper['post_id'] ) ) ) ) );

			echo $link_output[1];

		echo '</div>';
	}
	?>

	<div class="wm-posts-element wm-html-element title<?php if ( $project_preview ) echo ' screen-reader-text'; ?>"><?php
		echo '<' . tag_escape( $helper['atts']['heading_tag'] ) . wm_schema_org( 'name' ) . '>';

			echo $link_output[0];

			the_title();

			echo $link_output[1];

		echo '</' . tag_escape( $helper['atts']['heading_tag'] ) . '>';
	?></div>

</article>
