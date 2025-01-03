@php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
$value = $paper;
@endphp

@extends('dashboard')
@section('title', 'Question Paper Details')
@section('content')
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Question Paper Details</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Question Papers</a></li>
        <li class="active">Details</li>
      </ol>    
    </section>

    <!-- Main content -->
  <section class="content">
    <div class="row"><!-- left column -->
      <div class="col-md-8"><!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h4 class="box-title">Question Paper Information</h4>
          </div>
          <div class="col-md-12 text-right toolbar-icon">
            <a href="{{route('paper.create')}}" title="Add New" class="label label-info"><i class="fa fa-plus"></i></a>
            <a href="{{route('paper.view', $value->id)}}" title="View" class="label label-primary"><i class="fa fa-th"></i></a>
            <a href="{{route('paper.index')}}" title="View" class="label label-success"><i class="fa fa-list"></i></a>
            <a href="{{route('paper.edit', $value->id)}}" class="label label-warning" title="Edit this"><i class="fa fa-gear"></i></a>
          </div>
          <div class="col-md-12">
            <table class="table">
              <tbody>
                <tr>
                  <th style="width: 200px;">Question Paper No.:</th>
                  <td>{{$value->name}}</td>
                </tr>
                <tr>
                  <th>Course:</th>
                  <td>{{$value->course ? $value->course->name : ''}}</td>
                </tr>
                <tr>
                  <th>Batch:</th>
                  <td>{{$value->batch ? $value->batch->name : ''}}</td>
                </tr>
                <tr>
                  <th>Department:</th>
                  <td>{{$value->department ? $value->department->name : ''}}</td>
                </tr>
                <tr>
                <tr>
                  <th>Banner:</th>
                  <td><img src="{{$value->banner}}" alt="" style="width: 100%"></td>
                </tr>
                <tr>
                  <th>Header:</th>
                  <td>{!!$value->header !!}</td>
                </tr>
                <tr>
                  <th>Details:</th>
                  <td>{{$value->details}}</td>
                </tr>
                <tr>
                  <th>Max Questions Entry:</th>
                  <td>{{$value->max}}</td>
                </tr>
                <tr>
                  <th>Question Count:</th>
                  <td>{{count($value->questions->select('id'))}}</td>
                </tr>
                <tr>
                  <th>Status:</th>
                  <td>
                    <span class="label label-warning">{{$value->status}}</span>
                  </td>
                </tr>
                <tr>
                  <th>List Format:</th>
                  <td>{{$value->format}}</td>
                </tr>
                <tr>
                  <th>Time (in Minutes):</th>
                  <td>{{$value->time}} </td>
                </tr>
                <tr>
                  <th>Mark (For Correct Answer):</th>
                  <td>{{$value->mark}} </td>
                </tr>
                <tr>
                  <th>Mark (Negative for wrong Answer):</th>
                  <td>{{$value->minus}} </td>
                </tr>
                <tr>
                  <th>Student Can View Result After Exam?:</th>
                  <td>{{$value->result_view}} </td>
                </tr>
                <tr>
                  <th>How many times can a student take the exam?:</th>
                  <td>{{$value->exam_limit}} </td>
                </tr>
                <tr>
                  <th>Show Random Questions?:</th>
                  <td>{{$value->random}} </td>
                </tr>
                <tr>
                  <th>Display Question?:</th>
                  <td>{{$value->display}} </td>
                </tr>
                <tr>
                  <th>Who can exam?:</th>
                  <td>{{$value->permit}} </td>
                </tr>
                <tr>
                  <th>Record Created On:</th>
                  <td>{{$source->dtformat($value->created_at)}} </td>
                </tr>
                <tr>
                  <th>Record Updated On:</th>
                  <td>{{$source->dtformat($value->updated_at)}} </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="clearfix"></div>
        </div>
      </div><!-- /.box -->
    </div><!--/.col (left) -->
  </section><!-- /.content -->
   
@endsection
