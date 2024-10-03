@php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
$value = $paper;
@endphp

@extends('dashboard')
@section('title', 'Edit Question Paper')
@section('stylesheets')
<link href="/assets/summernote/summernote.min.css" rel="stylesheet">
@endsection
@section('content')
<section class="content-header">
  <h1>Edit Question Paper</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Question Papers</a></li>
    <li class="active">Edit Question Paper</li>
</ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row"> <!-- left column -->
    <div class="col-md-12"> <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border">
            <h3 style="color: #800" class="box-title">Question Paper Details</h3>
            <div class="text-right toolbar-icon pull-right" style="display: inline">
                <a href="{{route('paper.create')}}" title="Add" class="label label-info"><i class="fa fa-plus"></i></a>
                <a href="{{route('paper.index')}}" title="View" class="label label-success"><i class="fa fa-list"></i></a>
                <a href="{{route('paper.show', $paper->id)}}" class="label label-primary" title="Show"><i class="fa fa-file-text"></i></a>
            </div>
        </div>
        <form action="{{route('paper.update', $value)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="box-body">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="header">Header</label>
                        <textarea class="form-control editor" name="header" id="header" rows="5" required>{{$value->header}}</textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" required value="{{$value->name}}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="time">Time (in minute)</label>
                        <input type="number" class="form-control" name="time" id="time" required value="{{$value->time}}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="mark">Mark (For Correct Answer)</label>
                        <input type="number" class="form-control" name="mark" id="mark" required value="{{$value->mark}}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="minus">Mark (Negative for wrong Answer)</label>
                        <input type="number" class="form-control" name="minus" id="minus" value="{{$value->minus}}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="result_view">Student Can View Result After Exam?</label>
                        <select class="form-control" name="result_view" id="result_view" >
                            <option value="">Select One</option>
                            <option value="Yes" {{$value->result_view == 'Yes'? 'selected': ''}}>Yes</option>
                            <option value="No" {{$value->result_view == 'No'? 'selected': ''}}>No</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="exam_limit">How many times can a student take the exam?</label>
                        <select class="form-control" name="exam_limit" id="exam_limit" >
                            <option value="">Select One</option>
                            <option value="1" {{$value->exam_limit == '1'? 'selected': ''}}>One Time</option>
                            <option value="2" {{$value->exam_limit == '2'? 'selected': ''}}>Two Time</option>
                            <option value="3" {{$value->exam_limit == '3'? 'selected': ''}}>Three Time</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="random">Show Random Questions?</label>
                        <select class="form-control" name="random" id="random" >
                            <option value="">Select One</option>
                            <option value="Yes" {{$value->random == 'Yes'? 'selected': ''}}>Yes</option>
                            <option value="No" {{$value->random == 'No'? 'selected': ''}}>No</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="display">Display Question?</label>
                        <select class="form-control" name="display" id="display" >
                            <option value="">Select One</option>
                            <option value="All" {{$value->display == 'All'? 'selected': ''}}>All in One Paper</option>
                            <option value="One" {{$value->display == 'One'? 'selected': ''}}>One by One</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="permit">Who can exam?</label>
                        <select class="form-control" name="permit" id="permit" >
                            <option value="">Select One</option>
                            <option value="Every One" {{$value->permit == 'Every One'? 'selected': ''}}>Every One</option>
                            <option value="Authenticated" {{$value->permit == 'Authenticated'? 'selected': ''}}>Authenticated</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="format">MCQ List Format</label>
                        <select class="form-control" name="format" id="format" >
                            <option value="">Select One</option>
                            @foreach($source->mcqlist() as $key => $val)
                            <option value="{{$key}}" {{$value->format == $key? 'selected': ''}}>{{implode(', ', $val)}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" name="status" id="status" >
                            <option value="">Select One</option>
                            <option value="Unpublished" {{$value->status == 'Unpublished'? 'selected': ''}}>Unpublished</option>
                            <option value="Published" {{$value->status == 'Published'? 'selected': ''}}>Published</option>
                            <option value="Completed" {{$value->status == 'Completed'? 'selected': ''}}>Completed</option>
                        </select>
                    </div>
                {{-- </div>
                <div class="col-md-4"> --}}
                    <div class="form-group">
                        <label for="open">Publish Time</label>
                        <input type="time" class="form-control" name="open" id="open" value="{{$value->open}}">
                    </div>
                {{-- </div>
                <div class="col-md-4"> --}}
                    <div class="form-group">
                        <label for="close">Close Time</label>
                        <input type="time" class="form-control" name="close" id="close" value="{{$value->close}}" >
                    </div>
                </div>
                {{-- <div class="clearfix"></div> --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="max">Questions Limit</label>
                        <input type="number" class="form-control" name="max" id="max" value="{{$value->max}}" >
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="details">Details</label>
                        <textarea class="form-control" name="details" id="details" rows="4">{{$value->details}}</textarea>
                    </div>
                </div>
            </div> <!-- /.box body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right" onclick="formCheck(this)"><i class="fa fa-save"></i> Save</button>
            </div>
        </form>
    </div> <!-- /.box -->
    </div> <!--/.col (left) -->
</div> <!-- /.row -->
</section> <!-- /.content -->
@endsection

@section('scripts')
<script src="/assets/summernote/summernote.min.js"></script>
<script type="text/javascript">
    function getsubcats(elm){

        var catid = elm.options[elm.options.selectedIndex].value;

        $.ajax({
            type: 'GET', //THIS NEEDS TO BE GET
            url: '/get_sub_cats/'+catid,
            success: function (data) {

                var obj = JSON.parse(JSON.stringify(data));
                var sub_cat_html = "";

                $.each(obj['subcats'], function (key, val) {
                   sub_cat_html += "<option value="+val.id+">"+val.name+"</option>";
                });

                if(sub_cat_html != ""){
                    $("#sub_cat").html('<option value="">Select SubCategory</option>'+sub_cat_html)
                }else{
                    $("#sub_cat").html('<option value="">No SubCategory</option>')
                }
            },
            error: function(data) { 
                 console.log('data error');
            }
        });
    }

    //this script for text editor
    $(document).ready(function() {
        $('.editor').summernote({
            height: 150
        });
    });

    // getsubcats(elm);
</script>
@endsection