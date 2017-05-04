<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class SourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cacheExpirationMinutes = 1;

        if (\Cache::has('sources')) {
            $data = \Cache::get('sources');
        } else {
            try {
                $client = new Client();

                $result = $client->request('GET', 'https://newsapi.org/v1/sources', [
                    'Accept'       => 'application/json',
                    'Content-Type' => 'application/json',
                    'query'        => [
                        'language' => 'en',
                    ],
                ]);

                $data = json_decode($result->getBody()->getContents());
                \Cache::put('sources', $data, $cacheExpirationMinutes);

            } catch (RequestException $e) {
                if ($e->hasResponse()) {
                    return \Response::api($e->getResponse()->getBody()->getContents(), [$e->getMessage()]);
                }
            }
        }

        return \Response::api($data);
    }
}
