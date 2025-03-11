@extends('dashboard')
@section('title', 'Edit Student')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Student</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Users</a></li>
        <li class="active">Edit Student</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Edit Student</h3>
            </div>
            <div class="col-md-12 text-right toolbar-icon">
              <a href="{{route('student.show', $user->id)}}" class="label label-info" title="Show"><i class="fa fa-file-text"></i></a>
              <a href="{{route('student.index')}}" title="View" class="label label-success"><i class="fa fa-list"></i></a>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="{{route('student.update', $user)}}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <div class="box-body">
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" name="name" class="form-control" required value="{{$user->name}}" />
                </div>
                <div class="form-group">
                    <label for="">Email Address</label>
                    <input type="email" name="email" class="form-control" required value="{{$user->email}}" />
                </div>
                <div class="form-group">
                    <label for="" >Contact</label>
                    <input type="text" name="contact" class="form-control" value="{{$user->contact}}" />
                </div>
                <div class="form-group">
                  <label for="image">Profile Image</label>
                  <input class="form-control" type="file" id="image" name="image" />
                  <p class="text-center"><img src="{{$user->image}}" alt=""  style="max-width:150px" /></p>
                </div>
                <div class="form-group">
                  <label for="" >Change Password</label>
                  <input type="text" name="password" class="form-control"/>
                </div>
                <div class="checkbox"><b>Status: &nbsp; </b>
                  <label><input type="checkbox" name="status" value="Active" {{$user->status == 'Active'? 'checked': ''}}> Active</label>
                </div>

              </div> <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-save"></i> Save</button>
              </div>
            </form>
          </div> <!-- /.box -->

        </div> <!--/.col (left) -->
      </div> <!-- /.row -->
    </section> <!-- /.content -->
@endsection