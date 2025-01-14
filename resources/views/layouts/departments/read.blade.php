@extends('dashboard')
@section('title', 'Department Details')
@section('content')
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Department Details</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Departments</a></li>
        <li class="active">Details</li>
      </ol>    
    </section>

    <!-- Main content -->
  <section class="content">
    <div class="row"><!-- left column -->
      <div class="col-md-8"><!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h4 class="box-title">Department Information</h4>
          </div>
          <div class="col-md-12 text-right toolbar-icon">
            <a href="{{route('department.create')}}" title="Add New" class="label label-info"><i class="fa fa-plus"></i></a>
            <a href="{{route('department.edit', $department->id)}}" class="label label-warning" title="Edit this"><i class="fa fa-edit"></i></a>
            
          </div>
          <div class="col-md-12">
            <table class="table">
                <tbody>
                  <tr>
                    <th style="width: 200px;">Name:</th>
                    <td>{{$department->name}}</td>
                  </tr>
                <tr>
                    <th>Brand:</th>
                    <td>{{$department->brand}}</td>
                  </tr>
                <tr>
                    <th>MRP Price:</th>
                    <td>{{$department->mrp_price}}</td>
                  </tr>
                <tr>
                    <th>Credit Price:</th>
                    <td>{{$department->credit_price}}</td>
                  </tr>
                <tr>
                <tr>
                  <th>Cash Price:</th>
                  <td>{{$department->cash_price}}</td>
                </tr>
                <tr>
                  <th>Buying Price:</th>
                  <td>{{$department->buying_price}}</td>
                </tr>
                <tr>
                    <th>Serial No:</th>
                    <td>{{$department->serial_no}}</td>
                  </tr>
                  <tr>
                    <th>Details:</th>
                    <td>{{$department->details}}</td>
                  </tr>
                
                   <tr>
                    <th>Status:</th>
                    <td>
                      @if($department->status == 0)
                      <span class="label label-warning">Unactive</span>
                      @elseif($department->status == 1)
                      <span class="label label-success">Active</span>
                      @elseif($department->status == 2)
                      <span class="label label-danger">Disabled</span>
                      @endif
                    </td>
                  </tr>
                  
                  <tr>
                    <th>Date:</th>
                    <td>{{date('d M Y h:i:s A',strtotime($department->buying_date) )}} </td>
                  </tr>
                  <tr>
                    <th>Record Created On:</th>
                    <td>{{date('d M Y h:i:s A',strtotime($department->created_at) )}} </td>
                  </tr>
                  <tr>
                    <th>Record Updated On:</th>
                    <td>{{date('d M Y h:i:s A',strtotime($department->updated_at) )}} </td>
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
