@extends('layouts.base')

@section('title', 'ユーザー情報の編集')

@section('content')
  <div class="container">
    <div class="card border border-primary mt-5 w-75 mx-auto">
      <div class="card-header p-4 h3 text-center text-light bg-primary">ユーザー情報を編集する</div>
      <div class="card-body w-75 mx-auto">
        <div class="card-text alert alert-danger" role="alert">
          エラーメッセージ
        </div>
        <form action="" method="POST" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="form-group">
            <label for="name" class="col-form-label">ユーザー名</label>
            <input name="name" type="text" class="form-control" id="name" value="{{ $name }}" required autofocus>
          </div>
          <div class="form-group">
            <label for="email" class="col-form-label">メールアドレス</label>
            <input name="email" type="email" class="form-control" id="email" value="{{ $email }}" required>
          </div>
          <div class="form-group">
            <div class="input-group">
              <label class="input-group-btn">
                <span class="btn btn-primary">
                  画像を選択
                  <input name="user_image" type="file" class="form-control-file" id="user_image" style="display:none">
                </span>
              </label>
              <input type="text" class="form-control" readonly="" aria-describedby="user_image_help">
            </div>
            <small id ="user_image_help" class="form-text text-muted"><p>※画像を選択しない場合、以前の画像はそのままとなります。</p></small>
          </div>
          <div class="form-group">
            <div class="mx-auto text-center">
              <button type="submit" class="btn btn-primary btn-lg px-5">更新</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection