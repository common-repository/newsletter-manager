<?php
if ( ! defined( 'ABSPATH' ) ) 
	exit;

	
	add_action( 'admin_init', 'xyz_em_tinymce_button' );
	
	function xyz_em_tinymce_button() {
		if ( current_user_can( 'edit_posts' ) && current_user_can( 'edit_pages' ) ) {
			
			if ( get_user_option('rich_editing') == 'true') {
				
				add_filter( 'mce_buttons', 'xyz_em_register_tinymce_button' );
				add_filter( 'mce_external_plugins', 'xyz_em_add_tinymce_button' );
			}
		}
	}
	
	function xyz_em_register_tinymce_button( $buttons ) {
		$buttonName_html = 'xyz_em_selector_emoji';		
		array_push( $buttons, $buttonName_html);
		return $buttons;
	}
	
	function xyz_em_add_tinymce_button( $plugin_array ) {
	    $plugin_array['xyz_em_buttons'] = get_site_url() . '/index.php?wp_nlm=editor_plugin_js';
		return $plugin_array;
	}
?>