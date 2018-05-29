@extends('include.template')

@section('content')

	<div class="main-content">
		<div class="wrap-content container" id="container">
			<!-- start: DASHBOARD TITLE -->
			<section id="page-title" class="padding-top-15 padding-bottom-15">
				<div class="row">
                  	<div class="col-sm-8">
                      	<h1>
                      		<i class="ti-user"></i> เปลี่ยนรหัสผ่าน
                      	</h1>
                  	</div>
				</div>
			</section>
			<!-- end: DASHBOARD TITLE -->
			<!-- start: USER PROFILE -->
			<div class="container-fluid container-fullw bg-white">

                @if(Session::has('flash_messages'))
                  @php
                  $flash_messages = Session::get('flash_messages');
                  @endphp
                  <div class="alert alert-{{$flash_messages['status']}}">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                    {{$flash_messages['messages']}}
                  </div>
                  @elseif ($errors->any())
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
						<div class="col-md-12">

							<fieldset>
								<legend>
									ข้อมูลผู้ใช้
								</legend>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label text-bold">
												ชื่อผู้ใช้ <span class="symbol required"></span>
											</label>
											<span class="input-icon">
												<input class="form-control" type="text" name="username" id="username" placeholder="Text Field" value="{{ old('username', $result->username) }}" disabled>
												<i class="ti ti-user"></i> </span>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label text-bold">
												รหัสผ่านปัจจุบัน <span class="symbol required"></span>
											</label>
											<span class="input-icon">
												<input class="form-control" type="password" name="current_password" id="current_password" placeholder="" @if($result->auth_type=="ldap") disabled @endif>
												<i class="ti ti-unlock"></i> </span>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label text-bold">
												รหัสผ่านใหม่ <span class="symbol required"></span>
											</label>
											<span class="input-icon">
												<input class="form-control" type="password" name="password" id="passwordd" placeholder="" @if($result->auth_type=="ldap") disabled @endif>
												<i class="ti ti-unlock"></i> </span>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label text-bold">
												ยืนยันรหัสผ่านใหม่ <span class="symbol required"></span>
											</label>
											<span class="input-icon">
												<input class="form-control" type="password" name="password_confirmation" id="confirm_password" placeholder="" @if($result->auth_type=="ldap") disabled @endif>
												<i class="ti ti-unlock"></i> </span>
										</div>
									</div>
									<div class="col-md-6"></div>
								</div>
							</fieldset>
						</div>

						<div class="col-md-6">
							<fieldset>
								<legend>
									คำแนะนำการตั้งรหัสผ่านใหม่ ดังนี้
								</legend>
								<div class="row">
									<ol class="margin-top-0 margin-bottom-0">
										<li>ต้องเป็นภาษาอังกฤษ ประกอบด้วยตัวอักษรพิมพ์ใหญ่อย่างน้อย 1 ตัวอักษร</li>
										<li>ประกอบด้วยตัวเลข 0 – 9 อย่างน้อย 1 ตัว</li>
										<li>สามารถระบุอักขระพิเศษได้ ดังนี้  @  #  $   เท่านั้น</li>
										<li>ความยาวไม่น้อยกว่า 8 ตัวอักษร และไม่เกิน 16 ตัวอักษร</li>
										<li>ไม่สามารถเป็นค่าว่าง หรือ มี Space ระหว่างคำได้</li>
									</ol>
								</div>
							</fieldset>
						</div>

						<div class="col-md-12">
							<div class="row">
								<div class="col-md-12 text-center">
									<button class="btn btn-primary btn-wide" type="submit">
										บันทึก <i class="ti-check"></i>
									</button>
								</div>
							</div>
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
			'current_password' : 'required',
            'passwordd' : 'required',
            'confirm_password' : 'required'
		};

		FormElements.init();
		FormValidator.init(SetRules);
	});
</script>
<!-- end: JavaScript Event Handlers for this page -->
<!-- end: CLIP-TWO JAVASCRIPTS -->
@stop