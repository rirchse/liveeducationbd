@php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
$value = $subject;
@endphp

@extends('dashboard')
@section('title', 'Subject Details')
@section('content')
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Subject Details</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Subjects</a></li>
        <li class="active">Details</li>
      </ol>    
    </section>

    <!-- Main content -->
  <section class="content">
    <div class="row"><!-- left column -->
      <div class="col-md-8"><!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h4 class="box-title">Subject Information</h4>
          </div>
          <div class="col-md-12 text-right toolbar-icon">
            <a href="{{route('subject.create')}}" title="Add New" class="label label-info"><i class="fa fa-plus"></i></a>
            <a href="{{route('subject.edit', $value->id)}}" class="label label-warning" title="Edit this"><i class="fa fa-edit"></i></a>
            <a href="{{route('subject.index', $value->id)}}" class="label label-success" title="Index"><i class="fa fa-list"></i></a>
            
          </div>
          <div class="col-md-12">
            <table class="table">
                <tbody>
                  <tr>
                    <th style="width: 200px;">Name:</th>
                    <td>{{$value->name}}</td>
                  </tr>
                  <tr>
                    <th>Course Name:</th>
                    <td>
                      @foreach($value->courses as $val)
                      <label class="label label-primary">{{$val->name}}</label>
                      @endforeach
                    </td>
                  </tr>
                  <tr>
                    <th>Department Name:</th>
                    <td>
                      @foreach($value->departments as $val)
                      <label class="label label-primary">{{$val->name}}</label>
                      @endforeach
                    </td>
                  </tr>
                  <tr>
                    <th>Details:</th>
                    <td>{{$value->details}}</td>
                  </tr>
                
                   <tr>
                    <th>Status:</th>
                    <td>
                      @if($value->status == 'Active')
                      <span class="label label-success">Active</span>
                      @elseif($value->status == 'Inactive')
                      <span class="label label-warning">Inactive</span>
                      @endif
                    </td>
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
