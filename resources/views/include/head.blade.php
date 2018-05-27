@php
$menu  		= \Request::get('permissions');
if(@$menu[Request::segment(1)]['main']) {
	$mainmenu 	= $menu[Request::segment(1)]['main'];
	$mainmenu 	= $mainmenu['menu_name'];
} else {
	$mainmenu 	= "Dashboard";
}

@endphp
<title>{{ @env('TITLE_NAME') }} | {{ $mainmenu }}</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- start: META -->
<!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta content="" name="description" />
<meta content="" name="author" />
<!-- end: META -->
<!-- start: GOOGLE FONTS -->
{{-- <link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" /> --}}
<!-- end: GOOGLE FONTS -->
<!-- start: MAIN CSS -->

<link rel="stylesheet" href="{{asset('core/vendor/bootstrap/css/bootstrap.min.css', env('REDIRECT_HTTPS'))}}">
<link rel="stylesheet" href="{{asset('core/vendor/fontawesome/css/font-awesome.min.css', env('REDIRECT_HTTPS'))}}">
<link rel="stylesheet" href="{{asset('core/vendor/themify-icons/themify-icons.min.css', env('REDIRECT_HTTPS'))}}">
<link href="{{asset('core/vendor/animate.css/animate.min.css', env('REDIRECT_HTTPS'))}}" rel="stylesheet" media="screen">
<link href="{{asset('core/vendor/perfect-scrollbar/perfect-scrollbar.min.css', env('REDIRECT_HTTPS'))}}" rel="stylesheet" media="screen">
<link href="{{asset('core/vendor/switchery/switchery.min.css', env('REDIRECT_HTTPS'))}}" rel="stylesheet" media="screen">
<!-- end: MAIN CSS -->
<!-- start: CLIP-TWO CSS -->
<link rel="stylesheet" href="{{asset('core/assets/css/styles.css', env('REDIRECT_HTTPS'))}}">
<link rel="stylesheet" href="{{asset('core/assets/css/plugins.css', env('REDIRECT_HTTPS'))}}">

<link rel="stylesheet" href="{{asset('core/assets/css/themes/theme-2.css', env('REDIRECT_HTTPS'))}}">
<!-- end: CLIP-TWO CSS -->
<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
<!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->

<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
<link href="{{asset('core/vendor/select2/select2.min.css', env('REDIRECT_HTTPS'))}}" rel="stylesheet" media="screen">
<link href="{{asset('core/vendor/bootstrap-datepicker/bootstrap-datepicker3.standalone.min.css', env('REDIRECT_HTTPS'))}}" rel="stylesheet" media="screen">
<link href="{{asset('core/vendor/DataTables/css/DT_bootstrap.css', env('REDIRECT_HTTPS'))}}" rel="stylesheet" media="screen">
<link href="{{asset('core/vendor/select2/select2.min.css', env('REDIRECT_HTTPS'))}}" rel="stylesheet" media="screen">
<link href="{{asset('core/vendor/bootstrap-fileinput/jasny-bootstrap.min.css', env('REDIRECT_HTTPS'))}}" rel="stylesheet" media="screen">
<link href="{{asset('core/vendor/fullcalendar/fullcalendar.min.css', env('REDIRECT_HTTPS'))}}" rel="stylesheet" media="screen">
<link rel="stylesheet" href="{{asset('core/vendor/fullcalendar/fullcalendar.print.css', env('REDIRECT_HTTPS'))}}" media="print">
<link href="{{asset('core/vendor/bootstrap-timepicker/bootstrap-timepicker.min.css', env('REDIRECT_HTTPS'))}}" rel="stylesheet" media="screen">
<link href="{{asset('core/vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css', env('REDIRECT_HTTPS'))}}" rel="stylesheet" media="screen">
<!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->

<link rel="stylesheet" href="{{asset('css/app.css', env('REDIRECT_HTTPS'))}}">