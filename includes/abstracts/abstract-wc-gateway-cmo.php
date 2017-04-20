
<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * WC_Gateway_PPEC
 */
abstract class WC_Gateway_CMO extends WC_Payment_Gateway {

	/**
	 * Constructor.
	 */
	public function __construct() {

		$this->init_form_fields();
		//$this->init_settings();

		add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );

		/*
		$this->has_fields         = false;
		$this->icon               = 'https://www.paypalobjects.com/webstatic/en_US/i/buttons/pp-acceptance-small.png';
		$this->supports[]         = 'refunds';
		$this->method_title       = __( 'PayPal Express Checkout', 'woocommerce-gateway-paypal-express-checkout' );
		$this->method_description = __( 'Allow customers to conveniently checkout directly with PayPal.', 'woocommerce-gateway-paypal-express-checkout' );

		if ( empty( $_GET['woo-paypal-return'] ) ) {
			$this->order_button_text  = __( 'Continue to payment', 'woocommerce-gateway-paypal-express-checkout' );
		}

		wc_gateway_ppec()->ips->maybe_received_credentials();

		$this->init_form_fields();
		$this->init_settings();

		$this->title        = $this->method_title;
		$this->description  = '';
		$this->enabled      = $this->get_option( 'enabled', 'yes' );
		$this->button_size  = $this->get_option( 'button_size', 'large' );
		$this->environment  = $this->get_option( 'environment', 'live' );
		$this->mark_enabled = 'yes' === $this->get_option( 'mark_enabled', 'no' );

		if ( 'live' === $this->environment ) {
			$this->api_username    = $this->get_option( 'api_username' );
			$this->api_password    = $this->get_option( 'api_password' );
			$this->api_signature   = $this->get_option( 'api_signature' );
			$this->api_certificate = $this->get_option( 'api_certificate' );
			$this->api_subject     = $this->get_option( 'api_subject' );
		} else {
			$this->api_username    = $this->get_option( 'sandbox_api_username' );
			$this->api_password    = $this->get_option( 'sandbox_api_password' );
			$this->api_signature   = $this->get_option( 'sandbox_api_signature' );
			$this->api_certificate = $this->get_option( 'sandbox_api_certificate' );
			$this->api_subject     = $this->get_option( 'sandbox_api_subject' );
		}

		$this->debug                      = 'yes' === $this->get_option( 'debug', 'no' );
		$this->invoice_prefix             = $this->get_option( 'invoice_prefix', 'WC-' );
		$this->instant_payments           = 'yes' === $this->get_option( 'instant_payments', 'no' );
		$this->require_billing            = 'yes' === $this->get_option( 'require_billing', 'no' );
		$this->paymentaction              = $this->get_option( 'paymentaction', 'sale' );
		$this->logo_image_url             = $this->get_option( 'logo_image_url' );
		$this->subtotal_mismatch_behavior = $this->get_option( 'subtotal_mismatch_behavior', 'add' );

		add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );

		// Change gateway name if session is active
		if ( ! is_admin() ) {
			if ( wc_gateway_ppec()->checkout->is_started_from_checkout_page() ) {
				$this->title        = $this->get_option( 'title' );
				$this->description  = $this->get_option( 'description' );
			}
		}
		*/
	}

	/**
	 * Initialise Gateway Settings Form Fields.
	 */
	public function init_form_fields() {
		//$this->form_fields = include( dirname( dirname( __FILE__ ) ) . '/settings/settings-ppec.php' );
		 $this->form_fields = array(
     'api_key' => array(
          'title' => __( 'CheckMeOut API Key', 'woocommerce' ),
          'type' => 'text',
          'description' => __( 'This input matches the CheckMeOut merchant API Key', 'woocommerce' ),
          'default' => __( 'API Key', 'woocommerce' )
          ),
     'secret_key' => array(
          'title' => __( 'CheckMeOut API Key', 'woocommerce' ),
          'type' => 'text',
          'description' => __( 'This input matches the CheckMeOut merchant Secret Key', 'woocommerce' ),
          'default' => __( 'Secret Key', 'woocommerce' )
          )
     );
	}
}