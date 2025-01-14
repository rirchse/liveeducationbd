@php
use \App\Http\Controllers\SourceCtrl;
$source = new SourceCtrl;
$user = Auth::guard('student')->user();
$student = [];
if($user)
{
  $student = \App\Models\Student::find($user->id);
}
$value = $batch;
@endphp
@extends('student')
@section('title', 'Course')
@section('content')
{{-- <script src='https://www.google.com/recaptcha/api.js' async defer></script> --}}
<style>
  .checkbox{padding-left: 25px}
  .panel ::-webkit-scrollbar{width: 5px;}
  ::-webkit-scrollbar-thumb{background-color: #ddd}
  .course-image{width:100%}
  .teacher-title p{margin:0}
  .box-title {display: block;width:100%}
  @media(min-width: 769px){
    .pricing{float: right;}
    .info{}
  }
  @media(max-width: 768px){
    .pricing{}
    .info{}
  }
</style>

<div class="content-wrapper">
  <div class="container no-padding">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1> Course {{-- <small>Courseple 2.0</small> --}} </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Course</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-4 pricing">
          <!-- Apply to the course -->
          <form action="{{route('payment.proceed')}}" method="post">
            @csrf
            <input type="hidden" name="batch_id" value="{{$value->id}}">
            
            <input type="hidden" name="name" value="{{$student->name}}" />
            <input type="hidden" name="email" value="{{$student->email}}" />
            <input type="hidden" name="phone" value="{{$student->contact}}" />
            <input type="hidden" name="address1" value="" />
            <input type="hidden" name="total" value="{{$value->net_price}}" />
            <div class="panel panel-default">
              <div class="penel-heading no-padding" style="text-align: center;padding:15px">
                <img class="course-image" src="{{ $value->banner? $value->banner : '/img/course.jpg'}}" alt="" />
              </div>
              <div class="panel-heading">
                <h3>
                  @if($value->discount) 
                  <del> &#2547;{{$source->point0($value->price)}}</del> &nbsp; <span class="label label-warning"> &#2547;{{$source->point0($value->discount)}} ছাড়</span>
                  @endif
                  <b> &nbsp; &#2547;{{$source->point0($value->net_price)}}</b>
                  </h3>
                  @if($value->offer_end_at)
                  <p style="color: red">ডিস্কাউন্ট অফারের মেয়াদ <b>{{$source->dtformat($value->offer_end_at)}}</b></p>
                  @endif
                <p>{{$value->subtitle}}</p>
              </div>
              @if(!empty($user->id) && !$value->students()->where('id', $user->id)->first())
              <div class="panel-body table-responsive">
                <table class="table">
                  <tr>
                    <td>আপনার নির্বাচিত ডিপার্টমেন্ট</td>
                    <th>{{$department->name}}</th>
                  </tr>
                  <tr>
                    <td>কোর্সটির মূল্য </td>
                    <th>&#2547; {{$value->net_price}}</th>
                  </tr>
                  <tr>
                    <td>অন্যান্য ফী </td>
                    <th>&#2547; 0</th>
                  </tr>
                  <tr>
                    <th>মোট =</th>
                    <th>&#2547; {{$value->net_price}}</th>
                  </tr>
                </table>
              </div>
              @endif
              <div class="panel-footer">
                  <button class="btn btn-warning btn-block btn-lg" onsubmit="return confirm('Double check you provided information.')">&#2547; {{$value->net_price}} পেমেন্ট করুন</button>
                <div class="clearfix"></div>
              </div>
            </div>
          </form>
          <div class="clearfix"></div>
        </div>
        <div class="col-md-8 info">
          <div class="panel panel-info">
            <div class="panel-heading">
              <h3>{{$value->name}} <br><small>Course: <b>{{$value->course ? $value->course->name:''}}</b></small></h3>
              @if($value->reg_end_at)
              <p style="text-align: center; color:red">রেজিস্ট্রেশনের মেয়াদ  আছে: <b><span id="timer"></span></b>
              </p>
              @endif
            </div>
            <div class="panel-body" style="min-height: 200px">
              {!!$value->short!!}
            </div>
          </div>
          
          <div class="panel panel-warning">
            <div class="panel-heading"><h4>কোর্সটির মেয়াদ ও অন্যান্য</h4></div>
            <div class="panel-body table-responsive">
              <table class="table table-bordered">
                @if($value->start_at)
                <tr>
                  <td>কোর্সটি শুরু হয়েছে</td>
                  <th>{{$source->dformat($value->start_at)}}</th>
                </tr>
                @endif
                @if($value->end_at)
                <tr>
                  <td>কোর্সটি শেষ হবে</td>
                  <th>{{$source->dformat($value->end_at)}}</th>
                </tr>
                @endif
                @if($value->reg_end_at)
                <tr>
                  <td>রেজিস্ট্রেশনের মেয়াদ শেষ হবে</td>
                  <th>{{$source->dtformat($value->reg_end_at)}}</th>
                </tr>
                @endif
                @if($value->offer_end_at)
                <tr>
                  <td>বর্তমান অফারের মেয়াদ</td>
                  <th>{{$source->dtformat($value->offer_end_at)}}</th>
                </tr>
                @endif
              </table>
            </div>
          </div>
        </div><!-- column -->
      </div>
    </section> <!-- /.content -->
  </div> <!-- /.container -->
</div>
@endsection
@section('scripts')
<script>
  // Set the date we're counting down to
  // var countDownDate = new Date("Oct 27, 2024 12:47:25").getTime();
  var countDownDate = new Date("{{$source->dtcformat($value->reg_end_at)}}").getTime();
  // var countDownDate = new Date().getTime();
  
  // Update the count down every 1 second
  var x = setInterval(function()
  {
    let timer = document.getElementById("timer");
  
    // Get today's date and time
    var now = new Date().getTime();
    // var now = new Date("{{$source->dtcformat($value->end_time)}}").getTime();
      
    // Find the distance between now and the count down date
    var distance = countDownDate - now;
      
    // Time calculations for days, hours, minutes and seconds
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
      
    // Output the result in an element with id="demo"
    let d = h = m = s = 0;
    if(days != 0)
    {
      d = days+" ";
    }
    if(hours != 0)
    {
      h = hours+" ";
    }
    if(minutes != 0)
    {
      m = minutes+" ";
    }
    if(seconds != 0)
    {
      s = seconds+" ";
    }
    // timer.innerHTML = hours + "h "
    // + minutes + "m " + seconds + "s ";
    if(m != null || s != null)
    {
    timer.innerHTML = d + "দিন " + h + "ঘণ্টা "
    + m + "মিনিট " + s + "সেকেন্ড ";
    }
    else
    {
      timer.innerHTML = '00:00:00';
    }

    // console.log(distance);
      
    // If the count down is over, write some text 
    if (distance < 60000 && distance > 59000)
    {
      timer.style.color='red';

    }

    if (distance < 0) {
      clearInterval(x);
      timer.innerHTML = '<span style="color:#d00">সময় শেষ</span>';
      // document.getElementById('questions_panel').innerHTML = '<div class="box box-warning"><a class="btn btn-warning" href="{{route("students.exam")}}">Back</div>';
      // submit the form automatically
      // submitExam();
    }
  }, 1000);
</script>
@endsection