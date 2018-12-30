@extends('layouts.base')

@section('title', 'パスワード発行メール送信')

@section('content')
    <<div class="container">
        {{-- カード本体 --}}
        <div class="card mt-4">
            <div class="card-header p-4 h3 text-center text-light bg-primary mb-0">パスワードを忘れた場合</div>
            
            <div class="card-body border border-top-0 border-primary">
                <p class="card-text text-center">ご登録いただいたメールアドレスを入力してください。</p>
                <p class="card-text text-center">パスワード発行ページのURLを記載したメールを送信します。</p>
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                {{-- 送信フォーム --}}
                <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                    {{ csrf_field() }}

                    {{-- メールアドレス --}}
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="control-label">メールアドレス</label>
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>

                    {{-- 送信ボタン --}}
                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-lg">
                            送信
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
