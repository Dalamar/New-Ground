<?php

namespace App\Services\ExternalApi;

use App\Contracts\ExternalApiService;
use GuzzleHttp\Client;

abstract class ApiClient implements ExternalApiService
{
    /**
     * Makes request for external resources and returns response data.
     * Wrapper around GuzzleHttp\Client.
     *
     * @param $url
     * @param string $method
     * @param array $query
     * @param array $options
     * @return string
     */
    public function request($url, $method = 'GET', $query = [], $options = [])
    {
        $options = array_merge([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'query' => $query,
        ], $options);

        $client = new Client();
        $result = $client->request($method, $url, $options);
        $response = $result->getBody()->getContents();

        return $response;
    }

    /**
     * @inheritdoc
     */
    public function injectData($original, $targetElement, $injection = [])
    {
        $collection = collect($original);
        $targets = $collection->get($targetElement);

        foreach ($targets as $target) {
            foreach ($injection as $key => $value) {
                $target->$key = $value;
            }
        }

        $result = $collection->merge([$targetElement => $targets]);

        return json_decode(json_encode($result));
    }

}