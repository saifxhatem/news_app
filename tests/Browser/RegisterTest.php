<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class RegisterTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_register_with_valid_input()
    {
        $user = User::factory()->make(); //create dummy user
        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/#/Register')
                    ->assertSee('Register')
                    ->type('@user_email', $user->email)
                    ->type('@user_name', $user->name)
                    ->keys('@user_dob', '06', '16', '1997')
                    ->click('@do_register')
                    ->assertVueIsNot('show_error', true, '@registration-component') //assert no errors on page
                    ->pause(5000)
                    ->assertDialogOpened('You have been registered on News App. Please check your email for your password.')
                    ->acceptDialog();
                    $this->assertEquals($browser->driver->getCurrentURL() , 'http://localhost:8000/#/'); //assert that user has been redirected after successful registration
        });
    }

    public function test_register_with_invalid_input()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/#/Register')
                    ->assertSee('Register')
                    ->type('@user_email', '')
                    ->type('@user_name', '')
                    ->keys('@user_dob', '06', '16', '1997')
                    ->click('@do_register')
                    ->assertVue('show_error', true, '@registration-component') //assert that there are errors
                    ->assertSee('cannot be empty'); //assert validation errors are being displayed to user
        });
    }

    
}
