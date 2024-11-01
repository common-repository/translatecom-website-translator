<?php
/**
 * This script loads settings.html in an iframe.
 *
 * @package translatecom-website-translator
 */

$plugin_name = 'translatecom-website-translator';
$old_url = dirname( __FILE__ );
$new_url = str_replace( DIRECTORY_SEPARATOR . 'wp-content' . DIRECTORY_SEPARATOR . 'plugins' . DIRECTORY_SEPARATOR . $plugin_name, '', $old_url );
include( $new_url . DIRECTORY_SEPARATOR . 'wp-load.php' );
include_once( $new_url . '/wp-includes/option.php' );
$translate_nonce = wp_create_nonce( 'translate_nonce' );

?>

<script>
  //Set api_key, email and domain in localstorage.
  //which will be used in app.js.
  localStorage.setItem('api_key', 'GrsYcRGeyWszS94M2my8J2ZwsZxBFG');
  localStorage.setItem('email', '<?php echo esc_attr( get_option( 'admin_email' ) ); ?>');
  localStorage.setItem('domain', '<?php echo esc_attr( get_option( 'siteUrl' ) ); ?>');
  localStorage.setItem('translate_nonce', '<?php echo esc_attr( $translate_nonce ); ?>');
</script>

<!-- Check if wt_embdecode is present in database -->
<?php if ( intval( get_option( 'wt_active' ) ) === 1 ) : ?>
	<script>
	  //Set is_registered yes so that we don't display registration form.
	  localStorage.setItem('is_registered', 'yes');
	</script>
<?php else : ?>
	<script>
	  //Set is_registered yes so that we don't display registration form.
	  localStorage.removeItem('is_registered');
	</script>
<?php endif;?>
<!-- Open settings.html in iframe -->
<div style="height: 100%">
	<iframe src="<?php echo esc_attr( plugins_url() ) . '/translatecom-website-translator/settings.html'?>" frameborder="0" scrolling="no" width="100%" height="1100px"></iframe>
</div>
