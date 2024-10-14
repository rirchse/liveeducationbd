@php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
@endphp

@extends('dashboard')
@section('title', 'View All Students')
@section('content')

  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Students Accounts</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Students</a></li>
      {{-- <li><a href="#">Tables</a></li> --}}
      <li class="active">Students Accounts</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">List of Students</h3>
            <div class="box-tools">
              <a href="{{route('student.create')}}" class="btn btn-sm btn-info"><i class="fa fa-plus"></i> Add</a>
              {{-- <div class="input-group input-group-sm" style="width: 150px;">
                <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                <div class="input-group-btn">
                  <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                </div>
              </div> --}}
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body table-responsive no-padding">
            <table id="example1" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th style="width:32px">#</th>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Contact</th>
                  <th>Status</th>
                  <th>Created On</th>
                  <th width="110">Action</th>
                </tr>
              </thead>

              @foreach($students as $value)

              <tr>
                <td><input type="checkbox"></td>
                <td>{{$value->id}}</td>
                <td>{{$value->name}}</td>
                <td>{{$value->email}}</td>
                <td>{{$value->contact}}</td>
                <td>
                  @if($value->status == "Active")
                  <span class="label label-success">{{$value->status}}</span>
                  @else
                  <span class="label label-warning">{{$value->status}}</span>
                  @endif
                </td>
                <td>{{ $source->dtformat($value->created_at) }}</td>
                <td>
                  <a href="{{route('student.show',$value->id)}}" class="label label-info" title="User Details"><i class="fa fa-file-text"></i></a>
                  <a href="{{route('student.edit',$value->id)}}" class="label label-warning" title="Edit this User"><i class="fa fa-edit"></i></a>
                  @if($value->status == 1)
                  {{-- <a href="/admin/user_login/{{$value->email}}" class="label label-success" title="Login to this account" target="_blank"><i class="fa fa-search-plus"></i></a> --}}
                  @endif
                  @if($value->status == 0)
                  {{-- <a href="/admin/resend_email_verification/{{$value->id}}" class="label label-primary" onclick="return confirm('Are you sure you want to resend email verification to this user?')" title="Resend verification email."><i class="fa fa-envelope-o"></i></a> --}}
                  @endif
                  @if($value->status == 3)
                  {{-- <a href="/admin/user/{{$value->id}}/restore" class="label label-success" title="Restore the account" onclick="return confirm('Are you sure you want to restore the account?')"><i class="fa fa-undo"></i></a> --}}
                  @endif
                </td>
              </tr>

              @endforeach
            </table>
          </div>
          <!-- /.box-body -->
          <div class="box-footer clearfix">
            <div class="pagination-sm no-margin pull-right">
              {{$students->links()}}
            </div>
          </div>
        </div>
        <!-- /.box -->
      </div>
    </div>
  </section>
  <!-- /.content -->
@endsection
{{-- @section('scripts')
  <script>
    $(function () {
      $('#example1').DataTable()
      $('#example2').DataTable({
        'paging'      : true,
        'lengthChange': false,
        'searching'   : false,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : false
      })
    })
  </script>
@endsection --}}