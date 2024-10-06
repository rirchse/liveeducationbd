@extends('dashboard')
@section('title', 'Edit Batch')
@section('content')
<section class="content-header">
  <h1>Edit Batch</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Batches</a></li>
    <li class="active">Edit Batch</li>
</ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row"> <!-- left column -->
    <div class="col-md-8"> <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border">
            <h3 style="color: #800" class="box-title">Batch Details</h3>
        </div>
        <form action="{{route('batch.update', $batch)}}" method="POST">
            @csrf
            @method('PUT')
            <div class="box-body">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="name">Batch Name</label>
                        <input type="text" class="form-control" name="name" id="name" required value="{{$batch->name}}">
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="details">Details</label>
                        <textarea class="form-control" name="details" id="details" rows="5">{{$batch->details}}</textarea>
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
</script>
@endsection