@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 mb-3">
            <h2>ユーザー情報</h2>
            <a href="/">タイムラインに戻る</a>
            <p><a href="/users/{{ Auth::user()->id }}">{{ Auth::user()->name }}</a> でログイン中</p>
            <div class="card">
                <div class="d-inline-flex">            
                    <div class="p-3 d-flex flex-column">
                        <img src="{{ $user->icon }}" class="rounded-circle" width="100" height="100">
                        <div class="mt-3 d-flex flex-column">
                            <h4 class="mb-0 font-weight-bold">{{ $user->nickname }}</h4>
                            <span class="text-secondary">{{ $user->name }}[ID:{{ $user->id }}]</span>
                        </div>
                    </div>

                    <div class="p-3 d-flex flex-column justify-content-between">        
                        <div class="d-flex">
                            <div>
                                @if ($user->id === Auth::user()->id)
                                    <p>[<a href="/users/{{ $user->id }}/edit">ユーザー情報編集</a>]</p>
                                    <form action="/users/{{ $user->id }}" id="form_{{ $user->id }}" method="post" style="display:inline" onclick="return confirm('この操作は戻せません。本当に削除しますか？')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit">ユーザーを削除</button>
                                    </form>
                                
                                @else
                                    @if (Auth::user()->isFollowed($user->id))
                                        <div class="px-2">
                                                <span class="px-1 bg-secondary text-light">フォローされています</span>
                                            </div>
                                    @endif
    
                                    @if (Auth::user()->isFollowing($user->id))
                                        <form action="/users/{{ $user->id }}/unfollow" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">フォロー解除</button>
                                        </form>
                                    @else   
                                        <form action="/users/{{ $user->id }}/follow" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-primary">フォローする</button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </div>
                    <h4>プロフィール</h4>
                    <p>{{ $user->profile }}</p>
                    <p>マイプレイス：{{ $user->prefName }}</p>
                    <p>マイカテゴリー：{{ $user->categoryName }}</p>
                    </div>
                    
                </div>
            </div>        

        <!-- 自分の投稿一覧 -->
            <h4>ユーザー投稿一覧</h4>
            @forelse ($myposts as $post)
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
                <p>まだ投稿はありません。</p>
            @endforelse
            
            <div class="my-4 d-flex justify-content-center">
                {{ $myposts->links() }}
            </div>
            
        </div>
    </div>
</div>    
@endsection