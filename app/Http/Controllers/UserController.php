<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Mail;
use App\Mail\Mailer;
use App\Jobs\SendEmails;
use Validator;
use Bouncer;

class UserController extends Controller
{
    
    public function register(Request $request, Faker $faker)
    {
        
        //validate the request before we add a new user

        $validated = $request->validate([
          'user_name' => 'required|max:255', 
          'user_dob' => 'required', 
          'user_email' => 'required|max:255|unique:App\Models\User,email', ]);
        
        //validation passed, create new user

        $user = new User;
        $user->name = $request->user_name;
        $user->password = $faker->password;
        $user->email = $request->user_email;
        $user->date_of_birth = $request->user_dob;
        $user->save();
        $user->assign('user');
        
        //create the email we will send the user with their randomly generated password

        $details = [
          'title' => 'Registration Successful!', 
          'body' => 'Your randomly generated password is:', 
          'password' => $user->password, 
          'user_name' => $user->name];

        //send the email
        
        // Mail::to($user->email)->send(new \App\Mail\Mailer($details));
        // return response("Registration successful", 200);
        SendEmails::dispatch($user, $details);
        //error_log('Some message here.');
        return response("Registration successful", 200);
    }

    public function login(Request $request)
    {

        //validate the login input before we try to login

        $validator = $request->validate([
            'user_password' => 'required|max:255',
            'user_email' => 'required|max:255', 
            ]);
        
        //validation passed, lookup user in the db
            
        $user = User::where('email', $request->user_email)
            ->where('password', $request->user_password)
            ->first();
        //if query fails, user has entered a wrong user/pass combination
        if (!isset($user))
        {
            return response("User not found", 205);
        }
        //else login is successful
        return response($user, 200);
    }

    public function register_bouncer_admin(Request $request, Faker $faker)
    {
        
        $user = new User;
        $user->name = 'Saif Hatem';
        $user->password = 'saif1997';
        $user->email = $faker->email;
        $user->date_of_birth = '1997-06-16';
        $user->save();
        $user->assign('admin');
        Bouncer::allow('admin')->to('manage-favorites-tool');
        //create the email we will send the user with their randomly generated password
        return response("Registration successful", 200);
    }
}

