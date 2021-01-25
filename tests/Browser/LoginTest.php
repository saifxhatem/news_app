<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class LoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_login_with_valid_credentials()
    {
        $user = User::factory()->create(); //create dummy user
        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/#/login')
                    ->assertSee('Login')
                    ->type('@user_email', $user->email)
                    ->type('@user_password', $user->password)
                    ->click('@do_login')
                    ->assertVueIsNot('show_error', true, '@login-component') //assert no errors on page
                    ->pause(5000)
                    ->assertDialogOpened('You have successfully logged in. You will now be redirected to the homepage.')
                    ->acceptDialog();
                    $this->assertEquals($browser->driver->getCurrentURL() , 'http://localhost:8000/#/'); //assert that user has been redirected after successful login
        });
    }

    public function test_login_with_invalid_credentials()
    {
        $user = User::factory()->create(); //create dummy user
        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/#/login')
                    ->assertSee('Login')
                    ->type('@user_email', $user->email)
                    ->type('@user_password', $user->password . '123')
                    ->click('@do_login')
                    ->pause(5000)
                    ->assertVue('show_error', true, '@login-component') //assert there are errors on page
                    ->assertVue('err_msg', 'Email or password are incorrect.', '@login-component');
        });
    }

    public function test_login_with_empty_credentials()
    {
        
        $this->browse(function (Browser $browser) {
            $browser->visit('/#/login')
                    ->assertSee('Login')
                    ->type('@user_email', '')
                    ->type('@user_password', '')
                    ->click('@do_login')
                    ->assertVue('show_error', true, '@login-component') //assert there are errors on page
                    ->assertSee('cannot be empty'); //assert validation errors are being displayed to user
        });
    }
}
