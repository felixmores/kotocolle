@extends('layouts.base')

@section('title', 'マイページ')

@section('content')
  <div class="container">
    <div class="card border border-primary mt-5">
      <div class="card-header p-4 h3 text-center text-light bg-primary">マイワード</div>
      <div class="card-body">
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
              <td><a href="{{ action('WordController@word_content_index', ['user_id' => $my_word->user_id, 'word_id' => $my_word->id]) }}">{{$my_word->word}}</a></td>
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

    <form action="{{ action('WordController@add_word_index') }}" method="GET">
      <div class="form-group">
        <button type="submit" class="btn btn-primary btn-lg my-4 mx-auto d-block">新しい言葉を登録</button>
      </div>
    </form>
    
    {{ $my_words->links() }}
  </div>
@endsection