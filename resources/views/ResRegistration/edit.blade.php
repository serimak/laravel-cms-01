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

  <link rel="stylesheet" href="{{asset('core/vendor/bootstrap-daterangepicker/daterangepicker.css', env('REDIRECT_HTTPS'))}}">

  <div class="main-content">
      <div class="wrap-content" id="container">
          <!-- start: DASHBOARD TITLE -->
          <section id="page-title" class="padding-top-15 padding-bottom-15">
              <div class="row">
                  <div class="col-sm-8">
                      <h1>
						  <i class="{{$menu_icon}}"></i> แก้ไขข้อมูลงานวิจัย
                      </h1>
                  </div>
              </div>
          </section>
          <!-- end: DASHBOARD TITLE -->

          <!-- start: Form CALENDAR -->
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

					<div class="col-md-8 col-xs-12">
						<fieldset>
							<legend class="text-bold">
								ข้อมูลโครงการ
							</legend>

							<div class="form-group">
								<label class="control-label text-bold">
									ชื่อโครงการ <span class="symbol required"></span>
								</label>
								<input type="text" placeholder="กรุณากรอก" class="form-control" id="project_name_th" name="project_name_th" maxlength="1024" value="{{ old('project_name_th', $result->project_name_th) }}">
							</div>
							<div class="form-group">
								<label class="control-label text-bold">
									ชื่อโครงการภาษาอังกฤษ
								</label>
								<input type="text" placeholder="กรุณากรอก" class="form-control" id="project_name_en" name="project_name_en" maxlength="1024" value="{{ old('project_name_en', $result->project_name_en) }}">
							</div>
							<div class="row">
								<div class="col-xs-10">	
									<div class="form-group">
										<label class="control-label text-bold">
											ผู้รับผิดชอบ <span class="symbol required"></span>
										</label>
										<select class="cs-select cs-skin-elastic" id="responsible_person_id" name="responsible_person_id" >
											<option value="">กรุณาเลือก</option>
											@foreach($resResponsiblePersonList as $key => $text)
												<option @if($result->responsible_person_id === $text->id) selected @endif value="{{ $text->id }}">{{ $text->name_th }}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="col-xs-2">
									<div class="form-group">
										<label class="control-label text-bold">
											เพิ่มที่ปรึกษา
										</label>
										<div class="btn-group"></div>
										<a id="btnAddAdvisor" class="btn btn-wide btn-success pull-right" href="javascript:void(0);"><i class="glyphicon glyphicon-plus"></i></a> 
									</div>
								</div>
							</div>

							<div class="row" id="advisor-grp">
								@foreach($advisorList as $key => $text)
									<div id="advisor{{$text->id}}">
										<div class="col-xs-10">
											<div class="form-group"><span class="input-icon">
												<input type="text" placeholder="ชื่อที่ปรึกษา" class="form-control" maxlength="200" value="{{$text->advisor_name_th}}" name="advisors[]"/><i class="ti-user"></i></span>
											</div>
										</div>
										<div class="col-xs-2">
											<div class="form-group"><a class="btn btn-wide btn-danger pull-right" href="javascript:removeAdvisor({{$text->id}});"><i class="glyphicon glyphicon-minus"></i></a>
											</div>
										</div>
									</div>
								@endforeach
							</div>

							<div class="form-group">
								<label class="control-label text-bold">
									ปีงบประมาณ <span class="symbol required"></span>
								</label>
								<select class="cs-select cs-skin-elastic" id="fiscal_year_id" name="fiscal_year_id">
									<option value="">กรุณาเลือก</option>
									@foreach($resFiscalYearList as $key => $text)
										<option @if($result->fiscal_year_id === $text->id) selected @endif value="{{ $text->id }}">{{ $text->name_th }}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group">
								<label class="control-label text-bold">
									ประเภทงบประมาณ <span class="symbol required"></span>
								</label>
								<select class="cs-select cs-skin-elastic" id="budget_type_id" name="budget_type_id">
									<option value="">กรุณาเลือก</option>
									@foreach($resBudgetTypeList as $key => $text)
										<option @if($result->budget_type_id === $text->id) selected @endif value="{{ $text->id }}">{{ $text->name_th }}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group">
								<label class="control-label text-bold">
									หน่วยงาน/คณะที่รับผิดชอบ <span class="symbol required"></span>
								</label>
								<select class="cs-select cs-skin-elastic" id="agency_responsible_id" name="agency_responsible_id">
									<option value="">กรุณาเลือก</option>
									@foreach($resAgencyResponsibleList as $key => $text)
										<option @if($result->agency_responsible_id === $text->id) selected @endif value="{{ $text->id }}">{{ $text->name_th }}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group">
								<label class="control-label text-bold">
									งบประมาณที่ได้รับจัดสรร <span class="symbol required"></span>
								</label>
								<input type="text" placeholder="กรุณากรอก" class="form-control" id="budget_allocated" name="budget_allocated" maxlength="13" value="{{ old('budget_allocated', $result->budget_allocated) }}">
								<div id="errorLong"></div>
							</div>

							<div class="form-group">
								<label class="text-bold">
									  วันที่เริ่มสัญญา <span class="symbol required"></span>:
								</label>
								<div class="input-group input-daterange">
									<span class="input-icon">
										<input type="text" placeholder="กรุณาเลือก" class="form-control" name="startDate" id="startDate" maxlength="20" value="{{ old('start_date', \Carbon\Carbon::parse( $result->start_date )->format( 'd/m/Y' )) }}">
										<i class="ti-calendar"></i> 
										<input type="hidden" name="start_date" id="start_date" value="{{ old('start_date', $result->start_date) }}">
									</span>
								</div>
							</div>

							<div class="form-group">
								<label class="text-bold">
									วันที่สิ้นสุดสัญญา <span class="symbol required"></span>:
								</label>
								<div class="input-group input-daterange">
									<span class="input-icon">
										<input type="text" placeholder="กรุณาเลือก" class="form-control" name="endDate" id="endDate" maxlength="20" value="{{ old('end_date', \Carbon\Carbon::parse( $result->end_date )->format( 'd/m/Y' )) }}">
										<i class="ti-calendar"></i> 
										<input type="hidden" name="end_date" id="end_date" value="{{ old('end_date', $result->end_date) }}">
									</span>
								</div>
							</div>

							<div class="form-group">
								<label class="text-bold">
									สถานะงาน <span class="symbol required"></span>:
								</label>
								<select class="cs-select cs-skin-elastic" id="job_status_id" name="job_status_id">
									<option value="">กรุณาเลือก</option>
									@foreach($resJobStatusList as $key => $text)
										<option @if($result->job_status_id === $text->id) selected @endif value="{{ $text->id }}">{{ $text->name_th }}</option>
									@endforeach
								</select>
							</div>

							<div class="form-group">
					            <label class="text-bold">
									วันที่ส่งงาน :
					            </label>
					            <div class="input-group input-daterange">
					                <span class="input-icon">
									    <input type="text" placeholder="กรุณาเลือก" class="form-control" name="dateOfSubmission" id="dateOfSubmission" maxlength="20" value="{{ old('date_of_submission', \Carbon\Carbon::parse( $result->date_of_submission )->format( 'd/m/Y' )) }}">
										<i class="ti-calendar"></i>
									    <input type="hidden" name="date_of_submission" id="date_of_submission" value="{{ old('date_of_submission', $result->date_of_submission) }}">
									</span>
								</div>
					        </div>
					   
						</fieldset>

						<div class="row">
							<div class="col-xs-5">
								<a href="{{ $menu_link }}" class="btn btn-danger btn-wide btn-block">
									<i class="fa fa-arrow-circle-left"></i> ยกเลิก
								</a>
							</div>
							<div class="col-xs-7 padding-left-0">
								<button class="btn btn-primary btn-wide btn-block save-event" type="submit">
									<i class="ti-save"></i>	บันทึก
								</button>
							</div>
						</div>
					</div>

				</div>

	        </form>
          </div>

      </div>
  </div>

