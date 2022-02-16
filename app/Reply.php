<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Reply extends Model
{
    use SoftDeletes;
    
    // fillableは最初に宣言するらしい
    protected $fillable = [
        'user_id',
        'reply_id',
        'post_id',
        'body',
        'image_path',
        // 'file',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    public function post()
    {
        return $this->belongsTo('App\Post');
    }
    
    public function replies()
    {
        return $this->hasMany('App\Reply');
    }
    
    public function favoriteReplies()
    {
        return $this->belongsToMany('App\User', 'favorite_replies')->withTimestamps();
    }
    
}
