<?php

namespace Greew\Sites\ErDetKaffetidDk\Object;

use Exception;

/**
 * Common class for fetching nearby cafés
 */
class Places
{

    /**
     * Find cafés nearby
     *
     * @param array $get The original $_GET array
     * @return array
     * @throws Exception
     */
    public static function find(array $get): array
    {
        if (!isset($get['lat'], $get['lng'])) {
            return self::format([], 'MissingParams');
        }

        // Convert to floats
        $lat = (float)$get['lat'];
        $lng = (float)$get['lng'];

        // Set query parameters
        $query = array(
            'location' => $lat . ',' . $lng,
            'language' => 'da',
            'rankby' => 'distance',
            'sensor' => 'true',
            'types' => 'cafe',
            'key' => Config::read('Keys.GoogleApi')
        );

        // Create call url
        $url = 'https://maps.googleapis.com/maps/api/place/search/json?' . http_build_query($query);
        $url = str_replace('%2C', ',', $url);

        // Send request to google
        $d = self::curl($url);

        // Json decode string
        $d = json_decode($d, true, 512, JSON_THROW_ON_ERROR);

        switch ($d['status']) {
            case 'OK':
                return self::format(array(
                    'latitude' => $lat,
                    'longitude' => $lng,
                    'results' => $d['results']
                ));
            case 'ZERO_RESULTS':
                return self::format(array(
                    'latitude' => $lat,
                    'longitude' => $lng,
                    'results' => []
                ));
        }
        return self::format([], 'UnknownApiResponse');
    }

    /**
     * Internal helper function
     *
     * @param $url
     * @return bool|string
     */
    private static function curl($url)
    {
        $curl = curl_init($url);

        // Return data instead of outputting directly
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);

        // Force http request to use http version 1.1
        curl_setopt($curl, CURL_HTTP_VERSION_1_1, true);

        // Sending cURL request and getting response in $response
        $response = curl_exec($curl);

        // Close the connection
        curl_close($curl);

        // Return the response
        return $response;
    }

    /**
     * Function that prints json header and data.
     *
     * @param array|null $data
     * @param string|null $error
     * @return array
     */
    private static function format(array $data = null, string $error = null): array
    {
        return array(
            'data' => $data,
            'error' => $error
        );
    }
}
