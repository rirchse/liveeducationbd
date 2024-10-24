@php
$user = Auth::guard('student')->user();
@endphp
@extends('student')
@section('title', 'Course')
@section('content')
{{-- <script src='https://www.google.com/recaptcha/api.js' async defer></script> --}}
<style>
  .checkbox{padding-left: 25px}
  .panel ::-webkit-scrollbar{width: 5px;}
  ::-webkit-scrollbar-thumb{background-color: #ddd}
</style>

<div class="content-wrapper">
  <div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1> Course {{-- <small>Courseple 2.0</small> --}} </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Course</a></li>
        {{-- <li class="active">Top Navigation</li> --}}
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      {{-- <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Course No.</h3>
        </div>
        <div class="box-body">
          The great content goes here
        </div> <!-- /.box-body -->
      </div> <!-- /.box --> --}}
      @foreach($courses as $value)
      <div class="col-md-4">
        <div class="panel panel-default">
          <div class="penel-heading" style="text-align: center;padding:15px">
            <img src="/img/logo.png" alt="">
          </div>
          <div class="panel-heading"><b>{{$value->name}}</b></div>
          <div class="panel-body" style="min-height:400px;max-height:400px;overflow:auto">{{$value->details}}
            @if($value->status == 'Scheduled')
            <span>{{$value->open.' - '.$value->close}}</span>
            @endif
          </div>
          <div class="panel-footer">
            @if($value->students()->where('id', $user->id)->first())
            <button class="btn btn-default pull-right" disabled>Applied</button>
            @else
            {{-- <a href="{{route('students.apply.course', $value->id)}}" class="btn btn-info pull-right" onclick="return confirm('Are you sure you want to apply to this course?')">Apply</a> --}}
            <a class="btn btn-info pull-right" href="{{route('students.course.show', $value->id)}}">View</a>
            @endif
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