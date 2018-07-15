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
                          <i class="{{$menu_icon}}"></i> รายละเอียดข้อมูลงานวิจัย
                      </h1>
                  </div>
              </div>
            </section>
			<!-- end: DASHBOARD TITLE -->
			<!-- start: USER PROFILE -->
			<div class="container-fluid container-fullw bg-white">
				<form action="#" role="form" id="form">
					<div class="row">
						<div class="col-md-12">
							<fieldset>
                                <legend class="text-bold">
                                    ข้อมูลโครงการ
                                </legend>

								<div class="form-group row">
									<label class="control-label text-bold col-xs-3">
                                        ชื่อโครงการ : 
									</label>
									<div class="col-xs-9">
										<p class="text-dark w-100">
											{{ $result->project_name_th }}
										</p>
									</div>
								</div>
			                    <div class="form-group row">
									<label class="control-label text-bold col-xs-3">
                                        ที่ปรึกษาโครงการวิจัย : 
									</label>
									<div class="col-xs-9">
										<p class="text-dark w-100">
											{{ $result->research_advisor }}
										</p>
									</div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-bold col-xs-3">
                                        หัวหน้าโครงการวิจัย : 
                                    </label>
                                    <div class="col-xs-9">
                                        <p class="text-dark w-100">
                                            {{ $result->research_leader }}
                                        </p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                        <label class="control-label text-bold col-xs-3">
                                            ผู้ร่วมวิจัย : 
                                        </label>
                                        <div class="col-xs-9">
                                            <p class="text-dark w-100">
                                                {{ $result->research_researcher }}
                                            </p>
                                        </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-bold col-xs-3">
                                        ปีงบประมาณ : 
                                    </label>
                                    <div class="col-xs-9">
                                        <p class="text-dark w-100">
                                            {{ $result->fiscal_year_id }}
                                        </p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-bold col-xs-3">
                                        ประเภทงบประมาณ : 
                                    </label>
                                    <div class="col-xs-9">
                                        <p class="text-dark w-100">
                                            {{ $result->budget_type_id }}
                                        </p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-bold col-xs-3">
                                        หน่วยงาน/คณะที่รับผิดชอบ : 
                                    </label>
                                    <div class="col-xs-9">
                                        <p class="text-dark w-100">
                                            {{ $result->agency_responsible_id }}
                                        </p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-bold col-xs-3">
                                        งบประมาณที่ได้รับจัดสรร : 
                                    </label>
                                    <div class="col-xs-9">
                                        <p class="text-dark w-100">
                                            {{ $result->budget_allocated }}
                                        </p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-bold col-xs-3">
                                        วันที่เริ่มสัญญา : 
                                    </label>
                                    <div class="col-xs-9">
                                        <p class="text-dark w-100">
                                            {{ $result->start_date }}
                                        </p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-bold col-xs-3">
                                        วันที่สิ้นสุดสัญญา : 
                                    </label>
                                    <div class="col-xs-9">
                                        <p class="text-dark w-100">
                                            {{ $result->end_date }}
                                        </p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-bold col-xs-3">
                                        สถานะงาน : 
                                    </label>
                                    <div class="col-xs-9">
                                        <p class="text-dark w-100">
                                            {{ $result->job_status_id }}
                                        </p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-bold col-xs-3">
                                        วันที่ส่งงาน : 
                                    </label>
                                    <div class="col-xs-9">
                                        <p class="text-dark w-100">
                                            {{ $result->date_of_submission }}
                                        </p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-bold col-xs-3">
                                        บทคัดย่อ : 
                                    </label>
                                    <div class="col-xs-9">
                                        <p class="text-dark w-100">
                                            <textarea name="abstract_th" id="abstract_th" value="{{ $result->abstract_th }}">{{ $result->abstract_th }}</textarea>
                                        </p>
                                    </div>
                                </div>
							</fieldset>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12">
							<a href="{{ $menu_link }}" class="btn btn-danger btn-wide pull-left">
								<i class="fa fa-arrow-circle-left"></i> ย้อนกลับ
							</a>
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
<script src="{{asset('core/vendor/moment/moment.min.js', env('REDIRECT_HTTPS'))}}"></script>
<script src="{{asset('core/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js', env('REDIRECT_HTTPS'))}}"></script>
<script src="{{asset('core/vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js', env('REDIRECT_HTTPS'))}}"></script>
<script src="{{asset('core/vendor/ckeditor/ckeditor.js', env('REDIRECT_HTTPS'))}}"></script>
<script src="{{asset('core/vendor/ckeditor/adapters/jquery.js', env('REDIRECT_HTTPS'))}}"></script>
<script src="{{asset('core/vendor/jquery-validation/jquery.validate.min.js', env('REDIRECT_HTTPS'))}}"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<!-- start: JavaScript Event Handlers for this page -->
<script src="{{asset('core/assets/js/form-elements.js', env('REDIRECT_HTTPS'))}}"></script>
<script src="{{asset('core/assets/js/form-validation.js', env('REDIRECT_HTTPS'))}}"></script>
<script src="{{asset('js/tinymce/tinymce.min.js', env('REDIRECT_HTTPS'))}}"></script>
<script>tinymce.init({ selector:'textarea' });</script>
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