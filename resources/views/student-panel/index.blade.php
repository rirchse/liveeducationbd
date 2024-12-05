@php
$student  = [];
$user = Auth::guard('student')->user();
if($user)
{
  $student = \App\Models\Student::find($user->id);
}
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
  .hover:hover{border:2px solid #080}
</style>

<div class="content-wrapper">
  <div class="container">

    <!-- Main content -->
    <section class="content">
      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">কোর্স সমূহ</h3>
        </div>
      </div> <!-- /.box -->
      <div class="row" style="margin-bottom:35px;">
        @foreach($batches as $value)
        <div class="col-md-2">
          <a href="{{route('home.course.show', $value->id)}}">
          <div class="panel panel-default">
            <div class="penel-heading hover no-padding" style="text-align: center; padding: 15px; min-height:150px">
                <img class="course-image" src="{{ $value->banner? $value->banner : '/img/course.jpg'}}" alt="" />
            </div>
          </div>
        </a>
        </div>
        @endforeach
      </div> <!-- /.row -->

      @if(!empty($user) && count($mybatches))      
      <div class="box box-warning">
        <div class="box-header with-border">
          <h3 class="box-title">আমার কোর্স</h3>
        </div>
      </div> <!-- /.box -->
      <div class="row" style="margin-bottom:35px">
        @foreach($mybatches as $value)
        <div class="col-md-2">
          <a href="{{route('students.course.show', $value->id)}}">
          <div class="panel panel-default">
            <div class="penel-heading no-padding" style="text-align: center; padding:15px">
              <img class="course-image" src="{{ $value->banner? $value->banner : '/img/course.jpg'}}" alt="" />
            </div>
            <div class="panel-heading"><b>{{$value->name}}</b></div>
          </div>
          </a>
        </div>
        @endforeach
      </div> <!-- /.row -->
      @endif

      @if(!empty($student) && count($student->batches()->get()))
      <div class="box box-danger">
        <div class="box-header with-border">
          <h3 class="box-title">পরীক্ষা</h3>
        </div>
      </div> <!-- /.box -->
      <div class="row" style="margin-bottom:35px">
        {{-- $paper->permit == 'Course' && $student->courses->find($course->id) || --}}
          
        @foreach($student->batches()->get() as $course)
        @if($course->paper)
        @php
        $paper = $course->paper;
        @endphp
          @if( $paper->permit == 'Batch' && $student->batches->find($paper->batch_id) || $paper->permit == 'Department' && $student->departments->find($paper->department_id) || $paper->permit == 'Group' && $student->groups->find($paper->group_id))
          <div class="col-md-3">
            <a class="" href="{{route('students.check', $paper->id)}}">
            <div class="panel">
              <div class="panel-heading">Live Education BD</div>
              <div class="panel-body" style="padding-top:0;font-size:22px"><b>{{$paper->name}}</b></div>
              <div class="panel-footer">
                Batch: <b>{{$course->name}}<b>
              </div>
            </div>
          </a>
          </div>
          @endif
        @endif
        @endforeach
        @if($papers)
        @foreach($papers as $paper)
        <div class="col-md-3">
          <a class="" href="{{route('students.check', $paper->id)}}">
          <div class="panel">
            <div class="panel-heading">Live Education BD</div>
            <div class="panel-body" style="padding-top:0;font-size:22px"><b>{{$paper->name}}</b></div>
            <div class="panel-footer">
              For: <b>{{$paper->permit}}<b>
            </div>
          </div>
        </a>
        </div>
        @endforeach
        @endif
      </div> <!-- /.row -->
      @endif
    </section> <!-- /.content -->
  </div> <!-- /.container -->
</div>
@endsection