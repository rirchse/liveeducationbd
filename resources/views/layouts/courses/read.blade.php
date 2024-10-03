@extends('dashboard')
@section('title', 'Course Details')
@section('content')
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Course Details</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Courses</a></li>
        <li class="active">Details</li>
      </ol>    
    </section>

    <!-- Main content -->
  <section class="content">
    <div class="row"><!-- left column -->
      <div class="col-md-8"><!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h4 class="box-title">Course Information</h4>
          </div>
          <div class="col-md-12 text-right toolbar-icon">
            <a href="{{route('course.create')}}" title="Add New" class="label label-info"><i class="fa fa-plus"></i></a>
            <a href="{{route('course.edit',$course->id)}}" class="label label-warning" title="Edit this"><i class="fa fa-edit"></i></a>
            
          </div>
          <div class="col-md-12">
            <table class="table">
                <tbody>
                  <tr>
                    <th style="width: 200px;">Name:</th>
                    <td>{{$course->name}}</td>
                  </tr>
                <tr>
                    <th>Brand:</th>
                    <td>{{$course->brand}}</td>
                  </tr>
                <tr>
                    <th>MRP Price:</th>
                    <td>{{$course->mrp_price}}</td>
                  </tr>
                <tr>
                    <th>Credit Price:</th>
                    <td>{{$course->credit_price}}</td>
                  </tr>
                <tr>
                <tr>
                  <th>Cash Price:</th>
                  <td>{{$course->cash_price}}</td>
                </tr>
                <tr>
                  <th>Buying Price:</th>
                  <td>{{$course->buying_price}}</td>
                </tr>
                <tr>
                    <th>Serial No:</th>
                    <td>{{$course->serial_no}}</td>
                  </tr>
                  <tr>
                    <th>Details:</th>
                    <td>{{$course->details}}</td>
                  </tr>
                
                   <tr>
                    <th>Status:</th>
                    <td>
                      @if($course->status == 0)
                      <span class="label label-warning">Unactive</span>
                      @elseif($course->status == 1)
                      <span class="label label-success">Active</span>
                      @elseif($course->status == 2)
                      <span class="label label-danger">Disabled</span>
                      @endif
                    </td>
                  </tr>
                  
                  <tr>
                    <th>Date:</th>
                    <td>{{date('d M Y h:i:s A',strtotime($course->buying_date) )}} </td>
                  </tr>
                  <tr>
                    <th>Record Created On:</th>
                    <td>{{date('d M Y h:i:s A',strtotime($course->created_at) )}} </td>
                  </tr>
                  <tr>
                    <th>Record Updated On:</th>
                    <td>{{date('d M Y h:i:s A',strtotime($course->updated_at) )}} </td>
                  </tr>
              </tbody>
            </table>
          </div>
          <div class="clearfix"></div>
          <p><a href="{{route('course.delete',$course->id)}}" onclick="return confirm('Are sure you want to permanently delete this product?')" class="text-danger" style="padding:15px">Permanently Remove?</a></p>
        </div>
      </div><!-- /.box -->
    </div><!--/.col (left) -->
  </section><!-- /.content -->
   
@endsection
