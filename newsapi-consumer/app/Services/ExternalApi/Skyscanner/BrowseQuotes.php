<?php

namespace App\Services\ExternalApi\Skyscanner;

use App\Services\ExternalApi\ApiClient;

class BrowseQuotes extends ApiClient
{
    public function fetchData(...$params)
    {
        $country = $params[0];
        $currency = $params[1];
        $locale = $params[2];
        $originPlace = $params[3];
        $destinationPlace = $params[4];
        $outboundPartialDate = $params[5];
        $inboundPartialDate = isset($params[6]) ? $params[6] : null;

        $url = "http://partners.api.skyscanner.net/apiservices/browsequotes/v1.0/{$country}/{$currency}/{$locale}/{$originPlace}/{$destinationPlace}/{$outboundPartialDate}/{$inboundPartialDate}";
        $query = ['apikey' => config('services.skyscanner.key')];

        $data = \GuzzleHttp\json_decode($this->request($url, 'GET', $query));

        return $data;
    }
}