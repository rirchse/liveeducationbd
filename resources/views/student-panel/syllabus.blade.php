@php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
@endphp

@extends('student')
@section('title', 'Syllabus')
@section('content')
<style>
  .mcqitems{list-style: none; padding-left: 10px}
  .mcqitems li{padding: 10px}
  .banner{margin-top:15px}
  .banner img{width:100%}
</style>

<div class="content-wrapper">
  <div class="container">
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Syllabus</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Syllabus</a></li>
        {{-- <li class="active">Details</li> --}}
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
              <a href="#" class="label label-info" title="Print" onclick="printDiv()"><i class="fa fa-print"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
      <div class="box" id="print">
        <div class="col-md-12">
          <div class="banner"><img src="{{$syllabus->banner}}" alt=""></div>
          <div class="header" style="text-align:center">{!! $syllabus->header !!} </div>
          <p style="text-align: center">Course Name: <b>{{$syllabus->course?$syllabus->course->name:''}}</b></p>
          <hr>
            <div class="row">
              @foreach($syllabus->questions as $key => $value)
              <div class="panel col-md-6">
                <div style="display: inline; font-weight:bold;float:left; padding-right:10px; text-align:justify">প্রশ্ন {{$key+1}}.</div>
                <div style="display: inline">{!! $value->title !!}</div>
                @php
                $correct_ans = '';
                @endphp
                <ul class="mcqitems" style="list-style: none">
                  @foreach($value->mcqitems as $k => $val)
                  @php
                  if($val->correct_answer)
                  {
                    $correct_ans = $source->mcqlist()[$syllabus->format][$k].' '.$val->item;
                  }
                  @endphp
                  <li style="width:50%; float:left"><span> {{$source->mcqlist()[$syllabus->format][$k]}} </span>{{$val->item}}</li>
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
</div> <!-- /.container -->
</div>
   
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