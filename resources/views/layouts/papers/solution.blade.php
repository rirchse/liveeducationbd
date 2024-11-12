@php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
@endphp

@extends('dashboard')
@section('title', 'Solution')
@section('content')
<style>
  .mcqitems{list-style: none; padding-left: 10px}
  .mcqitems li{padding: 10px}
  .banner{margin-top:15px}
  .banner img{width:100%}
</style>
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Solution</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Solution</a></li>
        <li class="active">Details</li>
      </ol>
    </section>

    <!-- Main content -->
  <section class="content">
    <div class="row"><!-- left column -->
      <div class="col-md-12"><!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h4 class="box-title" style="display: inline">Solution (<b>{{count($paper->questions)}}</b>)</h4>
            <div class="text-right toolbar-icon pull-right" style="display: inline">
              {{-- <a href="{{route('paper.add.question', $paper->id)}}" title="Add Questions" class="label label-info"><i class="fa fa-plus"></i> Add Questions</a> --}}
              {{-- <a href="{{route('paper.create')}}" title="Add" class="label label-primary"><i class="fa fa-pencil"></i> Create</a> --}}
              {{-- <a href="{{route('paper.index')}}" title="View" class="label label-success"><i class="fa fa-list"></i></a> --}}
              <a href="{{route('paper.view', $paper->id)}}" class="label label-primary" title="Details"><i class="fa fa-file-text"></i></a>
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
          <div class="banner"><img src="{{$paper->banner}}" alt=""></div>
          <div class="header" style="text-align:center">{!! $paper->header !!} </div>
          {{-- @if($paper->details)
          <div class="col-md-12 indication">
            <p>"{!! $paper->details !!}"</p><br>
          </div>
          @endif --}}
          <h3 style="text-align: center;border-bottom:2px solid #ddd; padding-bottom:15px">Solution Paper</h3>
            <div class="col-md-12">
              @foreach($paper->questions as $key => $value)
              <div class="panel">
                <div style="display: inline; font-weight:bold;float:left; padding-right:15px">প্রশ্ন নং- {{$key+1}}. </div> <div style="display: inline">{!! $value->title !!}</div>
                @php
                $correct_ans = '';
                @endphp
                <ul class="mcqitems">
                  @foreach($value->mcqitems as $k => $val)
                  @php
                  if($val->correct_answer)
                  {
                    $correct_ans = $source->mcqlist()[$paper->format][$k].' '.$val->item;
                  }
                  @endphp
                  <li><span> {{$source->mcqlist()[$paper->format][$k]}} </span>{{$val->item}}
                </li>
                  @endforeach
                </ul>
                <div style="color:green; padding-top:5px; padding-bottom:15px;">সঠিক উত্তরঃ <b>{{$correct_ans}}</b></div>
              </div>
              @php
              $correct_ans = '';
              @endphp
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
