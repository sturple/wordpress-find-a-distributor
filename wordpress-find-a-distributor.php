<?php
/**
 * Plugin Name: Wordpress Find a Distributor
 * Plugin URI: https://github.com/sturple/wordpress-find-a-distributor/
 * Description: Wordpress plugin to add custom post type distributor with shortcode interface to find a distributor with google map
 * Version: 0.0.2
 * Author: Shawn Turple / Robert Leahy
 * Author URI: http://turple.ca
 * License: GPL-3.0
 */


call_user_func(function () {
    $rel='vendor/autoload.php';
    $search=[__DIR__.'/',ABSPATH];
    $where=null;
    foreach ($search as $path) {
        $w=$path.$rel;
        if (!file_exists($w)) continue;
        $where=$w;
        break;
    }
    if (is_null($where)) throw new \RuntimeException('Could not find autoloader');

    require_once $where;


});
call_user_func(function () {
    global $wpdb;

    $prefix='fgms-distributor-';
    $domain='fgms-distributor';
    $wp=new \Fgms\WordPress\WordPressImpl();
    $settings=new \Fgms\Distributor\SettingsImpl($wp,$prefix,$domain);
    $geo=new \Fgms\Distributor\GoogleMapsGeocoder($settings->getApiKey(),new \Fgms\Distributor\GoogleMapsGeocoderPickFirstAmbiguityResolutionStrategy());
    $controller=new \Fgms\Distributor\ControllerImpl($wp,$wpdb,$geo,$prefix,$domain);
    $output_maps=true;
    add_action('wp_enqueue_scripts',function () use ($domain) {   wp_enqueue_style($domain,plugin_dir_url(__FILE__).'style.css'); });
    add_filter('fgms-distributor-shortcode-filter',function ($str) use (&$output_maps) {
        if ($str!=='') return $str;
        wp_enqueue_script('jquery');
        ob_start();
        require_once __DIR__.'/allowed-tags.php';
        require __DIR__.'/shortcode.php';
        $retr=ob_get_contents();
        ob_end_clean();
        return $retr;
    });
    add_filter('fgms-distributor-distributor-filter',function ($str, \WP_Post $post, $obj) {
        if ($str!=='') return $str;
        unset($str);
        extract((array)$obj);
        unset($obj);
        ob_start();
        require __DIR__.'/distributor.php';
        $retr=ob_get_contents();
        ob_end_clean();
        return $retr;
    },10,3);
});

?>
