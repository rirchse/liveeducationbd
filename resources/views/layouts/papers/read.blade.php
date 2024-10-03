@extends('dashboard')
@section('title', 'Question Paper')
@section('content')
<style>
  .mcqitems{list-style: none}
</style>
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Question Paper</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Question Paper</a></li>
        <li class="active">Details</li>
      </ol>    
    </section>

    <!-- Main content -->
  <section class="content">
    <div class="row"><!-- left column -->
      <div class="col-md-12"><!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h4 class="box-title" style="display: inline">Question Paper</h4>
            <div class="text-right toolbar-icon pull-right" style="display: inline">
              <a href="{{route('paper.add.question', $paper->id)}}" title="Add Questions" class="label label-info"><i class="fa fa-plus"></i> Add Questions</a>
              <a href="{{route('paper.create')}}" title="Add" class="label label-primary"><i class="fa fa-pencil"></i> Create</a>
              <a href="{{route('paper.index')}}" title="View" class="label label-success"><i class="fa fa-list"></i></a>
              <a href="{{route('paper.edit', $paper->id)}}" class="label label-warning" title="Edit"><i class="fa fa-gear"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
      <div class="box">
        <div class="col-md-12">
          <div class="header" style="text-align:center">{!! $paper->header !!}</div>
            <div class="col-md-6">
              <div class="panel">
                <div class="panel-">head</div>
                <ul class="mcqitems panel-body">
                  <li>a) aaa</li>
                  <li>b) bbb</li>
                  <li>c) bbb</li>
                  <li>d) bbb</li>
                </ul>
              </div>
            </div>
          </div>
          <div class="clearfix"></div>
        </div><!--/.col -->
      </div><!-- /.col -->
    </div><!-- /.row -->
  </section><!-- /.content -->
   
@endsection
