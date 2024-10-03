@extends('dashboard')
@section('title', 'Add New Chapter')
@section('content')
<section class="content-header">
  <h1>Add a Chapter</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Chapters</a></li>
    <li class="active">Add Chapter</li>
</ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row"> <!-- left column -->
    <div class="col-md-8"> <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border">
            <h3 style="color: #800" class="box-title">Chapter Details</h3>
        </div>
        <form action="{{route('chapter.store')}}" method="POST">
            @csrf
            <div class="box-body">
                {{-- <div class="col-md-12">
                    <div class="form-group">
                        <label for="name">Course Name</label>
                        <select class="form-control select2" multiple name="course_id[]" id="course_id" required onchange="getDepartments(this)">
                            @foreach($courses as $val)
                            <option value="{{$val->id}}">{{$val->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="name">Department Name</label>
                        <select class="form-control select2" multiple name="department_id[]" id="department_id" required onchange="getSemesters(this); getSubjects(this)">
                            @foreach($departments as $val)
                            <option value="{{$val->id}}">{{$val->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div> --}}
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="name">Subject Name</label>
                        <select class="form-control select2" multiple name="subject_id[]" id="subject_id" required>
                            @foreach($subjects as $val)
                            <option value="{{$val->id}}">{{$val->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="name">Chapter Title</label>
                        <input type="text" class="form-control" name="name" id="name" required>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="details">Details</label>
                        <textarea class="form-control" name="details" id="details" rows="5"></textarea>
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
<script type="text/javascript">
function getDepartments(e)
{
    let ids = Array.from(e.selectedOptions).map(({value}) => value);

    $.ajax({
        type: 'GET', //THIS NEEDS TO BE GET
        url: '/get_departments/' + ids,
        success: function (data) {

            var obj = JSON.parse(JSON.stringify(data));
            var options = '';

            $.each(obj['data'], function (key, val) {
                options += '<option value="'+val.id+'">'+val.name+'</option>';
            });

            if(options != ""){
                $("#department_id").html(options)
            }else{
                $("#department_id").html('<option value="">No One</option>')
                $("#subject_id").html('<option value="">No One</option>')
            }
        },
        error: function(data) { 
                console.log('data error');
        }
    });
}

function getSemesters(e)
{
    let ids = Array.from(e.selectedOptions).map(({value}) => value);
    let department = document.getElementById('department_id');
    let preElm = department.parentNode.parentNode;

    $.ajax({
        type: 'GET', //THIS NEEDS TO BE GET
        url: '/get_semesters/' + ids,
        success: function (data) {

            var obj = JSON.parse(JSON.stringify(data));
            var options = '';

            $.each(obj['data'], function (key, val) {
                options += '<option value="'+val.id+'">'+val.name+'</option>';
            });

            if(options != "")
            {
                if(preElm.nextElementSibling.id == 'semester')
                {
                    $("#semester_id").html(options)
                }
                else
                {
                    let elm = document.createElement('div');
                    elm.setAttribute('class', 'col-md-12');
                    elm.setAttribute('id', 'semester');
                    elm.innerHTML = '<div class="form-group">'+
                            '<label for="name">Semester Name</label>'+
                            '<select class="form-control select2" multiple name="semester_id[]" id="semester_id" onchange="getSemsSubjects(this)">'+ options +
                                '</select>'+
                            '</div>';
                    preElm.after(elm);
                }

                // select2 execution
                $(function(){ $('.select2').select2(); });
                
            }else{
                $("#semester_id").html('<option value="">No One</option>')
                $("#subject_id").html('<option value="">No One</option>')
                $("#chapter_id").html('<option value="">No One</option>')
                
                if(preElm.nextElementSibling.id == 'semester')
                {
                    preElm.nextElementSibling.remove()
                }
            }
        },
        error: function(data) { 
                console.log('data error');
        }
    });

    
}
function getSubjects(e)
{
    let ids = Array.from(e.selectedOptions).map(({value}) => value);

    $.ajax({
        type: 'GET', //THIS NEEDS TO BE GET
        url: '/get_subjects/' + ids,
        success: function (data) {

            var obj = JSON.parse(JSON.stringify(data));
            var options = '';

            $.each(obj['data'], function (key, val) {
                options += '<option value="'+val.id+'">'+val.name+'</option>';
            });

            if(options != ""){
                $("#subject_id").html(options)
            }else{
                $("#subject_id").html('<option value="">No One</option>')
            }
        },
        error: function(data) { 
                console.log('data error');
        }
    });
}

function getSemsSubjects(e)
{
    let ids = Array.from(e.selectedOptions).map(({value}) => value);

    $.ajax({
        type: 'GET', //THIS NEEDS TO BE GET
        url: '/get_sems_subjects/' + ids,
        success: function (data) {

            var obj = JSON.parse(JSON.stringify(data));
            var options = '';

            $.each(obj['data'], function (key, val) {
                options += '<option value="'+val.id+'">'+val.name+'</option>';
            });

            if(options != ""){
                $("#subject_id").html(options)
            }else{
                $("#subject_id").html('<option value="">No One</option>')
                $("#chapter_id").html('<option value="">No One</option>')
            }
        },
        error: function(data) { 
                console.log('data error');
        }
    });
}

//select2 execution
$(function(){ $('.select2').select2(); });
</script>
@endsection