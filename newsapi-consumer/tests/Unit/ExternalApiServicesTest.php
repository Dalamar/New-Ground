<?php

namespace Tests\Unit;

use App\Services\ExternalApi\NewsApi\Articles;
use Tests\TestCase;

class ExternalApiServicesTest extends TestCase
{
    protected $sourceData = '{
            "status": "ok",
            "source": "abc-news-au",
            "sortBy": "top",
            "articles": [{
                "author": "http:\/\/www.abc.net.au\/news\/henry-belot\/7953986",
                "title": "PM announces \'Gonski 2.0\' schools review, funding boost",
                "description": "The Federal Government says it will overhaul education funding in a bid to end the school funding wars, but Labor has condemned the plan as an act of political bastardry.",
                "url": "http:\/\/www.abc.net.au\/news\/2017-05-02\/malcolm-turnbull-announces-schools-funding-boost\/8489806",
                "urlToImage": "http:\/\/www.abc.net.au\/news\/image\/8490274-1x1-700x700.jpg",
                "publishedAt": "2017-05-02T08:08:15Z"
            }, {
                "author": "http:\/\/www.abc.net.au\/news\/sophie-mcneill\/4516794",
                "title": "\'Day from hell\': A doctor\'s account of the Khan Sheikhoun chemical attack",
                "description": "Dr Marmoun Morad was in Khan Sheikhoun when it was hit by a chemical attack. He told Lateline it was like seeing the end of the world.",
                "url": "http:\/\/www.abc.net.au\/news\/2017-05-02\/day-from-hell-khan-sheikhoun-chemical-attack\/8489214",
                "urlToImage": "http:\/\/www.abc.net.au\/news\/image\/8489466-1x1-700x700.jpg",
                "publishedAt": "2017-05-02T14:43:29Z"
            }]
        }';

    /**
     * Test of Article::injectData() method which must inject custom data into API response
     *
     * @return void
     */
    public function testNewsApiInject()
    {
        // Mocking Article::fetchData() method to omit external API requests
        $articleService = $this->createPartialMock(Articles::class, ['fetchData']);
        $articleService->method('fetchData')->willReturn($this->sourceData);

        // Getting source data
        $original = json_decode($articleService->fetchData());

        // Injecting test dummy data
        $actual = $articleService->injectData($original, 'articles', [
            'TestKey' => 'TestValue',
        ]);

        // Getting array of articles
        $articlesArray = $actual->articles;

        // Getting first articles object
        $actualObject = reset($articlesArray);

        // Getting injected value for assertion
        $value = $this->getObjectAttribute($actualObject, 'TestKey');

        // Finally asserting object attribute and value
        $this->assertObjectHasAttribute('TestKey', $actualObject);
        $this->assertSame('TestValue', $value);
    }
}
