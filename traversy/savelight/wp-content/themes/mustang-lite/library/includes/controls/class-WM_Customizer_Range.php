<?php
/**
 * Skinning System
 *
 * Customizer number slider.
 *
 * @package     WebMan WordPress Theme Framework
 * @subpackage  Skinning System
 * @copyright   2014 WebMan - Oliver Juhas
 *
 * @since    3.1
 * @version  1.9.1
 */



/**
 * Number slider
 */
class WM_Customizer_Range extends WP_Customize_Control {

	public $type = 'range';

	public $multiplier = 1; // Value display alteration

	public function enqueue() {
		//Scripts
			wp_enqueue_script( 'jquery-ui-slider' );
	}

	public function render_content() {
		if ( empty( $this->json ) || ! is_array( $this->json ) ) {
			$this->json = array( 0, 10, 1 ); // [min, max, step]
		}
		?>

		<label>
			<span class="customize-control-title"><?php echo $this->label; ?></span>
			<?php if ( $this->description ) : ?><span class="description customize-control-description"><?php echo $this->description; ?></span><?php endif; ?>

			<span class="slide-number-wrapper">
				<span id="<?php echo sanitize_title( $this->id ); ?>-slider" class="number-slider"></span>
			</span>
			<input type="number" name="<?php echo esc_attr( $this->id ); ?>" id="<?php echo sanitize_title( $this->id ); ?>" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); ?> />
		</label>

		<script><!--
			jQuery( function() {

				if ( jQuery().slider ) {

					jQuery( '#<?php echo sanitize_title( $this->id ); ?>' )
						.attr( 'type', 'hidden' );

					jQuery( '#<?php echo sanitize_title( $this->id ); ?>-slider' )
						.slider( {
							value  : <?php echo $this->value(); ?>,
							min    : <?php echo $this->json[0]; ?>,
							max    : <?php echo $this->json[1]; ?>,
							step   : <?php echo $this->json[2]; ?>,
							create : function( e, ui ) {

								jQuery( this )
									.find( '.ui-slider-handle' )
										.text( <?php echo intval( $this->value() * floatval( $this->multiplier ) ); ?> );

							},
							slide  : function( e, ui ) {

								jQuery( this )
									.find( '.ui-slider-handle' )
										.text( parseInt( ui.value * <?php echo floatval( $this->multiplier ); ?> ) );

								jQuery( '#<?php echo sanitize_title( $this->id ); ?>' )
									.val( parseInt( ui.value ) )
										.change();

							}
						} );

				}

			} );
		//--></script>

		<?php
	}

} // /WM_Customizer_Range
