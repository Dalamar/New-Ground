<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class NewsapiTest extends TestCase
{
    /**
     * Test for proxying the sources from newsapi.
     *
     * @return void
     */
    public function testSources()
    {
        $response = $this->get('/api/sources');

        $response->assertStatus(200);
    }

    /**
     * Test for proxying the articles from newsapi.
     *
     * @return void
     */
    public function testArticles()
    {
        $response = $this->get('/api/articles/abc-news-au');

        $response->assertStatus(200);

        $response->assertJsonFragment(['status' => 'success']);
    }

    /**
     * Test for requesting wrong source id for articles.
     *
     * @return void
     */
    public function testArticlesWrongSourceId()
    {
        $response = $this->get('/api/articles/abc-news-aus');

        $response->assertStatus(400);

        $response->assertJsonFragment(['status' => 'error']);
    }
}
