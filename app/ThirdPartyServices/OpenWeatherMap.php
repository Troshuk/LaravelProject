<?php

namespace App\ThirdPartyServices;

/**
 * The API to get the weather
 * openweathermap.org
 */
class OpenWeatherMap
{
    protected $client;
    protected $url;
    protected $version;
    protected $countryCode;

    public function __construct()
    {
        $this->version = config('openweathermap.version');
        $this->url = config('openweathermap.url');
        $this->countryCode = config('openweathermap.country_code');

        $this->client = new \GuzzleHttp\Client([
            'base_uri' => $this->url . $this->version . '/',
            'query' => [
                'appid' => config('openweathermap.api_key'),
                'units' => config('openweathermap.units'),
                'lang' => config('openweathermap.lang'),
            ],
        ]);
    }

    public function getByZipCode($zipCode, $countryCode = null)
    {
        $countryCode = $countryCode ?? $this->countryCode;

        return $this->api('weather', ['zip' => "$zipCode,$countryCode"]);
    }

    public function getByCityAndState($city, $state = null, $countryCode = null)
    {
        $countryCode = $countryCode ?? $this->countryCode;
        return $this->api('weather', ['q' => "$city,$state,$countryCode"]);
    }

    public function api(string $endpoint, array $query = [])
    {
        try {
            $request = $this->client->get($endpoint, ['query' => array_merge($this->client->getConfig('query'), $query)]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            report($e);
            $request = $e->getResponse();
        } finally {
            $response = json_decode($request->getBody()->getContents());
        }

        if (property_exists($response, 'message')) {
            abort($response->cod, $response->message);
        }

        return $response;
    }
}
