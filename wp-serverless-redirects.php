<?php

/*
Plugin Name: WP Serverless Redirects
Author: Daniel Olson
Author URI: https://github.com/getshifter/wp-serverless-redirects
Description: Redirects for static WordPress sites
*/

function wp_sls_redir_enqueue_script() {   
    wp_enqueue_script( 'wp_sls_redirects', plugin_dir_url( __FILE__ ) . 'js/wp-serverless-redirects.js' );
}

add_action('wp_enqueue_scripts', 'wp_sls_redir_enqueue_script');