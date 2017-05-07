<?php

namespace App\Http\Controllers\NewsApi;

use App\Contracts\ExternalApiService;
use App\Http\Controllers\Controller;

class SourceController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cacheKey = class_basename($this);

        if (\Cache::has($cacheKey)) {
            $data = \Cache::get($cacheKey);
        } else {
            $data = $this->provider->fetchData();
            \Cache::put($cacheKey, $data, $this->cacheExpirationMinutes);
        }

        return \Response::api($data);
    }
}
