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


require __DIR__ . '/vendor/autoload.php';
add_action('init',function () {
    register_post_type('fgms-distributor',[
        'labels' => [
            'name' => __('Distributors'),
            'singular_name' => __('Distributor')
        ],
        'public' => true,
        'register_meta_box_cb' => function (\WP_Post $post) {
            add_meta_box(
                'fgms-distributor-info',
                __('Distributor Information'),
                function () {
                    ?>
                    <label for="fgms-distributor-address"><?php _e('Address'); ?></label>
                    <br>
                    <input class="widefat" type="text" name="fgms-distributor-address">
                    <?php
                },
                null,
                'normal',
                'default',
                null
            );
        }
    ]);
});

?>