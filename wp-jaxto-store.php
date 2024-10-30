<?php
/*
Plugin Name: Jaxto - Connecting Independent Stores
Plugin URI: http://jaxto.in/
Description: Plugin that converts your WooCommerce Store with Global Platform for unified Login, Loyalty and Discount discovery.
Version: 1.1.0
Author: JAXTO
Author URI: http://twistmobile.in/
License: MIT License
Text Domain: wordpress-jaxto-store
Domain Path: /languages
*/

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

// --------------------------------------------------------------------

global $JAXTO_VERSION;
global $JAXTO_PROVIDERS_CONFIG;
global $JAXTO_COMPONENTS;
global $JAXTO_ADMIN_TABS;

$JAXTO_VERSION = "1.1.0";

/**
* This file might be used to :
*     1. Redefine JAXTO constants, so you can move JAXTO folder around.
*     2. Define JAXTO Pluggable PHP Functions. See http://jaxto.in/developer-api-functions.html
*     5. Implement your JAXTO hooks.
*/
if( file_exists( WP_PLUGIN_DIR . '/wp-jaxto-store-custom.php' ) )
{
	include_once( WP_PLUGIN_DIR . '/wp-jaxto-store-custom.php' );
}

/**
* Define JAXTO constants, if not already defined
*/
defined( 'JAXTO_ABS_PATH' ) || define( 'JAXTO_ABS_PATH', plugin_dir_path( __FILE__ ) );

defined( 'JAXTO_PLUGIN_URL' ) || define( 'JAXTO_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require_once( JAXTO_ABS_PATH . 'class-wp-jaxto-store.php' );
// Register hooks that are fired when the plugin is activated, deactivated, and uninstalled, respectively.
register_activation_hook( __FILE__, array( 'jaxto_main_class', 'jaxto_plugin_activate' ) );
//Code For Deactivation 
register_deactivation_hook( __FILE__, array( 'jaxto_main_class', 'jaxto_plugin_deactivate_plugin' ) );
jaxto_main_class::get_instance();

//Widgets
require_once( JAXTO_ABS_PATH . 'includes/widgets/class-wp-jaxto-store_widget.php' );
function jaxto_wp_widget() {
	register_widget( 'jaxto_widget' );
}
add_action( 'widgets_init', 'jaxto_wp_widget' );
//sortcode-Widget
add_shortcode("jaxto-app-link", "jaxto_sortcode_handler");
add_action('wp_footer', 'jaxto_sortcode_handler_footer', 100);
add_filter( 'wp_nav_menu_items', 'jaxto_menu_item', 10, 2 );
add_shortcode("jaxto-qrcode-app-link", "jaxto_qr_code");

//added for redirect after plugin activation.
register_activation_hook(__FILE__, 'jaxto_app_plugin_activate');
add_action('admin_init', 'jaxto_app_plugin_redirect');


function jaxto_app_plugin_activate() {
    add_option('jaxto_app_plugin_do_activation_redirect', true);
	
}
// Solution 1
function jaxto_app_plugin_redirect() {
    if (get_option('jaxto_app_plugin_do_activation_redirect', false)) {
        delete_option('jaxto_app_plugin_do_activation_redirect');
        wp_redirect('admin.php?page=wordpress-jaxto-store');
	exit;
    }
}

/**
* Check for Wordpress 3.0
*/
function jaxto_activate()
{
	/*if( ! function_exists( 'register_post_status' ) )
	{
		deactivate_plugins( basename( dirname( __FILE__ ) ) . '/' . basename (__FILE__) );

		wp_die( __( "This plugin requires WordPress 3.0 or newer. Please update your WordPress installation to activate this plugin.", 'wordpress-jaxto-store' ) );
	}*/
}

register_activation_hook( __FILE__, 'jaxto_activate' );

/**
* Attempt to install/migrate/repair JAXTO upon activation
*
* Create jaxto tables
* Migrate old versions
* Register default components
*/
function jaxto_install()
{
	jaxto_database_install();

	jaxto_update_compatibilities();

	jaxto_register_components();
}

register_activation_hook( __FILE__, 'jaxto_install' );

/**
* Add a settings to plugin_action_links
*/
function jaxto_add_plugin_action_links( $links, $file )
{
	static $this_plugin;

	if( ! $this_plugin )
	{
		$this_plugin = plugin_basename( __FILE__ );
	}

	if( $file == $this_plugin )
	{
		$jaxto_links  = '<a href="admin.php?page=wordpress-jaxto-store">' . __( "Settings" ) . '</a>';

		array_unshift( $links, $jaxto_links );
	}

	return $links;
}

add_filter( 'plugin_action_links', 'jaxto_add_plugin_action_links', 10, 2 );

/**
* Add faq and user guide links to plugin_row_meta
*/
function jaxto_add_plugin_row_meta( $links, $file )
{
	static $this_plugin;

	if( ! $this_plugin )
	{
		$this_plugin = plugin_basename( __FILE__ );
	}
	
	if( $file == $this_plugin )
	{
		
		$links[2] = '<a href="http://jaxto.in/">'.__( "View details" , 'wordpress-jaxto-store' ).'</a>';
	}

	return $links;
}

add_filter( 'plugin_row_meta', 'jaxto_add_plugin_row_meta', 10, 2 );

/**
* Loads the plugin's translated strings.
*
* http://codex.wordpress.org/Function_Reference/load_plugin_textdomain
*/
if( ! function_exists( 'jaxto_load_plugin_textdomain' ) )
{
	function jaxto_load_plugin_textdomain()
	{
		load_plugin_textdomain( 'wordpress-jaxto-store', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}
}

add_action( 'plugins_loaded', 'jaxto_load_plugin_textdomain' );

/**
* Return the current used JAXTO version
*/
if( ! function_exists( 'jaxto_get_version' ) )
{
	function jaxto_get_version()
	{
		global $JAXTO_VERSION;
		return $JAXTO_VERSION;
	}
}

/* 
includes 
*/

# JAXTO Setup & Settings
require_once( JAXTO_ABS_PATH . 'includes/settings/jaxto.providers.php'            ); // List of supported providers (mostly provided by hybridauth library)
require_once( JAXTO_ABS_PATH . 'includes/settings/jaxto.database.php'             ); // Install/Uninstall JAXTO database tables
require_once( JAXTO_ABS_PATH . 'includes/settings/jaxto.initialization.php'       ); // Check JAXTO requirements and register JAXTO settings
require_once( JAXTO_ABS_PATH . 'includes/settings/jaxto.compatibilities.php'      ); // Check and upgrade JAXTO database/settings (for older versions)

# JAXTO Admin interfaces
if( is_admin() && ( !defined( 'DOING_AJAX' ) || !DOING_AJAX ) )
{
	require_once( JAXTO_ABS_PATH . 'includes/admin/jaxto.admin.ui.php'        ); // The entry point to JAXTO Admin interfaces
}

// --------------------------------------------------------------------
