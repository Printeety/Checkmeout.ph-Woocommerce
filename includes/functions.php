<?php

function woo_cmo_start_checkout() {
	$checkout = wc_gateway_cmo()->checkout;

	try {
		$result = $checkout->get_cmo_order_url();

		wp_redirect( $result->link );
		exit;
	} catch( PayPal_API_Exception $e ) {
		wc_add_notice( $e->getMessage(), 'error' );

		$redirect_url = WC()->cart->get_cart_url();
		$settings     = wc_gateway_ppec()->settings;
		$client       = wc_gateway_ppec()->client;

		if ( $settings->is_enabled() && $client->get_payer_id() ) {
			ob_end_clean();
			?>
			<script type="text/javascript">
				if( ( window.opener != null ) && ( window.opener !== window ) &&
						( typeof window.opener.paypal != "undefined" ) &&
						( typeof window.opener.paypal.checkout != "undefined" ) ) {
					window.opener.location.assign( "<?php echo $redirect_url; ?>" );
					window.close();
				} else {
					window.location.assign( "<?php echo $redirect_url; ?>" );
				}
			</script>
			<?php
			exit;
		} else {
			wp_safe_redirect( $redirect_url );
			exit;
		}

	}
}