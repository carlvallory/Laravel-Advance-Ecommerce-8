<?

    if (!function_exists('coords')) {
        function coords(float $latitude, float $longitude):string {
            return $latitude . ", " . $longitude;
        }
    }

    if (!function_exists('coords2Latitude')) {
        function coords2Latitude(string $coords) {
            $parts = explode(',', $coords);
            // Check if there are at least two parts (latitude and longitude)
            if (count($parts) < 2) {
                throw new InvalidArgumentException('Invalid coordinates format. Expected "latitude,longitude".');
            }
            // Return the first part as latitude
            return doubleval($parts[0]);
        }
    }

    if (!function_exists('coords2Longitude')) {
        function coords2Longitude(string $coords) {
            $parts = explode(',', $coords);
            // Check if there are at least two parts (latitude and longitude)
            if (count($parts) < 2) {
                throw new InvalidArgumentException('Invalid coordinates format. Expected "latitude,longitude".');
            }
            // Return the last part as longitud
            return doubleval($parts[1]);
        }
    }
