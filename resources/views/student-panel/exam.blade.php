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
        <div class="col-md-3">
          <a class="" href="{{route('students.instruction', $value->id)}}">
          <div class="panel">
            <div class="panel-body no-padding">
              <img src="{{$value->banner ? $value->banner : '/img/paper-banner.png'}}" alt="" style="width:100%">
            </div>
            <div class="panel-body" style="font-size:22px"><b>Exam No. {{$value->name}}</b></div>
            <div class="panel-footer">
              Course: <b>{{$value->course()->first() ? $value->course()->first()->name:''}}<b>
            </div>
          </div>
        </a>
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