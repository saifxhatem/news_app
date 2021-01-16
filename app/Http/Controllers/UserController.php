<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Mail;
use App\Mail\Mailer;
use Validator;

class UserController extends Controller
{
    public function register(Request $request, Faker $faker)
    {
        $validated = $request->validate([
          'user_name' => 'required|max:255', 
          'user_dob' => 'required', 
          'user_email' => 'required|max:255|unique:App\Models\User,email', ]);
        
        $user = new User;
        $user->name = $request->user_name;
        $user->password = $faker->password;
        $user->email = $request->user_email;
        $user->date_of_birth = $request->user_dob;
        $user->save();

        $details = [
          'title' => 'Registration Successful!', 
          'body' => 'Your randomly generated password is:', 
          'password' => $user->password, 
          'user_name' => $user->name];

        Mail::to($user->email)->send(new \App\Mail\Mailer($details));

        return response("Registration successful", 200);
    }

    public function login(Request $request)
    {

        $validator = $request->validate(['user_password' => 'required|max:255', 'user_email' => 'required|max:255', ]);

        $user = User::where('email', $request->user_email)
            ->where('password', $request->user_password)
            ->first();

        if (!isset($user))
        {
            return response("User not found", 205);
        }
        return response($user, 200);
    }

}

