@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 mb-3">
            <h2>投稿の検索(β版)</h2>
            <h5>※現段階では1単語の本文検索しかできません</h5>
            <p><a href="/users/{{ Auth::user()->id }}">{{ Auth::user()->name }}</a> でログイン中</p>
            
            <p>
            <form class="form-inline" method="GET">
                <div class="form-group col-xs-6">
                    <input class="form-control form-control-lg size=20" type="text" name="search" value="{{request("search")}}" placeholder="単語を入力（本文の検索）" aria-label="検索...">
                </div>
                <div class="form-group">
                    <input type="submit" value="検索" class="btn btn-info">
                </div>
                <div class="form-group">
                    <button class="btn btn-secondary">
                        <a href="/posts/search" class="text-white">クリア</a>
                    </button>
                </div>
            </form>
            </p>

            <h3>検索結果</h3>
            @forelse ($posts as $post)
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
                            <p><a href='/posts/{{ $post->id }}'>{{ $post->body }}</a></p>
                            @if(!is_null($post->image_path))
                                <img src="{{ $post->image_path }}" class="img-fluid">
                            @endif
                        </div>
                        
                        <div class="card-footer py-1 d-flex justify-content-end bg-white">
                        <!-- ここからいいね機能 -->
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
            @empty
                <p>検索結果はありません。</p>
            @endforelse
        
            <div class="my-4 d-flex justify-content-center">
                {{ $posts->links() }}
            </div>

        </div>
    </div>
</div>
@endsection