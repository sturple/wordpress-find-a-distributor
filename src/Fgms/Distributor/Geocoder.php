<?php
namespace Fgms\Distributor;

class Geocoder{
    static private $url = "http://maps.google.com/maps/api/geocode/json?sensor=false&address=";
    var     $status;
    
    static public function getLocation($address, $postal){
        $url = self::$url.urlencode($address);
        
        $resp_json = self::curl_file_get_contents($url);
        $resp = json_decode($resp_json, true);
       
        if($resp['status'] =='OK'){           
            return $resp['results'][0]['geometry']['location'];
            
        }else {
            return  $url;
      
            
        }
    }


    static private function curl_file_get_contents($URL){
        $c = curl_init();
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_URL, $URL);
        $contents = curl_exec($c);
        curl_close($c);
        if ($contents) return $contents;
            else return FALSE;
    }
    static function loadedTest(){
        return 'Fgms\Distributor::Geocoder Loaded';
    }    
}
?>

