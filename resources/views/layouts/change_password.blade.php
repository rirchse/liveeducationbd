@extends('dashboard')
@section('title', 'Change My Password')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Change My Password</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Settings</a></li>
        <li class="active">Change My Password</li>
      </ol>
    </section>

    <!-- Main content -->
  <section class="content">
    <div class="row"><!-- left column -->
      <div class="col-md-6"><!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h4 class="box-title">Change My Password</h4>
          </div>
          <form action="{{route('user.change.password', $profile)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="col-md-12">
                
                <div class="form-group">
                  <label for="">Email Address:</label>
                  <input type="email" value="{{$profile->email}}" class="form-control" disabled />
                </div>
                <div class="form-group">
                  <label for="">Current Password:</label>
                  <input type="password" name="current_password" class="form-control" />
                </div>
                <div class="form-group">
                  <label for="">New Password:</label>
                  <input type="password" name="password" class="form-control" />
                </div>
                <div class="form-group">
                  <label for="">Confirm Password:</label>
                  <input type="password" name="password_confirmation" class="form-control" />
                </div>
            </div>
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary pull-right">Update Password</button><br><br>
            </div>
            <div class="clearfix"></div>
          </form>

                </div>
            </div>
        </div>
    </section>
@endsection