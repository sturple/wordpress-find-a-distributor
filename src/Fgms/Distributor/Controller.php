<?php
namespace Fgms\Distributor;

/**
 *  Implements the functionality of the Find a Distributor
 *  WordPress plugin.
 */
abstract class Controller
{
    private $wp;
    private $wpdb;
    private $geo;

    private $post_type;
    private $domain;

    private $address;
    private $city;
    private $territorial_unit;
    private $country;
    private $meta_box_id;

    private $save_action;

    private $table_name;
    private $ajax_action='fgms_distributor_radius';
    private $shortcode='find_a_distributor';
    private $db_version='0.0.1';
    private $db_version_opt;

    public function __construct (WordPress $wp, $wpdb, Geocoder $geo, $prefix='fgms-distributor-', $domain='fgms-distributor')
    {
        $this->wp=$wp;
        $this->wpdb=$wpdb;
        $this->geo=$geo;
        $this->post_type='distributor';
        $this->domain=$domain;
        $this->address=$prefix.'address';
        $this->city=$prefix.'city';
        $this->territorial_unit=$prefix.'territorial-unit';
        $this->country=$prefix.'country';
        $this->meta_box_id=$prefix.'info';
        $this->table_name=$wpdb->prefix.'fgms_distributor';
        $this->db_version_opt=$prefix.'db-version';
        $this->save_action=$prefix.'save-post';
        //  WordPress setup/attach hooks
        $this->wp->add_action('init',[$this,'registerPostType']);
        $this->wp->add_action('save_post',function ($id, \WP_Post $post) {  $this->savePost($post); },10,2);
        $this->wp->add_action('before_delete_post',function ($id) { $this->deletePost($this->wp->get_post($id));    });
        $ajax=[$this,'ajax'];
        $this->wp->add_action('wp_ajax_'.$this->ajax_action,$ajax);
        $this->wp->add_action('wp_ajax_nopriv_'.$this->ajax_action,$ajax);
        $this->wp->add_action('plugins_loaded',[$this,'setup']);
        $this->wp->add_shortcode('find_a_distributor',[$this,'shortcode']);
    }

    public function registerPostType()
    {
        $this->wp->register_post_type($this->post_type,[
            'labels' => [
                'name' => $this->wp->__('Distributors',$this->domain),
                'singular_name' => $this->wp->__('Distributor',$this->domain)
            ],
            'public' => true,
            'register_meta_box_cb' => [$this,'registerMetaBox']
        ]);
    }

    public function registerMetaBox(\WP_Post $post)
    {
        $this->wp->add_meta_box(
            $this->meta_box_id,
            $this->wp->__('Distributor Information',$this->domain),
            function () use ($post) {   $this->outputMetaBox($post);    },
            null,
            'normal',
            'default',
            null
        );
    }

    public function outputMetaBox(\WP_Post $post)
    {
        $first=true;
        $make=function ($name, $title) use (&$first, $post) {
            if ($first) $first=false;
            else $this->output('<br>');
            $this->output(
                sprintf(
                    '<label for="%1$s">%2$s</label><br><input class="widefat" type="text" name="%1$s" id="%1$s" value="%3$s">',
                    $this->wp->esc_attr($name),
                    htmlspecialchars($title),
                    $this->wp->esc_attr($this->wp->get_post_meta($post->ID,$name,true))
                )
            );
        };
        $make($this->address,'Address');
        $make($this->city,'City');
        $make($this->territorial_unit,'State/Province');
        $make($this->country,'Country');
    }

    public function savePost(\WP_Post $post)
    {
        if ($post->post_type!==$this->post_type) return;
        $id=$post->ID;
        $update=function ($key) use ($id) {
            $v=$this->post($key);
            update_post_meta($id,$key,is_null($v) ? '' : $v);
            return $v;
        };
        $a=$update($this->address);
        $ci=$update($this->city);
        $t=$update($this->territorial_unit);
        $co=$update($this->country);
        $obj=(object)[
            'lat' => null,
            'lng' => null,
            'address' => $a,
            'city' => $ci,
            'territorial_unit' => $t,
            'country' => $co
        ];
        if (is_null($a) || is_null($ci) || is_null($co)) {
            $this->delete($id);
        } else {
            $str=sprintf('%s, %s',$a,$ci);
            if (!is_null($t)) $str=sprintf('%s, %s',$str,$t);
            $str=sprintf('%s, %s',$str,$co);
            $l=$this->geo->forward($str);
            $lat=$l[0];
            $lng=$l[1];
            $this->insert($id,$lat,$lng);
            $obj->lat=$lat;
            $obj->lng=$lng;
        }
        $this->wp->do_action($this->save_action,$post,(object)[
            'lat' => $lat,
            'lng' => $lng,
            'address' => $a,
            'city' => $ci,
            'territorial_unit' => $t,
            'country' => $co
        ]);
    }

    public function deletePost(\WP_Post $post)
    {
        if ($post->post_type!==$this->post_type) return;
        $this->delete($post->ID);
    }

