<?php
namespace Fgms\Distributor;

/**
 *  An interface which may be implemented to provide geocoding
 *  capabilities/functionality.
 *
 *  Geocoding is the process of mapping an address, city, postal
 *  code, et cetera to a latitude and longitude or vice versa.
 */
interface Geocoder
{
    /**
     *  Performs forward geocoding.
     *
     *  Forward geocoding is the process of mapping an
     *  address, city, postal code, et cetera to a latitude
     *  and longitude.
     *
     *  \param [in] $address
     *      The address, city, postal code, et cetera.
     *
     *  \return
     *      An array which contains the latitude as the first element and
     *      the longitude as the second element.
     */
    public function forward($address);
}