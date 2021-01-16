<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Favorite;

class FavoriteController extends Controller
{
    //
    public function add_favorite(Request $request){
        $validated = $request->validate([
            'user_id' => 'required|max:255|exists:App\Models\User,id',
            'source.name' => 'required|max:255',
            'title' => 'required|max:255',
            'description' => 'required|max:10000',
            'url' => 'required|max:500',
            'urlToImage' => 'required|max:500',
            'category' => 'required|max:255',
          ]);
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
        $validated = $request->validate([
            'user_id' => 'required|exists:App\Models\User,id'
        ]);

        $favorites = Favorite::where('user_id', $request->user_id)->get();
        return $favorites;
    }

    public function delete_favorite(Request $request){
        $validated = $request->validate([
            'user_id' => 'required|exists:App\Models\User,id',
            'article_id' => 'required|exists:App\Models\Favorite,id'
        
        ]);
        Favorite::destroy($request->article_id); //since we know the ID and checked that it exists, we do not need to load the object since we can delete it directly
        return response("Headline removed successfully", 200);   
    }
}
