@extends('layouts.base')

@section('title', 'みんなの言葉')

@section('content')
  <div class="container">
    <div class="card border border-primary mt-5">
      <div class="card-header p-4 h3 text-center text-light bg-primary">みんなの言葉</div>
      <div class="card-body">
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
              <td><a href="{{ action('WordController@word_content_index', ['user_id' => $share_word->user_id, 'word_id' => $share_word->id]) }}">{{$share_word->word}}</a></td>
              <td>{{ $share_word->user->name }}</td>
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
    {{ $share_words->links() }}
  </div>
@endsection