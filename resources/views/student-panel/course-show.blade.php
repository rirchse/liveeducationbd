@php
$user = Auth::guard('student')->user();
$value = $course;
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
        {{-- <li class="active">Top Navigation</li> --}}
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="col-md-8">
        <div class="panel panel-default">
          <div class="panel-heading"><b>{{$value->name}}</b></div>
          <div class="panel-body" style="min-height: 420px">{!!$value->details!!}</div>
        </div>
      </div>
      <div class="col-md-4">
        <form action="{{route('students.course.apply')}}" method="post">
          @csrf
          <input type="hidden" name="course_id" value="{{$value->id}}">
        <div class="panel panel-default">
          <div class="penel-heading" style="text-align: center;padding:15px">
            <img class="course-image" src="{{ $value->banner? $value->banner : '/img/logo.png'}}" alt="" />
          </div>
          <div class="panel-heading"><b>{{$value->name}}</b></div>
          <div class="panel-body">
            <div class="form-group">
              <label for="">Department (Optional)</label>
              <select id="department_id" name="department_id" class="form-control">
                <option value="">Select One</option>
                @foreach($departments as $val)
                <option value="{{$val->id}}">{{$val->name}}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="">Batch</label>
              <select id="batch_id" name="batch_id" class="form-control" required>
                <option value="">Select One</option>
                @foreach($batches as $val)
                <option value="{{$val->id}}">{{$val->name}}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="">Group (Optional)</label>
              <select id="group_id" name="group_id" class="form-control">
                <option value="">Select One</option>
                @foreach($groups as $val)
                <option value="{{$val->id}}">{{$val->name}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="panel-footer">
            @if($value->students()->where('id', $user->id)->first())
            <button class="btn btn-default pull-right" disabled>Applied</button>
            @else
            <button class="btn btn-info pull-right" onclick="return confirm('Double check you provided information.')">Apply</button>
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

  window.location.hash = "no-back-button";

    // Again because Google Chrome doesn't insert
    // the first hash into the history
    window.location.hash = "Again-No-back-button"; 

    window.onhashchange = function(){
        window.location.hash = "no-back-button";
    }
</script>
@endsection