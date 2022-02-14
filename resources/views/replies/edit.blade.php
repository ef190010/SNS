@extends('layouts.app')

@section('content')

<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Edit Reply</title>
    </head>
    <body>
        <h1 class="title">SNS Name</h1>
        <h2>返信の編集</h2>
        
        <div class="content">
            <div class="back"><a href="/replies/{{ $reply->id }}">戻る</a></div>
            
            <form action="/replies/{{ $reply->id }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="body">
                    <h4>本文</h4>
                    <textarea name="reply[body]">{{ $reply->body }}</textarea>
                    <p class="body_error" style="color:red">{{ $errors->first('reply.body') }}</p>
                </div>
            
            <div class='image'>
                <h4>画像</h4>
                <p>元の画像</p>
                <img src="{{ $reply->image_path }}">
                @if (is_null($reply->image_path))
                    <p>画像はありません。</p>
                @endif
                <label for="photo">画像ファイル:</label>
                <input type="file" name="file">
                <p class="image_error" style="color:red">{{ $errors->first('file') }}</p>

            </div>
            
                <input type="submit" value="編集を確定">
            </form>
        </div>
    </body>
</html>
@endsection