<?php

namespace App\Http\Controllers\Skyscanner;

use App\Contracts\ExternalApiService;
use App\Http\Controllers\Controller;

class BrowseQuotesController extends Controller
{
    /**
     * @var ExternalApiService
     */
    private $provider;

    private $cacheExpirationMinutes;

    public function __construct(\App\Contracts\ExternalApiService $provider)
    {
        $this->provider = $provider;
        $this->cacheExpirationMinutes = 1;
    }

    /**
     * Display a listing of the resource.
     *
     * @param $country
     * @param $currency
     * @param $locale
     * @param $originPlace
     * @param $destinationPlace
     * @param $outboundPartialDate
     * @param null $inboundPartialDate
     * @return \Illuminate\Http\Response
     */
    public function index($country, $currency, $locale, $originPlace, $destinationPlace, $outboundPartialDate, $inboundPartialDate = null)
    {
        $cacheKey = implode('_', [
            class_basename($this),
            $country, $currency, $locale, $originPlace,
            $destinationPlace, $outboundPartialDate, $inboundPartialDate
        ]);


        if (\Cache::has($cacheKey)) {
            $data = \Cache::get($cacheKey);
        } else {
            $original = $this->provider->fetchData($country, $currency, $locale, $originPlace, $destinationPlace, $outboundPartialDate, $inboundPartialDate);

            $data = $this->provider->injectData($original, 'Quotes', [
                'NG_Description' => 'Custom description',
                'NG_Review' => 'Custom review',
            ]);
            \Cache::put($cacheKey, $data, $this->cacheExpirationMinutes);
        }

        return \Response::api($data);
    }
}
