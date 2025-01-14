@php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
$value = $chapter;
@endphp

@extends('dashboard')
@section('title', 'Chapter Details')
@section('content')
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Chapter Details</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Chapters</a></li>
        <li class="active">Details</li>
      </ol>    
    </section>

    <!-- Main content -->
  <section class="content">
    <div class="row"><!-- left column -->
      <div class="col-md-8"><!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h4 class="box-title">Chapter Information</h4>
          </div>
          <div class="col-md-12 text-right toolbar-icon">
            <a href="{{route('chapter.create')}}" title="Add New" class="label label-info"><i class="fa fa-plus"></i></a>
            <a href="{{route('chapter.edit', $value->id)}}" class="label label-warning" title="Edit this"><i class="fa fa-edit"></i></a>
            
          </div>
          <div class="col-md-12">
            <table class="table">
                <tbody>
                  <tr>
                    <th style="width: 200px;">Name:</th>
                    <td>{{$value->name}}</td>
                  </tr>
                  <tr>
                    <th>Subject Name:</th>
                    <td>
                      @foreach($value->subjects as $val)
                      <label class="label label-primary">{{$val->name}}</label>
                      @endforeach
                    </td>
                  </tr>
                  <tr>
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
