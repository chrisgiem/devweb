<?php
/**
 * Smush meta box footer on dashboard page.
 *
 * @package Hummingbird
 *
 * @var string $url  Url to Smush module.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<a href="<?php echo esc_url( $url ); ?>" class="sui-button sui-button-ghost" id="smush-link">
	<i class="sui-icon-wrench-tool" aria-hidden="true"></i>
	<?php esc_html_e( 'Configure', 'wphb' ); ?>
</a>
