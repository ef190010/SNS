@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 mb-3">
            <h2>投稿の詳細と返信</h2>
            <a href="/">タイムラインに戻る</a>
            <p><a href="/users/{{ Auth::user()->id }}">{{ Auth::user()->name }}</a> でログイン中</p>

            <h3>投稿の詳細</h3>
            <div class="card">
                <div class="card-header p-3 w-100 d-flex">
                    <img src="{{ $post->user->icon }}" class="rounded-circle" width="50" height="50">
                    <div class="ml-2 d-flex flex-column">
                        <p class="mb-0">{{ $post->user->nickname }}</p>
                        <a href="/users/{{ $post->user->id }}" class="text-secondary">{{ $post->user->name }}[ID:{{ $post->user->id }}]</a>
                    </div>
                    <div class="d-flex justify-content-end flex-grow-1">
                        <p class="mb-0 text-secondary">{{ $post->updated_at->format('Y-m-d H:i') }}</p>
                    </div>
                </div>                    
                    
                    <div class="card-body">
                        @if ($post->user->id === Auth::user()->id)        
                            <p>[<a href="/posts/{{ $post->id }}/edit">この投稿を編集</a>]</p>
                            <p>
                            <form action="/posts/{{ $post->id }}" id="form_{{ $post->id }}" method="post" style="display:inline" onclick="return confirm('本当に削除しますか?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">この投稿を削除</button>
                            </form>
                            </p>
                        @endif 

                            <p><a href='/posts/{{ $post->id }}'>{{ $post->body }}</a></p>
                            @if(!is_null($post->image_path))
                                <img src="{{ $post->image_path }}" class="img-fluid">
                            @endif
                    </div>
                        <div class="card-body">
                            <p>タグ：
                            @forelse($post->tags as $tag)   
                                {{ $tag->name }}
                            @empty
                                タグはありません。
                            @endforelse
                            </p>
                            <p>場所：{{ $post->prefName }}</p>
                            <p>カテゴリー：{{ $post->categoryName }}</p>
                            
                            <!-- ここから地図情報 -->
	                            <div id="map" class="img-fluid"></div>
	                            <span id="js-getLat" data-name="{{ $post->lat }}"></span>
	                            <span id="js-getLng" data-name="{{ $post->lng }}"></span>
                            <!-- ここまで -->
                        </div>

                        <div class="card-footer py-1 d-flex justify-content-end bg-white">
                            <!-- ここからいいね機能 -->
                            @if ($post->favoritePosts()->where('user_id', Auth::user()->id)->where('post_id', $post->id)->exists())
                                <form method="POST" action="/posts/{{ $post->id }}/unfavorite" class="mb-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">いいね取消</button>
                                </form>
                            @else
                                <form method="POST" action="/posts/{{ $post->id }}/favorite" class="mb-0">
                                    @csrf
                                    <button type="submit">いいね</button>
                                </form>
                            @endif
                            <!-- ここまで -->                            
                                              
                            <div class="mr-3 d-flex align-items-center">
                                <p class="mb-0 text-secondary">コメント：{{ $post->replies()->count() }}</p>
                            </div>
                            <div class="d-flex align-items-center">
                                <a href="#"><i class="far fa-comment fa-fw"></i></a>
                                <p class="mb-0 text-secondary">いいね：{{ $post->favoritePosts()->count() }}</p>
                            </div>
                        </div>
    	    </div>
    	</div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8 mb-3">            
            <h3>この投稿に返信</h3>
            <input type="button" value="作成画面を表示" onclick="clickBtn1()" class="btn btn-info"/>
            <div id="create_reply" class="card">
                <form action="/replies" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input name="reply[post_id]" type="hidden" value={{ $post->id }}>
                    <div class="body">
                    <textarea class="form-control" name="reply[body]" placeholder="本文を入力してください。" value="{{ old('reply.body') }}" ></textarea>
                        <p class="body_error" style="color:red">{{ $errors->first('reply.body') }}</p>
                    </div>
                
                    <div class="mb-3">
                        <label for="formFile" class="form-label">画像ファイル：</label>
                        <input class=form-control id="formFile" type="file" name="file">
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
            <h3>返信一覧</h3>
            @forelse($replies as $reply)
                <div class="card">
                    <div class="card-header p-3 w-100 d-flex">
                        <img src="{{ $reply->user->icon }}" class="rounded-circle" width="50" height="50">
                        <div class="ml-2 d-flex flex-column flex-grow-1">
                            <p class="mb-0">{{ $reply->user->nickname }}</p>
                            <a href="/users/{{ $reply->user->id }}" class="text-secondary">{{ $reply->user->name }}[ID:{{ $reply->user->id }}]</a>
                        </div>
                        <div class="d-flex justify-content-end flex-grow-1">
                            <p class="mb-0 text-secondary">{{ $reply->updated_at->format('Y-m-d H:i') }}</p>
                        </div>
                    </div>
                        
                    <div class="card-body">
                        <p><a href="/replies/{{ $reply->id }}">{{ $reply->body }}</a></p>
                        @if(!is_null($reply->image_path))
                            <img src="{{ $reply->image_path }}" class="img-fluid">
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
            @empty
                    <p class="mb-0 text-secondary">コメントはまだありません。</p>
            @endforelse
    	</div>
    </div>
</div>

<script src="{{ asset('/js/map.js') }}" defer></script>

<script src="https://maps.googleapis.com/maps/api/js?language=ja&region=JP&key={{ config('services.googlemap.apikey') }}&callback=showMap" defer>
</script>

<script src="{{ asset('/js/showform.js') }}" defer></script>

@endsection