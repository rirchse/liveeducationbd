@php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
@endphp

@extends('dashboard')
@section('title', 'Syllabus')
@section('content')
<style>
  .mcqitems{list-style: none; padding-left: 10px}
  .mcqitems li{padding: 10px}
  .banner{margin-top:15px}
  .banner img{width:100%}
</style>
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Syllabus</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Syllabus</a></li>
        <li class="active">Details</li>
      </ol>
    </section>

    <!-- Main content -->
  <section class="content">
    <div class="row"><!-- left column -->
      <div class="col-md-12"><!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h4 class="box-title" style="display: inline">Syllabus (<b>{{count($syllabus->questions)}}</b>)</h4>
            <div class="text-right toolbar-icon pull-right" style="display: inline">
              <a href="{{route('syllabus.add.question', ['syllabus', $syllabus->id])}}" title="Add Questions" class="label label-info"><i class="fa fa-plus"></i> Add Questions</a>
              <a href="{{route('syllabus.create')}}" title="Add" class="label label-primary"><i class="fa fa-pencil"></i> Create</a>
              {{-- <a href="{{route('syllabus.solution', $syllabus->id)}}" title="Solution" class="label label-info"><i class="fa fa-file-o"> Solution</i></a> --}}
              {{-- <a href="{{route('syllabus.result', $syllabus->id)}}" title="Result" class="label label-warning"><i class="fa fa-list-o"> Result</i></a> --}}
              <a href="{{route('syllabus.index')}}" title="View" class="label label-success"><i class="fa fa-list"></i></a>
              {{-- <a href="{{route('syllabus.show', $syllabus->id)}}" class="label label-primary" title="Details"><i class="fa fa-file-text"></i></a> --}}
              {{-- <a href="{{route('syllabus.edit', $syllabus->id)}}" class="label label-warning" title="Edit"><i class="fa fa-gear"></i></a> --}}
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
      <div class="box">
        <div class="col-md-12">
          <div class="banner"><img src="{{$syllabus->banner}}" alt=""></div>
          <div class="header" style="text-align:center">{!! $syllabus->header !!} </div>
          {{-- @if($syllabus->details)
          <div class="col-md-12 indication">
            <p>"{!! $syllabus->details !!}"</p><br>
          </div>
          @endif --}}
            <div class="col-md-12">
              @foreach($syllabus->questions as $key => $value)
              <div class="panel">
                <div style="display: inline; font-weight:bold;float:left; padding-right:10px">প্রশ্ন {{$key+1}}.</div><div style="display: inline">{!! $value->title !!}</div>
                <ul class="mcqitems">
                  @foreach($value->mcqitems as $k => $val)
                  <li><span><input type="radio" name="correct{{$value->id}}"></span><span> {{$source->mcqlist()[$syllabus->format][$k]}} </span>{{$val->item}}</li>
                  @endforeach
                </ul>
              </div>
              @endforeach
            </div>
          </div>
          <div class="clearfix"></div>
        </div><!--/.col -->
      </div><!-- /.col -->
    </div><!-- /.row -->
  </section><!-- /.content -->
   
@endsection
