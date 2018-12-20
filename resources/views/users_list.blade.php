@extends('layouts.base')

@section('title', '登録ユーザー一覧')

@section('content')
  <div class="container">
    <div class="card border border-primary mt-5">
      <div class="card-header p-4 h3 text-center text-light bg-primary">登録ユーザー一覧</div>
      <div class="card-body">
        <table class="table table-bordered">
          <thead class="thead-light">
            <tr>
              <th scope="col">ユーザーID</th>
              <th scope="col">ユーザー名</th>
              <th scope="col">メールアドレス</th>
              <th scope="col">退会日時</th>
            </tr>
          </thead>
          <tbody>
          @foreach ($users_list as $userinfo)
            <tr>
              <td>{{ $userinfo->id }}</td>
              <td><a href="{{ action('UserController@userinfo_index') }}">{{ $userinfo->name }}</a></td>
              <td>{{ $userinfo->email }}</td>
              @if ($userinfo->deleted_at)
              <td>{{ $userinfo->deleted_at }}</td>
              @else
              <td>利用中</td>
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