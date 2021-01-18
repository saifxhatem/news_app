<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTests extends TestCase
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
     //use RefreshDatabase;
    

    public function test_login_with_correct_credentials()
    {
        $user = new User;
        $user->email = $this->faker->email;
        $user->name = $this->faker->name;
        $user->date_of_birth = '1997-06-16';
        $user->password = $this->faker->password;
        $user->save();
        
        $response = $this->post('login', [
            'user_email' => $user->email,
            'user_password' => $user->password,
            ]);
        $this->assertEquals(200, $response->getStatusCode());
        
    }
    public function test_login_with_incorrect_credentials()
    {
        
        $response = $this->post('login', [
            'user_email' => 'saifxhatem@gmail.com',
            'user_password' => '123',
            ]);
        $this->assertEquals(205, $response->getStatusCode());
        
    }
    public function test_login_with_empty_fields()
    {
        //$this->withoutExceptionHandling();
        $response = $this->post('login', [
            'user_email' => '',
            'user_password' => '',
            ]);
        $this->assertEquals(302, $response->getStatusCode());
        
    }
    
}
