@php
	$menu  = \Request::get('permissions');

	if(@$menu[Request::segment(1)]['sub']) {

	   $submenu      = $menu[Request::segment(1)]['sub'][Request::segment(2)];
	   $menu_name    = $submenu['submenu_name'];
	   $menu_key     = $submenu['submenu_key'];
	   $menu_link    = url(Request::segment(1).'/'.$submenu['submenu_link']);
	   $menu_icon    = $submenu['submenu_icon'];
	   $menu_read    = ($submenu['submenu_read'] ? true : false);
	   $menu_write   = ($submenu['submenu_write'] ? true : false);
	   $menu_delete  = ($submenu['submenu_delete'] ? true : false);
	   $menu_super   = ($submenu['submenu_super'] ? true : false);
	} else {

	   $mainmenu     = $menu[Request::segment(1)]['main'];
	   $menu_name    = $mainmenu['menu_name'];
	   $menu_key     = $mainmenu['menu_key'];
	   $menu_link    = url($mainmenu['menu_link']);
	   $menu_icon    = $mainmenu['menu_icon'];
	   $menu_read    = ($mainmenu['menu_read'] ? true : false);
	   $menu_write   = ($mainmenu['menu_write'] ? true : false);
	   $menu_delete  = ($mainmenu['menu_delete'] ? true : false);
	   $menu_super   = ($mainmenu['menu_super'] ? true : false);
	}
@endphp

@extends('include.template')

