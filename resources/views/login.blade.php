<!DOCTYPE html>
<!-- Template Name: Clip-Two - Responsive Admin Template build with Twitter Bootstrap 3.x | Author: ClipTheme -->
<!--[if IE 8]><html class="ie8" lang="en"><![endif]-->
<!--[if IE 9]><html class="ie9" lang="en"><![endif]-->
<!--[if !IE]><!-->
<html lang="en">
	<!--<![endif]-->
	<!-- start: HEAD -->
	<!-- start: HEAD -->
	<head>
		<title>{{ @env('TITLE_NAME') }} | Log in</title>
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
		<!-- start: MAIN CSS -->
		<link rel="stylesheet" href="{{asset('core/vendor/bootstrap/css/bootstrap.min.css', env('REDIRECT_HTTPS'))}}">
		<link rel="stylesheet" href="{{asset('core/vendor/fontawesome/css/font-awesome.min.css', env('REDIRECT_HTTPS'))}}">
		<link rel="stylesheet" href="{{asset('core/vendor/themify-icons/themify-icons.min.css', env('REDIRECT_HTTPS'))}}">
		<link rel="stylesheet" href="{{asset('core/vendor/animate.css/animate.min.css', env('REDIRECT_HTTPS'))}}" rel="stylesheet" media="screen">
		<link rel="stylesheet" href="{{asset('core/vendor/perfect-scrollbar/perfect-scrollbar.min.css', env('REDIRECT_HTTPS'))}}" rel="stylesheet" media="screen">
		<link rel="stylesheet" href="{{asset('core/vendor/switchery/switchery.min.css', env('REDIRECT_HTTPS'))}}" rel="stylesheet" media="screen">
		<!-- end: MAIN CSS -->
		<!-- start: CLIP-TWO CSS -->
		<link rel="stylesheet" href="{{asset('core/assets/css/styles.css', env('REDIRECT_HTTPS'))}}">
		<link rel="stylesheet" href="{{asset('core/assets/css/plugins.css', env('REDIRECT_HTTPS'))}}">
		<link rel="stylesheet" href="{{asset('core/assets/css/themes/theme-1.css', env('REDIRECT_HTTPS'))}}" id="skin_color" />
		<link rel="stylesheet" href="{{asset('css/app.css', env('REDIRECT_HTTPS'))}}">
		<!-- end: CLIP-TWO CSS -->
		<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
		<!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->
	</head>
	<!-- end: HEAD -->
	<!-- start: BODY -->
	<body class="login">
		<!-- start: LOGIN -->
		<div class="row">
			<div class="main-login col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
				{{-- <div class="logo margin-top-30">
					<link rel="stylesheet" href="{{asset('core/assets/images/logo.png', env('REDIRECT_HTTPS'))}}" alt=""/>
				</div> --}}
				<!-- start: LOGIN BOX -->
				<div class="box-login">
					<form class="form-login" action="{{ url('/auth/login') }}" method="post">
						{{ csrf_field() }}
						<fieldset>
							<legend>
								ระบบฐานข้อมูลสืบค้นงานวิจัย
							</legend>
							<p>
								กรุณาใส่ ชื่อผู้ใช้งาน และ รหัสผ่าน เพื่อเข้าสู่ระบบ
							</p>
							@if ($errors->any())
								@if ($errors->first()=="การเปลี่ยนรหัสผ่านของคุณ สำเร็จ!")
							        <div class="alert alert-success">
							          {{$errors->first()}}
							        </div>
								@else
							        <div class="alert alert-danger">
							          {{$errors->first()}}
							        </div>
							    @endif
						    @endif

			                <!-- fix check cange profile 3 -->

							<div class="form-group">
								<span class="input-icon">
									<input type="text" class="form-control" name="username" placeholder="Username" value="{{ old('username') }}" required autofocus>
									<i class="fa fa-user"></i>
								</span>
                                @if ($errors->has('username'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                                
							</div>
							<div class="form-group">
								<span class="input-icon">
									<input type="password" class="form-control password" name="password" placeholder="Password">
									<i class="fa fa-lock"></i>
									<!-- <a class="forgot" href="login_forgot.html">
										I forgot my password
									</a> -->
								</span>
							</div>
							
							<div class="form-actions">
								<!-- <div class="checkbox clip-check check-primary">
									<input type="checkbox" id="remember" value="1">
									<label for="remember">
										Keep me signed in
									</label>
								</div> -->
								<div class="text-center margin-bottom-15">
									@captcha()
								</div>

								<button type="submit" class="btn btn-primary btn-block">
									เข้าสู่ระบบ <i class="fa fa-arrow-circle-right"></i>
								</button>
							</div>

						</fieldset>
					</form>
				</div>
				<!-- end: LOGIN BOX -->
			</div>
		</div>
		<!-- end: LOGIN -->
		<!-- start: MAIN JAVASCRIPTS -->
		<script src="{{asset('core/vendor/jquery/jquery.min.js', env('REDIRECT_HTTPS'))}}"></script>
		<script src="{{asset('core/vendor/bootstrap/js/bootstrap.min.js', env('REDIRECT_HTTPS'))}}"></script>
		<script src="{{asset('core/vendor/modernizr/modernizr.js', env('REDIRECT_HTTPS'))}}"></script>
		<script src="{{asset('core/vendor/jquery-cookie/jquery.cookie.js', env('REDIRECT_HTTPS'))}}"></script>
		<script src="{{asset('core/vendor/perfect-scrollbar/perfect-scrollbar.min.js', env('REDIRECT_HTTPS'))}}"></script>
		<script src="{{asset('core/vendor/switchery/switchery.min.js', env('REDIRECT_HTTPS'))}}"></script>
		<!-- end: MAIN JAVASCRIPTS -->
		<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<script src="{{asset('core/vendor/jquery-validation/jquery.validate.min.js', env('REDIRECT_HTTPS'))}}"></script>
		<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<!-- start: CLIP-TWO JAVASCRIPTS -->
		<script src="{{asset('core/assets/js/main.js', env('REDIRECT_HTTPS'))}}"></script>
		<!-- start: JavaScript Event Handlers for this page -->
		<script src="{{asset('core/assets/js/login.js', env('REDIRECT_HTTPS'))}}"></script>
		<script>
			$.ajaxSetup({
			    headers: {
			      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			    }
			});
			
			jQuery(document).ready(function() {
				Main.init();
				Login.init();
			});
		</script>
		<!-- end: JavaScript Event Handlers for this page -->
		<!-- end: CLIP-TWO JAVASCRIPTS -->
	</body>
	<!-- end: BODY -->
</html>