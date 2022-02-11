<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FavoritePost extends Model
{   
    protected $fillable = [
        'user_id',
        'post_id',
        ];
    
    protected $table = 'favorite_posts';
    
    public function post()
    {
        return $this->belongsTo('App\Post');
    }
    
    public function User()
    {
        return $this->belongsTo('App\User');
    }

}
