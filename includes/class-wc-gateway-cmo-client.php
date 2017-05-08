<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * PayPal NVP (Name-Value Pair) API client. This client supports both certificate
 * and signature for authentication.
 *
 * @see https://developer.paypal.com/docs/classic/api/#ec
 */
class WC_Gateway_CMO_Client {

	/**
	 * Make a remote request to CMO API.
	 *
	 *
	 * @param  array $params NVP request parameters
	 * @return array         NVP response
	 */
	protected function _request( array $params ) {
		try {
			//$this->_validate_request();

			// First, add in the necessary credential parameters.
			//$body = apply_filters( 'woocommerce_paypal_express_checkout_request_body', array_merge( $params, $this->_credential->get_request_params() ) );
			$args = array(
				'method'      => 'POST',
				'body'        => '',
				'user-agent'  => __CLASS__,
				'httpversion' => '1.1',
				'timeout'     => 30,
			);

			// For cURL transport.
			add_action( 'http_api_curl', array( /*$this->_credential*/'', 'configure_curl' ), 10, 3 );

			//wc_gateway_ppec_log( sprintf( '%s: remote request to %s with params: %s', __METHOD__, $this->get_endpoint(), print_r( $body, true ) ) );
			
			//$resp = wp_safe_remote_post( 'http://api.staging.checkmeout.ph/v1/receptacles', $args );
			$resp = wp_safe_remote_get( 'http://cmo-api.dev/v1/ecommerce-redirect', $args );
			var_dump($resp);exit;
			//return $this->_process_response( $resp );

		} catch ( Exception $e ) {
			return $$e;
		}
	}

	public function get_endpoint() {
		return sprintf(
			'http://cmo-api.dev/v1/ecommerce-redirect','', '');
	}

	/**
	 * Initiates an CMO Checkout transaction.
	 *
	 */
	public function set_cmo_checkout( array $params ) {
		// $params['METHOD']  = 'SetExpressCheckout';
		// $params['VERSION'] = self::API_VERSION;

		return $this->_request( $params );
	}
}	