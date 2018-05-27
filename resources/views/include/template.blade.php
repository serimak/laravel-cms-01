<!DOCTYPE html>
<!--[if IE 8]><html class="ie8" lang="en"><![endif]-->
<!--[if IE 9]><html class="ie9" lang="en"><![endif]-->
<!--[if !IE]><!-->
<html lang="en">
	<!--<![endif]-->
<head>
  @include('include.head')
</head>

<body>

	<div id="app">
		<!-- sidebar -->
    		@include('include.menu_left')
		<!-- / sidebar -->
		<div class="app-content">
			<!-- start: TOP NAVBAR -->
		    @include('include.menu_top')
			<!-- end: TOP NAVBAR -->
			@yield('content')
		</div>
	</div>

@include('include.scripts')

@yield('scripts')

</body>
</html>