@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2>返信の編集</h2>
            <a href="/replies/{{ $reply->id }}">返信詳細に戻る</a>
            <div class="card">
                <div class="card-header">
                    <div class="form-group row mb-0">
                        <div class="col-md-12 p-3 w-100 d-flex">
                            <img src="{{ $user->icon }}" class="rounded-circle" width="50" height="50">
                            <div class="ml-2 d-flex flex-column">
                                <p class="mb-0">{{ $user->nickname }}</p>
                                <a href="/users/{{ $user->id }}" class="text-secondary">{{ $user->name }}[ID:{{ $user->id }}]</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form action="/replies/{{ $reply->id }}" method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT')
                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                                <textarea class="form-control" name="reply[body]">{{ $reply->body }}</textarea>
                                <p class="col-md-12 text-right text-danger">200文字以内</p>
                                <p class="body_error" style="color:red">{{ $errors->first('reply.body') }}</p>

                                <p>元の画像</p>
                                @if (is_null($reply->image_path))
                                    <p>画像はありません。</p>
                                @else
                                    <img src="{{ $reply->image_path }}" class="img-fluid">
                                @endif
                                
                                <p>
                                    <label for="photo">画像ファイル：</label>
                                    <input type="file" name="file">
                                    <p class="image_error" style="color:red">{{ $errors->first('file') }}</p>
                                </p>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12 text-right">
                                <button type="submit" class="btn btn-primary">
                                    編集を確定
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection