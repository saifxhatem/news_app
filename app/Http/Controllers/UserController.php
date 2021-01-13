<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function register(Request $request){
        $validated = $request->validate([
            'user_name' => 'required|max:255',
            'user_password' => 'required|max:255',
            'user_email' => 'required|max:255|unique:App\Models\User,email',
          ]);
          $user = new User;
          $user->name = $request->user_name;
          $user->password = $request->user_password;
          $user->email = $request->user_email;
  
          $user->save();
          return response("Registration successful", 200);
    }

    public function login(Request $request){
        

          $validator = $request->validate([
            'user_password' => 'required|max:255',
            'user_email' => 'required|max:255',
          ]);
  
          
          $user = User::where('email', $request->user_email)
          ->where('password', $request->user_password)
          ->first();
          
          if (!isset($user)) {
            return response("User not found", 205);
          }
  
          
          
          return response("Login successful", 200);
    }

    
}