    public function ajax()
    {
        $get_get_float=function ($key) {
            $v=$this->get($key);
            if (is_null($v)) return null;
            if (!is_numeric($v)) throw new \RuntimeException(sprintf('GET value "%s" is non-numeric string "%s"',$key,$v));
            return floatval($v);
        };
        $radius=$get_get_float('radius');
        if (is_null($radius)) throw new \RuntimeException('No radius');
        $lng=$get_get_float('lng');
        $lat=$get_get_float('lat');
        if (is_null($lat)!==is_null($lng)) throw new \RuntimeException(sprintf('Only one of latitude or longitude given'));
        if (is_null($lat)) {
            $address=$this->get('address');
            if (is_null($address)) throw new \RuntimeException('No address');
            $pair=$this->geo->forward($address);
            $lat=$pair[0];
            $lng=$pair[1];
        }
        $arr=[];
        foreach ($this->getRadius($lat,$lng,$radius) as $obj) {
            $post=$obj->post;
            $id=$post->ID;
            $arr[]=(object)[
                'distance' => $obj->distance,
                'lat' => $obj->lat,
                'lng' => $obj->lng,
                'address' => get_post_meta($id,$this->address,true),
                'city' => get_post_meta($id,$this->city,true),
                'territorial_unit' => get_post_meta($id,$this->territorial_unit,true),
                'country' => get_post_meta($id,$this->country,true),
                'name' => $post->post_title,
                'description' => $post->post_content
            ];
        }
        $result=(object)[
            'lat' => $lat,
            'lng' => $lng,
            'radius' => $radius,
            'results' => $arr
        ];
        $this->header('Content-Type: application/json');
        $this->output(json_encode($result));
        $this->wp->wp_die();
    }

    public function setup()
    {
        if ($this->wp->get_option($this->db_version_opt)===$this->db_version) return;
        $sql=sprintf(
            'CREATE TABLE %s (
                ID int(11) NOT NULL AUTO_INCREMENT,
                lat double NOT NULL,
                lng double NOT NULL,
                PRIMARY KEY  (ID)
            ) %s;',
            $this->table_name,
            $this->wpdb->get_charset_collate()
        );
        $this->wp->dbDelta($sql);
        $this->wp->update_option($opt,$db_version);
    }

    public function shortcode()
    {
        //  TODO: Overhaul this
        $this->wp->wp_enqueue_script('jquery');
        ob_start();
        require __DIR__.'/../../../shortcode.php';
        $retr=ob_get_contents();
        ob_end_clean();
        return $retr;
    }

    private function dbRaise()
    {
        if ($this->wpdb->last_error!=='') throw new \RuntimeException($this->wpdb->last_error);
    }

    private function delete($id)
    {
        $this->wpdb->delete($this->table_name,['ID' => $id],['%d']);
        $this->dbRaise();
    }

    private function insert($id, $lat, $lng)
    {
        $this->wpdb->replace(
            $this->table_name,
            ['ID' => $id,'lat' => $lat,'lng' => $lng],
            ['%d','%f','%f']
        );
        $this->dbRaise();
    }

    private function getRadius($lat, $lng, $radius, $km=true)
    {
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
            $this->table_name,
            $lat,
            $lng,
            $radius,
            $magic
        );
        $objs=$this->wpdb->get_results($sql,OBJECT);
        $this->dbRaise();
        $retr=[];
        foreach ($objs as $obj) $retr[]=(object)[
            'distance' => floatval($obj->distance),
            'lat' => floatval($obj->lat),
            'lng' => floatval($obj->lng),
            'post' => get_post(intval($obj->ID))
        ];
        return $retr;
    }

    /**
     *  When implemented in a derived class performs
     *  output.
     *
     *  \param [in] $str
     *      The string to output.
     */
    abstract public function output($str);

    /**
     *  When implemented in a derived class sets a header
     *  on the current response.
     *
     *  \param [in] $header
     *      The header to set.
     */
    abstract public function header($header);

    /**
     *  When implemented in a derived class retrieves
     *  a value from the query string of the current
     *  request.
     *
     *  \param [in] $key
     *      The key by which the value in the query string
     *      is identified.
     *  \param [in] $default
     *      The value to return if \em key is not present in
     *      the query string, or is empty.  Defaults to
     *      \em null.
     *
     *  \return
     *      The value associated with \em key or \em default
     *      if there is no value associated with \em key.
     */
    abstract public function get($key, $default=null);

    /**
     *  When implemented in a derived class retrieves
     *  a value from the POST'd content of the current
     *  request.
     *
     *  \param [in] $key
     *      The key by which the value in the POST'd content
     *      is identified.
     *  \param [in] $default
     *      The value to return if \em key is not present in
     *      the POST'd content, or is empty.  Defaults to
     *      \em null.
     *
     *  \return
     *      The value associated with \em key or \em default
     *      if there is no value associated with \em key.
     */
    abstract public function post($key, $default=null);
}
