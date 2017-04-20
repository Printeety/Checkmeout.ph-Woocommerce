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
	protected $_supported_locales = array(
		'da_DK',
		'de_DE',
		'en_AU',
		'en_GB',
		'en_US',
		'es_ES',
		'fr_CA',
		'fr_FR',
		'he_IL',
		'id_ID',
		'it_IT',
		'ja_JP',
		'nl_NL',
		'no_NO',
		'pl_PL',
		'pt_BR',
		'pt_PT',
		'ru_RU',
		'sv_SE',
		'th_TH',
		'tr_TR',
		'zh_CN',
		'zh_HK',
		'zh_TW',
	);

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
	 * @since 1.2.0
	 *
	 * @param bool $force_reload Force reload settings
	 *
	 * @return WC_Gateway_PPEC_Settings Instance of WC_Gateway_PPEC_Settings
	 */
	public function load( $force_reload = false ) {
		if ( $this->_is_setting_loaded && ! $force_reload ) {
			return $this;
		}
		$this->_settings          = (array) get_option( 'woocommerce_ppec_paypal_settings', array() );
		$this->_is_setting_loaded = true;
		return $this;
	}
}
