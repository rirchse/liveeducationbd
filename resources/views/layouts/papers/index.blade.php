@php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
@endphp

@extends('dashboard')
@section('title', 'View All Question Papers')
@section('content')
<style>
  .tools{text-align: right;}
</style>
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
        <div class="box-body">
          <form action="">
            <div class="col-md-3">
              <div class="form-group">
                <label for="">Group</label>
                <select name="group_id" id="group_id" class="form-control">
                  <option value="">Select One</option>
                  <option value="">Group 1</option>
                  <option value="">Group 2</option>
                  <option value="">Group 3</option>
                  <option value="">Group 4</option>
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="">Batch</label>
                <select name="batch_id" id="batch_id" class="form-control">
                  <option value="">Select One</option>
                  <option value="">Batch 1</option>
                  <option value="">Batch 2</option>
                  <option value="">Batch 3</option>
                  <option value="">Batch 4</option>
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="">Question Paper No.</label>
                <input type="text" name="name" id="name" class="form-control">
              </div>
            </div>
            <div class="col-md-2"><br>
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>
        </div>
      </div>
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
                  <th>Paper No.</th>
                  <th>Questions</th>
                  <th>Department</th>
                  <th>Batch</th>
                  <th>Course</th>
                  <th>Exams</th>
                  <th>Status</th>
                  <th width="130">Action</th>
                </tr>
                @foreach($papers as $key => $value)
                <tr>
                  <td>{{ $value->id }}</td>
                  <td>{{ $value->name }}</td>
                  <td>{{ $value->questions->count() }}</td>
                  <td>{{ $value->department ? $value->department->name:'' }}</td>
                  <td>{{ $value->batch ? $value->batch->name : '' }}</td>
                  <td>{{ $value->course ? $value->course->name : '' }}</td>
                  <td>{{ $value->exams->count() }}</td>
                  <td>
                    @if($value->status == 'Published')
                    <span class="label label-success">{{$value->status}}</span>
                    @elseif($value->status == 'Scheduled')
                    <span class="label label-warning">{{$value->status}}</span>
                    @elseif($value->status == 'Unpublished')
                    <span class="label label-danger">{{$value->status}}</span>
                    @endif
                  </td>
                  <td>
                    <a href="{{route('paper.show', $value->id)}}" class="btn btn-info" title="Details"><i class="fa fa-file-text"></i></a>
                    <a href="{{route('paper.edit', $value->id)}}" class="btn btn-warning btn-sm" title="Edit this value"><i class="fa fa-edit"></i></a>
                    {{-- <form style="display: inline" action="{{route('paper.destroy', $value->id)}}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this one?')"><i class="fa fa-trash"></i></button>
                    </form> --}}
                  </td>
                </tr>
                @endforeach
              </table>
              {{-- <br>
              @foreach($papers as $key => $value)
              <a href="{{route('paper.view', $value->id)}}">
                <div class="col-md-6">
                  <div class="panel panel-default">
                    <div class="panel-heading input-group">
                        <h4>({{$key+1}}) : <b> {{$value->name}}</b></h4>
                        <span class="input-group-addon" title="Questions">{{$value->questions->count()}}</span>
                      <div class="clearfix"></div>
                    </div>
                  </div>
                </div>
              </a>
              @endforeach --}}
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <div class="pagination-sm no-margin pull-right">
                {{$papers->links()}}
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