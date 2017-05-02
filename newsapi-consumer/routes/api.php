<?php

use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/sources', function () {
    $client = new GuzzleHttp\Client();

    try {
        $result = $client->get('https://newsapi.org/v1/sources?language=en');

        return \Response::api(json_decode($result->getBody()->getContents()));

    } catch (RequestException $e) {
        if ($e->hasResponse()) {
            $responseData = $e->getResponse()->getBody()->getContents();

            return \Response::api(json_decode($responseData), [$e->getMessage()]);
        }
    }
});

Route::get('/articles/{sourceId}', function ($sourceId) {
    $client = new GuzzleHttp\Client();

    try {
        $result = $client->request('GET', 'https://newsapi.org/v1/articles?source=' . $sourceId
            . '&sortBy=top&apiKey=' . config('services.newsapi.key'));

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

        $modified = $collection->merge(['articles' => $articles]);

        return \Response::api($modified);

    } catch (RequestException $e) {
        if ($e->hasResponse()) {
            $responseData = $e->getResponse()->getBody()->getContents();

            return \Response::api(json_decode($responseData), [$e->getMessage()]);
        }
    }


});
