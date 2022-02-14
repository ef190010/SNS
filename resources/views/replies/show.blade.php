@extends('layouts.app')

@section('content')

<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Show Reply</title>
    </head>
    <body>
        <h1>SNS Name</h1>
        <h2>返信とコメント</h2>
            <div class="back">
                @if (!is_null($reply->reply_id))
                    <a href="/replies/{{ $reply->reply_id }}">返信元に戻る</a>
                @else
                    <a href='/posts/{{ $reply->post_id }}'>返信元に戻る</a>
                @endif
            </div>

        <h4>返信の詳細</h4>
        <div class="content">

            <p class="edit">[<a href="/replies/{{ $reply->id }}/edit">返信を編集</a>]</p>
            <!-- ※上の行は仮配置 -->

            <form action="/replies/{{ $reply->id }}" id="form_{{ $reply->id }}" method="POST" style="display:inline" onclick="return confirm('本当に削除しますか?')">
                @csrf
                @method('DELETE')
                <button type="submit">この返信を削除</button> 
            </form>
            
            <div class="content_post">
                <div class="user">
                        <img src="{{ $reply->user->icon }}">
                        <h5>{{ $reply->user->nickname }}</h5>
                        <a href="/users/{{ $reply->user->id }}">{{ $reply->user->name }}[ID:{{ $reply->user->id }}]</a> 
                </div>
                <div class="body">
                    <p>{{ $reply->body }}</p>
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
                
            </div>
            
            <div class="replyreply">
                <h4>この返信にコメント</h4>
                <input type="button" value="作成画面を表示" onclick="clickBtn2()" />

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
                <h4>コメント一覧</h4>
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
                    コメントはありません
                @endforelse
            </div>
        </div>
    </body>
</html>
@endsection