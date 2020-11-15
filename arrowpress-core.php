<?php
/*
Plugin Name: Arrowpress Core
Plugin URI: https://www.arrowhitech.com/
Description: Core for ArrowPress Theme.
Version: 1.0.0
Author: AHT
Author URI: https://www.arrowhitech.com/
License: MIT License
Text Domain: apr-core
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

$theme = wp_get_theme();
if ( ! empty( $theme['Template'] ) ) {
	$theme = wp_get_theme( $theme['Template'] );
}
define( 'APR_CORE_SITE_URI', site_url() );
define( 'APR_CORE_PATH', plugin_dir_url( __FILE__ ) );
define( 'APR_CORE_DIR', dirname( __FILE__ ) );
define( 'APR_CORE_THEME_NAME', $theme['Name'] );
define( 'APR_CORE_THEME_SLUG', $theme['Template'] );
define( 'APR_CORE_THEME_VERSION', $theme['Version'] );
define( 'APR_CORE_THEME_DIR', get_template_directory() );
define( 'APR_CORE_THEME_URI', get_template_directory_uri() );

if ( !class_exists( 'Apr_Core' ) ) :

    class Apr_Core {

        /*
        * This method loads other methods of the class.
        */
        function __construct() {

            /* Load define */
            $this->apr_core_define();

            /* Load check Elementor installed and activated */
            add_action( 'plugins_loaded', [ $this, 'apr_core_loaded' ] );

            /*Load script*/
            $this->apr_core_script();

        }

        /* Load define */
        function apr_core_define() {

            define('APR_VERSION', '1.0.0');

            define( 'APR_CORE_SERVER_PATH', dirname( __FILE__ ) );

        }
		
		 /* Load includes */
        function apr_core_includes() {
            require_once(APR_CORE_SERVER_PATH . '/includes/general-functions.php');
            require_once(APR_CORE_SERVER_PATH . '/includes/metabox/metabox.php');
            require_once(APR_CORE_SERVER_PATH . '/includes/metabox/class-taxonomy-metabox.php');
            require_once(APR_CORE_SERVER_PATH . '/includes/metabox/class-taxonomy-product.php');
            require_once(APR_CORE_SERVER_PATH . '/includes/widgets/class-widget.php');
            require_once(APR_CORE_SERVER_PATH . '/includes/widgets/class-widgets.php');
            require_once(APR_CORE_SERVER_PATH . '/includes/mobile-check.php');
            require_once(APR_CORE_SERVER_PATH . '/includes/posttypes/class-custom-meta-field.php');
            $postApr_Core_Taxonomy_Metabox = new Apr_Core_Taxonomy_Metabox('category');
            $productApr_Core_Taxonomy_Metabox = new Apr_Core_Taxonomy_Product_Metabox('product_cat');
            include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
            if (is_plugin_active('woocommerce/woocommerce.php')) {
                require 'includes/woocommerce/woocommerce-template-functions.php';
                require 'includes/woocommerce/class-woocommerce-extra.php';
            }

        }
		
        function apr_core_loaded() {

            /* Load languages */
            $this->apr_core_i18n();
			
			/* Load includes */
            $this->apr_core_includes();

            /* Load check Elementor installed and activated */
            if ( ! did_action( 'elementor/loaded' ) ) {
                add_action( 'admin_notices', [ $this, 'apr_core_admin_notice' ] );
                return;
            }

        }

        /* Load languages */
        function apr_core_i18n() {
            load_plugin_textdomain( 'apr-core', false, APR_CORE_PATH . 'languages' );
        }

        /* admin notice */
        function apr_core_admin_notice() {
            if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
            $apr_core_message = sprintf(
            /* translators: 1: Plugin name 2: Elementor */
                esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'apr-core' ),
                '<strong>' . esc_html__( 'Arrowpress for Elementor', 'apr-core' ) . '</strong>',
                '<strong>' . esc_html__( 'Elementor', 'apr-core' ) . '</strong>'
            );
            printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $apr_core_message );
        }
		
        /* Load script */
        function apr_core_script() {
            add_action( 'wp_enqueue_scripts', [ $this, 'apr_core_frontend_scripts' ], 999 );
            add_action( 'admin_enqueue_scripts', [ $this, 'load_admin_styles' ] );
        }
        function apr_core_frontend_scripts() {
			wp_enqueue_script( 'apr-script', APR_CORE_PATH . 'assets/js/elementor-scripts.min.js', array(), APR_VERSION );
        }
        function load_admin_styles(){
            wp_enqueue_script( 'apr-metabox-script', APR_CORE_PATH . 'assets/js/metabox.min.js', array(), APR_VERSION );
            wp_enqueue_style( 'apr-metabox-css', APR_CORE_PATH . 'assets/css/metabox.min.css', array(), APR_VERSION );
        }

    }

    new Apr_Core();

