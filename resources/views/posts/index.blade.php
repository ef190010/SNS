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
        <p class='create'>
            [<a href="/posts/create">新規作成</a>]
        </p>
        
        <div class='posts'>
            @foreach ($posts as $post)
                <div class='post'>
                    <div class="user_id">
                        <h4>ユーザーID</h4>
                        <a href="">{{ $post->user->id }}</a> 
                    </div>
                    <div class="user_name">
                        <h4>ユーザー名</h4>
                        <a href="">{{ $post->user->name }}</a> 
                    </div>
                    <div class="body">
                    <a href='/posts/{{ $post->id }}'>{{ $post->body }}</a>
                    </div>
                    <div class="image">
                        <img src="{{ $post->image_path }}">
                    </div>
                    
                </div>
            @endforeach
        </div>
        <div class='paginate'>
            {{ $posts->links() }}
        </div>
    </body>
</html>