<?php
/*
Plugin Name: User Access Shortcodes
Plugin URI: https://wpdarko.zendesk.com/hc/en-us/articles/206303637-Get-started-with-the-User-Access-Shortcodes-plugin
Description: "The most simple way of controlling who sees what in your posts/pages". This plugin adds a button to your post editor, allowing you to restrict content to logged in users only (or guests) with a simple shortcode. Find help and information on our <a href="http://wpdarko.com/support/">support site</a>. This free version is NOT limited and does not contain any ad. The <a href='http://wpdarko.com/items/user-access-shortcodes/'>PRO version</a> allows you target/include/exclude specific users and more.
Version: 1.3
Author: WP Darko
Author URI: http://wpdarko.com
License: GPL2
 */

function uasc_free_pro_check() {
    if (is_plugin_active('user-access-shortcodes-pro/uasc_pro.php')) {
        
        function my_admin_notice(){
        echo '<div class="updated">
                <p><strong>PRO</strong> version is activated.</p>
              </div>';
        }
        add_action('admin_notices', 'my_admin_notice');
        
        deactivate_plugins(__FILE__);
    }
}

add_action( 'admin_init', 'uasc_free_pro_check' );

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
        return do_shortcode($content);   
    else :      
        return do_shortcode($content);
    endif;
}

add_shortcode( 'UAS_loggedin', 'uasc_loggedin_sc' );

function uasc_loggedin_sc( $atts, $content = null ) {
    if ( is_user_logged_in() ) :
        return do_shortcode($content); 
    else :      
        $content = '';
        return do_shortcode($content);
    endif;
}
?>