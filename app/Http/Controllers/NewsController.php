<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use App\Models\User;





class NewsController extends Controller
{
    public function load_news(Request $request, $country_code, $topic){
      //start by validating the topic and return an error if topic validation fails
      if ($topic != "business" && $topic != "sports") 
        return response("Invalid topic", 404);
      //validate the country code and return an error if country code validation fails      
      if ($country_code != 'ae' && $country_code != 'eg') 
        return response("Invalid country", 404);
      //validation passed, create the string we will use to make the API call using user's chosen country code and topic  
      $url_string = "https://newsapi.org/v2/top-headlines?country=" . $country_code . "&category=" . $topic . "&apiKey=d68eedc60ffb475abe53a4d5d26acc0c";
      //make the API call
      //dd($url_string);
      $news = Http::get($url_string);
      return $news['articles'];
    }

    
}
