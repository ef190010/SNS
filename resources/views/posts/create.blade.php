<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Create</title>
    </head>
    <body>
        <h1>SNS Name</h1>
        <form action="/posts" method="POST">
            @csrf
            <div class="body">
                <h2>本文</h2>
                <textarea name="post[body]" placeholder="文章を入力してください。" value="{{ old('post.title') }}" ></textarea>
                <p class="body_error" style="color:red">{{ $errors->first('post.body') }}</p>
            </div>
            
            <div class="keywords">
                <h2>キーワード</h2>
                <div class="keyword">
                    <input type="text" name="post[keyword_1]" placeholder="キーワード1（任意）" value="{{ old('post.keyword_1') }}"/>
                    <p class="title1_error" style="color:red">{{ $errors->first('post.keyword_1') }}</p>
                </div>
                <div class="keyword">
                    <input type="text" name="post[keyword_2]" placeholder="キーワード2（任意）" value="{{ old('post.keyword_2') }}"/>
                    <p class="title2_error" style="color:red">{{ $errors->first('post.keyword_2') }}</p>
                </div>
                <div class="keyword">
                    <input type="text" name="post[keyword_3]" placeholder="キーワード3（任意）" value="{{ old('post.keyword_3') }}"/>
                    <p class="title3_error" style="color:red">{{ $errors->first('post.keyword_3') }}</p>
                </div>
            </div>
            
            <input type="submit" value="投稿"/>
        </form>
        
        <div class="back">[<a href="/">back</a>]</div>
    </body>
</html>