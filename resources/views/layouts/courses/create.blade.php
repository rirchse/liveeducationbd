@extends('dashboard')
@section('title', 'Add New Course')
@section('stylesheets')
<link href="/assets/summernote/summernote.min.css" rel="stylesheet">
@endsection
@section('content')
<section class="content-header">
  <h1>Add a Course</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Courses</a></li>
    <li class="active">Add Course</li>
</ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row"> <!-- left column -->
    <div class="col-md-10"> <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border">
            <h3 style="color: #800" class="box-title">Course Details</h3>
        </div>
        <form action="{{route('course.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="box-body">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="name">Course Name</label>
                        <input type="text" class="form-control" name="name" id="name" required>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="details">Details</label>
                        <textarea class="form-control editor" name="details" id="details" rows="5"></textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="banner">Banner</label>
                        <input type="file" class="form-control" name="banner" id="banner" onchange="showImg(this)" />
                        <p style="color:red;padding:5px 0">Image size: 4:6 / 400px X 600px</p>
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
<script type="text/javascript">
   // on upload show image
   function showImg(e)
    {
        if(e.parentNode.firstElementChild.tagName == 'IMG')
        {
            e.parentNode.firstElementChild.src = window.URL.createObjectURL(e.files[0]);
        }
        else
        {
            let img = document.createElement('img');
            img.src = window.URL.createObjectURL(e.files[0]);
            img.setAttribute('style', 'width:100%;max-width:400px; margin-top:15px');
            img.alt = '';
            e.parentNode.appendChild(img);
        }
        
    }

    //this script for text editor
    $(document).ready(function() {
        $('.editor').summernote({
            height: 150
        });
    });
</script>
@endsection