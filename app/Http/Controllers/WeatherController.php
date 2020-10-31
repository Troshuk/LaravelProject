<?php

namespace App\Http\Controllers;

use App\ThirdPartyServices\OpenWeatherMap;

class WeatherController extends Controller
{
    public function getByZip($zipCode)
    {
        $response = (new OpenWeatherMap)->getByZipCode($zipCode);

        $temperature = round($response->main->temp);
        $weather = $response->weather[0]->description;

        return "Right now in $response->name it is $temperature" . "° F with $weather";
    }

    public function getByCityAndState($city, $state)
    {
        $response = (new OpenWeatherMap)->getByCityAndState($city, $state);

        $temperature = round($response->main->temp);
        $weather = $response->weather[0]->description;

        return "Right now in $response->name it is $temperature" . "° F with $weather";
    }
}
