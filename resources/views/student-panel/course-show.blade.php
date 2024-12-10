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
          <form action="{{route('students.course.apply')}}" method="post">
            @csrf
            <input type="hidden" name="batch_id" value="{{$value->id}}">
            <div class="panel panel-default">
              <div class="penel-heading no-padding" style="text-align: center;padding:15px">
                <img class="course-image" src="{{ $value->banner? $value->banner : '/img/course.jpg'}}" alt="" />
              </div>
              <div class="panel-heading">
                <h3> <del> &#2547;{{$source->point0($value->price)}}</del> &nbsp; <span class="label label-warning">{{$source->point0($value->discount)}} &#2547; ছাড়</span><b> &nbsp; &#2547;{{$source->point0($value->net_price)}}</b></h3>
                <p>{{$value->subtitle}}</p>
              </div>
              @if(!empty($user->id) && !$value->students()->where('id', $user->id)->first())
              <div class="panel-body">
                @if($departments->count())
                <div class="form-group">
                  <label for="">Department</label>
                  <select id="department_id" name="department_id" class="form-control" required>
                    <option value="">Select One</option>
                    @foreach($departments as $val)
                    <option value="{{$val->id}}">{{$val->name}}</option>
                    @endforeach
                  </select>
                </div>
                @else
                No Departments for The course
                @endif
              </div>
              @endif
              <div class="panel-footer">
                @if(!empty($user->id) && $value->students()->where('id', $user->id)->first())
                <button class="btn btn-success btn-block" disabled>আপনি কোর্সটি কিনেছেন</button>
                @else
                <button class="btn btn-success btn-block btn-lg" onsubmit="return confirm('Double check you provided information.')">কোর্সটি কিনুন</button>
                @endif
                <div class="clearfix"></div>
              </div>
              <div class="panel-body">
                <h3>এই কোর্সে যা থাকছে</h3>
                {!! $value->what_is !!}</div>
            </div>
          </form>
          <div class="clearfix"></div>
        </div>
        <div class="col-md-8 info">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h2>{{$value->name}} <br><small>Course: <b>{{$value->course ? $value->course->name:''}}</b></small></h2>
              
            </div>
            <div class="panel-body" style="min-height: 200px">
              {!!$value->short!!}
            </div>
          </div>
  
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4>কোর্স ইন্সট্রাক্টর</h4>
            </div>
            <div class="panel-body">
              <div class="row">
                @if($value->teachers)
                  @foreach($value->teachers as $val)
                  <div class="col-md-6">
                    <div class="image">
                      <img src="{{$val->image? $val->image:'/img/teacher.png'}}" alt="" style="max-width: 80px; padding:5px; float:left; padding-right: 15px">
                    </div>
                    <div>
                      <b style="font-size:16px">{{$val->name}}</b><br>
                      {{$val->designation}}
                    </div>
                    <div class="clearfix"></div>
                  </div>
                  @endforeach
                @endif
              </div>
            </div>
          </div>
          <div class="panel panel-default">
            <div class="panel-heading"><h3>কোর্সটি করে যা শিখবেন</h3></div>
            <div class="panel-body">{!! $value->learn !!}</div>
          </div>
          <div class="panel panel-default">
            <div class="panel-heading"><h3>ক্লাস রুটিন</h3></div>
            <div class="panel-body">{!! $value->routine !!}</div>
          </div>
          <div class="panel panel-default">
            <div class="panel-heading"><h3>কোর্স সিলেবাস</h3></div>
            @if($value->departments)
            <div class="box-group" id="accordion">
              @foreach($value->departments as $key => $department)
              <div class="panel box box-primary">
                <div class="box-header with-border">
                  <div class="box-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#dept{{$key}}">{{$department->name}}</a></div>
                </div>
                <div id="dept{{$key}}" class="panel-collapse collapse">
                  <div class="box-body">
                    @if($department->syllabus)
                    <table class="table table-bordered">
                      <tr>
                        <td><b><a href="{{route('student.syllabus', $department->syllabus->id)}}">{{$department->syllabus->name}}</a></b></td>
                        <td>Routine <a href="{{$department->syllabus->routine}}" class="btn btn-warning"><i class="fa fa-download"></i></a></td>
                        <td>PDF <a href="{{$department->syllabus->pdf}}" class="btn btn-info"><i class="fa fa-download"></i></a></td>
                      </tr>
                    </table>
                    @else
                    <p>এই ডিপার্টমেন্টের জন্যে এখনো কোন সিলেবাস প্রকাশিত হয় নি</p>
                    @endif
                  </div>
                </div>
              </div>
              @endforeach
            </div>
            @endif
            
          </div>
          <div class="panel panel-default">
            <div class="panel-heading"><h3>কোর্স সম্পর্কে বিস্তারিত</h3></div>
            <div class="panel-body">{!! $value->details !!}</div>
          </div>
          <div class="panel panel-default">
            <div class="panel-heading"><h3>সচরাচর জিজ্ঞাসা</h3></div>
            <div class="panel-body">{!! $value->faq !!}</div>
          </div>
        </div><!-- column -->
      </div>
    </section> <!-- /.content -->
  </div> <!-- /.container -->
</div>

<script>
  window.location.hash = "no-back-button";

    // Again because Google Chrome doesn't insert
    // the first hash into the history
    window.location.hash = "Again-No-back-button"; 

    window.onhashchange = function(){
        window.location.hash = "no-back-button";
    }
</script>
@endsection