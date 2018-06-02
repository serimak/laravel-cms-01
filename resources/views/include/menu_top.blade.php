<header class="navbar navbar-default navbar-static-top">
	<!-- start: NAVBAR HEADER -->
		<div class="navbar-header">
			<a href="#" class="sidebar-mobile-toggler pull-left hidden-md hidden-lg" class="btn btn-navbar sidebar-toggle" data-toggle-class="app-slide-off" data-toggle-target="#app" data-toggle-click-outside="#sidebar">
				<i class="ti-align-justify"></i>
			</a>
			<a class="navbar-brand" href="#">
				<!-- <img src="{{asset('core/assets/images/logo.png', env('REDIRECT_HTTPS'))}}" alt="สวพ."/> -->
			</a>
			<a href="#" class="sidebar-toggler pull-right visible-md visible-lg" data-toggle-class="app-sidebar-closed" data-toggle-target="#app">
				<i class="ti-align-justify"></i>
			</a>
			<a class="pull-right menu-toggler visible-xs-block" id="menu-toggler" data-toggle="collapse" href=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<i class="ti-view-grid"></i>
			</a>
		</div>
	<!-- end: NAVBAR HEADER -->
	<!-- start: NAVBAR COLLAPSE -->
		<div class="navbar-collapse collapse">
			<ul class="nav navbar-right">
				<!-- start: USER OPTIONS DROPDOWN -->
				<li class="dropdown current-user">
					<a href class="dropdown-toggle" data-toggle="dropdown">
						@php
							$img = asset('images/user-default.jpg');
						@endphp
						<img src="{{$img}}">
						<span class="username">{{ Auth::user()->firstname_th }} <i class="ti-angle-down"></i></i></span>
					</a>
					<ul class="dropdown-menu dropdown-dark">
						@if (Auth::user()->username != 'guest')
						<li>
							<a href="{{ url('profile') }}">
								ข้อมูลส่วนตัว
							</a>
						</li>
						<li>
							<a href="{{ url('change_password') }}">
								เปลี่ยนรหัสผ่าน
							</a>
						</li>
						<li>
							<a href="{{ url('/auth/logout') }}">
								ออกจากระบบ
							</a>
						</li>
						@else
						<li>
							<a href="{{ url('/auth/guestlogout') }}">
								ออกจากระบบ
							</a>
						</li>
						@endif
					</ul>
				</li>
				<!-- end: USER OPTIONS DROPDOWN -->
			</ul>
			<!-- start: MENU TOGGLER FOR MOBILE DEVICES -->
			<div class="close-handle visible-xs-block menu-toggler" data-toggle="collapse" href=".navbar-collapse">
				<div class="arrow-left"></div>
				<div class="arrow-right"></div>
			</div>
			<!-- end: MENU TOGGLER FOR MOBILE DEVICES -->
		</div>
	<!-- end: NAVBAR COLLAPSE -->
</header>