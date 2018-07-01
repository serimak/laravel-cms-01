@php
  $main_menu 	= \Request::get('permissions');
  $user_role 	= \Auth::user()->role;
@endphp

@if (count($user_role))
	<div class="sidebar app-aside" id="sidebar">
		<div class="sidebar-container perfect-scrollbar">
			<nav>
				<!-- start: MAIN NAVIGATION MENU -->
				<div class="navbar-title">
					<span>MAIN NENU</span>
				</div>

				<ul class="main-navigation-menu">
					<!--
					<li {{ Request::is('dashboard') ? 'class=open' : '' }}>
						<a href="{{ url('dashboard') }}">
							<div class="item-content">
								<div class="item-media">
									<i class="ti-bar-chart-alt"></i>
								</div>
								<div class="item-inner">
									<span class="title"> Dashboard </span>
								</div>
							</div>
						</a>
					</li>
				    -->
					@if ($user_role[0]->cms_level)
						@foreach($main_menu as $key => $menu)
							@if ($menu['main'] && $menu['main']['menu_seq'] < 999)
								@if (Request::get('permissions')[$key])
									<li {{ Request::is($menu['main']['menu_key'].(@$menu['sub'] ? "/*" : "") ) ? 'class=open' : '' }}>
										<a href="{{ url($menu['main']['menu_link']) }}">
											<div class="item-content">
												<div class="item-media">
													<i class="{{$menu['main']['menu_icon']}}"></i>
												</div>
												<div class="item-inner">
													<span class="title"> {{$menu['main']['menu_name']}} </span>
													@if(@$menu['sub'])
														<i class="icon-arrow"></i>
													@endif
												</div>
											</div>

											@if(@$menu['sub'])
												<ul class="sub-menu" {{ Request::is($menu['main']['menu_key'].'/*') ? 'style=display:block;' : '' }}>
													@foreach ($menu['sub'] as $sub)

														<li {{ Request::is($menu['main']['menu_key'].'/'.$sub['submenu_key']) ? 'class=open' : '' }}>
															<a href="{{ url($menu['main']['menu_link']."/".$sub['submenu_link']) }}">
																<i class="{{$sub['submenu_icon']}}"></i> <span>{{$sub['submenu_name']}}</span>
															</a>
														</li>
													@endforeach
												</ul>
											@endif

										</a>
									</li>
								@endif
							@endif
						@endforeach
					@endif
				</ul>
				<!-- end: MAIN NAVIGATION MENU -->
				
				<!-- start: CORE FEATURES -->
				@if ($user_role[0]->sa_level)
					<div class="navbar-title">
						<span>SETTING</span>
					</div>
					<ul class="folders">
						@foreach($main_menu as $key => $menu)
							@if ($menu['main'] && $menu['main']['menu_seq'] > 900)
								@if (Request::get('permissions')[$key])
									<li {{ Request::is($menu['main']['menu_key'].(@$menu['sub'] ? "/*" : "") ) ? 'class=open' : '' }}>
										<a href="{{ url($menu['main']['menu_link']) }}">
											<div class="item-content">
												<div class="item-media">
													<i class="{{$menu['main']['menu_icon']}}"></i>
												</div>
												<div class="item-inner">
													<span class="title"> {{$menu['main']['menu_name']}} </span>
													@if(@$menu['sub'])
														<i class="icon-arrow"></i>
													@endif
												</div>
											</div>

											@if(@$menu['sub'])
												<ul class="sub-menu" {{ Request::is($menu['main']['menu_key'].'/*') ? 'style=display:block;' : '' }}>
													@foreach ($menu['sub'] as $sub)

														<li {{ Request::is($menu['main']['menu_key'].'/'.$sub['submenu_key']) || Request::is($menu['main']['menu_key'].'/'.$sub['submenu_key']."/*") ? 'class=open' : '' }}>
															<a href="{{ url($menu['main']['menu_link']."/".$sub['submenu_link']) }}">
																<i class="{{$sub['submenu_icon']}}"></i> <span>{{$sub['submenu_name']}}</span>
															</a>
														</li>
													@endforeach
												</ul>
											@endif
										</a>
									</li>
								@endif
							@endif
						@endforeach
					</ul>
				@endif
				<!-- end: CORE FEATURES -->
			</nav>
		</div>
	</div>
@endif