<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Edit</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
        <h1 class="title">SNS Name</h1>
        <div class="content">
            <form action="/posts/{{ $post->id }}" method="POST">
                @csrf
                @method('PUT')
                <h3>投稿の編集</h3>
                <div class="body">
                    <h2>本文</h2>
                    <textarea name="post[body]">{{ $post->body }}</textarea>
                    <p class="body_error" style="color:red">{{ $errors->first('post.body') }}</p>
                </div>
            
            <!-- 工事中 -->
            <div class="tags">
                <h2>タグ</h2>
                <div>
                    <input type="text" name="post_tag[]" value=""/>
                    <p class="tag_error" style="color:red">{{ $errors->first('') }}</p>
                </div>
            </div>

            <div class="categories">
                <h2>ジャンル</h2>
                <select name="post[categories]">
                    @foreach($categories as $key => $name)
                        <option value="{{ $key }}" @if($key == $post->categories) selected @endif>{{ $name }}</option>
                    @endforeach
                </select>
            </div>            

            <div class="prefs">
                <h2>都道府県</h2>
                <select name="post[prefs]">
                    @foreach($prefs as $key => $name)
                        <option value="{{ $key }}" @if($key == $post->prefs) selected @endif>{{ $name }}</option>
                    @endforeach
                </select>
            </div>            
            
            <div class='image'>
                <h2>画像</h2>
                <img src="{{ $post->image_path }}">
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