<<<<<<< Updated upstream:src/sendy-elements.php
<?php

/**
 * Plugin Name: Sendy Elements
 * Description: Plugin to extend Elementor forms with Sendy.
 * Version:     1.0.3
 * Author:      Jose Sotelo
 * Author URI:  https://inboundlatino.com/
 * Text Domain: sendy-elements
 */

 if ( ! defined( 'ABSPATH' ) ) {
 	exit; // Exit if accessed directly.
 }

 /**
  * Main Sendy Elements Extension Class
  *
  * The main class that initiates and runs the plugin.
  *
  * @since 1.0.0
  */
 final class Sendy_Elements {

 	/**
 	 * Plugin Version
 	 *
 	 * @since 1.0.0
 	 *
 	 * @var string The plugin version.
 	 */
 	const VERSION = '1.0.1';

 	/**
 	 * Minimum Elementor Version
 	 *
 	 * @since 1.0.0
 	 *
 	 * @var string Minimum Elementor version required to run the plugin.
 	 */
 	const MINIMUM_ELEMENTOR_VERSION = '2.5.0';

 	/**
 	 * Minimum PHP Version
 	 *
 	 * @since 1.0.0
 	 *
 	 * @var string Minimum PHP version required to run the plugin.
 	 */
 	const MINIMUM_PHP_VERSION = '5.4';

 	/**
 	 * Instance
 	 *
 	 * @since 1.0.0
 	 *
 	 * @access private
 	 * @static
 	 *
 	 * @var Sendy_Elements The single instance of the class.
 	 */
 	private static $_instance = null;

 	/**
 	 * Instance
 	 *
 	 * Ensures only one instance of the class is loaded or can be loaded.
 	 *
 	 * @since 1.0.0
 	 *
 	 * @access public
 	 * @static
 	 *
 	 * @return Sendy_Elements An instance of the class.
 	 */
 	public static function instance() {

 		if ( is_null( self::$_instance ) ) {
 			self::$_instance = new self();
 		}
 		return self::$_instance;

 	}

 	/**
 	 * Constructor
 	 *
 	 * @since 1.0.0
 	 *
 	 * @access public
 	 */
 	public function __construct() {

 		add_action( 'init', [ $this, 'i18n' ] );
 		add_action( 'plugins_loaded', [ $this, 'init' ] );

 	}

 	/**
 	 * Load Textdomain
 	 *
 	 * Load plugin localization files.
 	 *
 	 * Fired by `init` action hook.
 	 *
 	 * @since 1.0.0
 	 *
 	 * @access public
 	 */
 	public function i18n() {

 		load_plugin_textdomain( 'sendy-elements' );

 	}

 	/**
 	 * Initialize the plugin
 	 *
 	 * Load the plugin only after Elementor (and other plugins) are loaded.
 	 * Checks for basic plugin requirements, if one check fail don't continue,
 	 * if all check have passed load the files required to run the plugin.
 	 *
 	 * Fired by `plugins_loaded` action hook.
 	 *
 	 * @since 1.0.0
 	 *
 	 * @access public
 	 */
 	public function init() {

 		// Check if Elementor installed and activated
 		if ( ! did_action( 'elementor/loaded' ) ) {
 			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
 			return;
 		}

 		// Check for required Elementor version
 		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
 			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
 			return;
 		}

 		// Check for required PHP version
 		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
 			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
 			return;
		 }
		 
		 // Check if Elementor Pro Exists
		 if(!function_exists( 'elementor_pro_load_plugin' )){
            add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
            return;
        }

 		// Add Plugin actions
    require_once('plugin.php');
  }
 	/**
 	 * Admin notice
 	 *
 	 * Warning when the site doesn't have Elementor installed or activated.
 	 *
 	 * @since 1.0.0
 	 *
 	 * @access public
 	 */
 	public function admin_notice_missing_main_plugin() {

 		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

 		$message = sprintf(
 			/* translators: 1: Plugin name 2: Elementor Pro*/
 			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'sendy-elements' ),
 			'<strong>' . esc_html__( 'Sendy Elements', 'sendy-elements' ) . '</strong>',
 			'<strong>' . esc_html__( 'Elementor Pro', 'sendy-elements' ) . '</strong>'
 		);

 		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

 	}

 	/**
 	 * Admin notice
 	 *
 	 * Warning when the site doesn't have a minimum required Elementor version.
 	 *
 	 * @since 1.0.0
 	 *
 	 * @access public
 	 */
 	public function admin_notice_minimum_elementor_version() {

 		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

 		$message = sprintf(
 			/* translators: 1: Plugin name 2: Elementor Pro 3: Required Elementor Pro version */
 			esc_html__( '"%1$s" requires "%2$s" version "%3$s" or greater.', 'sendy-elements' ),
 			'<strong>' . esc_html__( 'Sendy Elements', 'sendy-elements' ) . '</strong>',
 			'<strong>' . esc_html__( 'Elementor Pro', 'sendy-elements' ) . '</strong>',
 			 self::MINIMUM_ELEMENTOR_VERSION
 		);

 		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

 	}

 	/**
 	 * Admin notice
 	 *
 	 * Warning when the site doesn't have a minimum required PHP version.
 	 *
 	 * @since 1.0.0
 	 *
 	 * @access public
 	 */
 	public function admin_notice_minimum_php_version() {

 		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

 		$message = sprintf(
 			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
 			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'sendy-elements' ),
 			'<strong>' . esc_html__( 'Sendy Elements', 'sendy-elements' ) . '</strong>',
 			'<strong>' . esc_html__( 'PHP', 'sendy-elements' ) . '</strong>',
 			 self::MINIMUM_PHP_VERSION
 		);

 		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

 	}

 }

 Sendy_Elements::instance();
