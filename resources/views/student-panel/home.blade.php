@php
$user = Auth::guard('student')->user();
@endphp
@extends('student')
@section('title', 'হোম')
@section('content')
{{-- <script src='https://www.google.com/recaptcha/api.js' async defer></script> --}}
<style>
  .checkbox{padding-left: 25px}
  .box-header{margin-bottom:15px}
  .box-header .box-title{text-align: center; display: block}
  .course-image{width:100%}
</style>

<div class="content-wrapper">
  <div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        হোম
        {{-- <small>হোমple 2.0</small> --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> হোম</a></li>
        <li><a href="#">হোম</a></li>
        {{-- <li class="active">Top Navigation</li> --}}
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">কোর্স সমূহ</h3>
        </div>
        <div class="box-body">
          @foreach($courses as $value)
          <div class="col-md-3">
            <div class="panel panel-default">
              <div class="penel-heading" style="text-align: center;padding:15px">
                <a href="{{route('students.course.show', $value->id)}}">
                  <img class="course-image" src="{{ $value->banner? $value->banner : '/img/logo.png'}}" alt="" />
                </a>
              </div>
              {{-- <div class="panel-heading"><b>{{$value->name}}</b></div> --}}
              <div class="panel-body">
                @if($value->status == 'Scheduled')
                <span>{{$value->open.' - '.$value->close}}</span>
                @endif
              </div>
              {{-- <div class="panel-footer">
                @if($value->students()->where('id', $user->id)->first())
                <button class="btn btn-default pull-right" disabled>Applied</button>
                @else
                <a class="btn btn-info pull-right" href="{{route('students.course.show', $value->id)}}">View</a>
                @endif
                <div class="clearfix"></div>
              </div> --}}
            </div>
          </div>
          @endforeach
        </div> <!-- /.box-body -->
      </div> <!-- /.box -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">আমার কোর্স</h3>
        </div>
        <div class="box-body">
          @foreach($mycourses as $value)
          <div class="col-md-3">
            <div class="panel panel-default">
              <div class="penel-heading" style="text-align: center;padding:15px">
                <img class="course-image" src="{{ $value->banner? $value->banner : '/img/logo.png'}}" alt="" />
              </div>
              <div class="panel-heading"><b>{{$value->name}}</b></div>
              <div class="panel-body">
                Status: {{$value->status}}
                @if($value->status == 'Scheduled')
                <span>{{$value->open.' - '.$value->close}}</span>
                @endif
              </div>
            </div>
          </div>
          @endforeach
        </div> <!-- /.box-body -->
      </div> <!-- /.box -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">আমার পরীক্ষা</h3>
        </div>
        <div class="box-body">
          @foreach($papers as $value)
          <div class="col-md-4">
            <div class="panel panel-default">
              <div class="panel-heading"><b>Exam No. {{$value->name}}</b></div>
              <div class="panel-body">Status: {{$value->status}} 
                @if($value->status == 'Scheduled')
                <p>{{$value->open.' - '.$value->close}}</p>
                @endif
              </div>
              <div class="panel-footer">
                <a class="btn btn-info pull-right" href="{{route('students.exam.show', $value->id)}}">Start Exam</a>
                <div class="clearfix"></div>
              </div>
            </div>
          </div>
          @endforeach
        </div> <!-- /.box-body -->
      </div> <!-- /.box -->
    </section> <!-- /.content -->
  </div> <!-- /.container -->
</div>
@endsection