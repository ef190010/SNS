<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Post</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="/css/app.css">
    </head>
    <body>
        <h1>SNS Name</h1>        
        <div class="content">
            <p class="edit">[<a href="/posts/{{ $post->id }}/edit">編集</a>]</p>
            <!-- ※上の行は仮配置 -->
            
            <form action="/posts/{{ $post->id }}" id="form_{{ $post->id }}" method="post" style="display:inline" onclick="return confirm('本当に削除しますか?')">
                @csrf
                @method('DELETE')
                <button type="submit">削除</button> 
            </form>
            
            <div class="content_post">
                <h3>投稿の詳細</h3>
                <div class="user_id">
                    <h4>ユーザーID</h4>
                    <a href="">{{ $post->user->id }}</a> 
                </div>
                <div class="user_name">
                    <h4>ユーザー名</h4>
                    <a href="">{{ $post->user->name }}</a> 
                </div>
                <div class="body">
                    <p>{{ $post->body }}</p>
                </div>
                
                <!-- 工事中 -->
                <div class="tags">
                    <h4>タグ</h4>
                    @foreach($post->tags as $tag)   
                        {{ $tag->name }}
                    @endforeach
                </div>
                
                <div class="image">
                    <img src="{{ $post->image_path }}">
                </div>
                <div class="prefs">
                    <p>{{ $post->prefName }}</p>
                </div>
                <div class="categories">
                    <h4>カテゴリー</h4>
                    <p>{{ $post->categoryName }}</p>
                </div>
            </div>
        </div>
        <div class="footer">
            <a href="/">戻る</a>
        </div>
    </body>
</html>