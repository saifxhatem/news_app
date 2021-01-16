<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use App\Models\User;





class NewsController extends Controller
{
    public function load_news(Request $request, $country_code, $topic){
      
      if ($topic != "business" && $topic != "sports") return response("Invalid topic", 404);
      if ($country_code != 'ae' && $country_code != 'eg') return response("Invalid country", 404);
      $url_string = "https://newsapi.org/v2/top-headlines?country=" . $country_code . "&category=" . $topic . "&apiKey=d68eedc60ffb475abe53a4d5d26acc0c";
      $news = Http::get($url_string);
      return $news['articles'];
    }

    
}
