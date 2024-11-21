<!-- top bar  -->
<style>
  .main-header{color: #000!important;margin-bottom:50px}
  #header{ padding: 15px; background: rgb(255,255,255,0.8);color: #000}
  .navbar-static-top{ background: #fff; position: fixed;top:0; left:0; right:0}
  .header_logo{width: 190px; padding-left: 50px;margin-top: -7px;margin-bottom: -10px}
  .header_a{float:none;}
  .header_menu{float: right;}
  .header_menu a{color: #000!important}
  .item{margin:9px; color:#eee!important;font-size:18px}
  .alert{margin: 10px auto;float: none;}
  .main-header .navbar-brand{color:#444}
  .navbar-toggle{color:#444}
  body{background-color:#0d0}
  @media screen and (max-width:768px)
  {
    .navbar-collapse, .navbar-nav{text-align:left; width: 100%; padding-left: 0}
  }
</style>

  <header id="head/er" class="main-header" style="color:#000!important">
    <nav class="navbar navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <a href="/" class="navbar-brand">
            <img class="header/_logo" src="/img/logo.png?v=3008" alt="" style="max-width: 70px; display:inline; padding-right: 15px">
            <b>{{config('app.name')}}</b>
          </a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>
        <div class="collapse navbar-collapse pull-right" id="navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="/signup">Sign up</a></li>
            <li><a href="/students/login">Login</a></li>
          </ul>
        </div>
        <div class="navbar-custom-menu">
         
        </div>
      </div>
    </nav>
  </header>
  @include('partials.messages')