@section('content')

	<div class="main-content">
		<div class="wrap-content container" id="container">
			<!-- start: PAGE TITLE -->
			<section id="page-title" class="padding-top-15 padding-bottom-15">
				<div class="row">
                  	<div class="col-sm-8">
                      	<h1>
                      		<i class="{{$menu_icon}}"></i> {{$menu_name}} 
                      		{{-- <small class="text-small">เพิ่มกลุ่มผู้ใช้งานและจัดการสิทธิ์การเข้าถึงเมนู</small> --}}
                      	</h1>
                  	</div>
				</div>
			</section>
			<!-- end: PAGE TITLE -->
			<!-- start: FORM VALIDATION EXAMPLE 1 -->
			<div class="container-fluid container-fullw bg-white">

				@if ($errors->any())
                    <div class="alert alert-danger">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                      </button>
                      <ul style="padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                          <li>
                            {{ $error }}
                          </li>
                        @endforeach
                      </ul>
                    </div>
                @endif

				<form role="form" name="formAdd" id="form" method="post">
					{{ csrf_field() }}
					<div class="row">
						<div class="col-md-9">
							<fieldset>
								<legend class="text-bold">
									Form Box
								</legend>
								<div class="row">

									<!-- start: ERROR MESSAGES -->
									<div class="col-md-12">
										<div class="errorHandler alert alert-danger no-display">
											<i class="fa fa-times-sign"></i> You have some form errors. Please check below.
										</div>
										<div class="successHandler alert alert-success no-display">
											<i class="fa fa-ok"></i> Your form validation is successful!
										</div>
									</div>
									<!-- end: ERROR MESSAGES -->

									<div class="col-md-12">
										<div class="form-group">
											<label class="control-label text-bold">
												Role Name <span class="symbol required"></span>
											</label>
											<input type="text" placeholder="Insert your First Name" name="role_name" class="form-control" id="role_name" value="{{ old('role_name') }}">
										</div>

										<div class="form-group">
											<label class="control-label text-bold">
												Access Level <span class="symbol required"></span>
											</label>
											<div>
												<div class="checkbox clip-check check-primary checkbox-inline">
													<input type="checkbox" name="cms_level" id="cms" value="1">
													<label for="cms">
														CMS Level
													</label>
												</div>
												<div class="checkbox clip-check check-primary checkbox-inline">
													<input type="checkbox" name="sa_level" id="sa" value="1">
													<label for="sa">
														SA Level
													</label>
												</div>
											</div>
										</div>

										@if ($menu_super)
										<div class="form-group">
											<label class="control-label text-bold">
												Superadmin
											</label>
											<select class="cs-select cs-skin-elastic" id="group_superadmin" name="permission_s">
												<option value="y">Yes</option>
												<option value="n" selected="">No</option>
											</select>
										</div>
										@endif

										<div class="form-group">
											<label class="control-label text-bold">
												Permissions 
												{{-- <span class="symbol required"></span> --}}
											</label>
											<p>Select Menu to allow access</p>
										</div>

									<!-- ########################################################################### -->
										<div class="form-group">
											<div class="row checkbox clip-check check-primary">
												<div class="col-md-4 margin-top-5">
													<input type="checkbox" class="parentCheckBox" id="Dashboard" checked="" data-set=".menu_0">
													<label class="text-bold" for="Dashboard">
														Dashboard
													</label>
												</div>
												<div class="col-md-6 menu_0">
													<span class="text-bold">
														&nbsp;&nbsp;&nbsp;
														<div class="checkbox clip-check check-primary checkbox-inline">
															<input type="checkbox" id="r_menu_0" checked="">
															<label for="r_menu_0">
																Read
															</label>
														</div>
														<div class="checkbox clip-check check-primary checkbox-inline">
															<input type="checkbox" id="w_menu_0" checked="">
															<label for="w_menu_0">
																Write
															</label>
														</div>
														<div class="checkbox clip-check check-primary checkbox-inline">
															<input type="checkbox" id="e_menu_0" checked="">
															<label for="e_menu_0">
																Delete
															</label>
														</div>
													</span>
												</div>
											</div>
										</div>

										@php
										$html = "";
										foreach ($all_menu as $key => $menu) {

								             $html .= '<div class="form-group">
													<div class="row checkbox clip-check check-primary">
														<div class="col-md-4 margin-top-5">
															<input type="checkbox" class="parentCheckBox" name="menu[mmu]['.$menu['id'].']" id="'.$menu['menu_name'].'" value="1" data-set=".menu_'.$menu['id'].'">
															<label class="text-bold" for="'.$menu['menu_name'].'">
																'.$menu['menu_name'].'
															</label>
														</div>
														<div class="col-md-6 menu_'.$menu['id'].'">
															<span class="text-bold">
																&nbsp;&nbsp;&nbsp;
																<div class="checkbox clip-check check-primary checkbox-inline">
																	<input type="checkbox" name="permission_r[mmu]['.$menu['id'].']" id="r_menu_'.$menu['id'].'" value="1">
																	<label for="r_menu_'.$menu['id'].'">
																		Read
																	</label>
																</div>
																<div class="checkbox clip-check check-primary checkbox-inline">
																	<input type="checkbox" name="permission_w[mmu]['.$menu['id'].']" id="w_menu_'.$menu['id'].'" value="1">
																	<label for="w_menu_'.$menu['id'].'">
																		Write
																	</label>
																</div>
																<div class="checkbox clip-check check-primary checkbox-inline">
																	<input type="checkbox" name="permission_d[mmu]['.$menu['id'].']" id="e_menu_'.$menu['id'].'" value="1">
																	<label for="e_menu_'.$menu['id'].'">
																		Delete
																	</label>
																</div>
															</span>
														</div>
													</div>';

													foreach ($menu['submenu'] as $k => $submenu) {

														$html .= '<div class="row checkbox clip-check check-primary margin-left-30 menu_'.$menu['id'].'">
															<div class="col-md-4 margin-top-5">
																<input type="checkbox" class="childCheckBox" name="menu[smu]['.$submenu['id'].']" id="'.$submenu['submenu_name'].'" value="1" data-set=".submenu_'.$menu['id'].'_'.$submenu['id'].'">
																<label class="text-bold" for="'.$submenu['submenu_name'].'">
																	'.$submenu['submenu_name'].'
																</label>
															</div>
															<div class="col-md-6 submenu_'.$menu['id'].'_'.$submenu['id'].'" style="margin-left: -30px;">
																<span class="text-bold">
																	&nbsp;&nbsp;&nbsp;
																	<div class="checkbox clip-check check-primary checkbox-inline">
																		<input type="checkbox" name="permission_r[smu]['.$submenu['id'].']" id="r_submenu_'.$menu['id'].'_'.$submenu['id'].'" value="1">
																		<label for="r_menu_'.$menu['id'].'_'.$submenu['id'].'">
																			Read
																		</label>
																	</div>
																	<div class="checkbox clip-check check-primary checkbox-inline">
																		<input type="checkbox" name="permission_w[smu]['.$submenu['id'].']" id="w_msubmenu_'.$menu['id'].'_'.$submenu['id'].'" value="1">
																		<label for="w_menu_'.$menu['id'].'_'.$submenu['id'].'">
																			Write
																		</label>
																	</div>
																	<div class="checkbox clip-check check-primary checkbox-inline">
																		<input type="checkbox" name="permission_d[smu]['.$submenu['id'].']" id="e_submenu_'.$menu['id'].'_'.$submenu['id'].'" value="1">
																		<label for="e_menu_'.$menu['id'].'_'.$submenu['id'].'">
																			Delete
																		</label>
																	</div>
																</span>
															</div>
														</div>';
													}

												$html .= '</div>';
										}
										echo $html;
										@endphp

									<!-- ########################################################################### -->
									</div>

								</div>
							</fieldset>

							<a href="{{ $menu_link }}" class="btn btn-danger btn-wide pull-left">
								<i class="fa fa-arrow-circle-left"></i> ย้อนกลับ
							</a>
							<button class="btn btn-primary btn-wide pull-right" type="submit">
								บันทึก <i class="ti-check"></i>
							</button>

						</div>

					</div>
				</form>
			</div>
			<!-- end: FORM VALIDATION EXAMPLE 1 -->
		</div>
	</div>

