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
            <h4 class="box-title" style="display: inline">Question Paper</h4>
            <div class="text-right toolbar-icon pull-right" style="display: inline">
              <a href="{{route('paper.add.question', $paper->id)}}" title="Add Questions" class="label label-info"><i class="fa fa-plus"></i> Add Questions</a>
              <a href="{{route('paper.create')}}" title="Add" class="label label-primary"><i class="fa fa-pencil"></i> Create</a>
              <a href="{{route('paper.index')}}" title="View" class="label label-success"><i class="fa fa-list"></i></a>
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
                {{-- <div class="panel-heading"> --}}
                  <div style="display: inline; font-weight:bold;float:left; padding-right:15px">প্রশ্ন নং- {{$key+1}}. </div> <div style="display: inline">{!! $value->title !!}</div>
                {{-- </div> --}}
                <ul class="mcqitems">
                  @foreach($value->mcqitems as $k => $val)
                  <li><span><input type="radio" name="correct"></span><span> {{$source->mcqlist()[$paper->format][$k]}} </span>{{$val->item}}</li>
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
