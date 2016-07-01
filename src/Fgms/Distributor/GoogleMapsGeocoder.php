<?php
namespace Fgms\Distributor;

/**
 *	A geocoder implemented using the Google Maps API.
 */
class GoogleMapsGeocoder implements Geocoder
{
    private $api_key;
    private $decode_depth=10;
    /**
     *	Creates a new GoogleMapsGeocoder object which performs
     *	geocoding requests against the Google Maps API using
     *	a certain API key.
     *
     *	\param [in] $api_key
     *		The API key which shall be used to perform requests
     *		against the Google Maps API.
     */
    public function __construct ($api_key)
    {
        $this->api_key=$api_key;
    }
    private function getAddress($address, $city, $territorial_unit, $country, $postal_code)
    {
        $retr=sprintf('%s, %s',$address,$city);
        if (!is_null($territorial_unit)) $retr=sprintf('%s, %s',$retr,$territorial_unit);
        $retr=sprintf('%s, %s',$retr,$country);
        if (!is_null($postal_code)) $retr=sprintf('%s, %s',$retr,$postal_code);
        return $retr;
    }
    private function getUrl($address, $city, $territorial_unit, $country, $postal_code)
    {
        return sprintf(
            'https://maps.googleapis.com/maps/api/geocode/json?address=%s&key=%s',
            rawurlencode($this->getAddress($address,$city,$territorial_unit,$country,$postal_code)),
            $this->api_key
        );
    }
    private function raise($msg, $code=0)
    {
        throw new GoogleMapsGeocoderException($msg,$code);
    }
    private function raiseJson($json)
    {
        $this->raise(
            sprintf('%s: %s',json_last_error_msg(),$json),
            json_last_error()
        );
    }
    public function forward($address, $city, $territorial_unit, $country, $postal_code=null)
    {
        $client=new \GuzzleHttp\Client();
        $response=$client->request('GET',$this->getUrl($address,$city,$territorial_unit,$country,$postal_code));
        $code=$response->getStatusCode();
        if ($code!==200) $this->raise(sprintf('%s %s',$code,$response->getReasonPhrase()));
        $body=$response->getBody();
        $json=json_decode($body,false,$this->decode_depth);
        if (json_last_error()!==JSON_ERROR_NONE) $this->raiseJson($body);
        if (!is_object($json)) $this->raise(sprintf('Root of JSON is not an object: %s',$body));
        if (!isset($json->results)) $this->raise(sprintf('No "results": %s',$body));
        $rs=$json->results;
        if (!is_array($rs)) $this->raise(sprintf('"results" not array: %s',$body));
        if (count($rs)===0) $this->raise(sprintf('No results: %s',$body));
        if (count($rs)!==1) $this->raise(sprintf('Ambiguous: %s',$body));
        $r=$rs[0];
        if (!isset($r->geometry)) $this->raise(sprintf('No "results"."geometry":%s',$body));
        $g=$r->geometry;
        if (!is_object($g)) $this->raise(sprintf('"results"."geometry" not an object: %s',$body));
        if (!isset($g->location)) $this->raise(sprintf('No "results"."geometry"."location": %s',$body));
        $l=$g->location;
        if (!is_object($l)) $this->raise(sprintf('"results"."geometry"."location" not an object: %s',$body));
        if (!isset($l->lat)) $this->raise(sprintf('No "results"."geometry"."location"."lat": %s',$body));
        $lat=$l->lat;
        if (!(is_int($lat) || is_float($lat))) $this->raise(sprintf('"results"."geometry"."location"."lat" not a number: %s',$body));
        if (!isset($l->lng)) $this->raise(sprintf('No "results"."geometry"."location"."lng": %s',$body));
        $lng=$l->lng;
        if (!(is_int($lng) || is_float($lng))) $this->raise(sprintf('"results"."geometry"."location"."lng" not a number: %s',$body));
        return [$lat,$lng];
    }
}