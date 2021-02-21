<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;
    //set fillables

    protected $fillable = [
        'source',
        'author',
        'title',
        'description',
        'url',
        'urlToImage',
        'category',
        'country',
        'favorite_status'
        
    ];
    //define relationship of favorites to user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function favoriteState()
    {
        //define relationship of user to favorites
        return $this->hasOne(FavoriteState::class);
    }
}
