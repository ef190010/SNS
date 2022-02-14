@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 mb-3">
        <h3>ユーザー情報</h3>
            <div class="back"><a href="/">タイムラインに戻る</a></div>
            <div class="login_user"><p><a href="">{{ Auth::user()->name }}</a> でログイン中</p></div>
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
                    <div>
                        @if ($user->id === Auth::user()->id)
                            <p class='edit'>
                                [<a href="/users/{{ $user->id }}/edit">ユーザー情報編集</a>]
                            </p>
                            <p class='create'>
                                [<a href="/posts/create">投稿を作成</a>]
                            </p>
                        @endif
                    </div>
                    <div>
                        <div>
                        @if ($user->id !== Auth::user()->id)
                            @if (Auth::user()->isFollowed($user->id))
                                <div class="px-2">
                                    <span class="px-1 bg-secondary text-light">フォローされています</span>
                                </div>
                            @endif
                        </div>   
                        <div>
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
                        </div>
                        @endif
                    </div>        
                    <p>マイプレイス：{{ $user->prefName }}</p>
                    <p>マイカテゴリー：{{ $user->categoryName }}</p>
                    </div>
                </div>
            </div>        
        </div>
            
        <!-- 自分の投稿一覧 -->
        <div>
        <h4>自分の投稿一覧</h4>
            @forelse ($myposts as $post)
                <div class="col-md-8 mb-3">
                    <div class="card">
                        <div class="card-haeder p-3 w-100 d-flex">
                            <img src="{{ $user->icon }}" class="rounded-circle" width="50" height="50">
                            <div class="ml-2 d-flex flex-column flex-grow-1">
                                <p class="mb-0">{{ $post->user->nickname }}</p>
                                <a href="/users/{{ $post->user->id }}" class="text-secondary">{{ $post->user->_name }}[ID:{{ $post->user->id }}]</a>
                            </div>
                            <div class="d-flex justify-content-end flex-grow-1">
                                <p class="mb-0 text-secondary">{{ $post->created_at->format('Y-m-d H:i') }}</p>
                            </div>
                        </div>                
                        <div class="card-body">
                            <a href='/posts/{{ $post->id }}'>{{ $post->body }}</a><br>
                            <img src="{{ $post->image_path }}">
                        </div>
                        <div class="card-footer py-1 d-flex justify-content-end bg-white">                        
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
            @empty
             <p>まだ投稿はありません。</p>
            @endforelse
        </div>
    </div>    
</div>            
</div>
@endsection