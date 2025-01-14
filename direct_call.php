<?php
if ( ! defined( 'ABSPATH' ) ) exit;
function xyz_nl_plugin_query_vars($vars) {
	$vars[] = 'wp_nlm';
	return $vars;
}
add_filter('query_vars', 'xyz_nl_plugin_query_vars');


function xyz_nl_plugin_parse_request($wp) {
	/*confirmation*/
	if (array_key_exists('wp_nlm', $wp->query_vars) && $wp->query_vars['wp_nlm'] == 'confirmation') {
		require( dirname( __FILE__ ) . '/confirmation.php' );
		die;
	}
	/*cron*/
	if (array_key_exists('wp_nlm', $wp->query_vars) && $wp->query_vars['wp_nlm'] == 'cron') {
		require( dirname( __FILE__ ) . '/cron.php' );
		die;
	}
	/*cron*/
	if (array_key_exists('wp_nlm', $wp->query_vars) && $wp->query_vars['wp_nlm'] == 'download') {
		require( dirname( __FILE__ ) . '/download.php' );
		die;
	}
	/*subscription*/
	if (array_key_exists('wp_nlm', $wp->query_vars) && $wp->query_vars['wp_nlm'] == 'subscribe') {
		require( dirname( __FILE__ ) . '/subscription.php' );
		die;
	}
	/*unsubscription*/
	if (array_key_exists('wp_nlm', $wp->query_vars) && $wp->query_vars['wp_nlm'] == 'unsubscribe') {
		require( dirname( __FILE__ ) . '/unsubscription.php' );
		die;
	}
	if (array_key_exists('wp_nlm', $wp->query_vars) && $wp->query_vars['wp_nlm'] == 'unsubscribe_confirmation') {
		require( dirname( __FILE__ ) . '/shortcodes/htmlcode.php' );
		die;
	}
	if (array_key_exists('wp_nlm', $wp->query_vars) && $wp->query_vars['wp_nlm'] == 'editor_plugin_js')
	{
	    require( dirname( __FILE__ ) . '/editor_plugin.js.php' );
	    die;
	}
	
}
add_action('parse_request', 'xyz_nl_plugin_parse_request');
?>
