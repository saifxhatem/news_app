<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoadNews extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    
     /*
        Codes:
        200 -> Valid request
        404 -> Wrong country code and/or wrong topic
     */
    use WithFaker;
    //use RefreshDatabase;
    
    
    public function test_load_news_with_valid_input()
    {
        $country_code = 'eg';
        $topic = 'business';
        $url_string = 'load-news/' . $country_code . '/' . $topic;
        $load_news = $this->get($url_string);
        $this->assertEquals(200, $load_news->getStatusCode());
    }

    public function test_load_news_with_invalid_input()
    {
        $country_code = 'wrong_country_code';
        $topic = 'wrong_topic';
        $url_string = 'load-news/' . $country_code . '/' . $topic;
        $load_news = $this->get($url_string);
        $this->assertEquals(404, $load_news->getStatusCode());
    }

    

    
    
    
}
