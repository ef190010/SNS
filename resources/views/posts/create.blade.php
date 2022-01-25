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
                <h2>本文</h2>
                <textarea name="post[body]" placeholder="文章を入力してください。" value="{{ old('post.body') }}" ></textarea>
                <p class="body_error" style="color:red">{{ $errors->first('post.body') }}</p>
            </div>
            
            <!-- 工事中 -->
            <div class="tags">
                <h2>タグ</h2>
                <div>
                    <input type="text" name="post_tag[]" placeholder="タグ（任意）" value=""/>
                    <p class="tag_error" style="color:red">{{ $errors->first('') }}</p>
                </div>
            </div>

            <div class="categories">
                <h2>ジャンル</h2>
                <select name="post[categories]">
                    @foreach($categories as $key => $name)
                        <option value="{{ $key }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>            

            <div class="prefs">
                <h2>都道府県</h2>
                <select name="post[prefs]">
                    @foreach($prefs as $key => $name)
                        <option value="{{ $key }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>            
            
            <div class='image'>
                <h2>画像</h2>
                <label for="photo">画像ファイル:</label>
                <input type="file" name="file">
                <p class="image_error" style="color:red">{{ $errors->first('file') }}</p>

            </div>
            
            <input type="submit" value="投稿"/>
        </form>
        
        <div class="back">[<a href="/">back</a>]</div>
    </body>
</html>