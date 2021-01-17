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
    ];
    //define relationship of favorites to user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
