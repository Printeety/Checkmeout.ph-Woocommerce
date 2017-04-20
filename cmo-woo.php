<?php
/*
   Plugin Name: Checkmeout for WooCommerce
   Plugin URI: http://www.checkmeout.ph
   Description: a plugin for paying and delivery using checkmeout
   Version: 1.0
   Author: 98Labs Inc.
   Author URI: http://98labs.com
   License: GPL2
*/
   if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function cmo_woo_gateway() {
	static $plugin;

	if ( ! isset( $plugin ) ) {
		require_once( 'includes/class-wc-gateway-cmo-plugin.php' );

		$plugin = new WC_Gateway_Cmo_Plugin( __FILE__, '1.2.0' );
	}

	return $plugin;
}

cmo_woo_gateway()->maybe_run();

?>

