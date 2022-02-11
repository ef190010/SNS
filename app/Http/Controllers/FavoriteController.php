<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Favorite;
use App\Post;
use App\Reply;
use Illuminate\Support\Facades\Auth;


class FavoriteController extends Controller
{
public function storePost(Post $post)
    {
        $post->favoritePosts()->attach(Auth::id());

        return back();
    }



public function deletePost(Post $post)
    {
        $post->favoritePosts()->detach(Auth::id());

        return back();
    }    
}
