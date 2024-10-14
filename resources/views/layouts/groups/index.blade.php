@php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
@endphp

@extends('dashboard')
@section('title', 'View All Group')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>All Group</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i>Dashboard</a></li>
    {{-- <li><a href="#">Tables</a></li> --}}
    <li class="active">All Group</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">List of Group</h3>
              <div class="box-tools">
                <a href="{{route('group.create')}}" class="btn btn-sm btn-info"><i class="fa fa-plus"></i> Add</a>
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
                  <th>Name</th>
                  <th>Details</th>
                  <th>Created At</th>
                  <th>Updated At</th>
                  <th>Status</th>
                  <th width="110">Action</th>
                </tr>
                @foreach($groups as $value)
                <tr>
                  <td>{{$value->id}}</td>
                  <td>{{$value->name}}</td>
                  <td>{{$value->details}}</td>
                  <td>{{$source->dtformat($value->created_at)}}</td>
                  <td>{{$source->dtformat($value->updated_at)}}</td>
                  <td>
                    @if($value->status == 'Active')
                    <span class="label label-success">{{$value->status}}</span>
                    @elseif($value->status == 'Deactive')
                    <span class="label label-warning">{{$value->status}}</span>
                    @endif
                  </td>
                  <td>
                    {{-- <a href="{{route('group.show',$value->id)}}" class="label label-info" title="Details"><i class="fa fa-file-text"></i></a> --}}
                    <a href="{{route('group.edit', $value->id)}}" class="btn btn-warning btn-sm" title="Edit"><i class="fa fa-edit"></i></a>
                    <form style="display: inline" action="{{route('group.destroy', $value->id)}}" method="POST">
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