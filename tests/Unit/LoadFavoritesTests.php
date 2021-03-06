<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Favorite;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoadFavorites extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    
     /*
        Codes:
        200 -> Favorites loaded successfully
        302 -> Validation failure
     */
    use WithFaker;
    //use RefreshDatabase;
    
    
    public function test_load_favorites_with_valid_input()
    {
        
        //create dummy user for the test
        $user = User::factory()->create();
        //create dummy headline for the test
        $favorite = Favorite::factory()->create([
            'user_id' => $user->id, //override the default user_id in the factory
        ]);

        //add dummy favorite for the test

        $add_dummy_favorite = $this->post('add-to-favorites', [
            'user_id' => $user->id,
            'title' => $favorite->title,
            'description' => $favorite->description,
            'url' => $favorite->url,
            'urlToImage' => $favorite->urlToImage,
            'category' => $favorite->category,
            'country' => $favorite->country,
            'posted_status' => 1,
            'source' => ['name' => $favorite->source]
            ]);
        
        $this->assertEquals(200, $add_dummy_favorite->getStatusCode());

        $load_favorite = $this->post('load-favorites', [
            'user_id' => $user->id,
            ]);
        
        $this->assertEquals(200, $load_favorite->getStatusCode());
    }

    public function test_load_favorites_with_invalid_input()
    {
        
        //create dummy user for the test
        $user = User::factory()->create();
        //create dummy headline for the test
        $favorite = Favorite::factory()->create([
            'user_id' => $user->id, //override the default user_id in the factory
        ]);

        //add dummy favorite for the test

        $add_dummy_favorite = $this->post('add-to-favorites', [
            'user_id' => $user->id,
            'title' => $favorite->title,
            'description' => $favorite->description,
            'url' => $favorite->url,
            'urlToImage' => $favorite->urlToImage,
            'category' => $favorite->category,
            'country' => $favorite->country,
            'posted_status' => 1,
            'source' => ['name' => $favorite->source]
            ]);
        
        $this->assertEquals(200, $add_dummy_favorite->getStatusCode());

        $load_favorite = $this->post('load-favorites', [
            'user_id' => '',
            ]);
        
        $this->assertEquals(302, $load_favorite->getStatusCode());
    }

    
    
    
}
