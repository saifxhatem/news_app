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
        
        $user = new User;
        $user->email = $this->faker->email;
        $user->name = $this->faker->name;
        $user->date_of_birth = '1997-06-16';
        $user->password = $this->faker->password;
        $user->save();

        //create dummy headline for the test
        $favorite = new Favorite;
        $favorite->user_id = $user->id;
        $favorite->source = 'Source Name';
        $favorite->title = 'Article Title';
        $favorite->description = 'Article Description';
        $favorite->url = 'random_url';
        $favorite->urlToImage = 'random_url';
        $favorite->category = 'business';
        $favorite->country = 'eg';
        $favorite->save();

        
        $response = $this->post('delete-favorite', [
            'user_id' => $user->id,
            'article_id' => $favorite->id,
            ]);
        $this->assertEquals(200, $response->getStatusCode());
        
    }

    public function test_delete_favorites_with_invalid_input()
    {
        //create dummy user for the test
        
        $user = new User;
        $user->email = $this->faker->email;
        $user->name = $this->faker->name;
        $user->date_of_birth = '1997-06-16';
        $user->password = $this->faker->password;
        $user->save();

        //create dummy headline for the test
        $favorite = new Favorite;
        $favorite->user_id = $user->id;
        $favorite->source = 'Source Name';
        $favorite->title = 'Article Title';
        $favorite->description = 'Article Description';
        $favorite->url = 'random_url';
        $favorite->urlToImage = 'random_url';
        $favorite->category = 'business';
        $favorite->country = 'eg';
        $favorite->save();

        
        $response = $this->post('delete-favorite', [
            'user_id' => '',
            'article_id' => '',
            ]);
        $this->assertEquals(302, $response->getStatusCode());
        
    }
    
    
}
