<?php
/**
 * Posts shortcode item template
 *
 * Default wm_staff item template
 * Consist of:
 * 		title,
 * 		image,
 * 		contacts,
 * 		taxonomy:staff_position,
 * 		content
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
?>

<article class="<?php echo esc_attr( $helper['item_class'] ); ?>"<?php echo wm_schema_org( 'person' ); ?>>

	<div class="wm-posts-element wm-html-element title"><?php
		echo '<' . tag_escape( $helper['atts']['heading_tag'] ) . wm_schema_org( 'name' ) . '>';

			echo $link_output[0];

			the_title();

			echo $link_output[1];

		echo '</' . tag_escape( $helper['atts']['heading_tag'] ) . '>';
	?></div>

	<?php
	if ( has_post_thumbnail( $helper['post_id'] ) ) {
		echo '<div class="wm-posts-element wm-html-element image image-container"' . wm_schema_org( 'image' ) . '>';

			echo $link_output[0];

			the_post_thumbnail( $helper['image_size'], array( 'title' => esc_attr( get_the_title( get_post_thumbnail_id( $helper['post_id'] ) ) ) ) );

			echo $link_output[1];

		echo '</div>';
	}
	?>

	<?php
		$staff_contacts = wma_meta_option( 'contacts', $helper['post_id'] );
		if ( $staff_contacts && is_array( $staff_contacts ) ) {
			$output_contacts = '';

			foreach ( $staff_contacts as $contact ) {
				if (
						! isset( $contact['icon'] )
						|| ! trim( $contact['icon'] )
					) {
					continue;
				}
				if ( ! isset( $contact['title'] ) ) {
					$contact['title'] = '';
				}
				if ( ! isset( $contact['link'] ) ) {
					$contact['link'] = '';
				}
				$title_attr = ( $contact['title'] ) ? ( ' title="' . esc_attr( strip_tags( $contact['title'] ) ) . '"' ) : ( '' );

				$output_contacts .= '<li class="contacts-item"' . wm_schema_org( 'itemprop="contactPoint"' ) . '>';
				if ( $contact['link'] ) {
					$output_contacts .= '<a href="' . esc_url( $contact['link'] ) . '" class="' . esc_attr( $contact['icon'] ) . '"' . $title_attr . '><span class="screen-reader-text">' . $contact['title'] . '</span></a>';
				} else {
					$output_contacts .= '<span class="' . esc_attr( $contact['icon'] ) . '"' . $title_attr . '></span><span class="screen-reader-text">' . $contact['title'] . '</span>';
				}
				$output_contacts .= '</li>';
			}

			if ( $output_contacts ) {
				echo '<ul class="wm-posts-element wm-html-element contacts">' . $output_contacts . '</ul>';
			}
		}
	?>

	<?php
		$terms       = get_the_terms( $helper['post_id'], 'staff_position' );
		$terms_array = array();
		if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
			foreach( $terms as $term ) {
				$terms_array[] = '<span class="term term-' . sanitize_html_class( $term->slug ) . '"' . wm_schema_org( 'itemprop="jobtitle"' ) . '>' . $term->name . '</span>';
			}
			echo '<div class="wm-posts-element wm-html-element taxonomy">' . $link_output[0] . implode( ', ', $terms_array ) . $link_output[1] . '</div>';
		}
	?>

	<div class="wm-posts-element wm-html-element content"<?php echo wm_schema_org( 'description' ); ?>>
		<?php echo do_shortcode( wpautop( get_the_content() ) ); ?>
	</div>

</article>
