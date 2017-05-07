<?php

namespace App\Services\ExternalApi\NewsApi;

use App\Services\ExternalApi\ApiClient;

class Sources extends ApiClient
{
    /**
     * @inheritdoc
     */
    public function fetchData(...$params)
    {
        $url = 'https://newsapi.org/v1/sources';
        $query = ['language' => 'en'];

        $data = \GuzzleHttp\json_decode($this->request($url, 'GET', $query));

        return $data;
    }
}