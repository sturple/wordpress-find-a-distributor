<?php
/**
 * Plugin Name: Wordpress Find a Distributor
 * Plugin URI: https://github.com/sturple/wordpress-find-a-distributor/
 * Description: Wordpress plugin to add custom post type distributor with shortcode interface to find a distributor with google map
 * Version: 0.0.1
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
    $api_key='';    //  TODO: Better solution for this
    $geo=new \Fgms\Distributor\GoogleMapsGeocoder($api_key);
    $controller=new \Fgms\Distributor\ControllerImpl(new \Fgms\Distributor\WordPressImpl(),$wpdb,$geo);
});

?>