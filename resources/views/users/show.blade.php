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
        <h3>ユーザー情報</h3>
        <div class="back"><a href="/">戻る</a></div>
        
            <div class="user_id">
                <p><a href="">{{ Auth::user()->name }}</a> でログイン中</p>
            </div>
        
        @if ($user->id === Auth::user()->id)
            <p class='edit'>
                [<a href="/users/{{ $user->id }}/edit">ユーザー情報編集</a>]
            </p>
        @endif

        @if ($user->id !== Auth::user()->id)
            @if (Auth::user()->isFollowed($user->id))
                <div class="px-2">
                    <span class="px-1 bg-secondary text-light">フォローされています</span>
                </div>
            @endif
            
            <div>
                @if (Auth::user()->isFollowing($user->id))
                    <form action="/users/{{ $user->id }}/unfollow" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">フォロー解除</button>
                    </form>
                @else
                    <form action="/users/{{ $user->id }}/follow" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">フォローする</button>
                    </form>
                @endif
            </div>
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
                    <h4>マイカテゴリー</h4>
                    <p>{{ $user->categoryName }}</p>
                </div>
            </div>
        
        <!-- この下に自分の投稿一覧 -->
        <div>
        <h4>自分の投稿一覧</h4>

            @forelse ($posts as $post)
                <div class='post'>
                    <div class="user_id">
                        <h4>ユーザーID</h4>
                        <a href="/users/{{ $post->user->id }}">{{ $post->user->name }}</a> 
                    </div>
                    <div class="user_name">
                        <h4>ユーザー名</h4>
                        <p>{{ $post->user->nickname }}</p> 
                    </div>
                    <div class="body">
                    <a href='/posts/{{ $post->id }}'>{{ $post->body }}</a>
                    </div>
                    <div class="image">
                        <img src="{{ $post->image_path }}">
                    </div>
                </div>
                    <div class="row justify-content-center">
                        <p>いいね数：{{ $post->favoritePosts()->count() }}</p>
                    </div>
                
            @empty
             <p>まだ投稿はありません。</p>
            @endforelse
            
            
        </div>
            
    </body>
</html>
@endsection