@extends('errors.layouts.error_base')

@section('content')
 <div class="container">
   <div class="alert alert-danger mt-5" role="alert">
   <h1 class="alert-heading text-center">503 ERROR Service Unavailable</h1>
   <p class="h4 text-center">ただいまサービスの利用ができません。</p>
   <hr>
   <p>ただいまアクセスが集中しているなどの理由で、ご利用できません。しばらくお時間を置いてから、再度アクセスしてください。</p>
   </div>
 </div>
@endsection