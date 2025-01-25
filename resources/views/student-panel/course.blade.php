@php
$user = Auth::guard('student')->user();
@endphp
@extends('student')
@section('title', 'কোর্স সমূহ')
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
      <h1>চলমান কোর্স সমূহ </h1>
      <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> হোম</a></li>
        <li><a href="#">কোর্স সমূহ</a></li>
        {{-- <li class="active">Top Navigation</li> --}}
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        @if(count($courses))
        @foreach($courses as $value)
        <div class="col-md-3">
          <a href="{{route('home.course.show', $value->id)}}">
          <div class="panel panel-default">
            <div class="penel-heading no-padding" style="text-align: center;padding:15px;min-height:150px">
              <img class="course-image" src="{{ $value->banner? $value->banner : '/img/course.png'}}" alt="" />
            </div>
            <div class="panel-heading"><b>{{substr($value->name, 0, 30)}} ...</b></div>
            <div class="panel-footer">
              @if(!empty($user) && $value->students()->where('id', $user->id)->first())
              <button class="btn btn-default pull-right" disabled>Applied</button>
              @else
              <a class="btn btn-info pull-right" href="{{route('home.course.show', $value->id)}}">View</a>
              @endif
              <div class="clearfix"></div>
            </div>
          </div>
        </a>
        </div>
        @endforeach
        @else
        <div class="panel panel-default">
          <div class="panel-body">
            No Course Available
          </div>
        </div>
        @endif
      </div>
    </section> <!-- /.content -->

<script></script>
@endsection