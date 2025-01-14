@extends('dashboard')
@section('title', 'Add New Syllabus')
@section('stylesheets')
<link href="/assets/summernote/summernote.min.css" rel="stylesheet">
@endsection
@section('content')
<section class="content-header">
  <h1>Add a Syllabus</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Syllabuss</a></li>
    <li class="active">Add Syllabus</li>
</ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row"> <!-- left column -->
    <div class="col-md-10"> <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border">
            <h3 style="color: #800" class="box-title">Syllabus Details</h3>
        </div>
        <form action="{{route('syllabus.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="box-body">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="name">Course Name</label>
                        <select class="form-control select2" name="course_id" id="course_id" required onchange="getBatches(this)">
                            <option value="">Select One</option>
                            @foreach($courses as $val)
                            <option value="{{$val->id}}">{{$val->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Batch</label>
                        <select name="batch_id" id="batch_id" class="form-control select2" required onchange="getDepartments(this)">
                            <option value="">Select One</option>
                            {{-- @foreach($batches as $val)
                            <option value="{{$val->id}}">{{$val->name}}</option>
                            @endforeach --}}
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Department</label>
                        <select name="department_id" id="department_id" class="form-control select2">
                            <option value="">Select One</option>
                            {{-- @foreach($departments as $val)
                            <option value="{{$val->id}}">{{$val->name}}</option>
                            @endforeach --}}
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Syllabus Name</label>
                        <input type="text" class="form-control" name="name" id="name" required>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="header">Header</label>
                        <textarea class="form-control editor" name="header" id="header" rows="5"></textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="details">Details</label>
                        <textarea class="form-control" name="details" id="details" rows="5"></textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Status:</label><br>
                        <label for="status"><input type="checkbox" name="status" id="status"> Active</label>
                    </div>
                </div>
            </div> <!-- /.box body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-save"></i> Save</button>
            </div>
        </form>
    </div> <!-- /.box -->
    </div> <!--/.col (left) -->
</div> <!-- /.row -->
</section> <!-- /.content -->
@endsection
@section('scripts')
<script src="/assets/summernote/summernote.min.js"></script>
<script>

    // on change course get batches
    function getBatches(e)
    {
        let ids = Array.from(e.selectedOptions).map(({value}) => value);
    
        $.ajax({
            type: 'GET', //THIS NEEDS TO BE GET
            url: '/get_batches/' + ids,
            success: function (data) {
    
                var obj = JSON.parse(JSON.stringify(data));
                var options = '<option value="">Select One</option>';
    
                $.each(obj['data'], function (key, val) {
                    options += '<option value="'+val.id+'">'+val.name+'</option>';
                });
    
                if(options != ""){
                    $("#batch_id").html(options)
                }else{
                    $("#batch_id").html('')
                }
            },
            error: function(data) { 
                    console.log('data error');
            }
        });
    }
    
    // on change batch get departments
    function getDepartments(e)
    {
        let ids = Array.from(e.selectedOptions).map(({value}) => value);
    
        $.ajax({
            type: 'GET', //THIS NEEDS TO BE GET
            url: '/get_departments_by_batch/' + ids,
            success: function (data) {
    
                var obj = JSON.parse(JSON.stringify(data));
                var options = '<option value="">Select One</option>';
    
                $.each(obj['data'], function (key, val) {
                    options += '<option value="'+val.id+'">'+val.name+'</option>';
                });
    
                if(options != ""){
                    $("#department_id").html(options)
                }else{
                    $("#department_id").html('')
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

    //select 2
    $(function(){$('.select2').select2();});
</script>
@endsection