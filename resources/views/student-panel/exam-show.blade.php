@php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
$user = Auth::guard('student')->user();
@endphp
@extends('student')
@section('title', 'Course')
@section('content')
{{-- <script src='https://www.google.com/recaptcha/api.js' async defer></script> --}}
<style>
  .checkbox{padding-left: 25px}
  .panel ::-webkit-scrollbar{width: 5px;}
  ::-webkit-scrollbar-thumb{background-color: #ddd}
  .mcqitems{list-style: none; padding-left: 10px}
  .mcqitems li{padding:5px; margin: 10px; max-width: 300px;}
  .mcqitems li label{ display: bl/ock;border-radius: 15px;border:1px solid #ddd; padding: 5px 15px; color: #444; cursor: pointer; font-weight: normal; min-width: 300px;}
  .mcqitems li input[type="radio"]{width: 20px;height: 20px; margin-right: 5px; padding-top:5px}
  .mcqitems li span{vertical-align: top}
  .banner{margin-top:15px}
  .banner img{width:100%}
  .timer{font-weight: bold; font-size: 20px; text-align: center; color:#666; border:2px solid; border-radius:10px}
  .time span{ border:2px solid #444; color:ddd}
  .sticky{position: fixed; top:7%; left: 0; right: 0; z-index: 999999;}
  #fixed{text-align: center}
  .selected{background:lightblue;}
</style>

<div class="content-wrapper">
  <div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="row">
        <div class="box box-info" id="fixed">
          <div class="col-xs-4">
            Questions: <b>50</b>
          </div>
          <div class="col-xs-4">
            <div class="timer"><span id="timer">00:00</span></div>
          </div>
          <div class="col-xs-4">
            Solved: <b>50</b>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="box col-md-12">
          <div class="banner"><img src="{{$paper->banner}}" alt=""></div>
          <div class="header" style="text-align:center">{!! $paper->header !!} </div>
          @if($paper->details)
          <div class="col-md-12 indication">
            <p>"{!! $paper->details !!}"</p><br>
          </div>
          @endif
        </div>
        <div class="col-md-12 no-padding">
          @foreach($paper->questions as $key => $value)
          <div class="panel panel-default">
            <div class="panel-heading" style="background-color:none">
              <div style="display: inline; font-weight:bold;float:left; padding-right:5px">প্রশ্ন {{$key+1}}.</div>
              <div style="display: inline;text-align:justify">{!! $value->title !!}</div>
            </div>
            <ul class="mcqitems" id="{{$value->id}}">
              @foreach($value->mcqitems as $k => $val)
              <li>
                <label for="correct{{$value->id.$val->id}}" class="">
                  <input onchange="select(this)" type="radio" name="correct{{$value->id}}" id="correct{{$value->id.$val->id}}" />
                  <span> {{$source->mcqlist()[$paper->format][$k]}} {{$val->item}}</span>
                </label>
              </li>
              @endforeach
            </ul>
          </div>
          @endforeach
        </div> <!--/.col -->
        <div class="col-md-12">
          <button class="btn btn-info pull-right">Submit</button>
        </div>
      </div><!-- /.row -->
    </section> <!-- /.content -->

  </div> <!-- /.container -->
</div> <!-- /.content-wrapper -->
@endsection
@section('scripts')
<script>
  // Set the date we're counting down to
  // var countDownDate = new Date("Oct 27, 2024 12:47:25").getTime();
  var countDownDate = new Date("{{$source->dtcformat($paper->open)}}").getTime();
  
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
      
    // If the count down is over, write some text 
    if (distance < 0) {
      clearInterval(x);
      document.getElementById("timer").innerHTML = '<span style="color:#d00">সময় শেষ</span>';
    }
  }, 1000);

  // navbar fixed on scroll
  window.onscroll = function(){
    let filterParent = document.getElementById('fixed');
    if(document.body.scrollTop >= 100 || document.documentElement.scrollTop >= 100)
    {
      filterParent.classList.add('sticky');
    }
    else
    {
      filterParent.classList.remove('sticky');
    }
  }

  // select mcq items
  function select(e)
  {
    let items = e.parentNode.parentNode.children;
    console.log(items);
  
    for(let x = 0; items.length > x; x++)
    {
      if(items[x].firstElementChild.firstElementChild.checked == true)
      {
        e.classList.add('selected');
      }
      else
      {
        e.classList.remove('selected');
      }
      console.log(items[x].firstElementChild.firstElementChild.checked == true);
      console.log(x);

    }
  }
  </script>
@endsection