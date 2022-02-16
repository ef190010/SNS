@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 mb-3">
            <h2>返信とコメント</h2>
            @if (!is_null($reply->reply_id))
                <a href="/replies/{{ $reply->reply_id }}">返信元に戻る</a>
            @else
                <a href='/posts/{{ $reply->post_id }}'>返信元に戻る</a>
            @endif
            <p><a href="/users/{{ Auth::user()->id }}">{{ Auth::user()->name }}</a> でログイン中</p>

            <h3>返信の詳細</h3>
            <div class="card">
                <div class="card-header p-3 w-100 d-flex">
                    <img src="{{ $reply->user->icon }}" class="rounded-circle" width="50" height="50">
                    <div class="ml-2 d-flex flex-column">
                        <p class="mb-0">{{ $reply->user->nickname }}</p>
                        <a href="/users/{{ $reply->user->id }}" class="text-secondary">{{ $reply->user->name }}[ID:{{ $reply->user->id }}]</a>
                    </div>
                    <div class="d-flex justify-content-end flex-grow-1">
                        <p class="mb-0 text-secondary">{{ $reply->created_at->format('Y-m-d H:i') }}</p>
                    </div>
                </div>                    

                <div class="card-body">
                    @if ($reply->user->id === Auth::user()->id)        
                        <p>[<a href="/replies/{{ $reply->id }}/edit">この返信を編集</a>]</p>
                        <form action="/replies/{{ $reply->id }}" id="form_{{ $reply->id }}" method="POST" style="display:inline" onclick="return confirm('本当に削除しますか?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit">この返信を削除</button> 
                        </form>
                    @endif

                    <p><a href='/posts/{{ $reply->id }}'>{{ $reply->body }}</a></p>
                    @if(!is_null($reply->image_path))
                        <img src="{{ $reply->image_path }}">
                    @endif            
                </div>

                <div class="card-footer py-1 d-flex justify-content-end bg-white">
                    <!-- ここからいいね機能 -->
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
                    <!-- ここまで -->                
                    
                    <div class="mr-3 d-flex align-items-center">
                        <p class="mb-0 text-secondary">コメント：{{ $reply->replies()->count() }}</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <a href="#"><i class="far fa-comment fa-fw"></i></a>
                        <p class="mb-0 text-secondary">いいね：{{ $reply->favoriteReplies()->count() }}</p>
                    </div>
                </div>
    	    </div>
    	</div>
    </div>
            
    <div class="row justify-content-center">
        <div class="col-md-8 mb-3">
            <h3>この返信にコメント</h3>
            <input type="button" value="作成画面を表示" onclick="clickBtn2()" />
            <div id="create_reply">
                <form action="/replies" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input name="reply[reply_id]" type="hidden" value={{ $reply->id }}>
                    <div class="body">
                        <textarea class="form-control" name="reply[body]" placeholder="本文を入力してください。" value="{{ old('reply.body') }}" ></textarea>
                        <p class="body_error" style="color:red">{{ $errors->first('reply.body') }}</p>
                    </div>
                
                    <div class='image'>
                        <label for="photo">画像ファイル：</label>
                        <input type="file" name="file">
                        <p class="image_error" style="color:red">{{ $errors->first('file') }}</p>
                    </div>
            
                    <button type="submit" class="btn btn-primary">
                        投稿
                    </button>
                </form>
            </div>
        </div>
    </div>
                
    <div class="row justify-content-center">
        <div class="col-md-8 mb-3">
            <ul class="list-group">    
                <h3>返信一覧</h3>
                @forelse($replies as $reply)
                    <li class="list-group-item">
                        <div class="py-3 w-100 d-flex">
                            <img src="{{ $reply->user->icon }}" class="rounded-circle" width="50" height="50">
                            <div class="ml-2 d-flex flex-column">
                                <p class="mb-0">{{ $reply->user->nickname }}</p>
                                <a href="/users/{{ $reply->user->id }}" class="text-secondary">{{ $reply->user->name }}[ID:{{ $reply->user->id }}]</a>
                            </div>
                            <div class="d-flex justify-content-end flex-grow-1">
                                <p class="mb-0 text-secondary">{{ $reply->created_at->format('Y-m-d H:i') }}</p>
                            </div>
                        </div>
                        
                        <div class="py-3">
                            <p><a href="/replies/{{ $reply->id }}">{{ $reply->body }}</a></p>
                            @if(!is_null($reply->image_path))
                                <img src="{{ $reply->image_path }}">
                            @endif
                        </div>
                    
                        <div class="card-footer py-1 d-flex justify-content-end bg-white">
                            <!-- ここからいいね機能 -->
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
                            <!-- ここまで -->                
                            
                            <div class="mr-3 d-flex align-items-center">
                                <p class="mb-0 text-secondary">コメント：{{ $reply->replies()->count() }}</p>
                            </div>
                            <div class="d-flex align-items-center">
                                <a href="#"><i class="far fa-comment fa-fw"></i></a>
                                <p class="mb-0 text-secondary">いいね：{{ $reply->favoriteReplies()->count() }}</p>
                            </div>
                        </div>
                    </li>
                @empty
                    <li class="list-group-item">
                        <p class="mb-0 text-secondary">コメントはまだありません。</p>
                    </li>
                @endforelse
            </ul>
        </div>
    </div>
</div>    
                    <script>
                        document.getElementById("create_reply").style.display = "none";
                
                        function clickBtn2(){
            	            const p2 = document.getElementById("create_reply");
                
	                        if(p2.style.display=="block"){
	                            p2.style.display ="none";
                            }else{
                                p2.style.display ="block";
                            }
                        }
                    </script>            
@endsection