@php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
$user = Auth::guard('student')->user();
$value = $paper;
$student = [];
if($user)
{
  $student = \App\Models\Student::find($user->id);
}
@endphp

@extends('student')
@section('title', 'পরীক্ষা সমূহ')
@section('content')
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
        <div class="col-md-6 col-md-offset-3">
          @if( $paper->permit == 'Batch' && $student->batches->find($paper->batch_id) || $paper->permit == 'Department' && $student->departments->find($paper->department_id) || $paper->permit == 'Group' && $student->groups->find($paper->group_id) || $paper->permit == 'Every One')
          
            @if($paper->close && $paper->close < date('Y-m-d H:i:s'))
            <div class="panel panel-warning">
              <div class="panel-heading">
                <b>Exam No. {{$value->name}}</b>
              </div>
              <div class="panel-body">
                <p class="text-danger">পরীক্ষার সময় শেষ...</p>
              </div>
              <div class="panel-footer">
                <a class="btn btn-danger pull-right" href="{{route('students.exam')}}">হোম এ ফিরে যান</a>
                <div class="clearfix"></div>
              </div>
            </div>

            @elseif($value->status == 'Scheduled')
            <div class="panel panel-warning">
              <div class="panel-heading">
                <b>Exam No. {{$value->name}}</b>
              </div>
              <div class="panel-body">
                <p> পরীক্ষা শুরু হবে <b>{{ $source->dtformat($value->open)}}</b> এবং শেষ হবে <b>{{ $source->dtformat($value->close)}}</b></p>
            </div>
              <div class="panel-footer">
                <a class="btn btn-info pull-right" href="{{route('students.exam', $value->id)}}">Back</a>
                <div class="clearfix"></div>
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
          @else
            <div class="panel panel-danger">
              <div class="panel-heading">
                <p>This exam is not match with you!</p>
                <a href="{{route('homepage')}}">Back</a>
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