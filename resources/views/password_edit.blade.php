@extends('layouts.base')

@section('title', 'パスワードの変更')

@section('content')
  <div class="container">
    <div class="card border border-primary mt-5 w-75 mx-auto">
      <div class="card-header p-4 h3 text-center text-light bg-primary">パスワードを変更する</div>
      <div class="card-body w-75 mx-auto">
        <div class="card-text alert alert-danger" role="alert">
          エラーメッセージ
        </div>
        <form action="" method="POST">
          {{ csrf_field() }}
          <div class="form-group">
            <label for="password" class="col-form-label">現在のパスワード</label>
            <input name="password" type="password" class="form-control" id="password" value="" required>
          </div>
          <div class="form-group">
            <label for="new_password" class="col-form-label">新しいパスワード</label>
            <input name="new_password" type="password" class="form-control" id="new_password" value="" required>
          </div>
          <div class="form-group">
            <label for="confirm_password" class="col-form-label">新しいパスワードの確認</label>
            <input name="confirm_password" type="password" class="form-control" id="confirm_password" value="" required>
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