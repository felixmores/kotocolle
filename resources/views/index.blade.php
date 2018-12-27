@extends('layouts.base')

@section('title', 'ことコレ')

@section('content')

<div class="jumbotron jumbotron-fluid text-white mt-3 mb-0">
  <div class="container">
    <h1 class="display-4">ことコレ</h1>
    <h1>～ことばコレクション～</h1>
    <p class="lead">心に残ったことばを記録してコレクションしよう</p>
  </div>
</div>
<div class="container-fluid bg-light">
  <div class="row">
    <div class="col-md-5">
      <h3>1.日常で気になったことばをコレクションしよう</h3>
    </div>
    <div class="col-md-7">
      <img class="img-fluid" src="images/top_image_1.jpg" alt="top_image_1">
    </div>
  </div>
  <hr class="border border-secondary my-5">
  <div class="row">
    <div class="col-md-5 order-md-2">
      <h3>2.コレクションしたことばをふとした時に確認</h3>
    </div>
    <div class="col-md-7 order-md-1">
      <img class="img-fluid" src="images/top_image_2.jpg" alt="top_image_2">
    </div>
  </div>
  <hr class="border border-secondary my-5">
  <div class="row">
    <div class="col-md-5">
      <h3>3.コレクションしたことばをみんなでシェアできる</h3>
    </div>
    <div class="col-md-7">
      <img class="img-fluid" src="images/top_image_3.jpg" alt="top_image_3">
    </div>
  </div>
</div>
@endsection