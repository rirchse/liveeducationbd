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
              <br>
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
              @endforeach
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