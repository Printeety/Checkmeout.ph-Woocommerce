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

		// Path.
		$this->plugin_path   = trailingslashit( plugin_dir_path( $this->file ) );
		$this->plugin_url    = trailingslashit( plugin_dir_url( $this->file ) );
		$this->includes_path = $this->plugin_path . trailingslashit( 'includes' );

		// Updates
		// if ( version_compare( $version, get_option( 'wc_ppec_version' ), '>' ) ) {
		// 	$this->run_updater( $version );
		// }
	}

	public function bootstrap() {
		try {
			if ( $this->_bootstrapped ) {
				throw new Exception( __( '%s in WooCommerce Gateway CMO plugin can only be called once', 'woocommerce-gateway-cmo-checkout' ), self::ALREADY_BOOTSTRAPED );
			}

			// $this->_check_dependencies();
			$this->_run();
			// $this->_check_credentials();

			$this->_bootstrapped = true;
			// delete_option( 'wc_gateway_ppce_bootstrap_warning_message' );
			// delete_option( 'wc_gateway_ppce_prompt_to_connect' );
		} catch ( Exception $e ) {
			//add_action( 'admin_notices', array( $this, 'show_bootstrap_warning' ) );
		}
	}

		public function maybe_run() {
		// register_activation_hook( $this->file, array( $this, 'activate' ) );

		 add_action( 'plugins_loaded', array( $this, 'bootstrap' ) );
		// add_filter( 'allowed_redirect_hosts' , array( $this, 'whitelist_paypal_domains_for_redirect' ) );
		// add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		add_filter( 'plugin_action_links_' . plugin_basename( $this->file ), array( $this, 'plugin_action_links' ) );
	}

		/**
	 * Run the plugin.
	 */
	protected function _run() {
		//require_once( $this->includes_path . 'functions.php' );
		$this->_load_handlers();
	}

	/**
	 * Load handlers.
	 */
	protected function _load_handlers() {
		// Client.
		//$this->_load_client();

		// Load handlers.
		//require_once( $this->includes_path . 'class-wc-gateway-cmo-settings.php' );
		require_once( $this->includes_path . 'class-wc-gateway-cmo-gateway-loader.php' );
			
		//$this->settings       = new WC_Gateway_Cmo_Settings();
		$this->gateway_loader = new WC_Gateway_CMO_Gateway_Loader();
	}

	/**
	 * Link to settings screen.
	 */
	public function get_admin_setting_link() {
		if ( version_compare( WC()->version, '2.6', '>=' ) ) {
			$section_slug = 'checkmeout';
		} else {
			$section_slug = strtolower( 'WC_Gateway_CMO' );
		}
		return admin_url( 'admin.php?page=wc-settings&tab=checkout&section=' . $section_slug );
	}

	// Notes : Change this later to point to CMO checkout plugin doc
	public function plugin_action_links( $links ) {
		$setting_url = $this->get_admin_setting_link();

		$plugin_links = array(
			'<a href="' . esc_url( $setting_url ) . '">' . esc_html__( 'Settings', 'woocommerce-gateway-paypal-express-checkout' ) . '</a>',
			'<a href="https://docs.woocommerce.com/document/paypal-express-checkout/">' . esc_html__( 'Docs', 'woocommerce-gateway-paypal-express-checkout' ) . '</a>',
		);
		return array_merge( $plugin_links, $links );
	}

}