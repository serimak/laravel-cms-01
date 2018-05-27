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
			<!-- start: DASHBOARD TITLE -->
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
			<!-- end: DASHBOARD TITLE -->
			<!-- start: USER PROFILE -->
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
						<div class="col-md-8">
							<fieldset>
								<legend>
									Account Info
								</legend>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label text-bold">
												ชื่อ <span class="symbol required"></span>
											</label>
											<input type="text" placeholder="Text Field" class="form-control" id="firstname_th" name="firstname_th" value="{{ old('firstname_th', $result->firstname_th) }}">
										</div>
										<div class="form-group">
											<label class="control-label text-bold">
												ชื่อกลาง
											</label>
											<input type="text" placeholder="Text Field" class="form-control" id="middlename_th" name="middlename_th" value="{{ old('middlename_th', $result->middlename_th) }}">
										</div>
										<div class="form-group">
											<label class="control-label text-bold">
												นามสกุล <span class="symbol required"></span>
											</label>
											<input type="text" placeholder="Text Field" class="form-control" id="lastname_th" name="lastname_th" value="{{ old('lastname_th', $result->lastname_th) }}">
										</div>
										<div class="form-group">
											<label class="control-label text-bold">
												First Name <span class="symbol required"></span>
											</label>
											<input type="text" placeholder="Text Field" class="form-control" id="firstname_en" name="firstname_en" value="{{ old('firstname_en', $result->firstname_en) }}">
										</div>
										<div class="form-group">
											<label class="control-label text-bold">
												Middle Name
											</label>
											<input type="text" placeholder="Text Field" class="form-control" id="middlename_en" name="middlename_en" value="{{ old('middlename_en', $result->middlename_en) }}">
										</div>
										<div class="form-group">
											<label class="control-label text-bold">
												Last Name <span class="symbol required"></span>
											</label>
											<input type="text" placeholder="Text Field" class="form-control" id="lastname_en" name="lastname_en" value="{{ old('lastname_en', $result->lastname_en) }}">
										</div>
										<div hidden class="form-group">
											<label class="control-label text-bold">
												Citizen ID
											</label>
											<input type="text" placeholder="Text Field" class="form-control" id="citizen_id" name="citizen_id" value="{{ old('citizen_id', $result->citizen_id) }}">
										</div>
										<div hidden class="form-group">
											<label class="control-label text-bold">
												Passport ID
											</label>
											<input type="text" placeholder="Text Field" class="form-control" id="passport_id" name="passport_id" value="{{ old('passport_id', $result->passport_id) }}">
										</div>
										<div hidden class="form-group">
											<label class="control-label text-bold">
												Library Code
											</label>
											<input type="text" placeholder="Text Field" class="form-control" id="library_code" name="library_code" value="{{ old('library_code', $result->library_code) }}">
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label text-bold">
												Gender <span class="symbol required"></span>
											</label>
											<div class="clip-radio radio-primary">
												<input type="radio" value="Female" name="gender" id="us-female" {{ old('gender', $result->gender)=="Female" ? 'checked="checked"' : '' }}>
												<label for="us-female">
													Female
												</label>
												<input type="radio" value="Male" name="gender" id="us-male" {{ old('gender', $result->gender)=="Male" ? 'checked="checked"' : '' }}>
												<label for="us-male">
													Male
												</label>
												<input type="radio" value="Other" name="gender" id="us-other" {{ old('gender', $result->gender)=="Other" ? 'checked="checked"' : '' }}>
												<label for="us-other">
													Other
												</label>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label text-bold">
												Title <span class="symbol required"></span>
											</label>
											<div class="clip-radio radio-primary">
												<select name="title_id" class="cs-select cs-skin-elastic">
												@foreach($titles as $title)
													{{-- <input type="radio" value="{{ $title->id }}" name="title_id" id="title_{{ $title->id }}"
													{{ old('title_id', $result->title_id)==$title->id ? 'checked="checked"' : '' }}>
													<label for="title_{{ $title->id }}">
														{{ $title->title_name_th }}
													</label> --}}
													<option @if(old('title_id', $result->title_id) == $title->id) selected @endif value="{{ $title->id }}">{{ $title->title_name_th }}</option>
												@endforeach
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="text-bold">
												Birth Date <span class="symbol required"></span>
											</label>
											<p class="input-group input-append datepicker date" style="padding: 0px;">
												<input type="text" class="form-control" name="birth_date" id="birth_date" value="{{ old('birth_date', $result->birth_date) }}">
												<span class="input-group-btn">
													<button type="button" class="btn btn-default">
														<i class="glyphicon glyphicon-calendar"></i>
													</button>
												</span>
											</p>
										</div>
										<div class="form-group">
											<label class="text-bold">
												Nationallity <span class="symbol required"></span>
											</label>
												{{-- @php

												var_dump(old('nationallity_id', $result->nationallity_id));exit();

												@endphp --}}
											<select name="nationallity_id" id="nationallity_id" class="cs-select cs-skin-elastic">
											    @foreach($nationalities as $key => $text)
											        <option @if(old('nationallity_id', $result->nationallity_id) == $text->id) selected @endif value="{{ $text->id }}">{{ $text->nationality_name }}</option>
											    @endforeach
											</select>
										</div>
										<div class="form-group">
											<label class="text-bold">
												Group Name <span class="symbol required"></span>
											</label>
											<select name="group_id" id="group_id" class="cs-select cs-skin-elastic">
											    @foreach($groups as $key => $text)
											        <option @if(old('group_id', $result->group_id) === $text->id) selected @endif value="{{ $text->id }}">{{ $text->group_name_th }}</option>
											    @endforeach
											</select>
										</div>
										<div class="form-group">
											<label class="text-bold">
												Role name <span class="symbol required"></span>
											</label>
											<select name="role_id" id="role_id" class="cs-select cs-skin-elastic">
											    @foreach($roles as $key => $text)
											        <option @if(old('role_id', $result->role_id) === $text->id) selected @endif value="{{ $text->id }}">{{ $text->role_name }}</option>
											    @endforeach
											</select>
										</div>
										{{-- <div class="form-group">
											<label class="control-label text-bold">
												Image Upload
											</label>
											<div class="fileinput fileinput-new" data-provides="fileinput">
												<div class="fileinput-new thumbnail"><img src="{{asset('images/blank.png', env('REDIRECT_HTTPS'))}}" alt="" style="height: 150px;">
												</div>
												<div class="fileinput-preview fileinput-exists thumbnail"></div>
												<div class="user-edit-image-buttons">
													<span class="btn btn-azure btn-file">
														<span class="fileinput-new"><i class="fa fa-picture"></i> Select image</span>
														<span class="fileinput-exists"><i class="fa fa-picture"></i> Change</span>
														<input type="file">
													</span>
													<a href="javascript:;" class="btn fileinput-exists btn-red" data-dismiss="fileinput">
														<i class="fa fa-times"></i> Remove
													</a>
												</div>
											</div>
										</div> --}}
									</div>
								</div>
							</fieldset>

							<fieldset>
								<legend>
									Access Info
								</legend>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label text-bold">
												Username / Student ID <span class="symbol required"></span>
											</label>
											<span class="input-icon">
												<input class="form-control" type="text" name="username" id="username" placeholder="Text Field" value="{{ old('username', $result->username) }}">
												<i class="ti ti-user"></i> </span>
										</div>
									</div>
									<div class="col-md-6"></div>
								</div>

								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label text-bold">
												Password <span class="symbol required"></span>
											</label>
											<span class="input-icon">
												<input class="form-control" type="password" name="password" id="passwordd" placeholder="Text Field">
												<i class="ti ti-unlock"></i> </span>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label text-bold">&nbsp;</label>

											<div class="input-group">
												<a class="input-group-addon" onclick="generatePassword();">
													Random
												</a>
												<input class="form-control" type="text" placeholder="Text Field" id="random_code">
											</div>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label text-bold">
												Confirm Password <span class="symbol required"></span>
											</label>
											<span class="input-icon">
												<input class="form-control" type="password" name="password_confirmation" id="confirm_password" placeholder="Text Field">
												<i class="ti ti-unlock"></i> </span>
										</div>
									</div>
									<div class="col-md-6"></div>
								</div>
							</fieldset>

							<fieldset>
									<legend>
										Status
									</legend>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="text-bold">
													User status <span class="symbol required"></span>
												</label>
												<select name="active" id="active" class="cs-select cs-skin-elastic">
													<option value="1">Active</option>
													<option value="0">Unctive</option>
												</select>
											</div>
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
			<!-- end: USER PROFILE -->
		</div>
	</div>

