@extends('layouts.base')

@section('title', '登録ユーザー一覧')

@section('content')
  <div class="container">
    {{-- カード本体 --}}
    <div class="card border border-danger mt-5">
      <div class="card-header p-4 h3 text-center text-light bg-danger">登録ユーザー一覧</div>
      <div class="card-body">

        {{-- テーブル本体 --}}
        <table class="table table-bordered">
          <thead class="thead-light">
            <tr>
              <th scope="col">ユーザーID</th>
              <th scope="col">ユーザー名</th>
              <th scope="col">メールアドレス</th>
              <th scope="col">退会日時</th>
              <th scope="col">退会</th>
            </tr>
          </thead>
          <tbody>
          @foreach ($users_list as $userinfo)
            <tr>
              {{-- ユーザーID --}}
              <td>{{ $userinfo->id }}</td>

              {{-- ユーザー名 --}}
              <td><a href="{{ action('WordController@words_list', ['user_id' => $userinfo->id]) }}">{{ $userinfo->name }}</a></td>
              
              {{-- メールアドレス --}}
              <td>{{ $userinfo->email }}</td>

              {{-- 退会日時 --}}
              @if ($userinfo->deleted_at)
              <td>{{ $userinfo->deleted_at }}</td>
              @else
              <td>利用中</td>
              @endif

              {{-- 退会ボタン --}}
              @if (!($userinfo->deleted_at))
              <form action="{{ action('UserController@users_list_delete') }}" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="user_id" value="{{ $userinfo->id }}">
                <td><button type="submit" class="btn btn-danger btn-sm">退会</button></td>
              </form>
              @else
              <td>退会済</td>
              @endif
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
    </div>  
    {{ $users_list->links() }}
  </div>
@endsection