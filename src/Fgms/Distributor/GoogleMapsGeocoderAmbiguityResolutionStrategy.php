<?php
namespace Fgms\Distributor;

/**
 *	An interface which may be implemented to provide
 *	ambiguity resolution for a \ref GoogleMapsGeocoder.
 *
 *	Ambiguity occurs when a query could potentially
 *	geocode to multiple geographic locations.  In this
 *	instance the Google Maps API returns all those
 *	possibilities and it falls to instances of this
 *	class to resolve that ambiguity.
 *
 *	\sa GoogleMapsGeocoder
 */
interface GoogleMapsGeocoderAmbiguityResolutionStrategy
{
	/**
	 *	Resolves ambiguity.
	 *
	 *	\param [in] $arr
	 *		The array of results returned by the
	 *		Google Maps API.
	 *
	 *	\return
	 *		The entry from \em arr which should be
	 *		selected.
	 */
	public function resolve(array $arr);
}