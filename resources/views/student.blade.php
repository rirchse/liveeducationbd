<!DOCTYPE html>
<html lang="en">
<head>
	@include('partials.styles')
	@yield('stylesheets')
	<style>
		.content-wrapper{
			background: rgb(0,3,36);
			background: linear-gradient(90deg, rgba(0,3,36,1) 0%, rgba(9,73,121,1) 53%, rgba(7,128,153,1) 100%);
		}
		.content-header, .content-header > .breadcrumb > li > a{color:#fff}
	</style>
</head>

<body class="layout-top-nav">
	<div class="wrapper" style="width:100%;">
    @include('student-panel.header')

		<div class="content-wrapper">
			<div class="container">

				@yield('content')

				@include('student-panel.footer')
			</div>
		</div>
	</div>

	<!--   Core JS Files   -->
	@include('partials.scripts')

	@yield('scripts')

	<script type="text/javascript">
    $().ready(function() {
    	demo.checkFullPageBackgroundImage();
    	setTimeout(function() {
    		// after 1000 ms we add the class animated to the login/register card
    		$('.card').removeClass('card-hidden');
    	}, 700)
    });
  </script>

</body>
</html>