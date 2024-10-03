@extends('dashboard')
@section('title', 'Edit Profile')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Profile</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Edit Profile</li>
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
              <h3 class="box-title">Edit Profile</h3>
            </div>
            <div class="col-md-12 text-right toolbar-icon">
              <a href="{{route('profile',$user->id)}}" class="label label-info" title="Profile Details"><i class="fa fa-file-text"></i></a>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="{{route('profile.update', $user)}}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')

              <div class="box-body">
                <div class="form-group">
                  <label for="">User Role</label>
                  <input type="text" class="form-control" value="{{ Auth::user()->authRole()->name }}" disabled />
                </div>
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" name="name" class="form-control" required value="{{$user->name}}" />
                </div><div class="form-group">
                    <label for="">Email Address</label>
                    <input type="email" name="email" class="form-control" required value="{{$user->email}}" disabled />
                </div>
                <div class="form-group">
                    <label for="" >Contact</label>
                    <input type="text" name="contact" class="form-control" required value="{{$user->contact}}" />
                </div>
                <div class="form-group">
                  <label for="image">Profile Image</label>
                  <input class="form-control" type="file" id="image" name="image" />
                </div>
                
                <p class="text-center"><img src="{{$user->image}}" alt=""  style="max-width:150px" /></p>

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