<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Favorite;
use App\Rules\FilterRules;


class FavoriteController extends Controller
{
    //
    public function add_favorite(Request $request){

        //first we validate our input

        $validated = $request->validate([
            'user_id' => 'required|max:255|exists:App\Models\User,id',
            'source.name' => 'required|max:255',
            'title' => 'required|max:255',
            'description' => 'required|max:10000',
            'url' => 'required|max:500',
            'urlToImage' => 'required|max:500',
            'category' => 'required|max:255',
            'country' => 'required|max:255',
            
          ]);

        /*
        input has been validated
        create new favorite and fill it with our request data
        */
        $favorite = new Favorite;
        $favorite->user_id = $request->user_id;
        $favorite->source = $request->source['name'];
        $favorite->title = $request->title;
        $favorite->description = $request->description;
        $favorite->url = $request->url;
        $favorite->urlToImage = $request->urlToImage;
        $favorite->category = $request->category;
        $favorite->country = $request->country;
        $favorite->save();
        return response("New favorite successfully added", 200);
    }

    public function load_favorite(Request $request)
    {
        //first we validate our input, need to make sure that the user is valid before we can load their favorites
        $validated = $request->validate([
            'user_id' => 'required|exists:App\Models\User,id',
            'filter' => [
                'required',
                new FilterRules()
            ],
            
        ]);
        /*
        validation passed, find user to load their favorites
        */
        
        if ($request->filter == 'all') {
                $favorites = Favorite::where('user_id', $request->user_id)->get();
                if ($favorites->count() < 1) return response ("User has no favorites from " . $request->filter, 216);
                    else return $favorites;
        }
        else {
            $favorites = Favorite::where('user_id', $request->user_id)
                ->where(function ($query) use ($request) {
                    $query->where('country', $request->filter)
                    ->orWhere('category', $request->filter);
                })->get();
                if ($favorites->count() < 1) return response ("User has no favorites from " . $request->filter, 216);
                    else return $favorites;
        }
    }

    public function delete_favorite(Request $request){
        //validate that both the user and the favorite exist
        $validated = $request->validate([
            'user_id' => 'required|exists:App\Models\User,id',
            'article_id' => 'required|exists:App\Models\Favorite,id'
        ]);
        //delete the favorite
        Favorite::destroy($request->article_id); //since we know the ID and checked that it exists, we do not need to load the object since we can delete it directly
        return response("Headline removed successfully", 200);   
    }

    public function count_favorites(request $request){
        $validated = $request->validate([
            'user_id' => 'required|exists:App\Models\User,id',
        ]);

        $favorite_count = Favorite::where('user_id', $request->user_id)->count();
        return $favorite_count;
    }

    
}
