<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Favorite;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteFavorites extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    
     /*
        Note: the first test here actually registers a new user, so you should either clean your user table after 
        running a test here or uncomment "use RefreshDatabase;"
        Codes:
        200 -> Login Successful
        205 -> Invalid email/password combination
        302 -> Validation failure
     */
    use WithFaker;

    
    
    public function test_delete_favorites_with_valid_input()
    {
        //create dummy user for the test
        
        $user = User::factory()->create();

        //create dummy headline for the test
        
        $favorite = Favorite::factory()->create([
            'user_id' => $user->id, //override the default user_id in the factory
        ]);

        
        $response = $this->post('delete-favorite', [
            'user_id' => $user->id,
            'article_id' => $favorite->id,
            ]);
        $this->assertEquals(200, $response->getStatusCode());
        
    }

    public function test_delete_favorites_with_invalid_input()
    {
        //create dummy user for the test
        
        
        $user = User::factory()->create();

        //create dummy headline for the test
        $favorite = Favorite::factory()->create([
            'user_id' => $user->id, //override the default user_id in the factory
        ]);

        
        $response = $this->post('delete-favorite', [
            'user_id' => '',
            'article_id' => '',
            ]);
        $this->assertEquals(302, $response->getStatusCode());
        
    }
    
    
}
