<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * CMO class to to curl service calls with the CMO API
 *
 *
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

			$resp = wp_remote_post( 'http://cmo-api.dev/v1/plugins/checkout', $args ); // TODO : centralize this? settings value maybe
			$this->_get_details_from_cart();
			
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

	/**
	 * Gets the general details from the cart
	 *
	 */
	protected function _get_details_from_cart() {
		//TODO : get data from the settings page
		// $settings = wc_gateway_ppec()->settings;
		$decimals      = 2;
		// $discounts     = round( WC()->cart->get_cart_discount_total(), $decimals );
		// $rounded_total = $this->_get_rounded_total_in_cart();

		$details = array(
			'total_item_amount' => round( WC()->cart->cart_contents_total, $decimals ),
			'order_tax'         => round( WC()->cart->tax_total + WC()->cart->shipping_tax_total, $decimals ),
			'shipping'          => round( WC()->cart->shipping_total, $decimals ),
			'items'				=> $this->_get_items_from_cart()
		);

		$details['order_total'] = round(
			$details['total_item_amount'] + $details['order_tax'] + $details['shipping'],
			$decimals
		);


		// If the totals don't line up, adjust the tax to make it work (it's
		// probably a tax mismatch).
		$wc_order_total = round( WC()->cart->total, $decimals );
		if ( $wc_order_total != $details['order_total'] ) {
			$details['order_tax']  += $wc_order_total - $details['order_total'];
			$details['order_total'] = $wc_order_total;
		}
		$details['order_tax'] = round( $details['order_tax'], $decimals );

		if ( ! is_numeric( $details['shipping'] ) ) {
			$details['shipping'] = 0;
		}


		return $details;
	}

	/**
	 * Get the Items from the woo commerce cart
	 *
	 *
	*/
	protected function _get_items_from_cart() {
		$decimals = 2;

		$items = array();
		foreach ( WC()->cart->cart_contents as $cart_item_key => $values ) {
			$amount = round( $values['line_subtotal'] / $values['quantity'] , $decimals );

			// Get the image link based on the post thumbnail
			$postID = $values['data']->post->ID;
			$product_meta = get_post_meta($postID);
    		$img = wp_get_attachment_image( $product_meta['_thumbnail_id'][0], 'full' );
    		$imgSrc = (string) reset(simplexml_import_dom(DOMDocument::loadHTML($img))->xpath("//img/@src"));
    

			$imgSrc = (string) reset(simplexml_import_dom(DOMDocument::loadHTML($values['data']->post->post_content))->xpath("//img/@src"));

			if ( version_compare( WC_VERSION, '3.0', '<' ) ) {
				$name = $values['data']->post->post_title;
				$description = $values['data']->post->post_content;
			} else {
				$product = $values['data'];
				$name = $product->get_name();
				$description = $product->get_description();
			}

			// Parse data to only return needed item values
			$item   = array(
				'name'        => $name,
				'description' => $description,
				'quantity'    => $values['quantity'],
				'amount'      => $amount,
				'image_link'  => $imgSrc
			);

			$items[] = $item;
		}

		return $items;
	}
}	