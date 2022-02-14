@extends('layouts.app')

@section('content')

<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Post</title>
    </head>
    <body>
        <h1>SNS Name</h1>        
        <h2>投稿の詳細と返信</h2>

        <div class="content">
            <div class="back"><a href="/">タイムラインに戻る</a></div>

            <h4>投稿の詳細</h4>
            <p class="edit">[<a href="/posts/{{ $post->id }}/edit">この投稿を編集</a>]</p>
            <form action="/posts/{{ $post->id }}" id="form_{{ $post->id }}" method="post" style="display:inline" onclick="return confirm('本当に削除しますか?')">
                @csrf
                @method('DELETE')
                <button type="submit">この投稿を削除</button>
            </form>
            
            <div class="content_post">
                    <div class="user">
                        <img src="{{ $post->user->icon }}">
                        <h5>{{ $post->user->nickname }}</h5>
                        <a href="/users/{{ $post->user->id }}">{{ $post->user->name }}[ID:{{ $post->user->id }}]</a> 
                    </div>
                <div class="body">
                    <p>{{ $post->body }}</p>
                </div>
                
                <div class="tags">
                    <h4>タグ</h4>
                    @forelse($post->tags as $tag)   
                        {{ $tag->name }}
                    @empty
                        <p>タグはありません。</p>
                    @endforelse
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
                
                <!-- ここから地図情報 -->
	            <div id="map"></div>
                <!-- ここまで -->
                
                <!-- ここからいいね機能 -->
                <div>
                    @if ($post->favoritePosts()->where('user_id', Auth::user()->id)->where('post_id', $post->id)->exists())
                        <form method="POST" action="/posts/{{ $post->id }}/unfavorite" class="mb-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit">いいね取消</button>
                        </form>
                    @else
                        <form method="POST" action="/posts/{{ $post->id }}/favorite" class="mb-0">
                            @csrf
                            <button type="submit">いいね</button>
                        </form>
                    @endif
                    <div class="row justify-content-center">
                        <p>いいね数：{{ $post->favoritePosts()->count() }}</p>
                    </div>
                </div>
                <!-- ここまで -->                
                
            </div>
            
            <div class="postreply">
                <h3>この投稿に返信</h3>
                <input type="button" value="作成画面を表示" onclick="clickBtn1()" />

                <div id="create_postreply">
                    <script>
                        document.getElementById("create_postreply").style.display = "none";
                    
                        function clickBtn1(){
                        	const p1 = document.getElementById("create_postreply");
                    
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
            </div>    
                
            <div class="show_replies">
                <h3>返信一覧</h3>
                @forelse($replies as $reply)
                    <div class="user">
                        <img src="{{ $reply->user->icon }}">
                        <h5>{{ $reply->user->nickname }}</h5>
                        <a href="/users/{{ $reply->user->id }}">{{ $reply->user->name }}[ID:{{ $reply->user->id }}]</a> 
                    </div>

                    <div class="body">
                        <a href="/replies/{{ $reply->id }}">{{ $reply->body }}</a>
                    </div>
                    <div class="image">
                        <img src="{{ $reply->image_path }}">
                    </div>
                    
                    <!-- ここからいいね機能 -->
                <div>
                    @if ($reply->favoriteReplies()->where('user_id', Auth::user()->id)->where('reply_id', $reply->id)->exists())
                        <form method="POST" action="/replies/{{ $reply->id }}/unfavorite" class="mb-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit">いいね取消</button>
                        </form>
                    @else
                        <form method="POST" action="/replies/{{ $reply->id }}/favorite" class="mb-0">
                            @csrf
                            <button type="submit">いいね</button>
                        </form>
                    @endif
                    <div class="row justify-content-center">
                        <p>いいね数：{{ $reply->favoriteReplies()->count() }}</p>
                    </div>
                </div>
                    <!-- ここまで -->                
                    
                @empty
                    返信はありません
                @endforelse
            </div>
        </div>
    	<script src="https://maps.googleapis.com/maps/api/js?language=ja&region=JP&key={{ config('services.googlemap.apikey') }}&callback=initMap" defer>
    	</script>
    </body>
</html>
@endsection