@php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
$user = Auth::guard('student')->user();
$student = [];
if($user)
{
  $student = \App\Models\Student::find($user->id);
}
// dd($page);
@endphp

@extends('student')
@section('title', 'Page')
@section('content')
<style>
  .checkbox{padding-left: 25px}
</style>

<div class="content-wrapper">
  <div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Single Page {{-- <small>Page 2.0</small> --}} </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> হোম</a></li>
        <li><a href="#">Single </a></li>
        {{-- <li class="active">Top Navigation</li> --}}
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="col-md-12" style="color:#fff">
        <h3>{{$page->title}}</h3>
        <hr>
        {!! $page->details !!}
      </div>
    </section> <!-- /.content -->
  </div> <!-- /.container -->
</div>

<script>
</script>
@endsection