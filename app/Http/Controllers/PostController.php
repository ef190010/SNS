<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Reply;
use App\Post;
use App\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;


class PostController extends Controller
{
    /**
    * Post一覧を表示する
    * 
    * @param Post Postモデル
    * @return array Postモデルリスト
    */
    public function index(Post $post)
    {
        return view('posts/index')->with(['posts' => $post->getPaginateByLimit()]);
    }

    /**
    * 特定IDのpostを表示する
    *
    * @params Object Post // 引数の$postはid=1のPostインスタンス
    * @return Reposnse post view
    */
    public function show(Post $post, Reply $reply)
    {   
        $reply = DB::table('replies')->with('user')->where('post_id', $post->id)->get();
        // $reply = DB::table('replies')->where('post_id', $post->id)->first();

        return view('posts/show')->with([
            'post' => $post,
            'replies' => $reply,
             ]);
        
    }
    
    public function create()
    {   
        $prefs = Config::get('prefs');
        $categories = Config::get('categories');
        
        return view('posts/create')->with([
            'prefs'=>$prefs, 
            'categories'=>$categories,
            ]);
    }
    
    public function store(Post $post, PostRequest $request)
    {
        $input = $request['post'];
        $input['user_id'] = $request->user()->id;
        if ($request->file('file')) {
        
            //S3へのファイルアップロード処理の時の情報を変数$upload_infoに格納
            $upload_info = Storage::disk('s3')->putFile('images', $request->file('file'), 'public');
            //$upload_infoからアップロードされた画像へのリンクURLを取得し、プロパティ(静的メソッド)image_pathに格納 
            $input['image_path'] = Storage::disk('s3')->url($upload_info);
        }
        $post->fill($input)->save();
        // 上の行は $post->create($input）としても良い
        return redirect('/posts/' . $post->id);
    }
    
    
    public function edit(Post $post)
    {
        $prefs = Config::get('prefs');
        $categories = Config::get('categories');

        return view('posts/edit')->with([
            'post' => $post,
            'prefs' => $prefs,
            'categories' => $categories,
            ]);
    }
    
    public function update(PostRequest $request, Post $post)
    {
        $input = $request['post'];
        if ($request->file('file')) {
        
            //S3へのファイルアップロード処理の時の情報を変数$upload_infoに格納
            $upload_info = Storage::disk('s3')->putFile('images', $request->file('file'), 'public');
            //$upload_infoからアップロードされた画像へのリンクURLを取得し、プロパティ(静的メソッド)image_pathに格納 
            $input['image_path'] = Storage::disk('s3')->url($upload_info);
        }
        
        $post->fill($input)->save();
        // 上の行は $post->create($input）としても良い
        return redirect('/posts/' . $post->id);

    }
    
    public function delete(Post $post)
    {
        $post->delete();
        return redirect('/');
    }
 
}
