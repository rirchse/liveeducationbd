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

<div class="content-wrapper">
  <div class="container">
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
          <div class="panel-heading"><b>{{substr($value->name, 0, 55)}} ...</b></div>
        </div>
      </div>
      </a>
      @endforeach
      @else
      <div class="panel panel-default">
        <div class="panel-body">
          No Course Available
        </div>
      </div>
      @endif
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
</script>
@endsection