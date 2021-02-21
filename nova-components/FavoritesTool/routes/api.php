<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Favorite;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;



/*
|--------------------------------------------------------------------------
| Tool API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your tool. These routes
| are loaded by the ServiceProvider of your tool. They are protected
| by your tool's "Authorize" middleware by default. Now, go build!
|
*/

// Route::get('/endpoint', function (Request $request) {
//     //
// });


Route::get('/get_current_user_id', function()
{
    $user = auth()->user();
    return $user->id;
});



//posted logic
//add new column 