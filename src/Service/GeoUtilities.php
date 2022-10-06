<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\PropertyAccess\PropertyAccess;

class GeoUtilities
{

    /**
     * Permet de calculer la distance entre deux coordonnées geographique
     */
    public function getDistanceFromLatLonInKm($lat1, $lon1, $lat2, $lon2) {
        $R = 6371; // Radius of the earth in km
        $dLat = $this->deg2rad($lat2 - $lat1);  // deg2rad below
        $dLon = $this->deg2rad($lon2 - $lon1);
        $a =
          sin($dLat/2) * sin($dLat/2) +
          cos($this->deg2rad($lat1)) * cos($this->deg2rad($lat2)) *
          sin($dLon/2) * sin($dLon/2)
          ;
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        $d = $R * $c; // Distance in km
    
        return round($d);
    }
    
    private function deg2rad($deg) {
        return $deg * (pi()/180);
    }

    /**
     * Permet de retourner lat et lon a partir d'une adresse.
     */
    public function getUserLocationFromGoogleApi($address) {
        $client = HttpClient::create();
            $response = $client->request('GET', 'https://maps.googleapis.com/maps/api/geocode/json?address=' . $address . '&key=AIzaSyApzqVcCxJm5_ihnjWWQqrMJcGH4H1CKjo');
    
            $content = json_decode($response->getContent(), true);
            $propertyAccessor = PropertyAccess::createPropertyAccessor();
    
            $position = (object) array('lat' => $propertyAccessor->getValue($content, '[results][0][geometry][location][lat]'), 'lng' => $propertyAccessor->getValue($content, '[results][0][geometry][location][lng]'));
            return $position;
    }

}