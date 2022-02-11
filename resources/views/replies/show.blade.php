@extends('layouts.app')

@section('content')

<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Reply</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="/css/app.css">
    </head>
    <body>
        <h1>SNS Name</h1>        
        <div class="content">
            <div class="back">
                @if (!is_null($reply->reply_id))
                    <a href="/replies/{{ $reply->reply_id }}">戻る</a>
                @else
                    <a href='/posts/{{ $reply->post_id }}'>戻る</a>
                @endif
            </div>

            <p class="edit">[<a href="/replies/{{ $reply->id }}/edit">編集</a>]</p>
            <!-- ※上の行は仮配置 -->

            <form action="/replies/{{ $reply->id }}" id="form_{{ $reply->id }}" method="POST" style="display:inline" onclick="return confirm('本当に削除しますか?')">
                @csrf
                @method('DELETE')
                <button type="submit">削除</button> 
            </form>
            
            <div class="content_post">
                <h3>返信の詳細</h3>
                <div class="user_id">
                    <h4>ユーザーID</h4>
                    <a href="">{{ $reply->user->id }}</a> 
                </div>
                <div class="user_name">
                    <h4>ユーザー名</h4>
                    <a href="">{{ $reply->user->name }}</a> 
                </div>
                <div class="body">
                    <p>{{ $reply->body }}</p>
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
                
            </div>
            
            <div class="replyreply">
                <input type="button" value="このコメントに返信" onclick="clickBtn2()" />

                <div id="create_replyreply">
                    <script>
                        document.getElementById("create_replyreply").style.display = "none";
                
                        function clickBtn2(){
            	            const p2 = document.getElementById("create_replyreply");
                
	                        if(p2.style.display=="block"){
	                            p2.style.display ="none";
                            }else{
                                p2.style.display ="block";
                            }
                        }
                    </script>            
            
                    <form action="/replies" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input name="reply[reply_id]" type="hidden" value={{ $reply->id }}>
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
                    <div class="user_id">
                        <h4>ユーザーID</h4>
                        <a href="">{{ $reply->user->id }}</a> 
                    </div>
                    <div class="user_name">
                        <h4>ユーザー名</h4>
                        <a href="">{{ $reply->user->name }}</a> 
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
    </body>
</html>
@endsection