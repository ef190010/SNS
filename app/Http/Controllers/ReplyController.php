<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReplyRequest;
use App\Reply;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class ReplyController extends Controller
{
    public function show(Reply $reply)
    {   
        $replies = new Reply;
        $replies = Reply::where('reply_id', $reply->id)->orderBy('updated_at', 'desc')->get();
        $user = Auth::user();

        return view('replies/show')->with([
            'reply' => $reply,
            'replies' => $replies,
            'user' => $user,
             ]);
    }    

    public function store(ReplyRequest $request, Reply $reply)
    {
        $input = $request['reply'];
        $input['user_id'] = $request->user()->id;
        
        if ($request->file('file')) {
        
            //S3へのファイルアップロード処理の時の情報を変数$upload_infoに格納
            $upload_info = Storage::disk('s3')->putFile('images', $request->file('file'), 'public');
            //$upload_infoからアップロードされた画像へのリンクURLを取得し、プロパティ(静的メソッド)image_pathに格納 
            $input['image_path'] = Storage::disk('s3')->url($upload_info);
        }
        $reply->fill($input)->save();
        // 上の行は $post->create($input）としても良い
        if ($reply->post_id) {
            return redirect('/posts/' . $reply->post_id);
        } else {
            return redirect('/replies/' . $reply->reply_id);
        }

    }

    public function edit(Reply $reply)
    {
        $user = Auth::user();
        
        return view('replies/edit')->with([
            'reply' => $reply,
            'user' => $user,
        ]);
    }
 
     public function update(ReplyRequest $request, Reply $reply)
    {
        $input = $request['reply'];
        if ($request->file('file')) {
        
            //S3へのファイルアップロード処理の時の情報を変数$upload_infoに格納
            $upload_info = Storage::disk('s3')->putFile('images', $request->file('file'), 'public');
            //$upload_infoからアップロードされた画像へのリンクURLを取得し、プロパティ(静的メソッド)image_pathに格納 
            $input['image_path'] = Storage::disk('s3')->url($upload_info);
        }
        
        $reply->fill($input)->save();
        // 上の行は $reply->create($input）としても良い
        
        return redirect('/replies/' . $reply->id);
    }
    
    public function delete(Reply $reply)
    {
        $reply->delete();
        if ($reply->post_id) {
            return redirect('/posts/' . $reply->post_id);
        } else {
            return redirect('/replies/' . $reply->reply_id);
        }
    }
   
}
