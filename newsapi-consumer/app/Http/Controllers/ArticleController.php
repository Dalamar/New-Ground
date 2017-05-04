<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Cache;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($sourceId)
    {
        $cacheExpirationMinutes = 5;

        if (\Cache::has($sourceId)) {
            $data = Cache::get($sourceId);
        } else {
            try {
                $client = new Client();
                $result = $client->request('GET', 'https://newsapi.org/v1/articles', [
                    'Accept'       => 'application/json',
                    'Content-Type' => 'application/json',
                    'query'        => [
                        'source' => $sourceId,
                        'sortBy' => 'top',
                        'apiKey' => config('services.newsapi.key'),
                    ],
                ]);

                $responseData = $result->getBody()->getContents();

                $original = json_decode($responseData);
                if (!json_last_error() === JSON_ERROR_NONE || !$original) {
                    return \Response::api(null, 'Failed to read JSON source');
                }

                $collection = collect($original);
                $articles   = $collection->get('articles');

                foreach ($articles as $article) {
                    $article->NG_Description = 'Custom description';
                    $article->NG_Review      = 'Custom review';
                }

                $data = $collection->merge(['articles' => $articles]);
                \Cache::put($sourceId, $data, $cacheExpirationMinutes);

            } catch (RequestException $e) {
                if ($e->hasResponse()) {
                    $responseData = $e->getResponse()->getBody()->getContents();

                    return \Response::api(json_decode($responseData), [$e->getMessage()]);
                }
            }
        }

        return \Response::api($data);
    }
}
