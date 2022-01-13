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
                    <p class='body'>
                        <a href='/posts/{{ $post->id }}'>{{ $post->body }}</a>
                    </p>
                </div>
            @endforeach
        </div>
        <div class='paginate'>
            {{ $posts->links() }}
        </div>
    </body>
</html>