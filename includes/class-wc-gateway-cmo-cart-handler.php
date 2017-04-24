<?php
/**
 * Cart handler.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WC_Gateway_PPEC_Cart_Handler handles button display in the cart.
 */
class WC_Gateway_CMO_Cart_Handler {

	/**
	 * Constructor.
	 */
	public function __construct() {
		// if ( ! wc_gateway_cmo()->settings->is_enabled() ) {
		// 	return;
		// }

		// add_action( 'woocommerce_before_cart_totals', array( $this, 'before_cart_totals' ) );
		// add_action( 'woocommerce_widget_shopping_cart_buttons', array( $this, 'display_mini_paypal_button' ), 20 );
		add_action( 'woocommerce_proceed_to_checkout', array( $this, 'display_cmo_button' ), 20 );
		//add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}


	/**
	 * Display paypal button on the cart page.
	 */
	public function display_cmo_button() {

		// $gateways = WC()->payment_gateways->get_available_payment_gateways();
		// $settings = wc_gateway_ppec()->settings;

		$imgpath = $includes_path . '../assets/img/woocmo.png';

		$express_checkout_img_url = apply_filters( 'woocommerce_paypal_express_checkout_button_img_url', sprintf( 'http://localhost:3000/cmo-checkout.png', $settings->button_size ) );
		$paypal_credit_img_url    = apply_filters( 'woocommerce_paypal_express_checkout_credit_button_img_url', sprintf( 'https://www.checkmeout.ph/static/media/checkmeout_logo.be95fe71.png', $settings->button_size ) );

		// billing details on checkout page to calculate shipping costs
		// if ( ! isset( $gateways['ppec_paypal'] ) ) {
		// 	return;
		// }

		$includes_path = wc_gateway_cmo()->includes_path;


		?>
		<div class="wcppec-checkout-buttons woo_pp_cart_buttons_div">

			<?php if ( has_action( 'woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout' ) ) : ?>
				<div class="wcppec-checkout-buttons__separator">
					<?php _e( '&mdash; or &mdash;', 'woocommerce-gateway-paypal-express-checkout' ); ?>
				</div>
			<?php endif; ?>



			<a href="<?php echo esc_url( add_query_arg( array( 'startcmocheckout' => 'true' ), wc_get_page_permalink( 'cart' ) ) ); ?>" id="" class="">
				<img src="<?php echo esc_url( $express_checkout_img_url ); ?>" alt="<?php _e( 'Check out with PayPal', 'woocommerce-gateway-paypal-express-checkout' ); ?>" style="width: auto; height: auto;">
			</a>	
		</div>
		<?php
	}
}