=======
<?php

/**
 * Plugin Name: Sendy Elements
 * Description: Plugin to extend Elementor forms with Sendy.
 * Version:     1.0.4
 * Author:      Jose Sotelo
 * Author URI:  https://inboundlatino.com/
 * Text Domain: sendy-elements
 */

 if ( ! defined( 'ABSPATH' ) ) {
 	exit; // Exit if accessed directly.
 }

 /**
  * Main Sendy Elements Extension Class
  *
  * The main class that initiates and runs the plugin.
  *
  * @since 1.0.0
  */
 final class Sendy_Elements {

 	/**
 	 * Plugin Version
 	 *
 	 * @since 1.0.0
 	 *
 	 * @var string The plugin version.
 	 */
 	const VERSION = '1.0.1';

 	/**
 	 * Minimum Elementor Version
 	 *
 	 * @since 1.0.0
 	 *
 	 * @var string Minimum Elementor version required to run the plugin.
 	 */
 	const MINIMUM_ELEMENTOR_VERSION = '2.5.0';

 	/**
 	 * Minimum PHP Version
 	 *
 	 * @since 1.0.0
 	 *
 	 * @var string Minimum PHP version required to run the plugin.
 	 */
 	const MINIMUM_PHP_VERSION = '5.4';

 	/**
 	 * Instance
 	 *
 	 * @since 1.0.0
 	 *
 	 * @access private
 	 * @static
 	 *
 	 * @var Sendy_Elements The single instance of the class.
 	 */
 	private static $_instance = null;

 	/**
 	 * Instance
 	 *
 	 * Ensures only one instance of the class is loaded or can be loaded.
 	 *
 	 * @since 1.0.0
 	 *
 	 * @access public
 	 * @static
 	 *
 	 * @return Sendy_Elements An instance of the class.
 	 */
 	public static function instance() {

 		if ( is_null( self::$_instance ) ) {
 			self::$_instance = new self();
 		}
 		return self::$_instance;

 	}

 	/**
 	 * Constructor
 	 *
 	 * @since 1.0.0
 	 *
 	 * @access public
 	 */
 	public function __construct() {

 		add_action( 'init', [ $this, 'i18n' ] );
 		add_action( 'plugins_loaded', [ $this, 'init' ] );

 	}

 	/**
 	 * Load Textdomain
 	 *
 	 * Load plugin localization files.
 	 *
 	 * Fired by `init` action hook.
 	 *
 	 * @since 1.0.0
 	 *
 	 * @access public
 	 */
 	public function i18n() {

 		load_plugin_textdomain( 'sendy-elements' );

 	}

 	/**
 	 * Initialize the plugin
 	 *
 	 * Load the plugin only after Elementor (and other plugins) are loaded.
 	 * Checks for basic plugin requirements, if one check fail don't continue,
 	 * if all check have passed load the files required to run the plugin.
 	 *
 	 * Fired by `plugins_loaded` action hook.
 	 *
 	 * @since 1.0.0
 	 *
 	 * @access public
 	 */
 	public function init() {

 		// Check if Elementor installed and activated
 		if ( ! did_action( 'elementor/loaded' ) ) {
 			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
 			return;
 		}

 		// Check for required Elementor version
 		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
 			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
 			return;
 		}

 		// Check for required PHP version
 		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
 			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
 			return;
		 }
		 
		 // Check if Elementor Pro Exists
		 if(!function_exists( 'elementor_pro_load_plugin' )){
            add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
            return;
        }

 		// Add Plugin actions
    require_once('plugin.php');
  }
 	/**
 	 * Admin notice
 	 *
 	 * Warning when the site doesn't have Elementor installed or activated.
 	 *
 	 * @since 1.0.0
 	 *
 	 * @access public
 	 */
 	public function admin_notice_missing_main_plugin() {

 		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

 		$message = sprintf(
 			/* translators: 1: Plugin name 2: Elementor Pro*/
 			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'sendy-elements' ),
 			'<strong>' . esc_html__( 'Sendy Elements', 'sendy-elements' ) . '</strong>',
 			'<strong>' . esc_html__( 'Elementor Pro', 'sendy-elements' ) . '</strong>'
 		);

 		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

 	}

 	/**
 	 * Admin notice
 	 *
 	 * Warning when the site doesn't have a minimum required Elementor version.
 	 *
 	 * @since 1.0.0
 	 *
 	 * @access public
 	 */
 	public function admin_notice_minimum_elementor_version() {

 		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

 		$message = sprintf(
 			/* translators: 1: Plugin name 2: Elementor Pro 3: Required Elementor Pro version */
 			esc_html__( '"%1$s" requires "%2$s" version "%3$s" or greater.', 'sendy-elements' ),
 			'<strong>' . esc_html__( 'Sendy Elements', 'sendy-elements' ) . '</strong>',
 			'<strong>' . esc_html__( 'Elementor Pro', 'sendy-elements' ) . '</strong>',
 			 self::MINIMUM_ELEMENTOR_VERSION
 		);

 		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

 	}

 	/**
 	 * Admin notice
 	 *
 	 * Warning when the site doesn't have a minimum required PHP version.
 	 *
 	 * @since 1.0.0
 	 *
 	 * @access public
 	 */
 	public function admin_notice_minimum_php_version() {

 		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

 		$message = sprintf(
 			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
 			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'sendy-elements' ),
 			'<strong>' . esc_html__( 'Sendy Elements', 'sendy-elements' ) . '</strong>',
 			'<strong>' . esc_html__( 'PHP', 'sendy-elements' ) . '</strong>',
 			 self::MINIMUM_PHP_VERSION
 		);

 		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

 	}

 }

 Sendy_Elements::instance();
>>>>>>> Stashed changes:sendy-elements.php
