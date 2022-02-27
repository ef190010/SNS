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
        $reply = Reply::where('post_id', $post->id)->orderBy('updated_at', 'desc')->get();
        // リレーションメソッド(userメソッド、ReplyControllerで使用)はModel（Replyクラス）経由で取得した情報にしか使えない
        // $reply = DB::table('replies')->where('post_id', $post->id)->get();

        return view('posts/show')->with([
            'post' => $post,
            'replies' => $reply,
             ]);
        
    }
    
    public function create()
    {   
        $prefs = Config::get('prefs');
        $categories = Config::get('categories');
        $user = Auth::user();
        
        return view('posts/create')->with([
            'prefs'=>$prefs, 
            'categories'=>$categories,
            'user'=>$user,
            ]);
    }
    
    public function store(Post $post, PostRequest $request, )
    {
        $input = $request['post'];
        $input['user_id'] = $request->user()->id;
        // dd($request->file);
        if ($request->file('file')) {
        
            //S3へのファイルアップロード処理の時の情報を変数$upload_infoに格納
            $upload_info = Storage::disk('s3')->putFile('images', $request->file('file'), 'public');
            //$upload_infoからアップロードされた画像へのリンクURLを取得し、プロパティ(静的メソッド)image_pathに格納 
            $input['image_path'] = Storage::disk('s3')->url($upload_info);
        }
        
        $post->fill($input)->save();
        // dd($post);
        // 上の行は $post->create($input）としても良い
        
        if ($request->tags) {
            // #(ハッシュタグ)で始まる単語を取得。結果は、$matchに多次元配列で代入される。
            preg_match_all('/#([a-zA-Z0-9０-９ぁ-んァ-ヶー一-龠]+)/u', $request->tags, $match);

            // match[0]に#あり、$match[1]に#が返ってくる。今回使うのは後者。
            $tags = [];
            foreach ($match[1] as $tag) {
                // irstOrCreateメソッド：tagsテーブルのnameカラムに該当のない$tagを新規登録
                $record = Tag::firstOrCreate(['name' => $tag]);
                // $recordを配列（$tags）に追加
                array_push($tags, $record);
            }
            // 投稿に紐づけされるタグのidを配列化
            $tags_id = [];
            foreach ($tags as $tag) {
                array_push($tags_id, $tag->id);
            }
            // attachメソッドで中間テーブルにレコード挿入
            // attachメソッドは$postsをsave()してから実行
            $post->tags()->attach($tags_id);
        }
        return redirect('/posts/' . $post->id);
    }
    
    
    public function edit(Post $post)
    {
        $prefs = Config::get('prefs');
        $categories = Config::get('categories');
        $user = Auth::user();

        return view('posts/edit')->with([
            'post' => $post,
            'prefs' => $prefs,
            'categories' => $categories,
            'user' => $user,
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
        
        if ($request->tags) {
            // #(ハッシュタグ)で始まる単語を取得。結果は、$matchに多次元配列で代入される。
            preg_match_all('/#([a-zA-z0-9０-９ぁ-んァ-ヶ亜-熙]+)/u', $request->tags, $match);

            // match[0]に#あり、$match[1]に#が返ってくる。今回使うのは後者。
            $tags = [];
            foreach ($match[1] as $tag) {
                // irstOrCreateメソッド：tagsテーブルのnameカラムに該当のない$tagを新規登録
                $record = Tag::firstOrCreate(['name' => $tag]);
                // $recordを配列（$tags）に追加
                array_push($tags, $record);
            }
            // 投稿に紐づけされるタグのidを配列化
            $tags_id = [];
            foreach ($tags as $tag) {
                array_push($tags_id, $tag->id);
            }
            // attachメソッドで中間テーブルにレコード挿入
            // attachメソッドは$postsをsave()してから実行
            $post->tags()->sync($tags_id);
        }
        
        return redirect('/posts/' . $post->id);

    }
    
    public function delete(Post $post)
    {
        $post->delete();
        return redirect('/');
    }
 
    public function search()
    {
        $posts = Post::orderBy("updated_at", "desc")->where(function ($query) {
    
            // 検索機能
            if ($search = request("search")) {
                $query->Where("body","LIKE","%{$search}%");
            }
        })->paginate(50);

        return view('/posts/search')->with([
            'posts' => $posts
        ]);
    }
}
