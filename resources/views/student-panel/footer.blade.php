<!-- Footer -->
<div style="background: #000">
  <p style="color:#fff; text-align:center">
    <a href="{{route('home.page', 'about-us')}}">About Us</a> |
    <a href="{{route('home.page', 'terms-condition')}}">Terms & Condition</a> |
    <a href="{{route('home.page', 'privacy-policy')}}">Privacy Policy</a> |
    <a href="{{route('home.page', 'return-policy')}}">Fund Return Policy</a>
  </p>
  <p style="text-align: center">
    <img src="/img/pay-buttons.png" alt="" style="width:100%">
  </p>
</div>
<footer class="col-md-12" id="footer" style="background:#000; padding:5px; color:#ddd; position: fixed; left:0; right:0; bottom:0; z-index:999">
  <div class="copyright">
    <ul class="icons">
      <!-- <li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li> -->
      {{-- <li><a target="_blank" href="https://www.facebook.com/NativeSharks-2225856404352825/" class="icon fa-facebook"><span class="label">Facebook</span></a></li> --}}
      <!-- <li><a href="#" class="icon fa-instagram"><span class="label">Instagram</span></a></li> -->
      <!-- <li><a href="#" class="icon fa-snapchat"><span class="label">Snapchat</span></a></li> -->
    </ul>
    <p style="text-align: center;">Copyright &copy; {{date('Y')}} {{config('app.name')}}. All rights reserved.</p>
  </div>
</footer>