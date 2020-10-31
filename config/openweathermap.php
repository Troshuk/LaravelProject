<?php

return [
    'country_code' => env('OPEN_WEATHER_MAP_COUNTRY_CODE', 'us'),
    'api_key' => env('OPEN_WEATHER_MAP_API_KEY'),
    'url' => env('OPEN_WEATHER_MAP_URL'),
    'units' => env('OPEN_WEATHER_MAP_UNITS', 'imperial'),
    'version' => env('OPEN_WEATHER_MAP_VERSION', '2.5'),
    'lang' => env('OPEN_WEATHER_MAP_LANG', 'us'),
];
