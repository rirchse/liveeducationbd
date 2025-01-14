@php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
$user = Auth::guard('student')->user();
$value = $paper;
@endphp

@extends('student')
@section('title', 'পরীক্ষা সমূহ')
@section('content')
<style>
  .checkbox{padding-left: 25px}
  .cst-btn{margin-bottom:10px}
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
        <div class="col-md-6 col-md-offset-3">
          @if(isset($check['scheduled']) && $value->status == 'Scheduled')
          <div class="panel panel-warning">
            <div class="panel-heading">
              <b>Exam No. {{$value->name}}</b>
            </div>
            <div class="panel-body">
              <p> পরীক্ষা শুরু হবে <b>{{ $source->dtformat($value->open) }}</b></p>
            </div>
            <div class="panel-footer">
              <a class="btn btn-info pull-right" href="{{route('students.exam', $value->id)}}">Back</a>
              <div class="clearfix"></div>
            </div>
          </div>

          @elseif(isset($check['result-exam']))
          <div class="panel panel-warning">
            <div class="panel-heading">
              <b>Exam No. {{$value->name}}</b>
            </div>
            <div class="panel-footer">
              @if($value->exam)
                <a href="{{route('students.result', $value->id)}}" class="btn btn-warning cst-btn">ফলাফল দেখুন</a>
                @endif
                @if($value->close && $value->close < date('Y-m-d H:i:s'))
                পরীক্ষার সময় শেষ ...
                @else
                <a class="btn btn-info cst-btn" href="{{route('students.instruction', $value->id)}}">পরীক্ষা দিন</a>
                @endif
            </div>
          </div>

          @elseif($value->status == 'Published')
          <div class="panel panel-warning">
            <div class="panel-heading">
              <b>Exam No. {{$value->name}}</b>
            </div>
            <div class="panel-body">
              <p>{!! $value->details !!}</p>
          </div>
            <div class="panel-footer">
              <a class="btn btn-info pull-right" href="{{route('students.exam.show', $value->id)}}">শুরু করুন</a>
              <div class="clearfix"></div>
            </div>
          </div>
          @endif
        </div>
    </section> <!-- /.content -->
  </div> <!-- /.container -->
</div>

<script>
</script>
@endsection