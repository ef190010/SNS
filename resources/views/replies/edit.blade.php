<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Reply Edit</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
        <h1 class="title">SNS Name</h1>
        <div class="content">
            <form action="/replies/{{ $reply->id }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <h3>返信の編集</h3>
                <div class="body">
                    <h4>本文</h4>
                    <textarea name="reply[body]">{{ $reply->body }}</textarea>
                    <p class="body_error" style="color:red">{{ $errors->first('reply.body') }}</p>
                </div>
            
            <div class='image'>
                <h4>画像</h4>
                <img src="{{ $reply->image_path }}">
                <label for="photo">画像ファイル:</label>
                <input type="file" name="file">
                <p class="image_error" style="color:red">{{ $errors->first('file') }}</p>

            </div>
            
                <input type="submit" value="編集を確定">
            </form>
        </div>
        <div class="footer">
            <a href="/">戻る</a>
        </div>
    </body>
</html>