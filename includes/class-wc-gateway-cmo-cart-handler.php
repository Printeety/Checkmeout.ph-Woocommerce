<?php
/**
 * Cart handler.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WC_Gateway_CMO_Cart_Handler handles button display in the cart.
 */
class WC_Gateway_CMO_Cart_Handler {

	/**
	 * Constructor.
	 */
	public function __construct() {
		 if ( ! wc_gateway_cmo()->settings->is_enabled() ) {
		 	return;
		 }

		add_action( 'woocommerce_before_cart_totals', array( $this, 'before_cart_totals' ) );
		add_action( 'woocommerce_proceed_to_checkout', array( $this, 'display_cmo_button' ), 20 );
		//add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}

	/**
	 * Start checkout handler when cart is loaded.
	 */
	public function before_cart_totals() {
		// If there then call start_checkout() else do nothing so page loads as normal.
		if ( ! empty( $_GET['startcmocheckout'] ) && 'true' === $_GET['startcmocheckout'] ) {
			// Trying to prevent auto running checkout when back button is pressed from PayPal page.
			$_GET['startcmocheckout'] = 'false';
			woo_cmo_start_checkout();
		}
	}


	/**
	 * Display paypal button on the cart page.
	 */
	public function display_cmo_button() {
		// $gateways = WC()->payment_gateways->get_available_payment_gateways();
            $settings = wc_gateway_cmo()->settings;
            $includes_path = wc_gateway_cmo()->includes_path;
			
			$express_checkout_img_url = apply_filters( 'woocommerce_paypal_express_checkout_button_img_url', sprintf( 'http://localhost:3000/woocmo-button.png', $settings->button_size ) );
		?>
		<div class="wcppec-checkout-buttons woo_pp_cart_buttons_div">
			<br />
			<?php if ( has_action( 'woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout' ) ) : ?>
				<div class="wcppec-checkout-buttons__separator">
					<?php _e( '&mdash; or &mdash;' ); ?>
				</div>
			<?php endif; ?>
			<br />
			<a href="<?php echo esc_url( add_query_arg( array( 'startcmocheckout' => 'true' ), wc_get_page_permalink( 'cart' ) ) ); ?>" id="" class="">
				<img src="<?php echo esc_url( $express_checkout_img_url ); ?>" alt="<?php _e( 'Check out with CMO', 'woocommerce-gateway-cmo-checkout' ); ?>" style="width: auto; height: auto;">
			</a>
		</div>
		<?php
	}
}
