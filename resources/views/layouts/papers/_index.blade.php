@php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
@endphp

@extends('dashboard')
@section('title', 'View All Question Papers')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>All Question Papers</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i>Dashboard</a></li>
    {{-- <li><a href="#">Tables</a></li> --}}
    <li class="active">All Question Papers</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">List of Question Papers</h3>
              <div class="box-tools">
                <a href="{{route('paper.create')}}" class="btn btn-sm btn-info">
                  <i class="fa fa-plus"></i> Add
                </a>
                {{-- <div class="input-group input-group-sm" style="float:right; width: 150px;margin-left:15px">
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
                <tr>
                  <th>Id</th>
                  <th>Header</th>
                  <th>Name</th>
                  <th>Time</th>
                  <th>Mark</th>
                  <th>Result View</th>
                  <th>Exam Limit</th>
                  <th>Display Questions</th>
                  <th>Question Limit</th>
                  <th>Status</th>
                  <th>Open Time</th>
                  <th>Close Time</th>
                  <th width="120">Action</th>
                </tr>
                @foreach($papers as $value)
                <tr>
                  <td>{{$value->id}}</td>
                  <td>{!! $value->header !!}</td>
                  <td>{{$value->name}}</td>
                  <td>{{$value->time}}</td>
                  <td>{{$value->mark}}</td>
                  <td>{{$value->result_view}}</td>
                  <td>{{$value->exam_limit}}</td>
                  <td>{{$value->display}}</td>
                  <td>{{$value->max}}</td>
                  <td>
                    <span class="label label-primary">{{$value->status}}</span>
                  </td>
                  <td>{{$value->open}}</td>
                  <td>{{$value->close}}</td>
                  <td>
                    <a href="{{route('paper.show', $value->id)}}" class="btn btn-sm label-info" title="Details"><i class="fa fa-file-text"></i></a>
                    <a href="{{route('paper.edit',$value->id)}}" class="btn btn-warning btn-sm" title="Edit"><i class="fa fa-gear"></i></a>
                    {{-- <form style="display: inline" action="{{route('paper.destroy', $value->id)}}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this one?')"><i class="fa fa-trash"></i></button></form> --}}
                  </td>
                </tr>
                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <div class="pagination-sm no-margin pull-right">
                {{-- {{$values->links()}} --}}
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