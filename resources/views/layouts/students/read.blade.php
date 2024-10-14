@php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
$value = $student;
@endphp

@extends('dashboard')
@section('title', 'Student Details')
@section('content')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Student Details</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i></a></li>
      <li class="active">Student Details</li>
    </ol>
  </section>

    <!-- Main content -->
  <section class="content">
    <div class="row"><!-- left column -->
      <div class="col-md-6"><!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h4 class="box-title">Student Information</h4>
          </div>
          <div class="col-md-12 text-right toolbar-icon">
            <a href="{{route('student.index')}}" title="View" class="label label-success"><i class="fa fa-list"></i></a>
            <a href="{{route('student.edit', $value->id)}}" class="label label-warning" title="Edit"><i class="fa fa-edit"></i></a>
            <form action="{{route('student.destroy', $value->id)}}" method="POST" style="display: inline">
            @csrf
            @method('DELETE')
            <button onclick="return confirm('Are you sure, you want to delete this?')" class="btn btn-sm btn-danger" title="Permanently Remove"><i class="fa fa-trash"></i></button>
            </form>
          </div>
          <div class="col-md-12">
            <table class="table">
              <tbody>
                  <tr>
                    <th>Name:</th>
                    <td>{{$value->name}}</td>
                  </tr>
                  <tr>
                    <th>Email:</th>
                    <td>{{$value->email}}</td>
                  </tr>
                  <tr>
                    <th>Contact:</th>
                    <td>{{$value->contact}}</td>
                  </tr>
                  <tr>
                    <th>Status:</th>
                    <td>
                      <span class="label label-{{$value->status == 'Active' ? 'success' : 'warning'}}">
                      {{$value->status}}
                      </span>
                    </td>
                  </tr>
                  <tr>
                    <th>Record Created On:</th>
                    <td>{{ $source->dtformat($value->created_at) }} </td>
                  </tr>
                  <tr>
                    <th>Updated On:</th>
                    <td>{{ $source->dtformat($value->updated_at) }} </td>
                  </tr>
                  <tr>
                    <th>Photo:</th>
                    <td>
                      @if($value->image)
                      <a href="{{$value->image}}" target="_blank" title="View large image"><img src="{{$value->image}}" width=100 style="border: 5px solid #eee"></a>
                      @else
                      No image
                      @endif
                    </td>
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
