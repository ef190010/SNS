<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReplyRequest;
use App\Reply;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReplyController extends Controller
{
    public function create()
    {
        return view('replies/create');
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
        return redirect('/posts/' . $reply->post_id);

    }
    
    public function edit(Reply $reply)
    {
        return view('replies/edit')->with([
            'reply' => $reply,
        ]);
    }
}
