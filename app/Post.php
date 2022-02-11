<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
    
    // fillableは最初に宣言するらしい
    protected $fillable = [
        'body',
        'user_id',
        'categories',
        'prefs',
        'image_path',
        // 'file',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    public function tags()
    {
        return $this->belongsToMany('App\Tag')->withTimestamps();
    }
    
    public function replies()
    {
        return $this->hasMany('App\Reply');
    }
    
    public function favoritePosts()
    {
        return $this->belongsToMany('App\User', 'favorite_posts')->withTimestamps();
    }
    
    /*
    // する
    public function follow(Int $user_id) 
    {
        return $this->follows()->attach($user_id);
    }

    // する
    public function unfollow(Int $user_id)
    {
        return $this->follows()->detach($user_id);
    }

    // いいねしているか
    public function isFavoritePost(Int $user_id)
    {
        return $this->follows()->where('followed_user_id', $user_id)->exists();
    }
    */

    
    public function getPrefNameAttribute() {
        return config('prefs.'.$this->prefs);
    }
    
    public function getCategoryNameAttribute() {
        return config('categories.'.$this->categories);
    }


    public function getPaginateByLimit(int $limit_count = 10)
    {
        // updated_atで降順に並べたあと、limitで件数制限をかける
        return $this->orderBy('updated_at', 'DESC')->paginate($limit_count);
    }
    
}
