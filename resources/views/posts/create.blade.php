@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2>投稿の作成</h2>
            <a href="/">タイムラインに戻る</a>
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
                    <form action="/posts" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                                <!-- 本文 -->
                                <textarea class="form-control" name="post[body]" placeholder="投稿の本文を入力してください。">{{ old('post.body') }}</textarea>
                                <p class="col-md-12 text-right text-danger">200文字以内</p>
                                <p class="body_error" style="color:red">{{ $errors->first('post.body') }}</p>

                                <p>タグ
                                    <input type="text" class="form-control" name="tags" placeholder="（任意）" value="{{ old('tags') }}" />
                                    <p class="tag_error" style="color:red">{{ $errors->first('tags') }}</p>
                                </p>
                                <p>※各タグの先頭には#をつけてください。（例：#富士山 #ご来光）</p>

                                <p>ジャンル
                                    <select class="form-control" name="post[categories]">
                                    @foreach($categories as $key => $name)
                                        <option value="{{ $key }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                                </p>

                                <p>都道府県
                                    <select class="form-control" name="post[prefs]">
                                    @foreach($prefs as $key => $name)
                                        <option value="{{ $key }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                                </p>

                                <div class="mb-3">
                                    <label for="formFile" class="form-label">画像ファイル：</label>
                                    <input class=form-control id="formFile" type="file" name="file">
                                    <p class="image_error" style="color:red">{{ $errors->first('file') }}</p>
                                </div>

                                <!-- ここから地図情報 -->
                                <p>位置情報（クリックでピンが刺せます）
                                    <div id="map" class="img-fluid"></div>
                                    <input type="hidden" name="post[lat]" id="lat">
                                    <input type="hidden" name="post[lng]" id="lng">
                                    <input type="button" class="btn btn-danger" value="ピンを削除" onclick="deleteMarker()">
                                </p>
                                <!-- ここまで -->
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-12 text-right">
                                <button type="submit" class="btn btn-primary">
                                    投稿
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 地図読み込み -->
<script src="{{ asset('/js/map.js') }}" defer></script>
<script src="https://maps.googleapis.com/maps/api/js?language=ja&region=JP&key={{ config('services.googlemap.apikey') }}&callback=initMap" defer>
</script>

@endsection