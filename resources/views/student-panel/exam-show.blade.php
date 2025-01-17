@php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
$user = Auth::guard('student')->user();
$end_time = date('Y-m-d H:i:s', strtotime('+'.$paper->time.' minutes', strtotime(date('Y-m-d H:i:s'))));
$questions = $paper->questions;
if($paper->random == 'Yes')
{
  // $questions = $paper->questions()->inRandomOrder()->get();
}
$start_at = strtotime(date('Y-m-d H:i:s'));
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
  .mcqitems li{padding:5px; max-width: 300px;}
  .mcqitems li:first-child{margin-top:10px}
  .mcqitems li label{ display: bl/ock;border-radius: 15px;border:1px solid #ddd; padding: 5px 15px; color: #444; cursor: pointer; font-weight: normal; max-width: 300px; width: 100%}
  .mcqitems li input[type="radio"]{width: 20px;height: 20px; margin-right: 5px; padding-top:5px}
  .mcqitems li span{vertical-align: top}
  .banner{margin-top:15px}
  .banner img{width:100%}
  .timer{font-weight: bold; font-size: 20px; text-align: center; color:#666; border:2px solid; border-radius:10px}
  .time span{ border:2px solid #444; color:ddd}
  .sticky{position: fixed; top:50px; left: 0; right: 0; z-index: 999999;}
  #fixed{text-align: center}
  .selected{background:lightblue;}
  .result table th{text-align: right}
</style>

{{-- <div class="content-wrapper">
  <div class="container"> --}}
    <!-- Content Header (Page header) -->
    <section class="content-header"></section>

    <!-- Main content -->
    <section class="content" id="content">
      @if(!empty($result))
      <div class="row">
        @foreach($exams as $value)
        <div class="col-md-4 result" id="result">
          <div class="panel panel-default">
            <img src="/img/paper-banner.png" alt="" style="width:100%">
            <div class="panel-heading no-padding">
              <h3 style="text-align: center">Exam: {{$value->id}} > Result</h3>
            </div>
            <div class="panel-body">
              <table class="table table-bordered">
                {{-- <tr>
                  <th colspan="2" style="text-align: center">Exam & Candidate Details</th>
                </tr>
                <tr>
                  <td>Candidate</td>
                  <th id="question">{{$value->max}}</th>
                </tr> --}}
                <tr>
                  <th colspan="2" style="text-align: center">Result Summary</th>
                </tr>
                <tr>
                  <td>Exam Name</td>
                  <th id="question">{{$value->name}}</th>
                </tr>
                <tr>
                  <td>Exam No.</td>
                  <th id="question">{{$value->name}}</th>
                </tr>
                <tr>
                  <td>Start Time</td>
                  <th id="question">{{$value->max}}</th>
                </tr>
                <tr>
                  <td>End Time</td>
                  <th id="question">{{$value->max}}</th>
                </tr>
                <tr>
                  <td>Total Questions</td>
                  <th id="question">{{$value->max}}</th>
                </tr>
                <tr>
                  <td>Answered</td>
                  <th id="answer">{{$value->answer}}</th>
                </tr>
                <tr>
                  <td>Correct</td>
                  <th id="correct">{{$value->correct}}</th>
                </tr>
                <tr>
                  <td>Wrong</td>
                  <th id="wrong">{{$value->wrong}}</th>
                </tr>
                <tr>
                  <td>No Answered</td>
                  <th id="no_answer">{{$value->no_answer}}</th>
                </tr>
                <tr>
                  <td>Mark for per right answer</td>
                  <th id="marks">{{$value->mark}}</th>
                </tr>
                <tr>
                  <td>Negative Mark for per wrong answer</td>
                  <th id="marks">{{$value->mark}}</th>
                </tr>
                <tr>
                  <td>Score</td>
                  <th id="marks">{{$value->mark}}</th>
                </tr>
                <tr>
                  <td>Result Percentage</td>
                  <th id="marks">{{$value->mark}}</th>
                </tr>
                <tr>
                  <td>Final Result</td>
                  <th id="marks">{{$value->mark}}</th>
                </tr>
              </table>
            </div>
            <div class="panel-footer">
              <p style="text-align: center">
                <a href="{{route('students.exam')}}"><i class="fa fa-arrow-left"></i> Back</a>
              </p>
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
        @endforeach
        
        {{-- <div class="box box-danger" style="text-align: center">
          <h4>No Exam Available</h4>
          <p><a href="{{route('students.exam')}}"><i class="fa fa-arrow-left"></i> Back</a></p>
        </div> --}}
        <div class="col-md-6 col-md-offset-3">
          <div class="panel panel-heading">
            <h4>Solution</h4>
          </div>
          @foreach($paper->questions as $key => $value)
          <div class="panel panel-default">
            <div class="panel-heading" style="background-color:none">
              <div style="display: inline; font-weight:bold;float:left; padding-right:5px">প্রশ্ন {{$key+1}}.</div>
              <div style="display: inline;text-align:justify">{!! $value->title !!}</div>
            </div>
            <ul class="mcqitems" id="{{$value->id}}">
              @foreach($value->mcqitems as $k => $val)
              <li>
                <label class="">
                  <input onclick="answer(this)" type="radio" name="{{$value->id}}" id="{{$value->id.$val->id}}" check="0" value="{{$val->id}}"/>
                  <span> {{$source->mcqlist()[$paper->format][$k]}} {{$val->item}}</span>
                </label>
              </li>
              @endforeach
            </ul>
          </div>
          @endforeach
        </div>
      </div>
      @else
        @if($exam)
        <div class="row">
          <div class="box box-info" id="fixed">
            <div class="col-xs-4">
              Questions: <b>{{$paper->questions->count()}}</b>
            </div>
            <div class="col-xs-4">
              <div class="timer"><span id="timer">00:00</span></div>
            </div>
            <div class="col-xs-4">
              Solved: <b id="solved">0</b>
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
        <div class="row" id="questions_panel">
          <div class="banner"><img src="{{$paper->banner}}" alt=""/></div>
          <div class="box col-md-12">
            <div class="header" style="text-align:center">{!! $paper->header !!} </div>
            <p style="text-align: center;width:100%;font-weight:bold;padding-bottom:15px">Exam No: {{$paper->name}}</p>
          </div>
          <div class="col-md-12 no-padding" id="questions-area">
            @foreach($questions as $key => $value)
            <div class="panel panel-default {{$paper->display == 'One' && $key != 0? 'hide':''}}">
              <div class="panel-heading" style="background-color:none">
                <div style="display: inline; font-weight:bold;float:left; padding-right:5px">প্রশ্ন {{$key+1}}.</div>
                <div style="display: inline;text-align:justify">{!! $value->title !!}</div>
              </div>
              <ul class="mcqitems" id="{{$value->id}}">
                @foreach($value->mcqitems as $k => $val)
                <li>
                  <label class="">
                    <input onclick="answer(this)" type="radio" name="{{$value->id}}" id="{{$value->id.$val->id}}" check="0" value="{{$val->id}}"/>
                    <span> {{$source->mcqlist()[$paper->format][$k]}} {{$val->item}}</span>
                  </label>
                </li>
                @endforeach
              </ul>
              @if($paper->display == 'One')
              <div class="panel-footer">
                <button class="btn btn-success" onclick="showNextQuestion(this)">Next <i class="fa fa-long-arrow-right"></i></button>
              </div>
              @endif
            </div>
            @endforeach
          </div> <!--/.col -->
          <button class="btn btn-info pull-right" onclick="submitExam()">Submit</button>
        </div><!-- /.row -->
        @else
        <p>We are getting trouble to sit you to the exam, right now. Please try again later. <a href="{{route('students.exam')}}">Go back to the exam page</a></p>
        @endif
      @endif
    </section> <!-- /.content -->

  {{-- </div> <!-- /.container -->
</div> <!-- /.content-wrapper --> --}}
@endsection
@section('scripts')
<script>
  //show next question
  function showNextQuestion(e)
  {
    let questionArea = document.getElementById('questions-area');
    e.parentNode.parentNode.classList.add('hide');
    if(e.parentNode.parentNode.nextElementSibling)
    {
      e.parentNode.parentNode.nextElementSibling.classList.remove('hide');
    }
    else
    {
      questionArea.innerHTML = '<div class="panel panel-default"> <div class="panel-body"> Exam Completed. You can Submit now! </div></div>';
    }
    // console.log(e.parentNode.parentNode.nextElementSibling);
  }
  
  // Set the date we're counting down to
  // var countDownDate = new Date("Oct 27, 2024 12:47:25").getTime();
  var countDownDate = new Date("{{$source->dtcformat($end_time)}}").getTime();
  // var countDownDate = new Date().getTime();
  
  // Update the count down every 1 second
  var x = setInterval(function() {
  
    // Get today's date and time
    var now = new Date().getTime();
    // var now = new Date("{{$source->dtcformat($end_time)}}").getTime();
      
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
      submitExam();

      clearInterval(x);
      document.getElementById("timer").innerHTML = '<span style="color:#d00">সময় শেষ</span>';
      document.getElementById('questions_panel').innerHTML = '<div class="box box-warning"><a class="btn btn-warning" href="{{route("students.exam")}}">Back</div>';
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
  let parentIds = [];
  function answer(e)
  {
    const parent = e.parentNode.parentNode.parentNode;
    const items = parent.children;
    
    let solved = document.getElementById('solved');
    let parenId = parent.getAttribute('id');
    if(e.getAttribute('check') == 0)
    {
      e.checked = true;
      e.setAttribute('check', 1);
      if(!parentIds.includes(parenId))
      {
        solved.innerHTML = Number(solved.innerHTML) + 1;
        parentIds.push(parenId);
      }
    }
    else
    {
      e.checked = false;
      e.setAttribute('check', 0);
      solved.innerHTML = Number(solved.innerHTML) - 1;
      parentIds.splice(parentIds.indexOf(parenId))
    }

    for(let x = 0; x < items.length; x++)
    {
      if(items[x].firstElementChild.firstElementChild.checked == true)
      {
        items[x].firstElementChild.firstElementChild.setAttribute('check', 1);
        items[x].firstElementChild.classList.add('selected');
      }
      else
      {
        items[x].firstElementChild.firstElementChild.setAttribute('check', 0);
        items[x].firstElementChild.classList.remove('selected');
      }
    }
  }

  // submit exam
  function submitExam()
  {
    let qids =[];
    let mcqids = [];
    let mcqitems = document.getElementsByClassName('mcqitems');
    for(let x = 0; x < mcqitems.length; x++)
    {
      for(let y = 0; y < mcqitems[x].children.length; y++)
      {
        if(mcqitems[x].children[y].firstElementChild.firstElementChild.checked == true)
        {
          let choice = mcqitems[x].children[y].firstElementChild.firstElementChild;
          qids.push(Number(choice.name));
          mcqids.push(Number(choice.value));
        }
      }
    }

    // console.log(mcqids);

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

    let formData = new FormData();
    formData.append('paper_id', '{{$paper->id}}');
    formData.append('exam_id', '{{$exam->id}}');
    formData.append('question_id', qids);
    formData.append('mcq_id', mcqids);
    formData.append('start_at', '{{$start_at}}');

    $.ajax({
      url: '{{route("student.exam.add")}}',
      type: 'POST',
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      success: function(data){
        // console.log(data);
        if(data.success == true)
        {
          let content = document.getElementById('content');
          let result_hidden = document.getElementById('result_hidden');
          let question = document.getElementById('question');
          let answer = document.getElementById('answer');
          let correct = document.getElementById('correct');
          let wrong = document.getElementById('wrong');
          let no_answer = document.getElementById('no_answer');
          let marks = document.getElementById('marks');
          let message = document.getElementById('message');
          let msg = 'পরীক্ষা সম্পূর্ণ হয়েছে, পরবর্তী ধাপে যাওয়ার জন্য ok করুন';

          if(data.message != null)
          {
            msg = data.message;
          }

          alert(msg);
          // content.innerHTML = result_hidden.innerHTML;
          window.location.href = '{{route("students.result", [$paper->id, "after"])}}';
        }
        // qcount.innerHTML = data.qcount.attached.length;
        // loading.classList.add('hide');
      },
      error: function(data){
        console.log(data);
      },
    });
    // console.log(qids);
  }

  // show result
  function showResult($data)
  {
    let content = document.getElementById('content');
    //
  }
  
  </script>

  <script type="text/javascript">
  document.addEventListener("keydown", function (e)
  {
    if ((e.ctrlKey && e.key === 'r') || e.key === 'F5')
    {
      e.preventDefault();
      alert("Page reload is disabled.");
    }
  });

  //reload block
  // window.onbeforeunload = function() { return "Your work will be lost."; };
//   window.addEventListener("beforeunload", function (e) {
//     e.preventDefault();
//     e.returnValue = ''; // Required for most browsers.
// });

//back button navigation is disabled
history.pushState(null, null, window.location.href);
window.onpopstate = function () {
    history.pushState(null, null, window.location.href);
    alert("Back button navigation is disabled.");
};

  </script>
  {{-- <script type="text/javascript">
    function disableF5(e) { if ((e.which || e.keyCode) == 116 || (e.which || e.keyCode) == 82) e.preventDefault(); };
    
    $(document).ready(function(){
         $(document).on("keydown", disableF5);
    });
    </script> --}}
@endsection