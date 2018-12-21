@extends('layouts.base')

@section('title', '言葉一覧')

@section('content')
  <div class="container">
    <div class="card border border-danger mt-5">
      <div class="card-header p-4 h3 text-center text-light bg-danger">言葉一覧</div>
      <div class="card-body">
        <table class="table table-bordered">
          <thead class="thead-light">
            <tr>
              <th scope="col">言葉ID</th>
              <th scope="col">言葉</th>
              <th scope="col">ランク</th>
              <th scope="col">公開状態</th>
            </tr>
          </thead>
          <tbody>
          @foreach ($words_list as $wordinfo)
            <tr>
              <td>{{ $wordinfo->id }}</td>
              <td>{{ $wordinfo->word }}</td>
              <td>{{ $wordinfo->lank }}</td>
              @if ($wordinfo->share_flag == 1)
              <td>公開中</td>
              @else
              <td>非公開</td>
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