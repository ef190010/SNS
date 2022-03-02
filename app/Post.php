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
        'lat',
        'lng',
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
    
    public function getPrefNameAttribute() {
        return config('prefs.'.$this->prefs);
    }
    
    public function getCategoryNameAttribute() {
        return config('categories.'.$this->categories);
    }

    // ページネーション
    public function getPaginateByLimit(int $limit_count = 30)
    {
        // updated_atで降順に並べたあと、limitで件数制限をかける
        return $this->orderBy('updated_at', 'DESC')->paginate($limit_count);
    }
    
}
