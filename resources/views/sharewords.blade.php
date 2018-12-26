@extends('layouts.base')

@section('title', 'みんなの言葉')

@section('content')
  <div class="container">
    {{-- カード本体 --}}
    <div class="card mt-5">
      <div class="card-header p-4 h3 text-center text-light bg-primary mb-0">みんなの言葉</div>
      <div class="card-body border border-top-0 border-primary">

        {{-- テーブル本体 --}}
        <table class="table table-bordered">
          <thead class="thead-light">
            <tr>
              <th scope="col">言葉</th>
              <th scope="col">ユーザー名</th>
              <th scope="col">ランク</th>
            </tr>
          </thead>
          <tbody>
          @foreach ($share_words as $share_word)
            <tr>
              {{-- 言葉 --}}
              <td><a href="{{ action('WordController@word_content_index', ['user_id' => $share_word->user_id, 'word_id' => $share_word->id]) }}">{{$share_word->word}}</a></td>
              
              {{-- ユーザー名 --}}
              <td>{{ $share_word->name }}</td>

              {{-- ランク --}}
              @switch($share_word->lank)
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
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <div class="mt-3">{{ $share_words->links() }}</div>
  </div>
@endsection