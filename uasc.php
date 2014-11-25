<?php
/**
 * Plugin Name: User Access Shortcodes
 * Plugin URI: http://wpdarko.com/darko-tools/user-access-shortcodes/
 * Description: "The most simple way of controlling who sees what on your website". This plugin adds a button to your post editor, allowing you to restrict content to logged in users only (or guests) with a simple shortcode. Find support and information on the <a href="http://wpdarko.com/darko-tools/user-access-shortcodes/">plugin's page</a>. This is a free plugin, it is NOT limited and does not contain any ad.
 * Version: 1.0
 * Author: WP Darko
 * Author URI: http://wpdarko.com
 * License: GPL2
 */

add_action( 'admin_head', 'uasc_css' );

function uasc_css()
{
    echo '
    <style>
        i.mce-i-uasc-mce-icon {
	       background-image: url("http://localhost:8888/plugin_dev/wp-content/plugins/user-access-shortcodes/img/uasc-icon.png");
        }
    </style>
    ';
}

// Hooks your functions into the correct filters
function uasc_add_mce_button() {
	// check user permissions
	if ( !current_user_can( 'edit_posts' ) && !current_user_can( 'edit_pages' ) ) {
		return;
	}
	// check if WYSIWYG is enabled
	if ( 'true' == get_user_option( 'rich_editing' ) ) {
		add_filter( 'mce_external_plugins', 'uasc_add_tinymce_plugin' );
		add_filter( 'mce_buttons', 'uasc_register_mce_button' );
	}
}
add_action('admin_head', 'uasc_add_mce_button');

// Declare script for new button
function uasc_add_tinymce_plugin( $plugin_array ) {
	$plugin_array['uasc_mce_button'] = plugins_url('/js/uasc-mce-button.js', __FILE__);
	return $plugin_array;
}

// Register new button in the editor
function uasc_register_mce_button( $buttons ) {
	array_push( $buttons, 'uasc_mce_button' );
	return $buttons;
}

add_shortcode( 'UAS_guest', 'uasc_guest_sc' );

function uasc_guest_sc( $atts, $content = null ) {
    if ( is_user_logged_in() ) :
        $content = '';
        return $content;   
    else :      
        return $content;
    endif;
}

add_shortcode( 'UAS_loggedin', 'uasc_loggedin_sc' );

function uasc_loggedin_sc( $atts, $content = null ) {
    if ( is_user_logged_in() ) :
        return $content; 
    else :      
        $content = '';
        return $content;
    endif;
}
?>