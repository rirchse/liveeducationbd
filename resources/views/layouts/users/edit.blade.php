@extends('dashboard')
@section('title', 'Edit User Account')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>User Account</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Edit User Account</li>
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
              <h3 class="box-title">Edit User Account <b>[{{$user_role->description}}]</b></h3>
            </div>
            <div class="col-md-12 text-right toolbar-icon">
              <a href="{{route('user.show',$user->id)}}" class="label label-info" title="User Details"><i class="fa fa-file-text"></i></a>
              <a href="{{route('user.index')}}" title="View {{Session::get('_types')}} users" class="label label-success"><i class="fa fa-list"></i></a>
              {{-- <a href="{{route('user.delete',$user->id)}}" class="label label-danger" title="Delete this account"><i class="fa fa-trash"></i></a> --}}
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="{{route('user.update', $user)}}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <div class="box-body">
                <div class="form-group">
                  <label for="">User Permissions</label>
                    <select name="user_role" class="form-control">
                        <option value="">Select Permission</option>
                        @foreach($roles as $role)
                        <option value="{{$role->id}}" {{$role->id == Auth::user()->authRole()->id ? 'selected' : ''}}>{{$role->name.' ['.$role->description.']'}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" name="name" class="form-control" required value="{{$user->name}}" />
                </div><div class="form-group">
                    <label for="">Email Address</label>
                    <input type="email" name="email" class="form-control" required value="{{$user->email}}" />
                </div>
                <div class="form-group">
                    <label for="" >Contact</label>
                    <input type="text" name="contact" class="form-control" required value="{{$user->contact}}" />
                </div>
                <div class="form-group">
                  <label for="image">Profile Image</label>
                  <input class="form-control" type="file" id="image" name="image" />
                </div>
                <div class="checkbox"><b>Status: &nbsp; </b>
                  <label><input type="checkbox" name="status" value="Active" {{$user->status == 'Active'? 'checked': ''}}> Active</label>
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