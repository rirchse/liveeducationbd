@php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
@endphp

@extends('dashboard')
@section('title', 'View All Course')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>All Course</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i>Dashboard</a></li>
    {{-- <li><a href="#">Tables</a></li> --}}
    <li class="active">All Course</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">List of Course</h3>
              <div class="box-tools">
                <a href="{{route('course.create')}}" class="btn btn-sm btn-info">
                  <i class="fa fa-plus"></i> Add
                </a>
                <div class="input-group input-group-sm" style="float:right; width: 150px;margin-left:15px">
                  <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table id="example1" class="table table-bordered table-hover">
                <tr>
                  <th>Id</th>
                  <th>Name</th>
                  <th>Students</th>
                  <th>Created At</th>
                  <th>Updated At</th>
                  <th>Status</th>
                  <th width="130">Action</th>
                </tr>
                @foreach($courses as $course)
                <tr>
                  <td>{{$course->id}}</td>
                  <td>{{$course->name}}</td>
                  <td><a href="{{route('student.view', [$course->id, 'course'])}}" class="btn btn-info">{{$course->students()->count()}}</a></td>
                  <td>{{$source->dtformat($course->created_at)}}</td>
                  <td>{{$source->dtformat($course->updated_at)}}</td>
                  <td>
                    @if($course->status == 'Active')
                    <span class="label label-success">Active</span>
                    @elseif($course->status == 'Inactive')
                    <span class="label label-warning">Inactive</span>
                    @endif
                  </td>
                  <td>
                    {{-- <a href="{{route('course.show',$course->id)}}" class="label label-info" title="course Details"><i class="fa fa-file-text"></i></a> --}}
                    <a href="{{route('students.add', [$course->id, 'Course'])}}" class="btn btn-primary btn-sm" title="Add Students"><i class="fa fa-user-plus"></i></a>
                    <a href="{{route('course.edit',$course->id)}}" class="btn btn-warning btn-sm" title="Edit this course"><i class="fa fa-edit"></i></a>
                    <form style="display: inline" action="{{route('course.destroy', $course->id)}}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this one?')"><i class="fa fa-trash"></i></button></form>
                  </td>
                </tr>
                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <div class="pagination-sm no-margin pull-right">
                {{-- {{$courses->links()}} --}}
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