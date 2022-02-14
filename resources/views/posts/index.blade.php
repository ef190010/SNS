@extends('layouts.app')

@section('content')
        <h2>タイムライン</h2>
        <div class="login_user">
            <p><a href="/users/{{ Auth::user()->id }}">{{ Auth::user()->name }}</a> でログイン中</p>
        </div>

        <p class='create'>
            [<a href="/posts/create">投稿を作成</a>]
        </p>
        
        <div class='posts'>
            @foreach ($posts as $post)
                <div class='post'>
                    <div class="user">
                        <img src="{{ $post->user->icon }}">
                        <h5>{{ $post->user->nickname }}</h5>
                        <a href="/users/{{ $post->user->id }}">{{ $post->user->name }}[ID:{{ $post->user->id }}]</a> 
                    </div>
                    <div class="body">
                        <a href='/posts/{{ $post->id }}'>{{ $post->body }}</a>
                    </div>
                    <div class="image">
                        <img src="{{ $post->image_path }}">
                    </div>
                    
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
            @endforeach
        </div>
        <div class='paginate'>
            {{ $posts->links() }}
        </div>
    </body>
</html>
@endsection