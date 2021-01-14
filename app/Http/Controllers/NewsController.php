<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use App\Models\User;





class NewsController extends Controller
{
    public function load_news(Request $request, $country_code){
      
      $url_string = "https://newsapi.org/v2/top-headlines?country=" . $country_code . "&apiKey=d68eedc60ffb475abe53a4d5d26acc0c";
      $news = Http::get($url_string);
      //dd($news['articles']);
      //dd($news->json());
      return $news['articles'];
    }

    
}
