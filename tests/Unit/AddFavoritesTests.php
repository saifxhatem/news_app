<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Favorite;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddFavorites extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    
     /*
        Codes:
        200 -> Favorite added successfully
        302 -> Validation failure
     */
    use WithFaker;
    //use RefreshDatabase;
    
    
    public function test_add_favorites_with_valid_input()
    {
        
        //create dummy user for the test
        $user = User::factory()->create();
        //create dummy headline for the test
        $favorite = Favorite::factory()->create([
            'user_id' => $user->id, //override the default user_id in the factory
        ]);

        
        $response = $this->post('add-to-favorites', [
            'user_id' => $user->id,
            'title' => $favorite->title,
            'description' => $favorite->description,
            'url' => $favorite->url,
            'urlToImage' => $favorite->urlToImage,
            'category' => $favorite->category,
            'country' => $favorite->country,
            'source' => ['name' => $favorite->source]
            ]);
        
        $this->assertEquals(200, $response->getStatusCode());
        
    }

    public function test_add_favorites_with_invalid_input()
    {
        //create dummy user for the test
        $user = User::factory()->create();
        //create dummy headline for the test
        $favorite = Favorite::factory()->create([
            'user_id' => $user->id, //override the default user_id in the factory
        ]);

        
        $response = $this->post('add-to-favorites', [
            'user_id' => '',
            'title' => '',
            'description' => '',
            'url' => '',
            'urlToImage' => '',
            'category' => '',
            'country' => '',
            'source' => ['name' => '']
            ]);
        $this->assertEquals(302, $response->getStatusCode());
        
    }
    
    
}
