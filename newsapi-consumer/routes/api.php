<?php

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

Route::get('/newsapi/sources', 'NewsApi\SourceController@index');

Route::get('/newsapi/articles/{sourceId}', 'NewsApi\ArticleController@index');

Route::get('/skyscanner/browsequotes/{country}/{currency}/{locale}/{originPlace}/{destinationPlace}/{outboundPartialDate}/{inboundPartialDate?}',
    'Skyscanner\BrowseQuotesController@index');
