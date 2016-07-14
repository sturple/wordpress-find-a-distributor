<?php
namespace Fgms\Distributor;

/**
 *	Resolves ambiguities for a \ref GoogleMapsGeocoder by
 *	simply picking the first alternative.
 *
 *	\sa GoogleMapsGeocoder
 */
class GoogleMapsGeocoderPickFirstAmbiguityResolutionStrategy implements GoogleMapsGeocoderAmbiguityResolutionStrategy
{
	public function resolve(array $arr)
	{
		if (count($arr)===0) throw new \LogicException('Expected $arr to have at least one entry');
		return $arr[0];
	}
}