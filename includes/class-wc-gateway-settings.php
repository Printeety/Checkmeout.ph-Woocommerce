<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handles settings retrieval from the settings API.
 */
class WC_Gateway_CMO_Settings {
	
	/**
	 * Setting values from get_option.
	 *
	 * @var array
	 */
	protected $_settings = array();
	
	/**
	 * List of locales supported by PayPal.
	 *
	 * @var array
	 */
	protected $_supported_locales = array('en_US');
	
	/**
	 * Flag to indicate setting has been loaded from DB.
	 *
	 * @var bool
	 */
	private $_is_setting_loaded = false;
	
	public function __set( $key, $value ) {
		if ( array_key_exists( $key, $this->_settings ) ) {
			$this->_settings[ $key ] = $value;
		}
	}
	
	public function __get( $key ) {
		if ( array_key_exists( $key, $this->_settings ) ) {
			return $this->_settings[ $key ];
		}
		return null;
	}
	
	public function __isset( $name ) {
		return array_key_exists( $key, $this->_settings );
	}
	
	public function __construct() {
		$this->load();
	}
	
	/**
	 * Load settings from DB.
	 *
	 * @param bool $force_reload Force reload settings
	 *
	 * @return WC_Gateway_CMO_Settings Instance of WC_Gateway_CMO_Settings
	 */
	public function load( $force_reload = false ) {
		if ( $this->_is_setting_loaded && ! $force_reload ) {
			return $this;
		}
		$this->_settings          = (array) get_option( 'woocommerce_checkmeout_settings', array() );
		
		$this->_is_setting_loaded = true;
		return $this;
	}
	
	/**
	 * Load settings from DB.
	 *
	 * @deprecated
	 */
	public function load_settings( $force_reload = false ) {
		return $this->load( $force_reload );
	}
	
	/**
	 * Save current settings.
	 */
	public function save() {
		update_option( 'woocommerce_cmo_settings', $this->_settings );
	}
	
	/**
	 * TODO : should be put the url generator here?
	 *
	 * @return string redirect URL
	 */
	public function get_cmo_redirect_url( $token, $commit = false ) {
		return null;
	}
	
	/**
	 * Is CMO enabled.
	 *
	 * @return bool
	 */
	public function is_enabled() {
		return 'yes' === $this->enabled;
	}
	
	/**
	 * Is logging enabled.
	 *
	 * @return bool
	 */
	public function is_logging_enabled() {
		return 'yes' === $this->debug;
	}
	
	/**
	 * Subtotal mismatches.
	 *
	 * @return string
	 */
	public function get_subtotal_mismatch_behavior() {
		return 'drop' === $this->subtotal_mismatch_behavior ? 'drop' : 'add';
	}
	
	/**
	 * Get session length.
	 *
	 * @todo Map this to a merchant-configurable setting
	 *
	 * @return int
	 */
	public function get_token_session_length() {
		return 10800; // 3h
	}
	
	/**
	 * Get brand name form settings.
	 *
	 * Default to site's name if brand_name in settings empty.
	 *
	 * @since 1.2.0
	 *
	 * @return string
	 */
	public function get_brand_name() {
		$brand_name = $this->brand_name ? $this->brand_name : get_bloginfo( 'name', 'display' );
		
		/**
		 * Character length and limitations for this parameter is 127 single-byte
		 * alphanumeric characters.
		 *
		 * @see https://developer.paypal.com/docs/classic/api/merchant/SetExpressCheckout_API_Operation_NVP/
		 */
		if ( ! empty( $brand_name ) ) {
			$brand_name = substr( $brand_name, 0, 127 );
		}
		
		/**
		 * Filters the brand name in cmo hosted checkout pages.
		 *
		 * @since 1.2.0
		 *
		 * @param string Brand name
		 */
		return apply_filters( 'woocommerce_cmo_checkout_get_brand_name', $brand_name );
	}
	
	/**
	 * Get number of digits after the decimal point.
	 *
	 * @since 1.2.0
	 *
	 * @return int Number of digits after the decimal point. Either 2 or 0
	 */
	public function get_number_of_decimal_digits() {
		return 2;
	}
}
