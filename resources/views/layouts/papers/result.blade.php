@php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
@endphp

@extends('dashboard')
@section('title', 'View All Results')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>All Results</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i>Dashboard</a></li>
    <li class="active">All Results</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">List of Results</h3>
          <div class="box-tools">
            <a href="{{route('paper.view', $paper->id)}}" title="View" class="btn btn-primary"><i class="fa fa-th"></i></a>
            <a class="btn btn-info" onclick="printDiv()">
              <i class="fa fa-print"></i> Print
            </a>
            <a href="{{route('paper.result.csv', $paper->id)}}" class="btn btn-success" title="File CSV"><i class="fa fa-download"></i> Export CSV</a>
          </div>
        </div>
        <!-- /.box-header -->
      </div><!--/.box -->
      <div class="box box-body table-responsive no-padding">
        <table id="print" class="table table-bordered table-hover">
          <tr>
            <th colspan="8">
              @if($paper->banner)
              <img src="{{$paper->banner}}" alt="" style="width:100%" />
              @endif
              {!! $paper->header !!}
            </th>
          </tr>
          <tr>
            <th colspan="4">Exam No. {{$paper->name}}</th>
            <th colspan="4" style="text-align: right">Exam Date: {{$source->dformat($exams[0]->created_at)}}</th>
          </tr>
          <tr>
            <th>SL No.</th>
            <th>Student Name</th>
            <th>Registration ID</th>
            <th>Department</th>
            <th style="text-align: right">Correct</th>
            <th style="text-align: right">Wrong</th>
            <th style="text-align: right">Blank</th>
            <th style="text-align: right">Total Mark</th>
          </tr>
          @foreach($exams as $key => $value)
          <tr>
            <td>{{$key+1}}</td>
            <td>{{$value->student->name}}</td>
            <td>{{str_pad($value->student->id, 6, '0', STR_PAD_LEFT)}}</td>
            <td>{{$value->paper->department ? $value->paper->department->name : ''}}</td>
            <td style="text-align: right">{{$value->correct}}</td>
            <td style="text-align: right">{{$value->wrong}}</td>
            <td style="text-align: right">{{$value->no_answer}}</td>
            <td style="text-align: right">{{$value->mark}}</td>
          </tr>
          @endforeach
        </table>
      </div> <!-- /.box-body -->
    </div> <!-- /.box -->
  </div>
  </section>
    <!-- /.content -->
    @endsection
@section('scripts')
  <script>
    function printDiv()
  {
    // document.getElementById('heading').style.display = 'block';
    var divToPrint = document.getElementById('print');
    var htmlToPrint = '' +
        '<style type="text/css">' +
        '.heading{display:block}'+
        '.pageheader{font-size:15px}'+
        'table { border-collapse:collapse; font-size:15px;width:100%}' +
        '.table tr th, .table tr td { padding: 10px; border:1px solid #ddd; text-align:left}' +
        'table tr{background: #ddd}'+
        '.receipt{display:none}'+
        '</style>';
    htmlToPrint += divToPrint.outerHTML;
    newWin = window.open(htmlToPrint);
    newWin.document.write(htmlToPrint);
    newWin.print();
    newWin.close();
    // document.getElementById('heading').style.display = 'none';
  }
  </script>
@endsection