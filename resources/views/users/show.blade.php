@extends('layouts.app')

@section('content')
<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>User</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
        <h1>SNS Name</h1>
        <div class="back"><a href="/">戻る</a></div>
        
        <h3>ユーザー情報</h3>
            <div class="user_id">
                <p><a href="">{{ Auth::user()->name }}</a> でログイン中</p>
            </div>
        
        @if ($user->id === Auth::user()->id)
            <p class='edit'>
                [<a href="/users/{{ $user->id }}/edit">ユーザー情報編集</a>]
            </p>
        @endif

            <div class="user">
                <div class="user_id">
                    <h4>ユーザーID</h4>
                    <p>{{ $user->id }}</p> 
                </div>
                <div class="user_name">
                    <h4>ユーザー名</h4>
                    <p>{{ $user->nickname }}</a> 
                </div>

                <div class="image">
                    @if(!is_null($user->icon))
                        <img src="{{ $user->icon }}">
                    @endif
                </div>
                <div class="prefs">
                    <p>場所：{{ $user->prefName }}</p>
                </div>
                <div class="categories">
                    <h4>カテゴリー</h4>
                    <p>{{ $user->categoryName }}</p>
                </div>
            </div>
        
        <!-- この下に自分の投稿一覧 -->    
            
    </body>
</html>
@endsection