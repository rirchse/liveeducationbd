@extends('dashboard')
@section('title', 'Profile Details')
@section('content')
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Profile Details</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i></a></li>
        <li class="active">Details</li>
      </ol>
    </section>

    <!-- Main content -->
  <section class="content">
    <div class="row"><!-- left column -->
      <div class="col-md-6"><!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h4 class="box-title">Profile Information</h4>
          </div>
          <div class="col-md-12 text-right toolbar-icon">
            <a href="{{route('profile.edit')}}" class="label label-warning" title="Edit this User"><i class="fa fa-edit"></i></a>
          </div>
          <table class="table">
              <tbody>
                <tr>
                  <th>Name:</th>
                  <td>{{$user->name}}</td>
                </tr>
                <tr>
                  <th>Email:</th>
                  <td>{{$user->email}}</td>
                </tr>
                <tr>
                  <th>Contact:</th>
                  <td>{{$user->contact}}</td>
                </tr>
                <tr>
                  <th>Record Created On:</th>
                  <td>{{date('d M Y h:i:s A',strtotime($user->created_at) )}} </td>
                </tr>
                <tr>
                  <th>Photo:</th>
                  <td><p class="text-center"><img src="{{$user->image}}" alt=""  style="max-width:150px" /></p></td>
                </tr>
            </tbody>
          </table>
                
          <div class="clearfix"></div>
          </div>
        </div><!-- /.box -->
      </div><!--/.col (left) -->
  </section><!-- /.content -->
   
@endsection
