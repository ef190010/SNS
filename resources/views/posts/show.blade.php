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
            <div class="back"><a href="/">戻る</a></div>

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
                    <p>場所：{{ $post->prefName }}</p>
                </div>
                <div class="categories">
                    <h4>カテゴリー</h4>
                    <p>{{ $post->categoryName }}</p>
                </div>
            </div>
            
            <div class="create_reply">
            <h3>返信の作成</h3>
            <input type="button" value="作成" onclick="clickBtn1()" />

                <div id="create_reply_content">
                <script>
                    document.getElementById("create_reply_content").style.display = "none";
                    
                    function clickBtn1(){
                    	const p1 = document.getElementById("create_reply_content");
                
	                    if(p1.style.display=="block"){
		                    p1.style.display ="none";
	                    }else{
		                    p1.style.display ="block";
	                    }
                    }
                </script>            
            
                <form action="/replies" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input name="reply[post_id]" type="hidden" value={{ $post->id }}>
                    <div class="body">
                        <h4>本文</h4>
                        <textarea name="reply[body]" placeholder="文章を入力してください。" value="{{ old('reply.body') }}" ></textarea>
                        <p class="body_error" style="color:red">{{ $errors->first('reply.body') }}</p>
                    </div>
                
                    <div class='image'>
                        <h4>画像</h4>
                        <label for="photo">画像ファイル:</label>
                        <input type="file" name="file">
                        <p class="image_error" style="color:red">{{ $errors->first('file') }}</p>
                    </div>
            
                    <input type="submit" value="投稿"/>
                </form>
                </div>
                
            <div class="show_reply">
                <h3>返信一覧</h3>
                @foreach($replies as $reply)
                    <div class="user_id">
                        <h4>ユーザーID</h4>
                        <a href="">{{ $reply->user->id }}</a> 
                    </div>
                    <div class="user_name">
                        <h4>ユーザー名</h4>
                        <a href="">{{ $reply->user->name }}</a> 

                    <div class="body">
                        <p>{{ $reply->body }}</p>
                    </div>
                    <div class="image">
                        <img src="{{ $reply->image_path }}">
                    </div>
                @endforeach
            </div>
                
            </div>
            
            
        </div>
    </body>
</html>