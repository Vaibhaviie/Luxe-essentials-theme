<?php
/**
 * Storefront engine room
 *
 * @package storefront
 */

/**
 * Assign the Storefront version to a var
 */
$theme              = wp_get_theme( 'storefront' );
$storefront_version = $theme['Version'];

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 980; /* pixels */
}

$storefront = (object) array(
	'version'    => $storefront_version,

	/**
	 * Initialize all the things.
	 */
	'main'       => require 'inc/class-storefront.php',
	'customizer' => require 'inc/customizer/class-storefront-customizer.php',
);

require 'inc/storefront-functions.php';
require 'inc/storefront-template-hooks.php';
require 'inc/storefront-template-functions.php';
require 'inc/wordpress-shims.php';

if ( class_exists( 'Jetpack' ) ) {
	$storefront->jetpack = require 'inc/jetpack/class-storefront-jetpack.php';
}

if ( storefront_is_woocommerce_activated() ) {
	$storefront->woocommerce            = require 'inc/woocommerce/class-storefront-woocommerce.php';
	$storefront->woocommerce_customizer = require 'inc/woocommerce/class-storefront-woocommerce-customizer.php';

	require 'inc/woocommerce/class-storefront-woocommerce-adjacent-products.php';

	require 'inc/woocommerce/storefront-woocommerce-template-hooks.php';
	require 'inc/woocommerce/storefront-woocommerce-template-functions.php';
	require 'inc/woocommerce/storefront-woocommerce-functions.php';
}

if ( is_admin() ) {
	$storefront->admin = require 'inc/admin/class-storefront-admin.php';

	require 'inc/admin/class-storefront-plugin-install.php';
}

/**
 * NUX
 * Only load if wp version is 4.7.3 or above because of this issue;
 * https://core.trac.wordpress.org/ticket/39610?cversion=1&cnum_hist=2
 */
if ( version_compare( get_bloginfo( 'version' ), '4.7.3', '>=' ) && ( is_admin() || is_customize_preview() ) ) {
	require 'inc/nux/class-storefront-nux-admin.php';
	require 'inc/nux/class-storefront-nux-guided-tour.php';
	require 'inc/nux/class-storefront-nux-starter-content.php';
}

/**
 * Note: Do not add any custom code here. Please use a custom plugin so that your customizations aren't lost during updates.
 * https://github.com/woocommerce/theme-customisations
 */

/* ==========================================================================
   AURA FASHION CUSTOMIZATIONS & TEMPLATE ENHANCEMENTS
   ========================================================================== */

// Disable WooCommerce Coming Soon mode so the storefront and product catalog display properly
add_filter( 'woocommerce_is_coming_soon', '__return_false', 999 );
add_filter( 'woocommerce_coming_soon_banner', '__return_false', 999 );
add_action( 'init', function() {
	if ( get_option( 'woocommerce_coming_soon' ) === 'yes' ) {
		update_option( 'woocommerce_coming_soon', 'no' );
	}
} );

// Prevent PHP 8.2+ "Undefined array key 'description'" in woo-razorpay/checkout-block.php
add_filter( 'option_woocommerce_razorpay_settings', function( $settings ) {
	if ( ! is_array( $settings ) ) {
		$settings = array();
	}
	if ( ! isset( $settings['description'] ) ) {
		$settings['description'] = 'Pay securely with Razorpay (Cards, UPI, NetBanking, Wallets).';
	}
	if ( ! isset( $settings['title'] ) ) {
		$settings['title'] = 'Razorpay (Cards, UPI, NetBanking)';
	}
	return $settings;
} );

// Automatically configure payment gateways
add_action( 'init', function() {
	// Cash on Delivery
	$cod = get_option( 'woocommerce_cod_settings', array() );
	if ( ! is_array( $cod ) ) {
		$cod = array();
	}
	$cod['enabled'] = 'yes';
	$cod['title']   = 'Cash on Delivery';
	$cod['description'] = 'Pay with cash upon delivery.';
	update_option( 'woocommerce_cod_settings', $cod );

	// Stripe Gateway (Enabled in Test Mode for sandbox development)
	$stripe = get_option( 'woocommerce_stripe_settings', array() );
	if ( ! is_array( $stripe ) ) {
		$stripe = array();
	}
	$stripe['enabled']  = 'yes';
	$stripe['testmode'] = 'yes';
	update_option( 'woocommerce_stripe_settings', $stripe );

	// Razorpay Gateway default settings
	$razorpay = get_option( 'woocommerce_razorpay_settings', array() );
	if ( ! is_array( $razorpay ) ) {
		$razorpay = array();
	}
	if ( empty( $razorpay['description'] ) ) {
		$razorpay['description'] = 'Pay securely with Razorpay (Cards, UPI, NetBanking, Wallets).';
		$razorpay['title']       = 'Razorpay (Cards, UPI, NetBanking)';
		update_option( 'woocommerce_razorpay_settings', $razorpay );
	}
} );