@stop

@section('scripts')

<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script src="{{asset('core/vendor/selectFx/classie.js',  env('REDIRECT_HTTPS'))}}"></script>
<script src="{{asset('core/vendor/selectFx/selectFx.js', env('REDIRECT_HTTPS'))}}"></script>
<script src="{{asset('core/vendor/moment/moment.min.js', env('REDIRECT_HTTPS'))}}"></script>
{{-- <script src="{{asset('core/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js', env('REDIRECT_HTTPS'))}}"></script> --}}
{{-- <script src="{{asset('core/vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js', env('REDIRECT_HTTPS'))}}"></script> --}}
<script src="{{asset('core/vendor/ckeditor/ckeditor.js', env('REDIRECT_HTTPS'))}}"></script>
<script src="{{asset('core/vendor/ckeditor/adapters/jquery.js', env('REDIRECT_HTTPS'))}}"></script>
<script src="{{asset('core/vendor/jquery-validation/jquery.validate.min.js', env('REDIRECT_HTTPS'))}}"></script>
<script src="{{asset('core/vendor/bootstrap-daterangepicker/daterangepicker.js', env('REDIRECT_HTTPS'))}}"></script>
<script src="{{asset('js/jquery.mask.min.js', env('REDIRECT_HTTPS'))}}"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<!-- start: JavaScript Event Handlers for this page -->
{{-- <script src="{{asset('core/assets/js/form-elements.js', env('REDIRECT_HTTPS'))}}"></script> --}}
<script src="{{asset('core/assets/js/form-validation.js', env('REDIRECT_HTTPS'))}}"></script>
<script>

  	jQuery(document).ready(function() {
		
		var SetRules = {
			'project_name_th' : 'required',
	        'responsible_person_id' : 'required',
	        'fiscal_year_id' : 'required',
			'budget_type_id' : 'required',
			'agency_responsible_id' : 'required',
			'budget_allocated' : {
	            required: true
	        },
			'start_date' : 'required',
			'end_date' : 'required',
	        'job_status_id' : 'required'
		};

    	// FormElements.init();
		FormValidator.init(SetRules);
	});
	  
  	$(function () {
		  
		var i = 0;
		@if($advisorMaximum)
			i = "{{$advisorMaximum}}";
		@endif

	  	$("#budget_allocated").keydown(function (e) {
	  			// Allow: backspace, delete, tab, escape, enter , - and .
	        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 189, 190]) !== -1 ||
	             // Allow: Ctrl/cmd+A
	            (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
	             // Allow: Ctrl/cmd+C
	            (e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
	            // Allow: Ctrl/cmd+V
	            (e.keyCode == 86 && (e.ctrlKey === true || e.metaKey === true)) ||
	             // Allow: Ctrl/cmd+X
	            (e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
	             // Allow: home, end, left, right
	            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
	        }
	        // Ensure that it is a number and stop the keypress
	        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
	            e.preventDefault();
	        }
	    });

	    $('#budget_allocated').bind('keyup', function(e){ 
	    	var keypress = e.keyCode || e.which || e.charCode; 
	        var budgetAllocatedVal = /^-?([0-8]?[0-9]|90)\.[0-9]{1,7}$/;
	        var budgetAllocated = $(this).val();
	        var invalidBudget = 'ข้อมูล งบประมาณที่ได้รับจัดสรร ไม่ถูกต้อง';
	        
	        if(!budgetAllocatedVal.test(budgetAllocated)) {
	            $("#errorLat").addClass('text-red').html(invalidBudget);
	            if(keypress != 12){
	                e.preventDefault();
	            } else { }
	            return false;
	        }else{
	            $("#errorLat").removeClass('text-red').html('ข้อมูล งบประมาณที่ได้รับจัดสรร ถูกต้อง');
	        }   
		});

		$('#startDate').daterangepicker({
			autoUpdateInput: false,
			singleDatePicker: true,
			"drops": "up",
			"autoApply": true,
			timePicker: false,
			"timePicker24Hour": true,
			locale: {
				format: 'DD/MM/YYYY'
			},
			@if($result->start_date)
				startDate: "{{$result->start_date}}"
			@endif
		});

		$('#startDate').on('apply.daterangepicker', function(ev, picker) {
			$(this).val(picker.startDate.format('DD/MM/YYYY'));
			$("#start_date").val(picker.startDate.format('YYYY-MM-DD HH:mm:ss'));
		});

		$('#endDate').daterangepicker({
			autoUpdateInput: false,
			singleDatePicker: true,
			"drops": "up",
			"autoApply": true,
			timePicker: false,
			"timePicker24Hour": true,
			locale: {
				format: 'DD/MM/YYYY'
			},
			@if($result->end_date)
				startDate: "{{$result->end_date}}"
			@endif
		});

		$('#endDate').on('apply.daterangepicker', function(ev, picker) {
			$(this).val(picker.startDate.format('DD/MM/YYYY'));
			$("#end_date").val(picker.startDate.format('YYYY-MM-DD HH:mm:ss'));
		});

		$('#dateOfSubmission').daterangepicker({
			autoUpdateInput: false,
			singleDatePicker: true,
			"drops": "up",
			"autoApply": true,
			timePicker: false,
			"timePicker24Hour": true,
			locale: {
				format: 'DD/MM/YYYY'
			},
			@if($result->date_of_submission)
				startDate: "{{$result->date_of_submission}}"
			@endif
		});

		$('#dateOfSubmission').on('apply.daterangepicker', function(ev, picker) {
			$(this).val(picker.startDate.format('DD/MM/YYYY'));
			$("#date_of_submission").val(picker.startDate.format('YYYY-MM-DD HH:mm:ss'));
		});

		$('#btnAddAdvisor').click(function(){
			i++;
			$("#advisor-grp").append('<div id="advisor'+i+'"><div class="col-xs-10"><div class="form-group"><span class="input-icon"><input type="text" placeholder="ชื่อที่ปรึกษา" class="form-control" maxlength="200" name="advisors[]"/><i class="ti-user"></i></span></div></div><div class="col-xs-2"><div class="form-group"><a class="btn btn-wide btn-danger pull-right" href="javascript:removeAdvisor('+i+');"><i class="glyphicon glyphicon-minus"></i></a></div></div></div>');	
		});

	  });

	  function removeAdvisor(i){
		$("#advisor"+i).remove();
	  }

</script>
<!-- end: JavaScript Event Handlers for this page -->
<!-- end: CLIP-TWO JAVASCRIPTS -->
<script>

</script>

@stop