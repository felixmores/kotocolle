@extends('layouts.base')

@section('title', 'ユーザー情報')

@section('content')
  <div class="container">
    <div class="card border border-primary mt-5">
      <div class="card-header p-4 h3 text-center text-light bg-primary">ユーザー情報</div>
      <div class="card-body mx-auto">
        <figure class="figure row mb-4">
          <img src="/storage/user_images/{{ $image_name }}" class="img-thumbnail rounded mx-auto w-25 h-25">
        </figure>
        <div class="row h5 mb-4">
          <div class="col-sm-6">ユーザー名</div>
          <div class="col-sm-6">{{ $name }}</div>
        </div>
        <div class="row h5 mb-4">
          <div class="col-sm-6">メールアドレス</div>
          <div class="col-sm-6">{{ $email }}</div>
        </div>
        <div class="btn-toolbar">
          <div class="btn-group">
            <form action="{{ action('UserController@userinfo_edit') }}" method="GET">
              <button type="submit" class="btn btn-primary mx-3">編集する</button>
            </form>
            <form action="{{ action('UserController@password_edit') }}" method="GET">
              <button type="submit" class="btn btn-success mx-3">パスワード変更</button>
            </form>
            <form action="" method="POST">
              {{ csrf_field() }}
              <button type="submit" class="btn btn-danger mx-3">退会する</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection