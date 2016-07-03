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
    $api_key='';    //  TODO: Better solution for this
    $type='distributor';
    $prefix='fgms-distributor-';
    $addr=$prefix.'address';
    $city=$prefix.'city';
    $tu=$prefix.'territorial-unit';
    $country=$prefix.'country';
    $mb=$prefix.'info';
    global $wpdb;
    $table_name=$wpdb->prefix.'fgms_distributor';
    $ajax_action='fgms_distributor_radius';
    $shortcode='find_a_distributor';
    $db_raise=function () use ($wpdb) {
        if ($wpdb->last_error!=='') throw new \RuntimeException($wpdb->last_error);
    };
    $del=function ($id) use ($wpdb,$table_name,$db_raise) {
        $wpdb->delete($table_name,['ID' => $id],['%d']);
        $db_raise();
    };
    $ins=function ($id, $lat, $lng) use ($wpdb,$table_name,$db_raise) {
        $wpdb->replace(
            $table_name,
            ['ID' => $id,'lat' => $lat,'lng' => $lng],
            ['%d','%f','%f']
        );
        $db_raise();
    };
    $get_radius=function ($lat, $lng, $radius, $km=true) use ($wpdb,$table_name,$db_raise) {
        $magic=$km ? 6371 : 3959;
        $sql=sprintf(
            'SELECT *,
            (%5$d * acos(
                cos(
                    radians(%2$f)
                )*cos(
                    radians(lat)
                )*cos(
                    radians(lng)-radians(%3$f)
                )+sin(
                    radians(%2$f)
                )*sin(
                    radians(lat)
                )
            )) AS distance
            FROM %1$s
            HAVING distance<%4$f',
            $table_name,
            $lat,
            $lng,
            $radius,
            $magic
        );
        $objs=$wpdb->get_results($sql,OBJECT);
        $db_raise();
        $retr=[];
        foreach ($objs as $obj) $retr[]=(object)[
            'distance' => floatval($obj->distance),
            'lat' => floatval($obj->lat),
            'lng' => floatval($obj->lng),
            'post' => get_post(intval($obj->ID))
        ];
        return $retr;
    };
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
    $get_superglobal=function ($key, $superglobal) {
        $super=($superglobal==='POST') ? $_POST : $_GET;
        if (!isset($super[$key])) return null;
        $retr=$super[$key];
        if (!is_string($retr)) throw new \RuntimeException(sprintf('%s value "%s" not a string',$superglobal,$key));
        $retr=preg_replace('/^\\s+|\\s+$/u','',$retr);
        if ($retr==='') return null;
        return $retr;
    };
    $get_post=function ($key) use ($get_superglobal) {
        return $get_superglobal($key,'POST');
    };
    $get_get=function ($key) use ($get_superglobal) {
        return $get_superglobal($key,'GET');
    };
    add_action('save_post',function ($id, \WP_Post $post) use ($type,$addr,$city,$tu,$country,$api_key,$del,$ins,$get_post) {
        if ($post->post_type!==$type) return;
        if (!current_user_can(get_post_type_object($post->post_type)->cap->edit_post,$id)) return;
        $update=function ($key) use ($id,$get_post) {
            $v=$get_post($key);
            update_post_meta($id,$key,is_null($v) ? '' : $v);
            return $v;
        };
        $a=$update($addr);
        $ci=$update($city);
        $t=$update($tu);
        $co=$update($country);
        if (is_null($a) || is_null($ci) || is_null($co)) {
            $del($id);
            return;
        }
        $geo=new \Fgms\Distributor\GoogleMapsGeocoder($api_key);
        $l=$geo->forward($a,$ci,$t,$co);
        $ins($id,$l[0],$l[1]);
    },10,2);
    add_action('before_delete_post',function ($id) use ($type,$del) {
        $post=get_post($id);
        if ($post->post_type!=$type) return;
        $del($id);
    });
    $ajax=function () use ($get_radius,$get_get,$addr,$city,$tu,$country) {
        $get_get_float=function ($key) use ($get_get) {
            $v=$get_get($key);
            if (is_null($v)) throw new \RuntimeException(sprintf('No GET value "%s"',$key));
            if (!is_numeric($v)) throw new \RuntimeException(sprintf('GET value "%s" is non-numeric string "%s"',$key,$v));
            return floatval($v);
        };
        $radius=$get_get_float('radius');
        $lng=$get_get_float('lng');
        $lat=$get_get_float('lat');
        $arr=[];
        foreach ($get_radius($lat,$lng,$radius) as $obj) {
            $post=$obj->post;
            $id=$post->ID;
            $arr[]=(object)[
                'distance' => $obj->distance,
                'lat' => $obj->lat,
                'lng' => $obj->lng,
                'address' => get_post_meta($id,$addr,true),
                'city' => get_post_meta($id,$city,true),
                'territorial_unit' => get_post_meta($id,$tu,true),
                'country' => get_post_meta($id,$country,true),
                'name' => $post->post_title,
                'description' => $post->post_content
            ];
        }
        header('Content-Type: application/json');
        echo(json_encode($arr));
        wp_die();
    };
    add_action('wp_ajax_'.$ajax_action,$ajax);
    add_action('wp_ajax_nopriv_'.$ajax_action,$ajax);
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
    add_shortcode('find_a_distributor',function () {
        wp_enqueue_script('jquery');
        ob_start();
        require __DIR__.'/shortcode.php';
        $retr=ob_get_contents();
        ob_end_clean();
        return $retr;
    });
});

?>