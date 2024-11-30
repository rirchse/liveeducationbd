@php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
$user = Auth::guard('student')->user();
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
        <li><a href="/"><i class="fa fa-dashboard"></i> হোম</a></li>
        <li><a href="{{route('students.exam')}}">পরীক্ষা সমূহ</a></li>
        {{-- <li class="active">Top Navigation</li> --}}
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @if(!empty($student) && count($student->courses()->get()))
      @foreach($student->courses()->get() as $course)
      @php
      $paper = $course->paper;
      @endphp
      <div class="col-md-3">
        <a class="" href="{{route('students.check', $paper->id)}}">
        <div class="panel" style="min-height: 130px">
          <div class="panel-heading">Live Education BD</div>
          <div class="panel-body" style="padding-top:0;font-size:22px"><b>{{$paper->name}}</b></div>
          <div class="panel-footer">
            Course: <b>{{$course->name}}<b>
          </div>
        </div>
      </a>
      </div>
      @endforeach
      @else
      <div class="panel panel-default">
        <div class="panel-body">
          No Exam Available
        </div>
      </div>
      @endif
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