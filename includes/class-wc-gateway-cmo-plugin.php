<?php
/**
 * CMO Express Checkout Plugin.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class WC_Gateway_CMO_Plugin {

		/**
	 * Filepath of main plugin file.
	 *
	 * @var string
	 */
	public $file;

	/**
	 * Plugin version.
	 *
	 * @var string
	 */
	public $version;

	/**
	 * Absolute plugin path.
	 *
	 * @var string
	 */
	public $plugin_path;

	/**
	 * Absolute plugin URL.
	 *
	 * @var string
	 */
	public $plugin_url;

	/**
	 * Absolute path to plugin includes dir.
	 *
	 * @var string
	 */
	public $includes_path;

	/**
	 * Flag to indicate the plugin has been boostrapped.
	 *
	 * @var bool
	 */
	private $_bootstrapped = false;

	public function __construct( $file, $version ) {
		$this->file    = $file;
		$this->version = $version;
		$this->plugin_path   = trailingslashit( plugin_dir_path( $this->file ) );
		$this->plugin_url    = trailingslashit( plugin_dir_url( $this->file ) );
		$this->includes_path = $this->plugin_path . trailingslashit( 'includes' );
	}

	public function bootstrap() {
		try {
			if ( $this->_bootstrapped ) {
				throw new Exception( __( '%s in WooCommerce Gateway CMO plugin can only be called once', 'woocommerce-gateway-cmo-checkout' ), self::ALREADY_BOOTSTRAPED );
			}
			
			$this->_run();
			$this->_bootstrapped = true;
		} catch ( Exception $e ) {
			// TODO
		}
	}

		public function maybe_run() {
		// register_activation_hook( $this->file, array( $this, 'activate' ) );

		 add_action( 'plugins_loaded', array( $this, 'bootstrap' ) );
		 add_filter( 'plugin_action_links_' . plugin_basename( $this->file ), array( $this, 'plugin_action_links' ) );
	}

		/**
	 * Run the plugin.
	 */
	protected function _run() {
		require_once( $this->includes_path . 'functions.php' );
		$this->_load_handlers();
	}

	/**
	 * Load handlers.
	 */
	protected function _load_handlers() {
		//$this->_load_client(); TODO : check implem

		// Load handlers.
		require_once($this->includes_path . 'class-wc-gateway-settings.php');
		require_once($this->includes_path . 'class-wc-gateway-cmo-jwt.php');
		require_once( $this->includes_path . 'class-wc-gateway-cmo-gateway-loader.php' );
		require_once( $this->includes_path . 'class-wc-gateway-cmo-cart-handler.php' );
		require_once( $this->includes_path . 'class-wc-gateway-cmo-checkout-handler.php' );
		require_once( $this->includes_path . 'class-wc-gateway-cmo-client.php' );
		require_once( $this->includes_path . 'class-wc-gateway-cmo-callback-handler.php' );
		
		$this->settings       = new WC_Gateway_Cmo_Settings();
		$this->jwt       			= new WC_Gateway_Cmo_JWT();
		$this->gateway_loader = new WC_Gateway_CMO_Gateway_Loader();
		$this->cart           = new WC_Gateway_CMO_Cart_Handler();
		$this->checkout       = new WC_Gateway_CMO_Checkout_Handler();
		$this->client 		  = new WC_Gateway_CMO_Client();
	}
	
	/**
	 * Link to settings screen.
	 *
	 * @return mixed
	 */
	public function get_admin_setting_link() {
		if ( version_compare( WC()->version, '2.6', '>=' ) ) {
			$section_slug = 'checkmeout';
		} else {
			$section_slug = strtolower( 'WC_Gateway_CMO' );
		}
		return admin_url( 'admin.php?page=wc-settings&tab=checkout&section=' . $section_slug );
	}
	
	/**
	 * TODO : add correct docs and plugin links
	 *
	 * @param $links
	 * @return array
	 */
	public function plugin_action_links( $links ) {
		$setting_url = $this->get_admin_setting_link();

		$plugin_links = array(
			'<a href="' . esc_url( $setting_url ) . '">' . esc_html__( 'Settings', 'woocommerce-gateway-cmo-checkout' ) . '</a>',
			'<a href="https://docs.woocommerce.com/document/cmo-checkout/">' . esc_html__( 'Docs', 'woocommerce-gateway-cmo-checkout' ) . '</a>',
		);
		return array_merge( $plugin_links, $links );
	}

}