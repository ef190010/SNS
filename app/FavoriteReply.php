<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FavoriteReply extends Model
{
    protected $fillable = [
        'user_id',
        'reply_id',
        ];
    
    protected $table = 'favorite_replies';
    
    /**
     * プライマリーキー無効 
     */
    protected $primaryKey = null;

    /**
     * AutoIncrement無効
     */
    public $incrementing = false;
    
    public function reply()
    {
        return $this->belongsTo('App\Reply');
    }
    
    public function User()
    {
        return $this->belongsTo('App\User');
    }

}
