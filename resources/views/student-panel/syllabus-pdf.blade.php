@php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>Syllabus</title>
  <style type="text/css">
    @font-face{
      font-family: "Siyamrupali";
      font-style: normal;
      font-weight: normal;
      src : url("/resources/fonts/Siyamrupali.ttf") format('truetype');
    }
    /* .custom-font{
      font: normal 20px/18px 'Siyamrupali';
    } */
    .mcqitems{list-style: none; padding-left: 10px}
    .mcqitems li{padding: 10px}
    .banner{margin-top:15px}
    .banner img{width:100%}

    body {
      margin: 0;
      font-size: 85%;
      font-family: 'solaimanLipi', sans-serif;
    }
  </style>
</head>
<body>

<div class="content-wrapper">
  <div class="container">
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 style="text-align: center; font-family: Tahoma">Syllabus</h1>
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
            <hr>
            <table style="width: 100%">
              <tr>
              @foreach($syllabus->questions as $key => $value)
                <td>
                  <div style="display: inline; font-weight:bold;float:left; padding-right:10px; text-align:justify;">প্রশ্ন {{$key+1}}.</div>
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
                    <td style="padding:10px">
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
</div> <!-- /.container -->
</div>
  
</body>
</html>