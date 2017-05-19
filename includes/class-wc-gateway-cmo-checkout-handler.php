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
	 * @since 1.0
	 *
	 * @var CMO_Checkout_Details
	 */
	protected $_checkout_details;

	public function __construct() {
		add_action( 'init', array( $this, 'init' ) );
		add_action( 'wp', array( $this, 'return_from_cmo' ) );
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
		}
	}

	public function get_cmo_order_url() {
		$client       = wc_gateway_cmo()->client;
		return $client->set_cmo_checkout( array() );
	}
	
	//TODO : handle return process, create order here and copy the billing details maybe?
	public function return_from_cmo() {
		if ( empty( $_GET['woo-cmo-return'] ) ) {
			return;
		}
		// TODO : implement the process based on CMO reply
		echo "capture return";exit;
	}
}
