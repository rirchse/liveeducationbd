@php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
@endphp

@extends('dashboard')
@section('title', 'Question Paper')
@section('content')
<style>
  .mcqitems{list-style: none; padding-left: 10px}
  .mcqitems li{padding: 10px}
  .banner{margin-top:15px}
  .banner img{width:100%}
</style>
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Question Paper</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Question Paper</a></li>
        <li class="active">Details</li>
      </ol>
    </section>

    <!-- Main content -->
  <section class="content">
    <div class="row"><!-- left column -->
      <div class="col-md-12"><!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h4 class="box-title" style="display: inline">Question Paper (<b>{{count($paper->questions)}}</b>)</h4>
            <div class="text-right toolbar-icon pull-right" style="display: inline">
              <a id="exam-url" href="#" style="font-size: 12px">{{route('students.instruction', $paper->id)}}</a>
              <button title="Copy Link" class="btn btn-default btn-sm" onclick="copyUrl(); alert('Link Copied to the clipboard')"><i class="fa fa-copy"></i> Copy Link </button>
              <a href="{{route('paper.add.question', $paper->id)}}" title="Add Questions" class="label label-info"><i class="fa fa-plus"></i> Add Questions</a>
              <a href="{{route('paper.create')}}" title="Add" class="label label-primary"><i class="fa fa-pencil"></i> Create</a>
              <a href="{{route('paper.solution', $paper->id)}}" title="Solution" class="label label-info"><i class="fa fa-file-o"> Solution</i></a>
              <a href="{{route('paper.exam', $paper->id)}}" title="Exam" class="label label-primary"><i class="fa fa-list"> Exams</i></a>
              <a href="{{route('paper.result', $paper->id)}}" title="Result" class="label label-warning"><i class="fa fa-list-o"> Result</i></a>
              <a href="{{route('paper.index')}}" title="View" class="label label-success"><i class="fa fa-list"></i></a>
              <a href="{{route('paper.show', $paper->id)}}" class="label label-primary" title="Details"><i class="fa fa-file-text"></i></a>
              <a href="{{route('paper.edit', $paper->id)}}" class="label label-warning" title="Edit"><i class="fa fa-gear"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
      <div class="box">
        <div class="col-md-12">
          <div class="banner"><img src="{{$paper->banner}}" alt=""></div>
          <div class="header" style="text-align:center">{!! $paper->header !!} </div>
            <div class="col-md-12">
              @foreach($paper->questions as $key => $value)
              <div class="panel">
                <div style="display: inline; font-weight:bold;float:left; padding-right:10px">প্রশ্ন {{$key+1}}.</div><div style="display: inline">{!! $value->title !!}</div>
                <ul class="mcqitems">
                  @foreach($value->mcqitems as $k => $val)
                  <li><span><input type="radio" name="correct{{$value->id}}"></span><span> {{$source->mcqlist()[$paper->format][$k]}} </span>{{$val->item}}</li>
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
@section('scripts')
<script>
  function copyUrl() {
      var range = document.createRange();
      range.selectNode(document.getElementById("exam-url"));
      window.getSelection().removeAllRanges(); // clear current selection
      window.getSelection().addRange(range); // to select text
      document.execCommand("copy");
      window.getSelection().removeAllRanges();// to deselect
  }
</script>
@endsection
