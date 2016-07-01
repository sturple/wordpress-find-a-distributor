<?php
namespace Fgms\Distributor;

/**
 *  An interface which may be implemented to provide geocoding
 *  capabilities/functionality.
 *
 *  Geocoding is the process of mapping an address to a latitude
 *  and longitude or vice versa.
 */
interface Geocoder
{
    /**
     *  Performs forward geocoding.
     *
     *  Forward geocoding is the process of mapping an
     *  address to a latitude and longitude.
     *
     *  \param [in] $address
     *      The street address.
     *  \param [in] $city
     *      The city in which \em address is located.
     *  \param [in] $territorial_unit
     *      The territorial unit (i.e. state, province, et cetera)
     *      in which \em city is located.  May be \em null if the
     *      country in which \em city resides does not have territorial
     *      units.
     *  \param [in] $country
     *      The country in which \em city and/or \em territorial_unit is
     *      located.
     *  \param [in] $postal_code
     *      The postal or zip code in which \em address resides.  Optional.
     *      Defaults to \em null.
     *
     *  \return
     *      An array which contains the latitude as the first element and
     *      the longitude as the second element.
     */
    public function forward($address, $city, $territorial_unit, $country, $postal_code=null);
}