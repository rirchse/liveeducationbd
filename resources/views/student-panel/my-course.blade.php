@php
$student = [];
$departments_ids = [];
$user = Auth::guard('student')->user();
if($user)
{
  $student = \App\Models\Student::find($user->id);
  $departments_ids = $student->departments->pluck('id')->toArray();
}
// dd($student->departments->pluck('id')->toArray());
@endphp

@extends('student')
@section('title', 'আমার কোর্স সমূহ')
@section('content')
{{-- <script src='https://www.google.com/recaptcha/api.js' async defer></script> --}}
<style>
  .checkbox{padding-left: 25px}
  .panel ::-webkit-scrollbar{width: 5px;}
  ::-webkit-scrollbar-thumb{background-color: #ddd}
  .course-image{width:100%}
</style>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>আমার কোর্স সমূহ</h1>
      <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> হোম</a></li>
        <li><a href="#">আমার কোর্স সমূহ</a></li>
        {{-- <li class="active">Top Navigation</li> --}}
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @if(count($courses))

      @foreach($courses as $value)
      <a href="{{route('home.course.show', $value->id)}}">
      <div class="col-md-3">
        <div class="panel panel-default">
          <div class="penel-heading no-padding" style="text-align: center;padding:15px;min-height:150px">
            <img class="course-image" src="{{ $value->banner? $value->banner : '/img/course.png'}}" alt="" />
          </div>
          <div class="panel-heading"><b>{{substr($value->name, 0, 30)}} ...</b></div>
          <div class="box-group" id="accordion{{$value->id}}">
            <div class="p/anel bo/x box-primary">
              <div class="box-header with-border">
                <div class="box-t/itle">
                  <a data-toggle="collapse" data-parent="#accordion{{$value->id}}" href="#dept{{$value->id}}">
                    <b>বিস্তারিত দেখুন...</b>
                    <span class="pull-right-container">
                      <i class="fa fa-chevron-down pull-right"></i>
                    </span>
                  </a>
                </div>
              </div>
              <div id="dept{{$value->id}}" class="panel-collapse collapse">
                <div class="box-body">
                  @php
                  $syllabuses = $value->syllabuses->whereIn('department_id', $departments_ids);
                  @endphp
                  {{-- {{$value->syllabuses->whereIn('department_id', $departments_ids)}} --}}
                  @if($syllabuses->count())
                    @foreach($syllabuses as $key => $syllabus)
                    <a class="btn btn-primary cst-btn btn-block" href="{{route('student.syllabus', $syllabus->id)}}">{{$syllabus->name}}</a>
                    @endforeach
                  @endif
                </div>
              </div>
            </div>
          </div><!-- /#accordion-->
        </div>
      </div>
      </a>
      @endforeach
      @else
      <div class="panel panel-default">
        <div class="panel-body">
          আপনি এখনো কোন কোর্স ক্রয় করেননি। কোর্স ক্রয় করার জন্যে <a href="{{route('students.course')}}">চলমান কোর্স সমূহ</a> পেজে যান।
        </div>
      </div>
      @endif
    </section> <!-- /.content -->

<script>
  function showPassword(e)
  {
    let elm = e.previousElementSibling;
    if(elm.type == 'password')
    {
      elm.setAttribute('type', 'text');
      e.firstChild.classList.add('fa-eye');
      e.firstChild.classList.remove('fa-eye-slash');
    }
    else 
    {
      elm.setAttribute('type', 'password');
      e.firstChild.classList.add('fa-eye-slash');
      e.firstChild.classList.remove('fa-eye');
    }
  }
</script>
@endsection