<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class LoadNewsTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_load_news_as_guest()
    {
        //$user = User::factory()->create(); //create dummy user
        $this->browse(function (Browser $browser) {
            $browser->visit('/#/news')
                    ->assertVueIsNot('show_error', true, '@news-component') //assert no errors on page
                    ->assertSee('Which country do you want to see news for?')
                    ->assertSee('Egypt')
                    ->assertSee('UAE')
                    ->click('@choose_egypt')
                    ->assertVue('country_code', 'eg', '@news-component') //assert country_code set correctly
                    ->assertSee('Please choose a topic')
                    ->assertSee('Business')
                    ->assertSee('Sports')
                    ->click('@choose_sports')
                    ->assertVue('topic', 'sports', '@news-component') //assert topic set correctly
                    ->pause(5000)
                    ->assertVisible('@articles');
        });
    }

    public function test_load_news_as_user()
    {
        $user = User::factory()->create(); //create dummy user
        $this->browse(function (Browser $browser) use ($user) {
            //first, login
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
            //login successful, navigate to news        
            $browser->visit('/#/news')
                    ->assertVueIsNot('show_error', true, '@news-component') //assert no errors on page
                    ->assertSee('Which country do you want to see news for?')
                    ->assertSee('Egypt')
                    ->assertSee('UAE')
                    ->click('@choose_egypt')
                    ->assertVue('country_code', 'eg', '@news-component') //assert country_code set correctly
                    ->assertSee('Please choose a topic')
                    ->assertSee('Business')
                    ->assertSee('Sports')
                    ->click('@choose_sports')
                    ->assertVue('topic', 'sports', '@news-component') //assert topic set correctly
                    ->pause(5000)
                    ->assertVisible('@articles')
                    ->assertVisible('@save_headline_button')
                    ;
        });
    }

    
}
