@extends('layouts.base')

@section('title', 'ユーザー情報')

@section('content')
  <div class="container">
    {{-- カード本体 --}}
    <div class="card mt-5">
      <div class="card-header p-4 h3 text-center text-light bg-primary mb-0">ユーザー情報</div>
      <div class="card-body border border-top-0 border-primary">

        {{-- ユーザー画像 --}}
        <figure class="figure row mb-4">
          @if ($image_name !== 'no_user_image.gif')
          <img src="/storage/user_images/{{ $image_name }}" class="img-thumbnail rounded mx-auto w-25 h-25">
          @else
          <img src="/images/{{ $image_name }}" class="img-thumbnail rounded mx-auto w-25 h-25">
          @endif
        </figure>

        {{-- ユーザー名 --}}
        <div class="row h5 mb-4 text-center">
          <div class="col-sm-4">ユーザー名</div>
          <div class="col-sm-8">{{ $name }}</div>
        </div>

        {{-- メールアドレス --}}
        <div class="row h5 mb-4 text-center">
          <div class="col-sm-4">メールアドレス</div>
          <div class="col-sm-8">{{ $email }}</div>
        </div>

        {{-- ボタングループ --}}
        <div class="btn-group row d-flex justify-content-center">
          <form action="{{ action('UserController@userinfo_edit') }}" method="GET">
            <button type="submit" class="btn btn-primary mx-3">編集する</button>
          </form>
          <form action="{{ action('UserController@password_edit') }}" method="GET">
            <button type="submit" class="btn btn-success mx-3">パスワード変更</button>
          </form>
          <form action="{{ action('UserController@userinfo_delete') }}" method="POST">
            {{ csrf_field() }}
            <button type="submit" class="btn btn-danger mx-3">退会する</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection