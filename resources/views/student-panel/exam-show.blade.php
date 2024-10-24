@php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
$user = Auth::guard('student')->user();
// $value = $exams;
@endphp
@extends('student')
@section('title', 'Course')
@section('content')
{{-- <script src='https://www.google.com/recaptcha/api.js' async defer></script> --}}
<style>
  .checkbox{padding-left: 25px}
  .panel ::-webkit-scrollbar{width: 5px;}
  ::-webkit-scrollbar-thumb{background-color: #ddd}
  .mcqitems{list-style: none; padding-left: 10px}
  .mcqitems li{padding: 10px}
  .banner{margin-top:15px}
  .banner img{width:100%}
</style>

<div class="content-wrapper">
  <div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1> Exam {{-- <small>Example 2.0</small> --}} </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Exam</a></li>
        {{-- <li class="active">Top Navigation</li> --}}
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="box col-md-12">
          <div class="banner"><img src="{{$paper->banner}}" alt=""></div>
          <div class="header" style="text-align:center">{!! $paper->header !!} </div>
          @if($paper->details)
          <div class="col-md-12 indication">
            <p>"{!! $paper->details !!}"</p><br>
          </div>
          @endif
        </div>
        <div class="col-md-12 no-padding">
          @foreach($paper->questions as $key => $value)
          <div class="panel panel-default">
            <div class="panel-heading" style="background-color:none">
              <div style="display: inline; font-weight:bold;float:left; padding-right:15px">প্রশ্ন নং- {{$key+1}}. </div>
              <div style="display: inline">{!! $value->title !!}</div>
            </div>
            <ul class="mcqitems">
              @foreach($value->mcqitems as $k => $val)
              <li><span><input type="radio" name="correct{{$value->id}}"></span><span> {{$source->mcqlist()[$paper->format][$k]}} </span>{{$val->item}}</li>
              @endforeach
            </ul>
          </div>
          @endforeach
        </div><!--/.col -->
        
        <div class="col-md-12">
          <button class="btn btn-info pull-right">Submit</button>
        </div>
      </div><!-- /.row -->
    </section> <!-- /.content -->

  </div> <!-- /.container -->
</div> <!-- /.content-wrapper -->
@endsection