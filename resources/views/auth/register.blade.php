@extends('login')
@section('title', 'Register')
@section('content')
{{-- <script src='https://www.google.com/recaptcha/api.js' async defer></script> --}}
<style>
  .checkbox{padding-left: 25px}
</style>

<div class="main-wrapper" style="width:100%;margin-bottom:50px">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="sign-up-form">
        <div class="login-box" style="margin-top:10px">
        <div class="login-logo">
          <h2 style="color:#fff">{{config('app.name', 'App Name')}} Register</h2>
        </div>
        <!-- /.login-logo -->
        
        <div class="login-box-body">
          {{-- <p class="login-box-msg">
            <img src="/img/logo.png?v=3008" alt=""><br><br>Login to start your session</p> --}}

            <div style="text-align:center">
              <h4>Sign up by Google</h4>
              <a class="btn btn-default" href="/auth/google">
                <img style="max-width: 150px" src="https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png" alt="">
              </a>
            </div>
  
            <hr>
  
            <h3 style="text-align: center">or</h3>

          <form action="{{ route('register.post') }}" method="POST" style="margin-bottom:15px">
            @csrf
            <div class="form-group">
              <label for="name">Full Name</label>
              <div class="input-group">
                <input type="text" name="name" class='form-control' required />
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
              </div>
            </div>
            <div class="form-group">
              <label for="email">Email Address</label>
              <div class="input-group">
                <input type="email" name="email" class='form-control' required />
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
              </div>
            </div>
            <div class="form-group">
              <label for="mobile">Mobile</label>
              <div class="input-group">
                <input type="text" name="contact" class='form-control' required placeholder="010 00 000 000" />
                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
              </div>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <div class="input-group">
                <input type="password" name="password" class="form-control" required>
                <span class="input-group-addon" onclick="showPassword(this)"><i class="fa fa-eye-slash"></i></span>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-12">
                {{-- @include('/partials.google_recaptcha') --}}
                {{-- <br> --}}
              </div>
              {{-- <div class="col-xs-8">
                <div class="checkbox icheck">
                  <label class="">
                    <input type="checkbox" class="checkbox"> Remember Me
                  </label>
                  <div class="clearfix"></div>
                </div>
              </div> --}}
              <!-- /.col -->
              <div class="col-xs-12">
                <button type="submit" class="btn btn-info btn-submit btn-block">Submit</button>
              </div>
              <!-- /.col -->
            </div>
          </form>

          <!-- <div class="social-auth-links text-center">
            <p>- OR -</p>
            <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Login using
              Facebook</a>
            <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Login using
              Google+</a>
          </div> -->
          <!-- /.social-auth-links -->

          <a href="{{route('students.login')}}" class="text-primary">Already have an account?</a>
        </div><!-- /.login-box-body -->
      </div><!-- /.login-box -->
      </div>
      
    </div>
  </div>
</div>

<script>
  function showPassword(e)
  {
    let elm = e.previousElementSibling;
    if(elm.type == 'password')
    {
      elm.setAttribute('type', 'text');
      e.firstChild.classList.add('fa-eye');
      e.firstChild.classList.remove('fa-eye-slash');
    }
    else 
    {
      elm.setAttribute('type', 'password');
      e.firstChild.classList.add('fa-eye-slash');
      e.firstChild.classList.remove('fa-eye');
    }
  }
</script>
@endsection