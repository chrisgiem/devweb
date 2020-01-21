<?php
/**
 * Advanced tools: general meta box.
 *
 * @package Hummingbird
 *
 * @var bool   $query_stings    URL Query Strings enabled or disabled.
 * @var bool   $cart_fragments  WooCommerce cart fragments.
 * @var bool   $emoji           Remove Emojis file enabled or disabled.
 * @var string $prefetch        Prefetch dns urls.
 * @var bool   $woo_active      Is WooCommerce activated.
 * @var string $woo_link        Link to WooCommerce Settings - Products page.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<div class="sui-margin-bottom">
	<p>
		<?php esc_html_e( 'Here are a few additional tweaks you can make to further reduce your page load times.', 'wphb' ); ?>
	</p>
</div>

<?php do_action( 'wphb_advanced_tools_notice' ); ?>

<div class="sui-box-settings-row">
	<div class="sui-box-settings-col-1">
		<span class="sui-settings-label"><?php esc_html_e( 'URL Query Strings', 'wphb' ); ?></span>
		<span class="sui-description">
			<?php esc_html_e( 'Some proxy caching servers and even some CDNs cannot cache static assets with query strings, resulting in a large missed opportunity for increased speeds.', 'wphb' ); ?>
		</span>
	</div>
	<div class="sui-box-settings-col-2">
		<label class="sui-toggle sui-tooltip sui-tooltip-top-right" data-tooltip="<?php esc_attr_e( 'Remove query strings from my assets', 'wphb' ); ?>">
			<input type="checkbox" name="query_strings" id="query_strings" <?php checked( $query_stings ); ?> <?php disabled( apply_filters( 'wphb_query_strings_disabled', false ) ); ?>>
			<span class="sui-toggle-slider"></span>
		</label>
		<label for="query_strings"><?php esc_html_e( 'Remove query strings from my assets', 'wphb' ); ?></label>
	</div>
</div>

<div class="sui-box-settings-row">
	<div class="sui-box-settings-col-1">
		<span class="sui-settings-label"><?php esc_html_e( 'WooCommerce Cart Fragments', 'wphb' ); ?></span>
		<span class="sui-description">
			<?php esc_html_e( 'WooCommerce uses ajax calls to update cart totals without refreshing the page. These ajax calls run on every page and can drastically increase page load times. We recommend disabling cart fragments on all non-WooCommerce pages.', 'wphb' ); ?>
		</span>
	</div>
	<div class="sui-box-settings-col-2">
		<label class="sui-toggle sui-tooltip sui-tooltip-top-right" data-tooltip="<?php esc_attr_e( 'Disable cart fragments', 'wphb' ); ?>">
			<input type="checkbox" name="cart_fragments" id="cart_fragments" <?php checked( (bool) $cart_fragments ); ?> <?php disabled( apply_filters( 'wphb_cart_fragments_disabled', ! $woo_active ) ); ?>>
			<span class="sui-toggle-slider"></span>
		</label>
		<label for="cart_fragments"><?php esc_html_e( 'Disable cart fragments', 'wphb' ); ?></label>

		<div class="<?php echo $cart_fragments && $woo_active ? '' : 'sui-hidden'; ?>" id="cart_fragments_desc">
			<div class="sui-border-frame sui-toggle-content">
				<span class="sui-description">
					<?php esc_html_e( 'Choose whether to disable this feature on only non-WooCommerce pages, or all pages.', 'wphb' ); ?>
				</span>
				<div class="sui-form-field sui-no-margin-bottom">
					<span class="sui-label"><?php esc_html_e( 'Disable cart fragments on', 'wphb' ); ?></span>
					<div class="sui-side-tabs">
						<div class="sui-tabs-menu">
							<label for="cart_fragments-true" class="sui-tab-item <?php echo 'all' === $cart_fragments ? '' : 'active'; ?>">
								<input type="radio" name="cart_fragments_value" value="1" id="cart_fragments-true" checked="checked">
								<?php esc_html_e( 'Non-WooCommerce Pages', 'wphb' ); ?></label>

							<label for="cart_fragments-all" class="sui-tab-item <?php echo 'all' === $cart_fragments ? 'active' : ''; ?>">
								<input type="radio" name="cart_fragments_value" value="all" id="cart_fragments-all">
								<?php esc_html_e( 'All Pages', 'wphb' ); ?></label>
						</div>
					</div>
				</div>
				<div class="sui-notice">
					<p>
						<?php
						printf(
							/* translators: %1$s - <a> link, %2$s - </a> closing tag */
							esc_html__( 'After disabling cart fragments, be sure to enable the %1$sRedirect to the cart page after successful addition%2$s option in your Woocommerce Settings to redirect your customers to the main cart page instead of waiting for an item to be added to the cart.', 'wphb' ),
							'<a href="' . esc_url( $woo_link ) . '" target="_blank">',
							'</a>'
						);
						?>
					</p>
				</div>
			</div>
		</div>

		<?php if ( ! $woo_active ) : ?>
			<div class="sui-notice" style="margin: 10px 0 0 48px">
				<p>
					<?php esc_html_e( 'This option requires WooCommerce to be installed and activated.', 'wphb' ); ?>
				</p>
			</div>
		<?php endif; ?>
	</div>
</div>

<div class="sui-box-settings-row">
	<div class="sui-box-settings-col-1">
		<span class="sui-settings-label"><?php esc_html_e( 'Emojis', 'wphb' ); ?></span>
		<span class="sui-description">
			<?php esc_html_e( 'WordPress adds Javascript and CSS files to convert common symbols like “:)” to visual emojis. If you don’t need emojis this will remove two unnecessary assets.', 'wphb' ); ?>
		</span>
	</div>
	<div class="sui-box-settings-col-2">
		<label class="sui-toggle sui-tooltip sui-tooltip-top-right" data-tooltip="<?php esc_attr_e( 'Remove the default Emoji JS & CSS files', 'wphb' ); ?>">
			<input type="checkbox" name="emojis" id="emojis" <?php checked( $emoji ); ?> <?php disabled( apply_filters( 'wphb_emojis_disabled', false ) ); ?>>
			<span class="sui-toggle-slider"></span>
		</label>
		<label for="emojis"><?php esc_html_e( 'Remove the default Emoji JS & CSS files', 'wphb' ); ?></label>
	</div>
</div>

<div class="sui-box-settings-row">
	<div class="sui-box-settings-col-1">
		<span class="sui-settings-label"><?php esc_html_e( 'Prefetch DNS Requests', 'wphb' ); ?></span>
		<span class="sui-description">
			<?php esc_html_e( 'Speeds up web pages by pre-resolving DNS. In essence it tells a browser it should resolve the DNS of a specific domain prior to it being explicitly called – very useful if you use third party services.', 'wphb' ); ?>
		</span>
	</div>
	<div class="sui-box-settings-col-2">
		<textarea class="sui-form-control" name="url_strings" placeholder="//fonts.googleapis.com
//fonts.gstatic.com
//ajax.googleapis.com
//apis.google.com
//google-analytics.com
//www.google-analytics.com
//ssl.google-analytics.com
//youtube.com
//s.gravatar.com"><?php echo esc_html( $prefetch ); ?></textarea>
		<span class="sui-description">
			<?php esc_html_e( 'Add one host entry per line replacing the http:// or https:// with // e.g. //fonts.googleapis.com. We’ve added a few common DNS requests to get you started.', 'wphb' ); ?>
			<?php
			printf(
				'<a href="#" id="wphb-adv-paste-value">%s</a>',
				esc_html__( 'Paste in recommended defaults.', 'wphb' )
			);
			?>
		</span>
	</div>
</div>
