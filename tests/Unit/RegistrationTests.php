<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;


class RegistrationTests extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    /*
        Codes:
        200 -> Registration success Successful
        302 -> Validation failure
     */
    
    use WithFaker;
    //use RefreshDatabase;
    
    
    
    public function test_register_with_valid_input()
    {
        $response = $this->post('register', [
            'user_name' => $this->faker->name,
            'user_email' => $this->faker->email,
            'user_dob' => '1997-06-16',
            ]);
        
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test_register_with_validation_errors()
    {
        $response = $this->post('register', [
            'user_name' => '',
            'user_email' => '',
            'user_dob' => '',
            ]);
        $this->assertEquals(302, $response->getStatusCode());
    }
}
