<?php
/**
 * Created by PhpStorm.
 * User: hanseh
 * Date: 18/05/2017
 * Time: 4:55 PM
 */

class WC_Gateway_CMO_Jwt {

	public function __construct()
	{}
	
	public function generateJWT()
	{
		return wc_gateway_cmo()->settings->api_key;
	}
}