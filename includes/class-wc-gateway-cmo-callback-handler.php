<?php
/**
 * Created by PhpStorm.
 * User: hanseh
 * Date: 18/05/2017
 * Time: 8:28 PM
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WC_Gateway_CMO_Callback_Handler {
	function __construct()
	{
	}
	
	public function handle() {
		add_action( 'woocommerce_api_wc_gateway_cmo', array( $this, 'check_request' ) );
	}
	
	public function check_request()
	{
		$inputJSON = file_get_contents('php://input');
		$input = json_decode($inputJSON, TRUE);
		
//		var_dump($_REQUEST);
//		var_dump($input);
//		exit;
	}
}
