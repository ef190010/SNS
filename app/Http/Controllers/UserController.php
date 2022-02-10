<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\User;
use App\Follower;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;



class UserController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function show(User $user)
    {
        // $users = new User;
        // $users = User::where('id', $user->id)->get();

        return view('users/show')->with([
            'user' => $user,
        ]);
    }
    
    /**
     * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function edit()
    {
        $prefs = Config::get('prefs');
        $categories = Config::get('categories');

        return view('users/edit')->with([
            'user' => Auth::user(),
            'prefs' => $prefs,
            'categories' => $categories,
            ]);
    }
    

    public function update(UserRequest $request)
    {
        $user = Auth::user();
        $user->fill($request->all());
        // dd($user);
        if ($request->file('icon')) {
            //S3へのファイルアップロード処理の時の情報を変数$upload_infoに格納
            $upload_info = Storage::disk('s3')->putFile('icons', $request->file('icon'), 'public');
            //$upload_infoからアップロードされた画像へのリンクURLを取得し、プロパティ(静的メソッド)image_pathに格納 
            $user->icon = Storage::disk('s3')->url($upload_info);
        }
        
        // パスワードの項目があるとき（つまり、パスワードを変更するとき）
        if (!is_null($request->password)) {
            // パスワードの値をハッシュ化して上書きする。
            $user->password = Hash::make($request->password);
        } else {
            // パスワードの項目に値がないときは、アップデートの対象にしない。
            unset($user->password);
        }
        $user->save();
        return redirect('/users/'. $user->id);

    }
    
    /*
    public function delete(Post $post)
    {
        $post->delete();
        return redirect('/');
    }
    */
    
    // フォロー
    public function follow(User $user)
    {
        Auth::user()->follow($user->id);
        return back();
    }

    // フォロー解除
    public function unfollow(User $user)
    {
        Auth::user()->unfollow($user->id);    
        return back();
        
    }
}