@php
// $user = Auth::guard('student')->user();
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
      <div class="row" style="margin-bottom:35px">
        @foreach($courses as $value)
        <div class="col-md-3">
          <div class="panel panel-default">
            <div class="penel-heading hover" style="text-align: center;padding:15px;min-height:150px">
              <a href="{{route('home.course.show', $value->id)}}">
                <img class="course-image" src="{{ $value->banner? $value->banner : '/img/logo.png'}}" alt="" />
              </a>
            </div>
          </div>
        </div>
        @endforeach
      </div> <!-- /.row -->
      <div class="box box-danger">
        <div class="box-header with-border">
          <h3 class="box-title">পরীক্ষা</h3>
        </div>
      </div> <!-- /.box -->
      <div class="row" style="margin-bottom:35px">
        @if($batches)
          @foreach($batches as $batch)
          {{-- {{$batch->paper()->where('status', 'Published')->get()}} --}}
          @if($batch->paper()->where('status', 'Published')->get())
          <div class="col-md-12">
            {{-- <label class="" for="" style="color:#fff;background: rgb(38,43,99);
background: linear-gradient(90deg, rgba(38,43,99,1) 25%, rgba(9,73,121,1) 50%, rgba(7,128,153,1) 100%); width:100%; display:block; padding:5px 10px">{{$batch->name}}</label> --}}
          </div>
          @endif
          
            @foreach($batch->paper()->get() as $value)
            <div class="col-md-3">
              <a class="" href="{{route('students.exam.show', $value->id)}}">
              <div class="panel">
                {{-- <div class="panel-body no-padding">
                  <img src="{{$value->banner ? $value->banner : '/img/paper-banner.png'}}" alt="" style="width:100%">
                </div> --}}
                <div class="panel-heading">Live Education BD</div>
                <div class="panel-body" style="font-size:22px"><b>{{$value->name}}</b></div>
                <div class="panel-footer">
                  Course: <b>{{$value->course()->first() ? $value->course()->first()->name:''}}<b>
                </div>
              </div>
            </a>
            </div>
            @endforeach
          @endforeach
        @endif
      </div> <!-- /.row -->
    </section> <!-- /.content -->
  </div> <!-- /.container -->
</div>
@endsection