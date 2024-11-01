<?php
/**
 * We make an API call to embed.php from app.js angular app once website is added to translate.com for translation.
 * This scirpt will save wt_embed_code in option table in WP database.
 *
 * @package translatecom-website-translator
 */

$plugin_name = 'translatecom-website-translator';
$old_url = dirname( __FILE__ );
$new_url = str_replace( DIRECTORY_SEPARATOR . 'wp-content' . DIRECTORY_SEPARATOR . 'plugins' . DIRECTORY_SEPARATOR . $plugin_name, '', $old_url );
include( $new_url . DIRECTORY_SEPARATOR . 'wp-load.php' );
include_once( $new_url . '/wp-includes/option.php' );

check_ajax_referer( 'translate_nonce', 'secuirty' );

// Save WL embedcode in options table in database.
if ( isset( $_POST['wt_embed_code'] ) ) {
		update_option( 'wt_active', 1 );
		update_option( 'wt_embed_code', sanitize_text_field( wp_unslash( $_POST['wt_embed_code'] ) ) );
}
// Delete WL embedcode in options table in database.
if ( isset( $_POST['delete'] ) ) {
		update_option( 'wt_active', 0 );
		delete_option( 'wt_embed_code' );
}
