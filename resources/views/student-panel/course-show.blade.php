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
</style>

<div class="content-wrapper">
  <div class="container">
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
      <div class="col-md-8">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h2>{{$value->name}} <br><small>Course: <b>{{$value->course ? $value->course->name:''}}</b></small></h2>
            
          </div>
          <div class="panel-body" style="min-height: 200px">
            {!!$value->details!!}
          </div>
        </div>

        <div class="panel panel-default">
          <div class="panel-heading">
            <h4>কোর্স ইন্সট্রাক্টর</h4>
          </div>
          <div class="panel-body">
            @if($value->teachers)
              @foreach($value->teachers as $val)
              <div class="col-md-6">
                <img src="{{$val->image? $val->image:'/img/teacher.png'}}" alt="" style="max-width: 80px; padding:5px;float:left">
                <div style="display:inline">
                  <b>{{$val->name}}</b><br>
                  {{$val->designation}}
                </div>
              </div>
              @endforeach
            @endif
          </div>
        </div>
        <div class="panel panel-default">
          
          <div class="panel-body  table-responsive">
            {{-- {{dd($value->syllabus)}} --}}
            @if(!is_null($value->syllabus))
            <table class="table table-striped table-bordered">
              <tr>
                <th colspan="4"><h4>Syllabuses & Routine</h4></th>
              </tr>
              <tr>
                <th>Name</th>
                <th>Department</th>
                <th>Routine</th>
                <th>PDF</th>
              </tr>
              @foreach($value->syllabus->get() as $syllabus)
                @if(!empty($user->id) && $value->students()->where('id', $user->id)->first())
                  @if($student->departments->find($syllabus->department_id))
                  <tr>
                    <th>
                      <a href="{{route('student.syllabus', $syllabus->id)}}" class="btn btn-primary"> <i class="fa fa-book"> </i> {{$syllabus->name}}</a>
                    </th>
                    <td>{{$syllabus->department? $syllabus->department->name:''}}</td>
                    <td>@if($syllabus->routine)
                      <a target="_blank" href="{{$syllabus->routine}}" class="btn btn-warning" title="Download"><i class="fa fa-download"></i> Download Routine</a>
                      @endif</td>
                    <td>
                      @if($syllabus->pdf)
                      <a target="_blank" href="{{$syllabus->pdf}}" class="btn btn-info" title="Download"><i class="fa fa-download"></i> Download PDF</a>
                      @endif
                    </td>
                  </tr>
                  @endif
                @else
                <tr>
                  <th>
                    <a href="{{route('student.syllabus', $syllabus->id)}}" class="btn btn-primary"> <i class="fa fa-book"> </i> {{$syllabus->name}}</a>
                  </th>
                  <td>{{$syllabus->department? $syllabus->department->name:''}}</td>
                  <td>@if($syllabus->routine)
                    <a target="_blank" href="{{$syllabus->routine}}" class="btn btn-warning" title="Download"><i class="fa fa-download"></i> Download Routine</a>
                    @endif</td>
                  <td>
                    @if($syllabus->pdf)
                    <a target="_blank" href="{{$syllabus->pdf}}" class="btn btn-info" title="Download"><i class="fa fa-download"></i> Download PDF</a>
                    @endif
                  </td>
                </tr>
                @endif
              @endforeach
            </table>
            @endif
          </div>
        </div>
      </div><!-- column -->
      <div class="col-md-4">
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
        </div>
      </form>
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