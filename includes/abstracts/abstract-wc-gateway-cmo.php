<?php

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}

/**
 * WC_Gateway_CMO
 */
abstract class WC_Gateway_CMO extends WC_Payment_Gateway {

  /**
   * Constructor.
   */
  public function __construct() {
    $this->method_title       = __( 'CheckMeOut', 'woocommerce-gateway-cmo-checkout' );
    $this->method_description = __( 'CheckMeOut allows you to offer your buyers a variety of payment options and easily manage your deliveries.', 'woocommerce-gateway-cmo-checkout' );

    $this->init_form_fields();
    add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
  }

  public function process_admin_options() {


    parent::process_admin_options();

  }

  /**
   * Initialise Gateway Settings Form Fields.
   */
  public function init_form_fields() {
     $this->form_fields = array(
       'enabled' => array(
         'title'   => __( 'Enable/Disable', 'woocommerce-gateway-cmo-express-checkout' ),
         'type'    => 'checkbox',
         'label'   => __( 'Enable CheckMeOut', 'woocommerce-gateway-cmo-checkout' ),
         'description' => __( 'This enables CMO Checkout which allows customers to checkout directly via checkmeout from your cart page.', 'woocommerce-gateway-cmo-checkout' ),
         'desc_tip'    => true,
         'default'     => 'yes',
       ),
      //  'cod' => array(
       //
      //    'title'       => __( 'COD', 'woocommerce-gateway-cmo-checkout' ),
      //    'type'        => 'checkbox',
      //    'label'   => __( 'Enable/Disable COD', 'woocommerce-gateway-cmo-checkout' ),
      //    'description' => __( 'This setting specifies whether you will process live transactions, or whether you will process simulated transactions using the PayPal Sandbox.', 'woocommerce-gateway-paypal-express-checkout' ),
      //    'default'     => 'yes',
      //    'desc_tip'    => true
       //
      //  ),
      //  'credit_card' => array(
      //    'title'       => __( 'Credit Card', 'woocommerce-gateway-cmo-checkout' ),
      //    'type'        => 'checkbox',
      //    'label'   => __( 'Enable/Disable Credit Card', 'woocommerce-gateway-cmo-checkout' ),
      //    'description' => __( 'This setting specifies whether you will process live transactions, or whether you will process simulated transactions using the PayPal Sandbox.', 'woocommerce-gateway-paypal-express-checkout' ),
      //    'default'     => 'yes',
      //    'desc_tip'    => true
      //  ),
      //  'online' => array(
      //    'title'       => __( 'Online Banking', 'woocommerce-gateway-cmo-checkout' ),
      //    'type'        => 'checkbox',
      //    'label'   => __( 'Enable/Disable Online Banking', 'woocommerce-gateway-cmo-checkout' ),
      //    'description' => __( 'This setting specifies whether you will process live transactions, or whether you will process simulated transactions using the PayPal Sandbox.', 'woocommerce-gateway-paypal-express-checkout' ),
      //    'default'     => 'yes',
      //    'desc_tip'    => true
      //  ),
     'display_settings' => array(
       'title'       => __( 'Display Settings', 'woocommerce-gateway-cmo-checkout' ),
       'type'        => 'title',
       'description' => __( 'Enter your API credentials to connect your account and start using CheckMeOut with your website.', 'woocommerce-gateway-cmo-checkout' ),
     ),
     'api_key' => array(
          'title' => __( 'CheckMeOut API Key', 'woocommerce' ),
          'type' => 'text',
          'description' => __( 'This should match your CheckMeOut merchant API Key', 'woocommerce' ),
          'default' => __( 'API Key', 'woocommerce' ),
          'placeholder' => __( 'API Key' )
          ),
     'secret_key' => array(
          'title' => __( 'CheckMeOut Secret Key', 'woocommerce' ),
          'type' => 'text',
          'description' => __( 'This should match your CheckMeOut merchant Secret Key', 'woocommerce' ),
          'default' => __( 'Secret Key', 'woocommerce' ),
          'placeholder' => __( 'Secret Key' )
          )
     );
  }
}
