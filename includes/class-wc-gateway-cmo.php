<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class WC_Gateway_CMO_checkmeout extends WC_Gateway_CMO {
	public function __construct() {
		$this->id = 'checkmeout';

		parent::__construct();

		// if ( $this->is_available() ) {
		// 	$ipn_handler = new WC_Gateway_PPEC_IPN_Handler( $this );
		// 	$ipn_handler->handle();
		// }
	}
}
