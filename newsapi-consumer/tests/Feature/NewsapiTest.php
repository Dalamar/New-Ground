<?php

namespace Tests\Feature;

use Tests\TestCase;

class NewsapiTest extends TestCase
{
    /**
     * Test for proxying the sources from newsapi.
     *
     * @return void
     */
    public function testSources()
    {
        $response = $this->get('/api/newsapi/sources');

        $response->assertStatus(200);
    }

    /**
     * Test for proxying the articles from newsapi.
     *
     * @return void
     */
    public function testAbcNewsAuArticles()
    {
        $response = $this->get('/api/newsapi/articles/abc-news-au');

        $response->assertStatus(200);
        $response->assertJsonFragment(['status' => 'success']);
        $response->assertJsonFragment(['NG_Description' => 'Custom description']);
        $response->assertJsonFragment(['NG_Review' => 'Custom review']);
    }

    /**
     * Test for requesting wrong source id for articles.
     *
     * @return void
     */
    public function testArticlesWrongSourceId()
    {
        $response = $this->get('/api/newsapi/articles/abc-news-aus');

        $response->assertStatus(400);
        $response->assertJsonFragment(['status' => 'error']);
    }
}
