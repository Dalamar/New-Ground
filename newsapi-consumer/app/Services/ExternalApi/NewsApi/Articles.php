<?php

namespace App\Services\ExternalApi\NewsApi;

use App\Services\ExternalApi\ApiClient;

class Articles extends ApiClient
{
    public function fetchData(...$params)
    {
        $sourceId = $params[0];

        $url = 'https://newsapi.org/v1/articles';
        $query = [
            'source' => $sourceId,
            'sortBy' => 'top',
            'apiKey' => config('services.newsapi.key'),
        ];

        $data = \GuzzleHttp\json_decode($this->request($url, 'GET', $query));

        return $data;
    }
}