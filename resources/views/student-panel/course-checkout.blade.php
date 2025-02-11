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
@section('title', 'Course-Checkout')
@section('content')
{{-- <script src='https://www.google.com/recaptcha/api.js' async defer></script> --}}
<style>
  .checkbox{padding-left: 25px}
  .panel ::-webkit-scrollbar{width: 5px;}
  ::-webkit-scrollbar-thumb{background-color: #ddd}
  .course-image{width:100%}
  .teacher-title p{margin:0}
  .box-title {display: block;width:100%}
  /* @media(min-width: 769px){
    .pricing{float: right;}
    .info{}
  }
  @media(max-width: 768px){
    .pricing{}
    .info{}
  } */
</style>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1> Course Checkout {{-- <small>Courseple 2.0</small> --}} </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Course</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-6 col-md-offset-3 pricing">
          <!-- Apply to the course -->
          <form action="{{route('students.course.apply')}}" method="post">
            @csrf
            <div class="panel panel-default">
              <div class="panel-heading no-padding" style="text-align: center;padding:15px">
                {{-- <img class="course-image" src="{{ $value->banner? $value->banner : '/img/course.jpg'}}" alt="" /> --}}
              </div>
            <div class="panel-header">
              <h3 style="padding:0 15px">{{$value->name}}</h3>
            </div>
            <div class="panel-body">
                <input type="hidden" name="student_id" value="{{$user ? $user->id : null}}">
                <input type="hidden" name="batch_id" value="{{$value->id}}">
                
                <input type="hidden" name="name" value="{{$student? $student->name:''}}" />
                <input type="hidden" name="email" value="{{$student? $student->email:''}}" />
                <input type="hidden" name="phone" value="{{$student? $student->contact:''}}" />
                <input type="hidden" name="address1" value="" />
                <input type="hidden" name="total" value="{{$value->net_price}}" />
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
                  <br>
                @if(!empty($user->id) && !$value->students()->where('id', $user->id)->first())
                <div class="table-responsive">
                  <table class="table">
                    <tr>
                      <td>ডিপার্টমেন্ট নির্বাচন করুন </td>
                      <th>
                        @if(!empty($user->id) && !$value->students()->where('id', $user->id)->first())
                          @if($departments->count())
                            <select id="department_id" name="department_id" class="form-control" required>
                              <option value="">Select One</option>
                              @foreach($departments as $val)
                              <option value="{{$val->id}}">{{$val->name}}</option>
                              @endforeach
                            </select>
                          @else
                          No Departments for The course
                          @endif
                        @endif</th>
                    </tr>
                    <tr>
                      <td>কোর্সটির মূল্য </td>
                      <th>&#2547; {{$source->point0($value->net_price)}}</th>
                    </tr>
                    <tr>
                      <td>অন্যান্য ফী </td>
                      <th>&#2547; 0</th>
                    </tr>
                    <tr style="font-size:18px">
                      <th>মোট =</th>
                      <th>&#2547; {{$source->point0($value->net_price)}}</th>
                    </tr>
                  </table>
                @endif
                </div>
              </div>
              <div class="panel-footer">
      
                {{-- <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button> --}}
                @if(!empty($user->id) && $value->students()->where('id', $user->id)->first())
                <h4>আপনি কোর্সটি কিনেছেন</h4>
                <a class="btn btn-info" href="{{route('students.my-course')}}">আমার কোর্স এ ফিরে যান</a>
                
                @else
                
                <button class="btn btn-primary btn-block btn-lg" onsubmit="return confirm('Double check you provided information.')">পেমেন্ট এর জন্য এগিয়ে যান</button>
                @endif
                <div class="clearfix"></div>
              </div>
            </div>
          </form>
          <div class="clearfix"></div>
        </div>
      </div>
    </section> <!-- /.content -->
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