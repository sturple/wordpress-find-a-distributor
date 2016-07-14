<?php
namespace Fgms\Distributor;

/**
 *	Resolves ambiguities for a \ref GoogleMapsGeocoder
 *	by simply throwing a \ref GoogleMapsGeocoderException.
 *
 *	\sa GoogleMapsGeocoder
 */
class GoogleMapsGeocoderExceptionAmbiguityResolutionStrategy implements GoogleMapsGeocoderAmbiguityResolutionStrategy
{
    public function resolve(array $arr) {
        throw new GoogleMapsGeocoderException(
            sprintf(
                'Ambiguous: %s',
                json_encode($arr,JSON_PRETTY_PRINT)
            )
        );
    }
}