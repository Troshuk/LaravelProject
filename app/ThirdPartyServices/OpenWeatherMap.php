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

    /**
     * @author Denys Troshuk
     */
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

    /**
     * [getByZipCode returns current weather by zip code]
     * @param  string|integer       $zipCode
     * @param  string|null          $countryCode    us,ua,ru...
     * @return object                               full response from API
     * @author Denys Troshuk
     */
    public function getByZipCode(string $zipCode,  ? string $countryCode = null)
    {
        $countryCode = $countryCode ?? $this->countryCode;
        $zipCode = str_pad($zipCode, 5, "0", STR_PAD_LEFT);

        return $this->api('weather', ['zip' => "$zipCode,$countryCode"]);
    }

    /**
     * [getByCityAndState returns current weather by city and state]
     * @param  string      $city            Sarasota
     * @param  string      $state           FL...
     * @param  string|null $countryCode     us,ua,ru...
     * @return object                       full response from API
     * @author Denys Troshuk
     */
    public function getByCityAndState(string $city, string $state,  ? string $countryCode = null)
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
