<?php
/**
 * General meta box.
 *
 * @since 2.2.0
 * @package Hummingbird
 *
 * @var string $site_language     Site language.
 * @var string $translation_link  Link to translations.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<p><?php esc_html_e( 'Configure general settings for this plugin.', 'wphb' ); ?></p>

<div class="sui-box-settings-row">
	<div class="sui-box-settings-col-1">
		<span class="sui-settings-label "><?php esc_html_e( 'Translations', 'wphb' ); ?></span>
		<span class="sui-description">
			<?php
			printf(
				/* translators: %1$s: opening a tag, %2$s: closing a tag */
				esc_html__( 'By default, Hummingbird will use the language you’d set in your %1$sWordPress Admin Settings%2$s if a matching translation is available.', 'wphb' ),
				'<a href="' . esc_html( admin_url( 'options-general.php' ) ) . '">',
				'</a>'
			);
			?>
		</span>
	</div>
	<div class="sui-box-settings-col-2">
		<div class="sui-form-field">
			<label for="language-input" class="sui-label">
				<?php esc_html_e( 'Active Translation', 'wphb' ); ?>
			</label>
			<input type="text" id="language-input" class="sui-form-control" disabled="disabled" placeholder="<?php echo esc_attr( $site_language ); ?>">
			<span class="sui-description">
				<?php
				printf(
					/* translators: %1$s: opening a tag, %2$s: closing a tag */
					esc_html__( 'Not using your language, or have improvements? Help us improve translations by providing your own improvements %1$shere%2$s.', 'wphb' ),
					'<a href="' . esc_html( $translation_link ) . '" target="_blank">',
					'</a>'
				);
				?>
			</span>
		</div>
	</div>
</div>
