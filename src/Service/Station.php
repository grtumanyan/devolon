<?php

namespace App\Service;


class Station
{
    public function calculateDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo)
    {
        $distance =( 6371 * acos((cos(deg2rad($latitudeFrom)) ) * (cos(deg2rad($latitudeTo))) * (cos(deg2rad($longitudeFrom) - deg2rad($longitudeTo)) )+ ((sin(deg2rad($latitudeTo))) * (sin(deg2rad($latitudeFrom))))) );

        return $distance;
    }

    public function orderStations($stations)
    {
        usort($stations, array($this,'sortByDistance'));

        return $stations;
    }

    private static function sortByDistance($x, $y) {
        return $x['distance'] - $y['distance'];
    }
}