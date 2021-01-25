<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class SaveHeadlineTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_guest_not_able_to_save_headline()
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
                    ->pause(1000)
                    ->assertVisible('@articles')
                    ->assertMissing('@save_headline_button');
        });
    }

    public function test_user_able_to_save_headline()
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
                    ->pause(500)
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
                    ->pause(1000)
                    ->assertVisible('@articles')
                    ->assertVisible('@save_headline_button')
                    ->assertVisible('#save_headline_0')
                    ->assertMissing('#saved_headline_0')
                    ->click('#save_headline_0') //save the first article
                    ->pause(1000)
                    ->assertVisible('#saved_headline_0')
                    ->assertMissing('#save_headline_0');
                    $this->assertEquals('Saved ❤️', $browser->text('#saved_headline_0'));
        });
    }

    
}
