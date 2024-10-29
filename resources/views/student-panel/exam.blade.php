@php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
$user = Auth::guard('student')->user();
@endphp

@extends('student')
@section('title', 'পরীক্ষা সমূহ')
@section('content')
{{-- <script src='https://www.google.com/recaptcha/api.js' async defer></script> --}}
<style>
  .checkbox{padding-left: 25px}
</style>

<div class="content-wrapper">
  <div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1> পরীক্ষা সমূহ {{-- <small>পরীক্ষা সমূহple 2.0</small> --}} </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> হোম</a></li>
        <li><a href="#">পরীক্ষা সমূহ</a></li>
        {{-- <li class="active">Top Navigation</li> --}}
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        @foreach($papers as $value)
        <div class="col-md-6">
          <div class="panel panel-default">
            <div class="panel-heading"><b>Exam No. {{$value->name}}</b></div>
            <div class="panel-body">Status: {{$value->status}} 
              @if($value->status == 'Scheduled')
              <p>{!!$source->dtformat($value->open).' <br> '.$source->dtformat($value->close)!!}</p>
              @endif
            </div>
            <div class="panel-footer">
              <a class="btn btn-info pull-right" href="{{route('students.exam.show', $value->id)}}">শুরু করুন</a>
              <div class="clearfix"></div>
            </div>
          </div>
        </div>
        @endforeach
    </section> <!-- /.content -->
  </div> <!-- /.container -->
</div>

<script>
  function showPassword(e)
  {
    let elm = e.previousElementSibling;
    if(elm.type == 'password')
    {
      elm.setAttribute('type', 'text');
      e.firstChild.classList.add('fa-eye');
      e.firstChild.classList.remove('fa-eye-slash');
    }
    else 
    {
      elm.setAttribute('type', 'password');
      e.firstChild.classList.add('fa-eye-slash');
      e.firstChild.classList.remove('fa-eye');
    }
  }
</script>
@endsection