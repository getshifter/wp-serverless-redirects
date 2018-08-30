<?php

/*
Plugin Name: WP Serverless Redirects
Author: Daniel Olson
Author URI: https://github.com/getshifter/wp-serverless-redirects
Description: Redirects for static WordPress sites
*/

function compile_redirects(
    $routes = array(
        'redirection/v1/export/all/json'
    )
) {

    $redirects_array = array();

    foreach ($routes as $route) {
        
        $url =  esc_url( home_url( '/' ) ) . 'wp-json/wp/v2/' . $route;
        $jsonData = json_decode( file_get_contents($url) );

        $redirects_array[$route] = (array) $jsonData;
    }

    $redirects = json_encode($redirects_array);

    return $redirects;

}

function save_redirects(
        $redirects,
        $file_name = 'redirection.json'
    ) {
    $upload_dir = wp_get_upload_dir();
    $save_path = $upload_dir['basedir'] . '/wp-sls-redirects/' . $file_name;
    $dirname = dirname($save_path);
    
    if (!is_dir($dirname))
    {
        mkdir($dirname, 0755, true);
    }

    $f = fopen( $save_path , "w+" );
    fwrite($f , $redirects);
    fclose($f);
}

function build_redirects()
{
    $redirects = compile_redirects();
    save_redirects($redirects);
}

add_action( 'redirection_redirect_updated', 'build_redirects' );
add_action( 'redirection_save_options', 'build_redirects' );
add_action( 'redirection_redirect_deleted', 'build_redirects' );