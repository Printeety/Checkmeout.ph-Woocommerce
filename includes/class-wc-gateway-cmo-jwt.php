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
		$header = [
			'alg' => 'HS256',
			'typ' => 'JWT'
		];
		
		$payload = [
			'iat' => time(),
			'sub' => wc_gateway_cmo()->settings->api_key
		];
		
		$signature = $this->_sign($header, $payload, wc_gateway_cmo()->settings->secret_key);
		
		return $this->__base64_encode_safe(json_encode($header), true) . '.' . $this->__base64_encode_safe(json_encode($payload), true) . '.' . $signature;
	}
	
	private function _sign($header, $payload, $secret_key, $alg = 'HS256')
	{
		// Build the data to be signed.
		$data = $this->__base64_encode_safe( json_encode($header), true) . '.' . $this->__base64_encode_safe(json_encode($payload), true);
		
		// Sign it.
		switch (strtolower($alg)) {
			case 'hs256':
				$signature = $this->__base64_encode_safe(hash_hmac('sha256', $data, $secret_key, true), true);
				break;
			default:
				throw new \Exception('The requested hashing algorithm is not supported.', 401);
		}
		
		return $signature;
	}
	
	private function __base64_encode_safe($data)
	{
		return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
	}
}