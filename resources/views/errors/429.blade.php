@extends('errors.layouts.error_base')

@section('content')
 <div class="container">
   <div class="alert alert-danger mt-5" role="alert">
   <h1 class="alert-heading text-center">429 ERROR Bad Request</h1>
   <p class="h4">ただいまアクセスが多く、お探しのページを表示できませんでした。</p>
   <hr>
   <p>お手数ですが、しばらく時間を置いてから、再度お探しのページにアクセスしてください。</p>
   </div>
 </div>
@endsection