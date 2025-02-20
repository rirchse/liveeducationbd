@php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
@endphp

@extends('dashboard')
@section('title', 'Routine')
@section('content')
<style>
  .mcqitems{list-style: none; padding-left: 10px}
  .mcqitems li{padding: 10px}
  .banner{margin-top:15px}
  .banner img{width:100%}
</style>
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Routine</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Routine</a></li>
        <li class="active">Details</li>
      </ol>
    </section>

    <!-- Main content -->
  <section class="content">
    <div class="row"><!-- left column -->
      <div class="col-md-12"><!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h4 class="box-title" style="display: inline">Routine (<b>{{count($routine->questions)}}</b>)</h4>
            <div class="text-right toolbar-icon pull-right" style="display: inline">
              <a href="{{route('routine.add.question', ['routine', $routine->id])}}" title="Add Questions" class="label label-info"><i class="fa fa-plus"></i> Add Questions</a>
              <a href="{{route('routine.create')}}" title="Add" class="label label-primary"><i class="fa fa-pencil"></i> Create</a>
              {{-- <a href="{{route('routine.solution', $routine->id)}}" title="Solution" class="label label-info"><i class="fa fa-file-o"> Solution</i></a> --}}
              <a href="{{route('routine.index')}}" title="View" class="label label-success"><i class="fa fa-list"></i></a>
              {{-- <a href="{{route('routine.show', $routine->id)}}" class="label label-primary" title="Details"><i class="fa fa-file-text"></i></a> --}}
              <a href="{{route('routine.edit', $routine->id)}}" class="label label-warning" title="Edit"><i class="fa fa-gear"></i></a>
              {{-- <a href="#" class="label label-info" title="Print" onclick="printDiv()"><i class="fa fa-print"></i></a> --}}
              <a href="{{route('routine.pdf', $routine->id)}}" title="PDF Download" class="label label-info"><i class="fa fa-file"> Print PDF</i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
      <div class="box" id="print">
        <div class="col-md-12">
          <div class="banner"><img src="{{$routine->banner}}" alt=""></div>
          <div class="header" style="text-align:center">{!! $routine->header !!} </div>
          <p style="text-align: center">Course Name: <b>{{$routine->course?$routine->course->name:''}}</b></p>
          <hr>
            <div class="row">
              @foreach($routine->questions as $key => $value)
              <div class="panel col-md-6">
                <div style="display: inline; font-weight:bold;float:left; padding-right:10px; text-align:justify">প্রশ্ন {{$key+1}}.</div>
                <div style="display: inline">{!! $value->title !!}</div>
                @foreach($value->getlabels as $val)
                <label style="border:1px solid #aaa; padding:0 5px; color:brown">{{$val->label}}</label>
                @endforeach

                @php
                $correct_ans = '';
                @endphp
                <ul class="mcqitems" style="list-style: none">
                  @foreach($value->mcqitems as $k => $val)
                  @php
                  if($val->correct_answer)
                  {
                    $correct_ans = $source->mcqlist()[$routine->format][$k].' '.$val->item;
                  }
                  @endphp
                  <li style="width:50%; float:left"><span> {{$source->mcqlist()[$routine->format][$k]}} </span>{{$val->item}}</li>
                  @endforeach
                  <div class="clearfix"></div>
                </ul>
                <div style="color:green; clear:top; padding:10px 0;">সঠিক উত্তরঃ <b>{{$correct_ans}}</b></div>
              </div>
              <div class="{{$key % 2 ? 'clearfix':''}}"></div>
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
  
  function printDiv()
  {
    // document.getElementById('heading').style.display = 'block';
    var divToPrint = document.getElementById('print');
    var htmlToPrint = '' +
        '<style type="text/css">' +
        '.heading{display:block}'+
        '.pageheader{font-size:15px}'+
        'table { border-collapse:collapse; font-size:15px;width:100%}' +
        '.table tr th, .table tr td { padding: 10px; border:1px solid #ddd; text-align:left}' +
        'table tr{background: #ddd}'+
        '.receipt{display:none}'+
        '</style>';
    htmlToPrint += divToPrint.outerHTML;
    newWin = window.open(htmlToPrint);
    newWin.document.write(htmlToPrint);
    newWin.print();
    newWin.close();
    // document.getElementById('heading').style.display = 'none';
  }
</script>
@endsection