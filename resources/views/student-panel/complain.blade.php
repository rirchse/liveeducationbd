@php
$user = Auth::guard('student')->user();
$student = [];
if($user)
{
  $student = \App\Models\Student::find($user->id);
}
@endphp
@extends('student')
@section('title', 'হোম')
@section('content')
{{-- <script src='https://www.google.com/recaptcha/api.js' async defer></script> --}}
<style> </style>

<div class="content-wrapper">
  <div class="container">

    <!-- Main content -->
    <section class="content">
      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-ti/tle" style="text-align: center;display:block">আপনার মতামত দিন</h3>
        </div>

        <div class="row" style="margin-bottom:35px">
          <div class="col-md-12">
            <div class="col-md-6 col-md-offset-3">
              <form action="{{ route('students.complain.store') }}" method="POST" style="margin-bottom:15px">
                @csrf
                <div class="form-group">
                  <label for="name">আপনার নাম</label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input type="text" name="name" class='form-control' required value="{{$user?$user->name:''}}" />
                  </div>
                </div>
                <div class="form-group">
                  <label for="email">ইমেইল এড্রেস</label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                    <input type="email" name="email" class='form-control' required value="{{$user?$user->email:''}}"/>
                  </div>
                </div>
                <div class="form-group">
                  <label for="mobile">মোবাইল নম্বর</label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                    <input type="text" name="contact" class='form-control' required placeholder="010 00 000 000" value="{{$user?$user->contact:''}}"/>
                  </div>
                </div>
                {{-- <div class="form-group">
                  <label for="department">আপনার ডিপার্টমেন্ট</label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-sitemap"></i></span>
                    <input type="text" name="department" class="form-control" />
                  </div>
                </div> --}}
                @if($user && $student->batches)
                <div class="form-group">
                  <label for="department">আপনার ব্যাচ নির্বাচন করুন</label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-sitemap"></i></span>
                    <select name="department" class="form-control" >
                      <option value="">Select One</option>
                      @foreach($student->batches as $batch)
                      <option value="{{$batch->id}}">{{$batch->name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                @endif
                <div class="row">
                  <div class="col-xs-12">
                    {{-- @include('/partials.google_recaptcha') --}}
                    {{-- <br> --}}
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label class="">আপনার মতামত লিখুন</label>
                      <textarea name="details" id="" cols="30" rows="10" class="form-control"></textarea>
                    </div>
                  </div>
                  <!-- /.col -->
                  <div class="col-xs-12">
                    <button type="submit" class="btn btn-info btn-submit btn-block">Submit</button>
                  </div>
                  
                </div><!-- /.col -->
              </form>
            </div>
          </div>
        </div> <!-- /.row -->
      </div> <!-- /.box -->

    </section> <!-- /.content -->
  </div> <!-- /.container -->
</div>
@endsection