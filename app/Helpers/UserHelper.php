<?php

namespace App\Helpers;

class UserHelper
{
    /**
     * @param $city
     * @return mixed|string
     */
    public static function getCityName($city)
    {
        $dataCityName = config('master_data.provinces');
        if (array_key_exists($city, $dataCityName)) {
            return $dataCityName[$city];
        }

        return '';
    }
}
