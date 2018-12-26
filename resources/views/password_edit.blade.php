@extends('layouts.base')

@section('title', 'パスワードの変更')

@section('content')
  <div class="container">
    {{-- カード本体 --}}
    <div class="card mt-5">
      <div class="card-header p-4 h3 text-center text-light bg-primary mb-0">パスワードを変更する</div>
      <div class="card-body border border-top-0 border-primary">
        {{-- エラーメッセージ --}}
        @if (count($errors) > 0)
        <div class="card-text alert alert-danger" role="alert">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif

        {{-- 送信フォーム --}}
        <form action="{{ action('UserController@password_update') }}" method="POST">
          {{ csrf_field() }}

          {{-- 現在のパスワード --}}
          <div class="form-group">
            <label for="password" class="col-form-label">現在のパスワード</label>
            <input name="password" type="password" class="form-control" id="password" value="{{ old('password') }}" required>
          </div>

          {{-- 新しいパスワード --}}
          <div class="form-group">
            <label for="new_password" class="col-form-label">新しいパスワード</label>
            <input name="new_password" type="password" class="form-control" id="new_password" value="{{ old('new_password') }}" required>
          </div>

          {{-- 新しいパスワードの確認 --}}
          <div class="form-group">
            <label for="confirm_password" class="col-form-label">新しいパスワードの確認</label>
            <input name="new_password_confirmation" type="password" class="form-control" id="confirm_password" value="" required>
          </div>

          {{-- 更新ボタン --}}
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