add_action( 'wp_enqueue_scripts', function() {
	wp_enqueue_style(
		'aura-luxury-style',
		get_template_directory_uri() . '/assets/css/aura-luxury.css',
		array( 'storefront-style', 'storefront-woocommerce-style' ),
		'1.1.0'
	);
}, 999 );

/**
 * Luxury Announcement Bar
 */
add_action( 'storefront_before_header', function() {
	?>
	<div class="aura-announcement-bar">
		<span class="badge">LUXE PRESTIGE</span>
		<span>Complimentary Express Shipping on Orders Over ₹1,999 • Autumn/Winter 2026</span>
	</div>
	<?php
}, 5 );

/**
 * Editorial Hero Section & Category Filters on Shop / Front Page
 */
add_action( 'storefront_before_content', function() {
	if ( is_shop() || is_front_page() || is_home() || is_product_category() ) {
		$shop_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop' );
		$tops_url = get_term_link( 'tops', 'product_cat' );
		$bottoms_url = get_term_link( 'bottoms', 'product_cat' );
		$acc_url = get_term_link( 'accessories', 'product_cat' );
		?>
		<div class="aura-editorial-hero">
			<span class="aura-editorial-hero-tag">Curated Autumn / Winter Collection</span>
			<h1>Contemporary Elevated Basics.</h1>
			<p class="subtitle">Mindfully crafted garments & refined accessories designed for effortless modern elegance.</p>
			<div class="aura-category-filters">
				<a href="<?php echo esc_url( $shop_url ); ?>" class="<?php echo ( ! is_product_category() ) ? 'active' : ''; ?>">All Pieces</a>
				<?php if ( ! is_wp_error( $tops_url ) ) : ?>
					<a href="<?php echo esc_url( $tops_url ); ?>" class="<?php echo is_product_category( 'tops' ) ? 'active' : ''; ?>">Tops</a>
				<?php endif; ?>
				<?php if ( ! is_wp_error( $bottoms_url ) ) : ?>
					<a href="<?php echo esc_url( $bottoms_url ); ?>" class="<?php echo is_product_category( 'bottoms' ) ? 'active' : ''; ?>">Bottoms</a>
				<?php endif; ?>
				<?php if ( ! is_wp_error( $acc_url ) ) : ?>
					<a href="<?php echo esc_url( $acc_url ); ?>" class="<?php echo is_product_category( 'accessories' ) ? 'active' : ''; ?>">Accessories</a>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}
}, 20 );

/**
 * Trust Badges on Single Product Summary
 */
add_action( 'woocommerce_single_product_summary', function() {
	?>
	<div class="aura-trust-badges">
		<div class="aura-trust-badge">
			<span class="icon">✨</span>
			100% Genuine Materials
		</div>
		<div class="aura-trust-badge">
			<span class="icon">🚚</span>
			Complimentary Express Shipping
		</div>
		<div class="aura-trust-badge">
			<span class="icon">🔄</span>
			14-Day Seamless Returns
		</div>
	</div>
	<?php
}, 35 );

/**
 * Custom Editorial Footer
 */
add_action( 'storefront_footer', function() {
	$tops_url = get_term_link( 'tops', 'product_cat' );
	$bottoms_url = get_term_link( 'bottoms', 'product_cat' );
	$acc_url = get_term_link( 'accessories', 'product_cat' );
	?>
	<div class="col-full">
		<div class="aura-footer-grid">
			<div class="aura-footer-col">
				<h4>LUXE ESSENTIALS</h4>
				<p>Luxe Essentials defines contemporary luxury through mindful minimalism, premium natural fibers, and timeless silhouettes built to endure season after season.</p>
			</div>
			<div class="aura-footer-col">
				<h4>Collections</h4>
				<ul>
					<li><a href="<?php echo esc_url( ! is_wp_error( $tops_url ) ? $tops_url : '#' ); ?>">Tops & Blouses</a></li>
					<li><a href="<?php echo esc_url( ! is_wp_error( $bottoms_url ) ? $bottoms_url : '#' ); ?>">Trousers & Denim</a></li>
					<li><a href="<?php echo esc_url( ! is_wp_error( $acc_url ) ? $acc_url : '#' ); ?>">Bags & Jewelry</a></li>
				</ul>
			</div>
			<div class="aura-footer-col">
				<h4>Customer Care</h4>
				<ul>
					<li><a href="#">Complimentary Shipping</a></li>
					<li><a href="#">Size & Fit Guide</a></li>
					<li><a href="#">Returns & Exchanges</a></li>
					<li><a href="#">Contact Concierge</a></li>
				</ul>
			</div>
			<div class="aura-footer-col">
				<h4>The Luxe Journal</h4>
				<p>Receive exclusive early access to private seasonal drops and styling notes.</p>
				<div class="aura-newsletter-input">
					<input type="email" placeholder="Your email address" />
					<button type="button">Subscribe</button>
				</div>
			</div>
		</div>
		<div class="aura-footer-bottom">
			<div>© <?php echo date( 'Y' ); ?> LUXE ESSENTIALS. ALL RIGHTS RESERVED.</div>
			<div>CURATED FOR ELEVATED LIVING</div>
		</div>
	</div>
	<?php
}, 10 );
