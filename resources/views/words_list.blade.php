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
              <td><a href="{{ action('WordController@word_content_index', ['user_id' => $wordinfo->user_id, 'word_id' => $wordinfo->id]) }}">{{ $wordinfo->id }}</a></td>
              <td>{{ $wordinfo->word }}</td>
              @switch($wordinfo->lank)
                @case(1)
                  <td>金言</td>
                  @break
                @case(2)
                  <td>銀言</td>
                  @break
                @case(3)
                  <td>銅言</td>
                  @break
                @default
                  <td>ランクなし</td>
              @endswitch
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
    {{ $words_list->links() }}
  </div>
@endsection