<?php
/**
 * Cart handler.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class WC_Gateway_CMO_Checkout_Handler {

	/**
	 * Cached result from self::get_checkout_defails.
	 *
	 * @since 1.2.0
	 *
	 * @var CMO_Checkout_Details
	 */
	protected $_checkout_details;

	public function __construct() {
		add_action( 'init', array( $this, 'init' ) );
	}

	/**
	 * If the buyer clicked on the "Check Out with CMO" button, we need to wait for the cart
	 * totals to be available.  Unfortunately that doesn't happen until
	 * woocommerce_before_cart_totals executes, and there is already output sent to the browser by
	 * this point.  So, to get around this issue, we'll enable output buffering to prevent WP from
	 * sending anything back to the browser.
	 */
	public function init() {
		if ( isset( $_GET['startcmocheckout'] ) && 'true' === $_GET['startcmocheckout'] ) {
			ob_start();
			// TODO : trigger CMO redirect with automatic page creation

			//header("Location: http://localhost:3000/dialog/checkout/cups-cb1f27116");
			//header('Location: http://localhost:3000/I/my-product-13-123456789');
			//_e( 'Billing details', 'woocommerce-gateway-paypal-express-checkout' );
			//exit;

		}
	}

	public function get_cmo_order_url() {
		return 'test';
	}

}
