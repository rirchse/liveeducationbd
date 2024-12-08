@php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
@endphp

@extends('dashboard')
@section('title', 'Syllabus')
@section('content')
  <style type="text/css">
    .mcqitems{list-style: none; padding-left: 10px}
    .mcqitems li{padding: 10px}
    .banner{margin-top:15px}
    .banner img{width:100%}
  </style>
  
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 style="text-align: center; font-family: Tahoma">Syllabus</h1>
      <a href="{{route('syllabus.view', $syllabus->id)}}" title="Add" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</a>
      <a href="#" title="Add" class="btn btn-info pull-right" onclick="printDiv()"><i class="fa fa-print"></i> Print</a>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box" id="print">
            <div class="col-md-12">
              <div class="banner"><img src="{{$syllabus->banner}}" alt=""></div>
              <div class="header" style="text-align:center">{!! $syllabus->header !!} </div>
              <p style="text-align: center">Course Name: <b>{{$syllabus->course?$syllabus->course->name:''}}</b></p>
              <p style="text-align: center">Batch: <b>{{$syllabus->batch?$syllabus->batch->name:''}}</b></p>
              <hr>
              <table style="width: 100%">
                <tr>
                @foreach($syllabus->questions as $key => $value)
                  <td style="width: 50%;padding:10px">
                    <div style="display: inline; font-weight:bold;float:left; padding-right:15px; text-align:justify;">প্রশ্ন {{$key+1}}.</div>
                    <div style="display: inline">{!! $value->title !!}</div>
                    @php
                    $correct_ans = '';
                    @endphp
                    <table class="mcqitems" style="width:100%">
                      <tr>
                      @foreach($value->mcqitems as $k => $val)
                      @php
                      if($val->correct_answer)
                      {
                        $correct_ans = $source->mcqlist()[$syllabus->format][$k].' '.$val->item;
                      }
                      @endphp
                      <td style="padding:10px;">
                        <span> {{$source->mcqlist()[$syllabus->format][$k]}} </span>{{$val->item}}
                      </td>
                      @if($k+1 == 2)
                    </tr>
                    <tr>
                      @endif
                      @endforeach
                    </tr>
                    </table>
                    <div style="color:green; clear:top; padding:10px 0;">সঠিক উত্তরঃ <b>{{$correct_ans}}</b></div>
                  </td>
                  @if($key % 2)
                  </tr>
                  <tr>
                  @endif
                {{-- <div class="{{$key % 2 ? 'clearfix':''}}"></div> --}}
                @endforeach
              </table>
            </div>
            <div class="clearfix"></div>
          </div><!--/.box -->
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