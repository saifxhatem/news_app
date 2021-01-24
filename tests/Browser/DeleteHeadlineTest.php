<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\Favorite;

class DeleteHeadlineTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_guest_not_able_to_delete_headline()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/#/')
                    ->assertDontSee('Favorites') //assert user does not see the link
                    ->visit('/#/favorites')
                    ->assertDialogOpened('You are not logged in! You will be redirected to homepage') //assert user can't access page without being logged in
                    ->acceptDialog();
                    $this->assertEquals($browser->driver->getCurrentURL() , 'http://localhost:8000/#/'); //assert user has been redirected to homepage
                    
        });
    }

    public function test_user_able_to_delete_headline()
    {
        $user = User::factory()->create(); //create dummy user
        $favorite = Favorite::factory()->create([
            'user_id' => $user->id, //override the default user_id in the factory
        ]);
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
                    ->acceptDialog()
                    ->assertSee("Favorites");

                    $this->assertEquals($browser->driver->getCurrentURL() , 'http://localhost:8000/#/'); //assert that user has been redirected after successful login
            //login successful, navigate to news        
            $browser->visit('/#/favorites')
                    ->assertSee('Saved Headlines')
                    ->assertVisible('@filter_selector')
                    ->select('@filter_selector', 'all')
                    ->pause(250)
                    ->assertVisible('#article_0') //assert user can see favorite
                    ->assertVisible('#delete_article_0') //assert user can see "delete favorite" button
                    ->click('#delete_article_0')
                    ->pause(250)
                    ->screenshot('after_clicking_delete')
                    ->assertMissing('#article_0') //assert article has been hidden successfully
                    ->assertMissing('#delete_article_0') //assert delete button has been hidden successfully
                    ;
        });
    }

    
}
