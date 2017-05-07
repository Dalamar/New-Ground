<?php

namespace App\Http\Controllers\NewsApi;

use App\Contracts\ExternalApiService;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
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
    public function index($sourceId)
    {
        $cacheKey = class_basename($this) . '_' . $sourceId;

        if (\Cache::has($cacheKey)) {
            $data = \Cache::get($cacheKey);
        } else {
            $original = $this->provider->fetchData($sourceId);

            $data = $this->provider->injectData($original, 'articles', [
                'NG_Description' => 'Custom description',
                'NG_Review' => 'Custom review',
            ]);

            \Cache::put($cacheKey, $data, $this->cacheExpirationMinutes);
        }

        return \Response::api($data);
    }
}