@stop

@section('scripts')
<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script src="{{asset('core/vendor/bootstrap-fileinput/jasny-bootstrap.js', env('REDIRECT_HTTPS'))}}"></script>
<script src="{{asset('core/vendor/selectFx/classie.js', env('REDIRECT_HTTPS'))}}"></script>
<script src="{{asset('core/vendor/selectFx/selectFx.js', env('REDIRECT_HTTPS'))}}"></script>
<script src="{{asset('core/vendor/select2/select2.min.js', env('REDIRECT_HTTPS'))}}"></script>
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
	jQuery(document).ready(function() {

		var SetRules = {
			'username' : 'required',
            // 'passwordd' : 'required',
            'firstname_th' : 'required',
            'firstname_en' : 'required',
            // 'middlename_th' : 'required',
            // 'middlename_en' : 'required',
            'lastname_th' : 'required',
            'lastname_en' : 'required',
            // 'citizen_id' : 'required',
            // 'passport_id' : 'required'
            // 'library_code' : 'required'
		};

		FormElements.init();
		FormValidator.init(SetRules);
	});

	$(".select2").select2({
		minimumResultsForSearch: -1,
    	placeholder: "- Select -",
  	});

	function generatePassword() {

	    var length = 8,
	        charset = "abcdefghijklnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
	        retVal = "";
	      	for (var i = 0, n = charset.length; i < length; ++i) {
	        	retVal += charset.charAt(Math.floor(Math.random() * n));
	      	}

	    $("#random_code").val(retVal);
	    $("#passwordd").val(retVal);
	    $("#confirm_password").val(retVal);
	}
</script>
<!-- end: JavaScript Event Handlers for this page -->
<!-- end: CLIP-TWO JAVASCRIPTS -->
@stop