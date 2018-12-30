@extends('layouts.base')

@section('title', 'マイページ')

@section('content')
  <div class="container">
    {{-- カード本体 --}}
    <div class="card mt-5">
      <div class="card-header p-4 h3 text-center text-light bg-primary mb-0">マイワード</div>
      <div class="card-body border border-top-0 border-primary">

        {{-- テーブル本体 --}}
        <table class="table table-bordered">
          <thead class="thead-light">
            <tr>
              <th scope="col">言葉</th>
              <th scope="col">ランク</th>
            </tr>
          </thead>
          <tbody>
          @foreach ($my_words as $my_word)
            <tr>
              {{-- 言葉 --}}
              <td><a href="{{ action('WordController@word_content_index', ['user_id' => $my_word->user_id, 'word_id' => $my_word->id]) }}">{{$my_word->word}}</a></td>

              {{-- ランク --}}
              @switch($my_word->lank)
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

    {{-- 言葉登録画面へのボタン --}}
    <form action="{{ action('WordController@add_word_index') }}" method="GET">
      <div class="form-group">
        <button type="submit" class="btn btn-primary btn-lg my-4 mx-auto d-block">新しい言葉を登録</button>
      </div>
    </form>
    
    <div class="pb-2">{{ $my_words->links() }}</div>
  </div>
@endsection