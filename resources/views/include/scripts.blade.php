<!-- start: MAIN JAVASCRIPTS -->
<script src="{{asset('core/vendor/jquery/jquery.min.js', env('REDIRECT_HTTPS'))}}"></script>
<script src="{{asset('core/vendor/bootstrap/js/bootstrap.min.js', env('REDIRECT_HTTPS'))}}"></script>
<script src="{{asset('core/vendor/modernizr/modernizr.js', env('REDIRECT_HTTPS'))}}"></script>
<script src="{{asset('core/vendor/jquery-cookie/jquery.cookie.js', env('REDIRECT_HTTPS'))}}"></script>
<script src="{{asset('core/vendor/perfect-scrollbar/perfect-scrollbar.min.js', env('REDIRECT_HTTPS'))}}"></script>
<script src="{{asset('core/vendor/switchery/switchery.min.js', env('REDIRECT_HTTPS'))}}"></script>
<!-- end: MAIN JAVASCRIPTS -->
<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<!-- <script src="{{asset('core/vendor/Chart.js/Chart.min.js', env('REDIRECT_HTTPS'))}}"></script> -->
<script src="{{asset('core/vendor/jquery.sparkline/jquery.sparkline.min.js', env('REDIRECT_HTTPS'))}}"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<!-- start: CLIP-TWO JAVASCRIPTS -->
<script src="{{asset('core/assets/js/main.js', env('REDIRECT_HTTPS'))}}"></script>
<!-- start: JavaScript Event Handlers for this page -->
<script src="{{asset('core/assets/js/index.js', env('REDIRECT_HTTPS'))}}"></script>
<script>
	$.ajaxSetup({
	    headers: {
	      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});

	jQuery(document).ready(function() {
		Main.init();
		Index.init();
		$('#app').addClass('app-sidebar-closed');
	});
</script>
<!-- end: JavaScript Event Handlers for this page -->
<!-- end: CLIP-TWO JAVASCRIPTS -->