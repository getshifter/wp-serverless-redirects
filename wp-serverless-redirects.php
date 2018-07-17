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

add_action('wp_head', 'wp_sls_redir_enqueue_script');


function wp_sls_redir_export() {

    $file = 'redirects.json';
    $upload_dir = wp_get_upload_dir();
    $save_path = $upload_dir['basedir'] . '/wp-sls-redirects';

    if (!is_dir($save_path)) {
        mkdir($save_path, 0755, true);
    }

    exec('wp redirection export all '. $file .' --format=json');
    exec('mv ' . $file . ' ' . $save_path );

}

add_action( 'save_post', 'wp_sls_redir_export' );