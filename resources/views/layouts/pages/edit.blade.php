@extends('dashboard')
@section('title', 'Edit Page')
@section('stylesheets')
<link href="/assets/summernote/summernote.min.css" rel="stylesheet">
@endsection
@section('content')
<section class="content-header">
  <h1>Edit Page</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Pages</a></li>
    <li class="active">Edit Page</li>
</ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row"> <!-- left column -->
    <div class="col-md-12"> <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border">
            <h3 style="color: #800" class="box-title">Page Details</h3>
        </div>
        <form action="{{route('page.update', $page)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="box-body">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="title">Page Title</label>
                        <input type="text" class="form-control" name="title" id="title" required value="{{$page->title}}">
                    </div>
                    <div class="form-group">
                        <label for="slug">Page Slug</label>
                        <input type="text" class="form-control" name="slug" id="slug" required readonly ondblclick="makeEditable(this)" value="{{$page->slug}}">
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="details">Details</label>
                        <textarea class="form-control editor" name="details" id="details" rows="5">{{$page->details}}</textarea>
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
    
    //this script for text editor
    $(document).ready(function() {
        $('.editor').summernote({
            height: 350
        });
    });

    //make field editable
    function makeEditable(e)
    {
        e.removeAttribute('readonly', 'readonly');
    }
</script>
@endsection