@stop

@section('scripts')
<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script src="{{asset('core/vendor/selectFx/classie.js', env('REDIRECT_HTTPS'))}}"></script>
<script src="{{asset('core/vendor/selectFx/selectFx.js', env('REDIRECT_HTTPS'))}}"></script>
<script src="{{asset('core/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js', env('REDIRECT_HTTPS'))}}"></script>
<script src="{{asset('core/vendor/ckeditor/ckeditor.js', env('REDIRECT_HTTPS'))}}"></script>
<script src="{{asset('core/vendor/ckeditor/adapters/jquery.js', env('REDIRECT_HTTPS'))}}"></script>
<script src="{{asset('core/vendor/jquery-validation/jquery.validate.min.js', env('REDIRECT_HTTPS'))}}"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<!-- start: JavaScript Event Handlers for this page -->
<script src="{{asset('core/assets/js/form-elements.js', env('REDIRECT_HTTPS'))}}"></script>
<script src="{{asset('core/assets/js/form-validation.js', env('REDIRECT_HTTPS'))}}"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script>
	$(function () {

		FormElements.init();
		FormValidator.init('');

		CheckBox();
	});

	function CheckBox() {

        $(".parentCheckBox").click(
            function() {
                $(this).parents('.form-group:eq(0)').find('.childCheckBox').prop('checked', this.checked);
                $($(this).prop('checked', this.checked).data('set')+" input:checkbox").prop('checked', this.checked);
            }
        );
        //clicking the last unchecked or checked checkbox should check or uncheck the parent checkbox
        $('.childCheckBox').click(
            function() {
                if ($(this).parents('.form-group:eq(0)').find('.parentCheckBox').prop('checked') == true && this.checked == false)
                    $(this).parents('.form-group:eq(0)').find('.parentCheckBox').prop('checked', true);
                	$($(this).prop('checked', this.checked).data('set')+" input:checkbox").prop('checked', this.checked);

                if (this.checked == true) {
                    var flag = true;
                    $(this).parents('.form-group:eq(0)').find('.childCheckBox').each(
	                    function() {
	                        // if (this.checked == false)
	                        //     flag = false;
	                    }
                    );
                    $(this).parents('.form-group:eq(0)').find('.parentCheckBox').prop('checked', flag);
                }
            }
        );
	}

</script>
<!-- end: JavaScript Event Handlers for this page -->
<!-- end: CLIP-TWO JAVASCRIPTS -->
@stop