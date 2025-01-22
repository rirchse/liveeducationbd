@php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
$user = Auth::guard('student')->user();
$value = $paper;
@endphp

@extends('student')
@section('title', 'পরীক্ষা সমূহ')
@section('content')
<style>
  .checkbox{padding-left: 25px}
  .cst-btn{margin-bottom:10px}
</style>

  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> পরীক্ষা সমূহ {{-- <small>পরীক্ষা সমূহple 2.0</small> --}} </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> হোম</a></li>
      <li><a href="#">পরীক্ষা সমূহ</a></li>
      {{-- <li class="active">Top Navigation</li> --}}
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
      <div class="col-md-6 col-md-offset-3">
        @if(isset($check['scheduled']) && $value->status == 'Scheduled')
        <div class="panel panel-warning">
          <div class="panel-heading">
            <b>Exam No. {{$value->name}}</b>
          </div>
          <div class="panel-body">
            <p> পরীক্ষা সময় <b>{{ $source->dtformat($value->open) }}</b> </p>
            <b><span id="timer" style="font-size:20px; font-wieght:bold"></span></b> পরে পরীক্ষা শুরু হবে
          </div>
          <div class="panel-footer">
            <a class="btn btn-info pull-right" href="{{route('students.exam', $value->id)}}">Back</a>
            <div class="clearfix"></div>
          </div>
        </div>

        @elseif(isset($check['result-exam']))
        <div class="panel panel-warning">
          <div class="panel-heading">
            <b>Exam No. {{$value->name}}</b>
          </div>
          <div class="panel-footer">
            @if($value->exam)
              <a href="{{route('students.result', $value->id)}}" class="btn btn-warning cst-btn">ফলাফল দেখুন</a>
              @endif
              @if($value->close && $value->close < date('Y-m-d H:i:s'))
              পরীক্ষার সময় শেষ ...
              @else
              <a class="btn btn-info cst-btn" href="{{route('students.instruction', $value->id)}}">পরীক্ষা দিন</a>
              @endif
          </div>
        </div>

        @elseif($value->status == 'Published')
        <div class="panel panel-warning">
          <div class="panel-heading">
            <b>Exam No. {{$value->name}}</b>
          </div>
          <div class="panel-body">
            <p>{!! $value->details !!}</p>
        </div>
          <div class="panel-footer">
            <a class="btn btn-info pull-right" href="{{route('students.exam.show', $value->id)}}">শুরু করুন</a>
            <div class="clearfix"></div>
          </div>
        </div>
        @endif
      </div>
  </section> <!-- /.content -->

<script>
  // Set the date we're counting down to
  // var countDownDate = new Date("Oct 27, 2024 12:47:25").getTime();
  var countDownDate = new Date("{{$source->dtcformat($value->open)}}").getTime();
  // var countDownDate = new Date().getTime();
  
  // Update the count down every 1 second
  var x = setInterval(function() {
  
    // Get today's date and time
    var now = new Date().getTime();
    // var now = new Date("{{$source->dtcformat($paper->close)}}").getTime();
      
    // Find the distance between now and the count down date
    var distance = countDownDate - now;
      
    // Time calculations for days, hours, minutes and seconds
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
      
    // Output the result in an element with id="demo"
    let d = h = m = s = '';
    if(days != 0)
    {
      d = days+"d ";
    }
    if(hours != 0)
    {
      h = hours+" : ";
    }
    if(minutes != 0)
    {
      m = minutes+" :";
    }
    if(seconds != 0)
    {
      s = seconds+" ";
    }
    // document.getElementById("timer").innerHTML = hours + "h "
    // + minutes + "m " + seconds + "s ";
    document.getElementById("timer").innerHTML = d + " " + h + " "
    + m + " " + s + " ";

    // console.log(distance);
      
    // If the count down is over, write some text 
    if (distance < 60000 && distance > 59000) {
      // alert('10 Seconds Left!');
      document.getElementById('timer').style.color='red';

    }
    if (distance < 0)
    {      
      // submit the form automatically
      // submitExam();

      clearInterval(x);
      document.getElementById("timer").innerHTML = '<span style="color:#d00">অনুগ্রহ পূর্বক অপেক্ষা করুন...</span>';
      // document.getElementById('questions_panel').innerHTML = '<div class="box box-warning"><a class="btn btn-warning" href="{{route("students.exam")}}">Back</div>';
        updatePaper();
    }
  }, 1000);

  // update paper by ajax
  function updatePaper()
  {
    $.ajax({
      type : 'GET',
      url : '{{route("paper.update.ajax", "$value->id")}}',
      success : function(data){
        console.log(data);
        if(data.success == true)
        {
          window.location.href = '{{route("students.instruction", $value->id)}}';
        }
      },
      error : function(data){
        console.log(data);
      }
    });
  }
</script>
@endsection