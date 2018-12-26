@extends('layouts.base')

@section('title', 'パスワード変更')

@section('content')
    <div class="container">
        {{-- カード本体 --}}
        <div class="card mt-5">
            <div class="card-header h3 p-4 text-center text-light bg-primary mb-0">パスワードを変更する</div>
            
            <div class="card-body border border-top-0 border-primary mb-4">
                <p class="card-text text-center">新しいパスワードを入力してください。</p>
                <p class="card-text text-center">次回より設定したパスワードでログインできます。</p>
                
                {{-- 送信フォーム --}}
                <form class="form-horizontal" method="POST" action="{{ route('password.request') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="token" value="{{ $token }}">

                        {{-- メールアドレス --}}
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="control-label">メールアドレス</label>

                            <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" required autofocus>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                        {{-- パスワード --}}
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="control-label">パスワード</label>

                            <input id="password" type="password" class="form-control" name="password" required>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>

                        {{-- パスワード確認 --}}
                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password-confirm" class="control-label">パスワード確認</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                            @endif
                        </div>

                        {{-- 変更ボタン --}}
                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-lg">
                                変更
                            </button>
                        </div>
                </form>
            </div>
        </div>
    </div>
@endsection
