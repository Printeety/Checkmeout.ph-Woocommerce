<?php
/**
 * Plugin bootstrapper.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WC_Gateway_CMO_Gateway_Loader {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$includes_path = wc_gateway_cmo()->includes_path;

		require_once( $includes_path . 'abstracts/abstract-wc-gateway-cmo.php' );
		require_once( $includes_path . 'class-wc-gateway-cmo.php' );
		
		add_filter( 'woocommerce_payment_gateways', array( $this, 'payment_gateways' ) );
	}

	public function payment_gateways( $methods ) {
		$methods[] = 'WC_Gateway_CMO_checkmeout';
		return $methods;
	}

}
