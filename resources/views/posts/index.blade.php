@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 mb-3">
            <h2>タイムライン</h2>
            <p><a href="/users/{{ Auth::user()->id }}">{{ Auth::user()->name }}</a> でログイン中</p>

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
                        <p style="white-space:pre-wrap;"><a href='/posts/{{ $post->id }}'>{{ $post->body }}</a></p>
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

                        <!-- コメント数・いいね数 -->
                        <div class="mr-3 d-flex align-items-center">
                            <p class="mb-0 text-secondary">コメント：{{ $post->replies()->count() }}</p>
                        </div>
                        <div class="d-flex align-items-center">
                            <p class="mb-0 text-secondary">いいね：{{ $post->favoritePosts()->count() }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <p>投稿はまだありません</p>
            @endforelse

            <!-- ページネーション -->
            <div class="my-4 d-flex justify-content-center">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
</div>
@endsection