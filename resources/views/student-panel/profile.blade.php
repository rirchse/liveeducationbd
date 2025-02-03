@php
$user = Auth::guard('student')->user();
$student = [];
if($user)
{
  $student = \App\Models\Student::find($user->id);
}
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
@endphp
@extends('student')
@section('title', 'হোম')
@section('content')
{{-- <script src='https://www.google.com/recaptcha/api.js' async defer></script> --}}
<style> </style>

    <!-- Main content -->
    <section class="content">
      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-ti/tle" style="text-align: center;display:block">প্রোফাইল</h3>
        </div>

        <div class="row" style="margin-bottom:35px">
          <div class="col-md-12">
            <div class="col-md-6 col-md-offset-3">
              <form action="#" method="POST" style="margin-bottom:15px">
                @csrf
                <div class="form-group">
                  <label for="name">রেজিস্ট্রেশন আইডি</label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input type="text" name="name" class='form-control' required value="{{$user?$source->numset($user->id, 6):''}}" disabled/>
                  </div>
                </div>
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
                <div class="form-group">
                  <label for="mobile">রেজিস্ট্রেশন তারিখ</label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input type="text" name="contact" class='form-control' required placeholder="010 00 000 000" value="{{$user?$user->created_at:''}}"/>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div> <!-- /.row -->
      </div> <!-- /.box -->

    </section> <!-- /.content -->
@endsection