<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 */
class WC_Gateway_CMO_Client {

	const INVALID_CREDENTIAL_ERROR  = 1;
	const INVALID_ENVIRONMENT_ERROR = 2;
	const REQUEST_ERROR             = 3;

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
			$body = array(
						"product" => "pending",
    					"amount" => 100,
    					"receptacle" => "regular",
    					"image" => "test"
    		);

			$args = array(
				'method'      => 'POST',
				'body'        => $body,
				'user-agent'  => __CLASS__,
				'httpversion' => '1.1',
				'timeout'     => 30,
			);

			// For cURL transport.
			//add_action( 'http_api_curl', array( /*$this->_credential*/'', 'configure_curl' ), 10, 3 );

			//wc_gateway_ppec_log( sprintf( '%s: remote request to %s with params: %s', __METHOD__, $this->get_endpoint(), print_r( $body, true ) ) );
			
			//$resp = wp_safe_remote_post( 'http://api.staging.checkmeout.ph/v1/receptacles', $args );

			$resp = wp_remote_post( 'http://cmo-api.dev/v1/plugins/checkout', $args );
			
			return $this->_process_response( $resp );
		} catch ( Exception $e ) {
			return $$e;
		}
	}

	public function get_endpoint() {
		return sprintf(
			'http://cmo-api.dev/v1/ecommerce-redirect','', '');
	}

	protected function _process_response( $response ) {
		if ( is_wp_error( $response ) ) {
			throw new Exception( sprintf( __( 'An error occurred while trying to connect to CMO: %s', 'woocommerce-gateway-cmo' ), $response->get_error_message() ), self::REQUEST_ERROR );
		}

		parse_str( wp_remote_retrieve_body( $response ), $result );

		return json_decode( key($result) );
	}

	/**
	 * Initiates an CMO Checkout transaction.
	 *
	 */
	public function set_cmo_checkout( array $params ) {
		return $this->_request( $params );
	}
}	