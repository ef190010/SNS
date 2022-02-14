<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    protected $fillable = [
        'followed_user_id',
        'following_user_id',
    ];
    
    protected $table = 'followers';
    
}
