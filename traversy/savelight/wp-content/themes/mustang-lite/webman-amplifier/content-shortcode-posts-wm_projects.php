<?php
/**
 * Posts shortcode item template
 *
 * Default wm_projects item template
 * Consist of:
 * 		image/slider,
 * 		title,
 * 		taxonomy:project_category,
 * 		excerpt
 *
 * You can redefine this template by redefining this file (keep the file name)
 * in the YOUR_THEME/webman-amplifier/ folder.
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

	<div class="wm-posts-element wm-html-element title"><?php
		echo '<' . tag_escape( $helper['atts']['heading_tag'] ) . wm_schema_org( 'name' ) . '>';

			echo $link_output[0];

			the_title();

			echo $link_output[1];

		echo '</' . tag_escape( $helper['atts']['heading_tag'] ) . '>';
	?></div>

	<?php
		$terms       = get_the_terms( $helper['post_id'], 'project_category' );
		$terms_array = array();
		if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
			foreach( $terms as $term ) {
				$terms_array[] = '<span class="term term-' . sanitize_html_class( $term->slug ) . '"' . wm_schema_org( 'itemprop="keywords"' ) . '>' . $term->name . '</span>';
			}
			echo '<div class="wm-posts-element wm-html-element taxonomy">' . implode( ', ', $terms_array ) . '</div>' ;
		}
	?>

	<?php
	/*
		if ( 0 < $helper['excerpt_length'] ) {
			echo '<div class="wm-posts-element wm-html-element excerpt"' . wm_schema_org( 'description' ) . '>' . wp_trim_words( get_the_excerpt(), $helper['excerpt_length'], '&hellip;' ) . '</div>';
		}
	*/
	?>

</article>
