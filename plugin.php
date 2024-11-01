<?php
/**
 * Plugin Name: Translate
 * Plugin URI: https://translate.com
 * Description: Configures and installs Translate.com's Website Translator code into your WordPress site.
 * Version: 2.2
 * Author: Translate.com
 * Author URI: https://translate.com
 * License: GPLv2
 *
 * @package translatecom-website-translator
 */

defined( 'ABSPATH' ) || die( 'No direct access allowed' );

$plugin_name = 'translatecom-website-translator';
include_once( ABSPATH . '/wp-includes/option.php' );

// Define wp_head action to add script tag in WP header.
add_action( 'wp_head', 'translate_website_translator' );
// Define action for adding menu in admin panel.
add_action( 'admin_menu', 'translate_website_translator_plugin_menu' );
// Define plugin activation hook.
register_activation_hook( __FILE__, 'translate_wt_activate' );
// Define plugin deactivation hook.
register_deactivation_hook( __FILE__, 'translate_wt_deactivate' );
// Define plugin uninstall hook.
register_uninstall_hook( __FILE__, 'translate_wt_uninstall' );

/**
 * Set wt_active option to 1 when plugin is activated
 */
function translate_wt_activate() {
	update_option( 'wt_active', 1 );
}

/**
 * Set wt_active option to 0 when plugin is deactivated.
 */
function translate_wt_deactivate() {
	update_option( 'wt_active', 0 );
}

/**
 * Delete embedcode option from database.
 */
function translate_wt_uninstall() {
	delete_option( 'wt_embed_code' );
}

/**
 * Add script tag in header of the website to show WL widget.
 */
function translate_website_translator() {
	if ( intval( get_option( 'wt_active' ) ) === 1 ) {
		$script  = "try{TranslateJS.init({'key':'API_KEY'});}catch(e){}";
		$api_key = esc_attr( stripslashes( get_option( 'wt_embed_code' ) ) );
		$script  = str_replace( 'API_KEY', $api_key, $script );
		wp_enqueue_script( 'translate-wl', 'https://wt-js.translate.com/translate.js' );
		wp_add_inline_script( 'translate-wl', $script );
	}
}

/**
 * Open plugin front end from admin panel.
 */
function translate_website_translator_plugin_menu() {
	$plugins_url = plugins_url();
	add_menu_page( 'Translate.com Website Translator Settings', 'Translate.com', 'administrator', 'translatecom-website-translator', 'translate_website_translator_settings_page', $plugins_url . '/translatecom-website-translator/img/logo.png' );
}

/**
 * Show plugin front end.
 */
function translate_website_translator_settings_page() {
	include_once( 'iframe.php' );
}

