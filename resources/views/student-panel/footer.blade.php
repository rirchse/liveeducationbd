<!-- Footer -->
<style>
  footer{margin-top:30px; background:#000; color:#ddd;}
  .footer-menu{}
  .footer-menu, .social-icons {list-style: none;padding-left: 0}
  .footer-menu li{padding:5px}
  .footer-logo{max-width: 150px; width:100%;}
  .social-icons li a{font-size: 18px}
</style>

<footer id="footer" class="footer">
  <div class="ro/w">
    <div class="col-md-12">
      <div class="col-md-4">
        <br>
        <img src="/img/logo.png" alt="" class="footer-logo">
      </div>
      <div class="col-md-4">
        <br>
        <ul class="footer-menu">
          <li>
            <a href="{{route('home.page', 'about-us')}}">About Us</a></li>
          <li>
            <a href="{{route('home.page', 'terms-condition')}}">Terms & Condition</a>
          </li>
          <li>
            <a href="{{route('home.page', 'privacy-policy')}}">Privacy Policy</a>
          </li>
          <li><a href="{{route('home.page', 'return-policy')}}">Fund Return Policy</a></li>
          <li><a href="{{route('students.complain')}}">Complain Us</a></li>
        </ul>
      </div>
      <div class="col-md-4">
        <h3>Contact Us</h3>
        <address>
          Mobile: 01718778184<br>
          Email: info@liveeducationbd.com<br>
          Address: Jogendranagar, Sabjagri-6450, Gurudaspur, Natore<br>
          Trade License No. 69141130786
        </address>
      </div>
        <div class="copyright">
          <ul class="social-icons">
            <!-- <li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li> -->
            <li>
              <a target="_blank" href="https://www.facebook.com/saeonlineexamgroup?mibextid=ZbWKwL">
                <div class="fa fa-facebook"></div>
                <span class="label">Facebook</span>
              </a>
            </li>
            <!-- <li><a href="#" class="icon fa-instagram"><span class="label">Instagram</span></a></li> -->
            <!-- <li><a href="#" class="icon fa-snapchat"><span class="label">Snapchat</span></a></li> -->
          </ul>
          <p style="text-align: center">
            <img src="/img/pay-buttons.png" alt="" style="width:100%">
          </p>
          <p style="text-align: center;">Copyright &copy; {{date('Y')}} {{config('app.name')}}. All rights reserved.</p>
        </div>
      </div>
  </div>
<div class="clearfix"></div>
</footer>