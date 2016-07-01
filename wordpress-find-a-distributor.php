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
call_user_func(function () {
    $type='fgms-distributor';
    $prefix=$type.'-';
    $addr=$prefix.'address';
    $city=$prefix.'city';
    $tu=$prefix.'territorial-unit';
    $country=$prefix.'country';
    $mb=$prefix.'info';
    global $wpdb;
    $table_name=$wpdb->prefix.'fgms_distributor';
    add_action('init',function () use ($type,$prefix,$addr,$city,$tu,$country,$mb) {
        register_post_type($type,[
            'labels' => [
                'name' => __('Distributors',$type),
                'singular_name' => __('Distributor',$type)
            ],
            'public' => true,
            'register_meta_box_cb' => function (\WP_Post $post) use ($type,$addr,$city,$tu,$country,$mb) {
                add_meta_box(
                    $mb,
                    __('Distributor Information',$type),
                    function () use ($type,$addr,$city,$tu,$country,$post) {
                        $first=true;
                        $make=function ($name, $title) use ($type,$post,&$first) {
                            if ($first) $first=false;
                            else echo('<br>');
                            ?>
                            <label for="<?php echo(esc_attr($name)); ?>"><?php _e($title,$type); ?></label>
                            <br>
                            <input class="widefat" type="text" name="<?php echo(esc_attr($name)); ?>" value="<?php echo(esc_attr(get_post_meta($post->ID,$name,true))); ?>">
                            <?php
                        };
                        $make($addr,'Address');
                        $make($city,'City');
                        $make($tu,'State/Province');
                        $make($country,'Country');
                    },
                    null,
                    'normal',
                    'default',
                    null
                );
            }
        ]);
    });
    add_action('save_post',function ($id, \WP_Post $post) use ($type,$addr,$city,$tu,$country) {
        if ($post->post_type!==$type) return;
        if (!current_user_can(get_post_type_object($post->post_type)->cap->edit_post,$id)) return;
        $update=function ($key) use ($id) {
            $v=isset($_POST[$key]) ? $_POST[$key] : '';
            update_post_meta($id,$key,$v);
        };
        $update($addr);
        $update($city);
        $update($tu);
        $update($country);
    },10,2);
    $db_version='0.0.1';
    add_action('plugins_loaded',function () use ($db_version,$prefix,$table_name,$wpdb) {
        $opt=$prefix.'db-version';
        if (get_option($opt)===$db_version) return;
        require_once ABSPATH.'wp-admin/includes/upgrade.php';
        $sql=sprintf(
            'CREATE TABLE %s (
                ID int(11) NOT NULL AUTO_INCREMENT,
                lat double NOT NULL,
                lng double NOT NULL,
                PRIMARY KEY  (ID)
            ) %s;',
            $table_name,
            $wpdb->get_charset_collate()
        );
        dbDelta($sql);
        update_option($opt,$db_version);
    });
});

?>