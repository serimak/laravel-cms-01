@extends('include.template')

@section('content')

	<div class="main-content">
		<div class="wrap-content container" id="container">
			<!-- start: DASHBOARD TITLE -->
			<section id="page-title" class="padding-top-15 padding-bottom-15">
				<div class="row">
                  	<div class="col-sm-8">
                      	<h1><i class="ti-user"></i> Users Add <small class="text-small">เพิ่มข้อมูลผู้ใช้งาน</small></h1>
                  	</div>
				</div>
			</section>
			<!-- end: DASHBOARD TITLE -->
			<!-- start: USER PROFILE -->
			<div class="container-fluid container-fullw bg-white">
				<form action="#" role="form" id="form">
					<div class="row">
						<div class="col-md-8">
							<fieldset>
								<legend>
									Account Info
								</legend>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">
												First Name
											</label>
											<input type="text" placeholder="Peter" class="form-control" id="firstname" name="firstname">
										</div>
										<div class="form-group">
											<label class="control-label">
												Last Name
											</label>
											<input type="text" placeholder="Clark" class="form-control" id="lastname" name="lastname">
										</div>
										<div class="form-group">
											<label class="control-label">
												Email Address
											</label>
											<input type="email" placeholder="peter@example.com" class="form-control" id="email" name="email">
										</div>
										<div class="form-group">
											<label class="control-label">
												Phone
											</label>
											<input type="email" placeholder="(641)-734-4763" class="form-control" id="phone" name="email">
										</div>
										<div class="form-group">
											<label class="control-label">
												Password
											</label>
											<input type="password" placeholder="password" class="form-control" name="password" id="password">
										</div>
										<div class="form-group">
											<label class="control-label">
												Confirm Password
											</label>
											<input type="password"  placeholder="password" class="form-control" id="password_again" name="password_again">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">
												Gender
											</label>
											<div class="clip-radio radio-primary">
												<input type="radio" value="female" name="gender" id="us-female">
												<label for="us-female">
													Female
												</label>
												<input type="radio" value="male" name="gender" id="us-male" checked>
												<label for="us-male">
													Male
												</label>
											</div>
										</div>
										<div class="row">
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label">
														Zip Code
													</label>
													<input class="form-control" placeholder="12345" type="text" name="zipcode" id="zipcode">
												</div>
											</div>
											<div class="col-md-8">
												<div class="form-group">
													<label class="control-label">
														City
													</label>
													<input class="form-control tooltips" placeholder="London (UK)" type="text" data-original-title="We'll display it when you write reviews" data-rel="tooltip"  title="" data-placement="top" name="city" id="city">
												</div>
											</div>
										</div>
										<div class="form-group">
											<label>
												Image Upload
											</label>
											<div class="fileinput fileinput-new" data-provides="fileinput">
												<div class="fileinput-new thumbnail"><img src="{{asset('images/blank.png', env('REDIRECT_HTTPS'))}}" alt="">
												</div>
												<div class="fileinput-preview fileinput-exists thumbnail"></div>
												<div class="user-edit-image-buttons">
													<span class="btn btn-azure btn-file"><span class="fileinput-new"><i class="fa fa-picture"></i> Select image</span><span class="fileinput-exists"><i class="fa fa-picture"></i> Change</span>
														<input type="file">
													</span>
													<a href="#" class="btn fileinput-exists btn-red" data-dismiss="fileinput">
														<i class="fa fa-times"></i> Remove
													</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</fieldset>
							<fieldset>
								<legend>
									Additional Info
								</legend>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">
												Twitter
											</label>
											<span class="input-icon">
												<input class="form-control" type="text" placeholder="Text Field">
												<i class="fa fa-twitter"></i> </span>
										</div>
										<div class="form-group">
											<label class="control-label">
												Facebook
											</label>
											<span class="input-icon">
												<input class="form-control" type="text" placeholder="Text Field">
												<i class="fa fa-facebook"></i> </span>
										</div>
										<div class="form-group">
											<label class="control-label">
												Google Plus
											</label>
											<span class="input-icon">
												<input class="form-control" type="text" placeholder="Text Field">
												<i class="fa fa-google-plus"></i> </span>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">
												Github
											</label>
											<span class="input-icon">
												<input class="form-control" type="text" placeholder="Text Field">
												<i class="fa fa-github"></i> </span>
										</div>
										<div class="form-group">
											<label class="control-label">
												Linkedin
											</label>
											<span class="input-icon">
												<input class="form-control" type="text" placeholder="Text Field">
												<i class="fa fa-linkedin"></i> </span>
										</div>
										<div class="form-group">
											<label class="control-label">
												Skype
											</label>
											<span class="input-icon">
												<input class="form-control" type="text" placeholder="Text Field">
												<i class="fa fa-skype"></i> </span>
										</div>
									</div>
								</div>
							</fieldset>
						</div>

						<div class="col-md-4">
							<fieldset>
								<legend class="text-bold">
									Tools Box
								</legend>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label class="text-bold">
												Create date
											</label>
											<p class="input-group input-append datepicker date">
												<input type="text" class="form-control" value="{{ date('d-m-Y') }}" readonly>
												<span class="input-group-btn">
													<button type="button" class="btn btn-default">
														<i class="glyphicon glyphicon-calendar"></i>
													</button> 
												</span>
											</p>
										</div>
										<div class="form-group">
											<label class="text-bold">
												Group status
											</label>
											<select class="cs-select cs-skin-elastic">
												<option value="active">Active</option>
												<option value="pending">Pending</option>
												<option value="deleted">deleted</option>
											</select>
										</div>

										<a href="{{ URL::previous() }}" class="btn btn-danger btn-wide pull-right">
											Back <i class="fa fa-arrow-circle-right"></i>
										</a>

										<button class="btn btn-primary btn-wide pull-left" type="submit">
											Submit <i class="ti-check"></i>
										</button>
									</div>
								</div>
							</fieldset>
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
<script src="{{asset('core/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js', env('REDIRECT_HTTPS'))}}"></script>
<!-- <script src="{{asset('core/vendor/bootstrap-timepicker/bootstrap-timepicker.min.js', env('REDIRECT_HTTPS'))}}"></script> -->
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
		FormElements.init();
		FormValidator.init();
	});
</script>
<!-- end: JavaScript Event Handlers for this page -->
<!-- end: CLIP-TWO JAVASCRIPTS -->
@stop