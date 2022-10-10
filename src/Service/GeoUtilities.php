<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyAccess\PropertyAccess;

class GeoUtilities
{
    protected $request;

    
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
   
    // public function getUserLocationFromGoogleApi($address) {

      
           
    //         return $position;
    // }

}