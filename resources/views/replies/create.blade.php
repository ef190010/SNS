<!-- 不要かもしれない -->

<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Reply Create</title>
    </head>
    <body>
        <h1>SNS Name</h1>
        <h3>返信の作成</h3>
        <div class="post_display">
            
        </div>
        
        <div class="create_reply">
        <form action="/replies" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="body">
                <h2>本文</h2>
                <textarea name="reply[body]" placeholder="文章を入力してください。" value="{{ old('reply.body') }}" ></textarea>
                <p class="body_error" style="color:red">{{ $errors->first('reply.body') }}</p>
            </div>
            
            <div class='image'>
                <h2>画像</h2>
                <label for="photo">画像ファイル:</label>
                <input type="file" name="file">
                <p class="image_error" style="color:red">{{ $errors->first('file') }}</p>

            </div>
            
            <input type="submit" value="投稿"/>
        </form>
        
        <div class="back">[<a href="/">戻る</a>]</div>
        </div>
    </body>
</html>
