<?php

return [
    'country_code' => env('OPENWEATHERMAP_COUNTRY_CODE', 'us'),
    'api_key' => env('OPENWEATHERMAP_API_KEY'),
    'url' => env('OPENWEATHERMAP_URL'),
    'units' => env('OPENWEATHERMAP_UNITS', 'imperial'),
    'version' => env('OPENWEATHERMAP_VERSION', '2.5'),
    'lang' => env('OPENWEATHERMAP_LANG', 'us'),
];
