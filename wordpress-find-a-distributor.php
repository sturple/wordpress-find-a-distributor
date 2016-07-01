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


use Fgms\Distributor\Controller;
use Fgms\Distributor\Geocoder;


spl_autoload_register( function($class_name) {
    // not sure why it is trying to find ACF.php ( i think this is advanced custom fields php)
    if ($class_name !== 'ACF') {
        $classes_dir = realpath( plugin_dir_path( __FILE__ ) ) . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR;
        $class_file = str_replace( '\\', DIRECTORY_SEPARATOR, $class_name ) . '.php';
        //might want to put a  file check
        require_once $classes_dir . $class_file;
    }


});
add_action('init',function () {
    register_post_type('fgms-distributor',[
        'labels' => [
            'name' => __('Distributors'),
            'singular_name' => __('Distributor')
        ],
        'public' => true
    ]);
});
add_action( 'admin_notices', function(){
    ?>
    <div class="notice notice-success is-dismissible">
        <p><?php _e( Controller::loadedTest() , 'fg-find-a-distributor' ); ?></p>
    </div>

    <?php
});
add_action( 'admin_notices', function(){
    ?>
    <div class="notice notice-success is-dismissible">
        <p><?php _e( Geocoder::loadedTest() , 'fg-find-a-distributor' ); ?></p>
    </div>

    <?php
});

?>