<?php

namespace Awful\Monitoring\Utils;

use Illuminate\Support\Facades\Log;

class Common
{
    /**
     * @param string|null $ip The request IP address.
     * @return mixed
     */
    public static function getLocationInformation(?string $ip): mixed
    {
        $key = env('API_KEY_IP_GEOLOCATION', "d36ac5cb21954d378a94741fac93cc1e");

        if ($key === null) {
            return null;
        }

        // create curl resource
        $ch = curl_init();
        // set url
        curl_setopt($ch, CURLOPT_URL, "https://api.ipgeolocation.io/ipgeo?apiKey=$key&ip=$ip");

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // $output contains the output string
        $output = curl_exec($ch);

        // check for errors
        if (curl_errno($ch)) {
            // handle error
            curl_close($ch);
            // return or throw an exception
        }

        // close cURL resource
        curl_close($ch);

        // decode the API response
        return json_decode($output, true);
    }

    /**
     * @param string|null $ip The request IP address.
     * @return array
     */
    public static function getLogProperties(string|null $ip): array
    {
        // Fetch location info from a helper method
        $locationInfo = static::getLocationInformation($ip);

        Log::info("The client location information => ". json_encode($locationInfo));

        // Prepare properties array
        return [
            'country' => $locationInfo['country_name'] ?? null ,
            'city' => $locationInfo['city'] ?? null,
        ];
    }
}