endif;
/**
 * Adding custom icon to icon control in Elementor
 */
function icon_font_custom( $controls_registry ) {
	// Get existing icons
	$icons = $controls_registry->get_control( 'icon' )->get_settings( 'options' );
	// Append new icons
	$new_icons = array_merge(
		array(
            'theme-icon-candlestick-holder' => 'Candlestick holder',
            'theme-icon-museum' => 'Museum',
            'theme-icon-vase' => 'Vase',
            'theme-icon-picture-frame' => 'Picture frame',
            'theme-icon-candlestick' => 'Candlestick',
            'theme-icon-balloon' => 'Balloon',
            'theme-icon-lamp' => 'Lamp',
            'theme-icon-scooter' => 'Scooter',
            'theme-icon-gift' => 'Gift',
            'theme-icon-destination' => 'Destination',
            'theme-icon-piece-of-cake' => 'Piece of cake',
            'theme-icon-cake' => 'Cake',
            'theme-icon-download' => 'Download',
            'theme-icon-back' => 'Back',
            'theme-icon-magnifying-glass' => 'Magnifying Glass',
            'theme-icon-upload' => 'Upload',
            'theme-icon-next' => 'Next',
            'theme-icon-star' => 'Star',
            'theme-icon-star-1' => 'Star 1',
            'theme-icon-right-quotes-symbol' => 'Right-quotes-symbol',
            'theme-icon-left-quotes-sign' => 'Reft-quotes-sign',
            'theme-icon-plus' => 'Plus',
            'theme-icon-play' => 'Play',
            'theme-icon-pinterest' => 'Pinterest',
            'theme-icon-paypal' => 'Paypal',
            'theme-icon-mastercard' => 'Mastercard',
            'theme-icon-visa-pay-logo' => 'Visa-pay-logo',
            'theme-icon-american-express-logo' => 'American-express-logo',
            'theme-icon-minus' => 'Minus',
            'theme-icon-maps-and-flags' => 'Maps-and-flags',
            'theme-icon-heart' => 'Heart',
            'theme-icon-heart1' => 'Heart 1',
            'theme-icon-google-hangouts' => 'Google hangouts',
            'theme-icon-slider' => 'Slider',
            'theme-icon-call' => 'Call',
            'theme-icon-envelope' => 'Envelope',
            'theme-icon-close' => 'Close',
            'theme-icon-nine-oclock-on-circular-clock' => 'Nine',
            'theme-icon-tick' => 'Tick',
            'theme-icon-cart' => 'Cart',
            'theme-icon-right-arrow' => 'Right arrow',
            'theme-icon-shopping-cart' => 'Shopping cart',
            'theme-icon-menu' => 'Menu',
            'theme-icon-logout' => 'Logout',
            'theme-icon-layout' => 'Layout',
            'theme-icon-user' => 'User',
            'theme-icon-pin' => 'Pin',
            'theme-icon-eye' => 'Eye',
            'theme-icon-shopping-bag' => 'Shopping-bag',
            'theme-icon-random' => 'Random',
            'theme-icon-facebook' => 'Facebook',
            'theme-icon-twitter' => 'Twitter',
            'theme-icon-home' => 'Home',
            'theme-icon-settings' => 'Settings',
            'theme-icon-return-box' => 'Return box',
            'theme-icon-support' => 'Support',
            'theme-icon-free-delivery' => 'Free delivery',
            'theme-icon-search-1' => 'Search1',
            'theme-icon-shopping-cart1' => 'Cart1',
            'theme-icon-shuffle' => 'Shuffle',
            'theme-icon-diagram' => 'Diagram',
            'theme-icon-user2' => 'User2',
            'theme-icon-like' => 'Like',
            'theme-icon-search' => 'Search',
            'theme-icon-user3' => 'User3',
            'theme-icon-policy' => 'Policy',
            'theme-icon-paint-palette' => 'Palette',
            'theme-icon-sewing-machine' => 'Machine',
            'theme-icon-delivery-bike' => 'Bike',
            'theme-icon-problem-solving' => 'Solving',
            'theme-icon-confetti' => 'Confetti',
            'theme-icon-goal' => 'Goal',
            'theme-icon-pinky-promise' => 'Pinky promise',
            'theme-icon-vision' => 'Vision',
            'theme-icon-phone-call-1' => 'Phone call 1',
            'theme-icon-placeholder' => 'Placeholder',
            'theme-icon-phone-call' => 'Phone call',

 		),
		$icons
	);
	// Then we set a new list of icons as the options of the icon control
	$controls_registry->get_control( 'icon' )->set_settings( 'options', $new_icons );
}
add_action( 'elementor/controls/controls_registered', 'icon_font_custom', 10, 1 );


