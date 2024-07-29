<?php

namespace App\Helpers;

use Malhal\Geographical\Geographical;

trait Geo
{
    use Geographical;

    /**
     * Calculate the distance between two geographical points.
     *
     * @param float $latitudeFrom Latitude of the first point.
     * @param float $longitudeFrom Longitude of the first point.
     * @param float $latitudeTo Latitude of the second point.
     * @param float $longitudeTo Longitude of the second point.
     * @param bool  $kilometers If true, the result is in kilometers, otherwise in miles.
     * @return float The distance between the two points.
     */
    public static function calculateDistance(float $latitudeFrom, float $longitudeFrom, float $latitudeTo, float $longitudeTo, bool $kilometers = true): float
    {
        $earthRadius = $kilometers ? 6371 : 3959; // Earth radius in kilometers or miles

        // Convert degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        // Haversine formula
        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

        return $angle * $earthRadius;
    }
}
