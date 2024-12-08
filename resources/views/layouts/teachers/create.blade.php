@extends('dashboard')
@section('title', 'Add New Teacher')
@section('content')

 <section class="content-header">
      <h1>Add New Teacher</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Users</a></li>
        <li class="active">Add New Teacher</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 style="color: #800" class="box-title">Teacher Details</h3>
            </div>
    <form action="{{route('teacher.store')}}" method="POST" enctype="multipart/form-data" >
        @csrf
        <div class="box-body">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" name="name" class="form-control" required />
                </div><div class="form-group">
                    <label for="">Email Address</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="" >Contact</label>
                    <input type="text" name="contact" class="form-control" required />
                </div>
                <div class="form-group">
                    <label for="">Password</label>
                    <div class="input-group">
                      <input type="text" name="password" class="form-control" required />
                      <span class="input-group-addon" onclick="showPassword(this)"><i class="fa fa-eye"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                  <label for="">Photo</label>
                  <input type="file" name="image" class="form-control" />
              </div>
              <p class="text-danger">Image Dimension: 200x200px;<br> Types must be in: .jpeg, .jpg, .png and <br>Max size: 500KB</p>
          </div>

        </div>

        <div class="box-footer">
            <button type="submit" class="btn btn-primary pull-right">Save</button>
        </div>
        <div class="clearfix"></div>
    </form>
          </div> <!-- /.box -->
        </div> <!--/.col (left) -->
      </div> <!-- /.row -->
    </section> <!-- /.content -->

    <script>
      function showPassword(e)
      {
        if(e.previousElementSibling.getAttribute('type') == 'password')
        {
          e.previousElementSibling.setAttribute('type', 'text');
        }
        else
        {
          e.previousElementSibling.setAttribute('type', 'password');
        }
        
      }
    </script>
@endsection