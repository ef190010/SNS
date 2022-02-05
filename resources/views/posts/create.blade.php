<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Create</title>
    </head>
    <body>
        <h1>SNS Name</h1>
        <h3>投稿の作成</h3>
        <form action="/posts" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="body">
                <h4>本文</h4>
                <textarea name="post[body]" placeholder="文章を入力してください。" >{{ old('post.body') }}</textarea>
                <p class="body_error" style="color:red">{{ $errors->first('post.body') }}</p>
            </div>
            
            <div class="tags">
                <h4>タグ</h4>
                <div>
                    <input type="text" name="tags" placeholder="タグ（任意）" value="{{ old('tags') }}"/>
                    <p class="tag_error" style="color:red">{{ $errors->first('tags') }}</p>
                </div>
            </div>

            <div class="categories">
                <h4>ジャンル</h4>
                <select name="post[categories]">
                    @foreach($categories as $key => $name)
                        <option value="{{ $key }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>            

            <div class="prefs">
                <h4>都道府県</h4>
                <select name="post[prefs]">
                    @foreach($prefs as $key => $name)
                        <option value="{{ $key }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>            
            
            <div class='image'>
                <h4>画像</h4>
                <label for="photo">画像ファイル:</label>
                <input type="file" name="file">
                <img src="file">
                <p class="image_error" style="color:red">{{ $errors->first('file') }}</p>

            </div>
            
            <input type="submit" value="投稿"/>
        </form>
        
        <div class="back">[<a href="/">back</a>]</div>
    </body>
</html>