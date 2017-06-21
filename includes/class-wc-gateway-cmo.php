<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class WC_Gateway_CMO_Checkmeout extends WC_Gateway_CMO {
	public function __construct() {
		$this->id = 'checkmeout';
		
		parent::__construct();
		
		$handler = new WC_Gateway_CMO_Callback_Handler( );
		$handler->handle();
		
		//do_action( 'woocommerce_api_wc_gateway_cmo', wp_unslash( $_POST ) );
	}
}
