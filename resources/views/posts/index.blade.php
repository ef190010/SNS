@extends('layouts.app')

@section('content')
<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Home</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
        <h1>SNS Name</h1>
        <h3>タイムライン</h3>
        <div class="user_id">
            <p><a href="/users/{{ Auth::user()->id }}">{{ Auth::user()->name }}</a> でログイン中</p>
        </div>

        <p class='create'>
            [<a href="/posts/create">新規作成</a>]
        </p>
        
        <div class='posts'>
            @foreach ($posts as $post)
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
                    
                    <!-- ここからいいね機能 -->
                <div>
                    @if ($post->favoritePosts()->where('user_id', Auth::user()->id)->where('post_id', $post->id)->exists())
                        <form method="POST" action="/posts/{{ $post->id }}/unfavorite" class="mb-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit">いいね取消</button>
                        </form>
                    @else
                        <form method="POST" action="/posts/{{ $post->id }}/favorite" class="mb-0">
                            @csrf
                            <button type="submit">いいね</button>
                        </form>
                    @endif
                    <div class="row justify-content-center">
                        <p>いいね数：{{ $post->favoritePosts()->count() }}</p>
                    </div>
                </div>
                    <!-- ここまで -->                
                    
                </div>
            @endforeach
        </div>
        <div class='paginate'>
            {{ $posts->links() }}
        </div>
    </body>
</html>
@endsection