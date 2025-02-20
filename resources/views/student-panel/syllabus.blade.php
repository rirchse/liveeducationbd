@php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
$qcount = 0; 
@endphp

@extends('student')
@section('title', 'Syllabus')
@section('content')
<style>
  .mcqitems{list-style: none; padding-left: 10px}
  .mcqitems li{padding: 10px}
  .banner{margin-top:15px}
  .banner img{width:100%}

  .department{font-size:12px; margin: 0 auto; padding-bottom:30px}
  .dept_title{border:1px solid #ddd}
  .sub_title{border-bottom:1px solid #000}
  .chap_title{border-bottom:1px dashed #000}
  .q_number{display: inline; font-weight:bold;float:left; padding-right:10px; text-align:justify}
  .q-title{display: inline; font-size:14px}
  .mcqitems{list-style: none}
  .exp-title{font-weight: bold}
  .explain{border:1px dotted #ddd}

  @media screen and (min-width:767px){
    .department{width:850px; columns:400px 2; column-gap:30px; column-rule: 1px solid #888; }
    .mcqitems{width:380px; column-width:170px;}
  }
  /* @media screen and (min-width:768px){
    .department{width:850px; columns:400px 2; column-gap:30px; column-rule: 1px solid #888; }
  } */
</style>

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
              <a href="{{route('students.syllabus.pdf', $syllabus->id)}}" class="label label-info" title="Download"><i class="fa fa-download"></i> Download PDF </a>
              @if($syllabus->routine)
              {{-- <a target="_blank" href="{{$syllabus->routine}}" class="label label-warning" title="Download"><i class="fa fa-download"></i> Download Routine</a> --}}
              @endif
              {{-- @if($syllabus->pdf)
              <a target="_blank" href="{{$syllabus->pdf}}" class="label label-info" title="Download"><i class="fa fa-download"></i> Download PDF</a>
              @endif --}}
              {{-- <a href="#" class="label label-info" title="Print" onclick="printDiv()"><i class="fa fa-print"></i></a> --}}
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
      <div class="box" id="print">
        <div class="col-md-12">
          <div class="banner">
            <img src="{{$syllabus->banner}}" alt=""/>
          </div>
          <div class="header" style="text-align:center">
            <h2>LIVE EDUCATION BD</h2>
            <b>ব্যাচ এর নামঃ </b> {{$syllabus->batch->name}}
            {!! $syllabus->header !!} </div>
          <p style="text-align: center">Course Name: <b>{{$syllabus->course?$syllabus->course->name:''}}</b></p>
          <hr>

            <div class="department">
              @foreach($groupedData as $department => $subjects)
              <h3 class="dept_title">{{ $department }}</h3> <!-- Department Name -->

              @foreach($subjects as $subject => $chapters)
                <h4 class="sub_title"><i class="fa fa-book"></i> {{ $subject }}</h4> <!-- Subject Name -->

                @foreach($chapters as $chapter => $questions)
                 @if($chapter)
                  <h5 class="chap_title"><i class="fa fa-file"></i> {{ $chapter }}</h5> <!-- Chapter Name -->
                  @endif

                    @foreach($questions as $questionId => $questionData)
                    <div class="question">
                      <div class="q_number">প্রশ্ন {{$qcount+1}}.</div>
                      <div class="q-title">{!! $questionData['question'] !!}</div>
                      @php
                      $correct_ans = '';
                      $qcount++;
                      @endphp
                      <ul class="mcqitems">
                        @foreach($questionData['mcqs'] as $k => $mcq)
                        @php
                        if($mcq['correct_answer'])
                        {
                          $correct_ans = $source->mcqlist()[$syllabus->format][$k].' '.$mcq['item'];
                        }
                        @endphp
                        <li><span> {{$source->mcqlist()[$syllabus->format][$k]}} </span>{{$mcq['item']}}</li>
                        @endforeach
                        <div class="clearfix"></div>
                      </ul>
                      <div style="color:green; clear:top; padding:10px 0;">সঠিক উত্তরঃ <b>{{$correct_ans}}</b></div>
                      @if(isset($questionData['explain']))
                      <div class="explain"><span class="exp-title">ব্যাখ্যা-</span>{!! $questionData['explain'] !!}</div>
                      @endif
                    </div>
                    @endforeach

                @endforeach
              @endforeach
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