<?php

function woo_cmo_start_checkout() {
	$checkout = wc_gateway_cmo()->checkout;
	try {
		$result = $checkout->get_cmo_order_url();
        var_dump($result);
		wp_redirect( $result->link );
		exit;
	} catch( Exception $e ) {
		wc_add_notice( $e->getMessage(), 'error' );

		$redirect_url = WC()->cart->get_cart_url();
		$settings     = wc_gateway_ppec()->settings;
		$client       = wc_gateway_ppec()->client;

		if ( $settings->is_enabled() && $client->get_payer_id() ) {
			ob_end_clean();
			?>
                <h1>error</h1>
			<?php
			exit;
		} else {
			wp_safe_redirect( $redirect_url );
			exit;
		}

	}
}
