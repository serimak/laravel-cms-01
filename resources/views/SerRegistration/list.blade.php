@php
    $menu  = \Request::get('permissions');

    if(@$menu[Request::segment(1)]['sub']) {

    $submenu      = $menu[Request::segment(1)]['sub'][Request::segment(2)];
    $menu_name    = $submenu['submenu_name'];
    $menu_key     = $submenu['submenu_key'];
    $menu_link    = $submenu['submenu_link'];
    $menu_icon    = $submenu['submenu_icon'];
    $menu_read    = ($submenu['submenu_read'] ? true : false);
    $menu_write   = ($submenu['submenu_write'] ? true : false);
    $menu_delete  = ($submenu['submenu_delete'] ? true : false);
    $menu_super   = ($submenu['submenu_super'] ? true : false);
    } else {

    $mainmenu     = $menu[Request::segment(1)]['main'];
    $menu_name    = $mainmenu['menu_name'];
    $menu_key     = $mainmenu['menu_key'];
    $menu_link    = $mainmenu['menu_link'];
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
      <div class="wrap-content" id="container">
          <!-- start: DASHBOARD TITLE -->
          <section id="page-title" class="padding-top-15 padding-bottom-15">
              <div class="row">
                  <div class="col-sm-8">
                      <h1>
                          <i class="{{$menu_icon}}"></i> {{$menu_name}} 
                          {{-- <small class="text-small">จัดการกลุ่มผู้ใช้งาน</small> --}}
                      </h1>
                  </div>
              </div>
          </section>
          <!-- end: DASHBOARD TITLE -->

          <!-- start: DYNAMIC TABLE -->
          <div class="container-fluid container-fullw bg-white">
            <div class="row">
              <div class="col-md-12">

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

                <form name="formInput" id="formInput" method="post" action="{{ url('research_search/selected') }}">
                  {{ csrf_field() }}
                  <input type="hidden" name="action" id="action">

                  <table class="table table-striped table-bordered table-hover table-full-width" id="datatable">
                    <thead>
                      <tr class="info">
                        <th hidden class="center" width="5"><input type="checkbox" class="select_all_item" style="margin-left:10px;"></th>
                        <th class="center">ลำดับ</th>
                        <th class="center">ชื่อโครงการ</th>
                        <th class="center">ที่ปรึกษาโครงการวิจัย</th>
                        <th class="center">หัวหน้าโครงการวิจัย</th>
                        <th class="center">ผู้ร่วมวิจัย</th>
                        <th class="center">ปีงบประมาณ</th>
                        <th class="center">ประเภทงบประมาณ</th>
                        <th class="center">หน่วยงาน/คณะที่รับผิดชอบ</th>
                        <th class="center">งบประมาณที่ได้รับจัดสรร</th>
                        <th class="center">วันที่เริ่มสัญญา</th>
                        <th class="center">วันที่สิ้นสุดสัญญา</th>
                        <th class="center">สถานะงาน</th>
                        <th class="center">วันที่ส่งงาน</th>
                        <th class="center">ดำเนินการ</th>
                      </tr>
                    </thead>
                    <tbody>
                        @if (isset($result))
                          @php
                            $i = 1;
                          @endphp
                          @foreach ($result as $row)
                            <tr>
                              <td hidden>{{ $row->id }}</td>
                              <td>{{ $i }}</td>
                              <td>{{ $row->project_name_th }}</td>
                              <td>{{ $row->research_advisor }}</td>
                              <td>{{ $row->research_leader }}</td>
                              <td>{{ $row->research_researcher }}</td>
                              <td>{{ $row->fiscal_year_id }}</td>
                              <td>{{ $row->budget_type_id }}</td>
                              <td>{{ $row->agency_responsible_id }}</td>
                              <td>{{ $row->budget_allocated }}</td>
                              <td>{{ $row->start_date }}</td>
                              <td>{{ $row->end_date }}</td>
                              <td>{{ $row->job_status_id }}</td>
                              <td>{{ $row->date_of_submission }}</td>
                              <td>
                                  <a class="btn btn-success padding-right-5 padding-left-5" href="{{ url('research_search/view/'.$row->id) }}"><i class="fa fa-list"></i> ดูข้อมูล</a>
                              </td>
                              @php
                                $i++;
                              @endphp
                            </tr>
                          @endforeach
                        @endif
                    </tbody>
                  </table>
                </form>
              </div>
            </div>
          </div>
          <!-- end: DYNAMIC TABLE -->
      </div>
  </div>

@stop

@section('scripts')

<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script src="{{asset('core/vendor/select2/select2.min.js', env('REDIRECT_HTTPS'))}}"></script>
<script src="{{asset('core/vendor/DataTables/jquery.dataTables.min.js', env('REDIRECT_HTTPS'))}}"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->

<script>
  $(function () {

      var table = $('#datatable').DataTable({
        "scrollX": true,
        "autoWidth": true,
        "oLanguage"   : {
          "sLengthMenu" : "Show _MENU_ Rows",
          "sSearch"   : "",
          "oPaginate" : {
              "sPrevious" : "",
              "sNext" : ""
            }
        },
        'columnDefs': [
          {
            'targets': 0,
            'width': '80px',
            'searchable':false,
            'orderable':false,
            'width': '70px',
            'className':'dt-body-center',
            'render': function (data, type, full, meta) {
                return '<input type="checkbox" name="id" value="' 
                        + $('<div/>').text(data).html() + '">';
            }
          },
          {
            'targets': 1,
            'width': '80px',
            'className':'dt-body-center'
          },
          {
            'targets': 2,
            'width': '220px',
            'className':'dt-body-center'
          },
          {
            'targets': 3,
            'width': '220px',
            'className':'dt-body-center'
          },
          {
            'targets': 4,
            'width': '220px',
            'className':'dt-body-center'
          },
          {
            'targets': 5,
            'width': '200px',
            'className':'dt-body-center'
          },
          {
            'targets': 6,
            'width': '120px',
            'className':'dt-body-center'
          },
          {
            'targets': 7,
            'width': '180px',
            'className':'dt-body-center'
          },
          {
            'targets': 8,
            'width': '220px',
            'className':'dt-body-center'
          },
          {
            'targets': 9,
            'width': '170px',
            'className':'dt-body-center'
          },
          {
            'targets': 10,
            'width': '130px',
            'className':'dt-body-center'
          },
          {
            'targets': 11,
            'width': '130',
            'className':'dt-body-center'
          },
          {
            'targets': 12,
            'width': '120px',
            'className':'dt-body-center'
          },
          {
            'targets': 13,
            'width': '100px',
            'className':'dt-body-center'
          },
          {
            'targets': 14,
            'width': '160px',
            'className':'dt-body-center'
          }
        ]
      });

      $('#datatable_wrapper .dataTables_filter input').addClass("form-control input-sm").attr("placeholder", "กรอกข้อมูลเพื่อค้นหา");
      // modify table search input
      $('#datatable_wrapper .dataTables_length select').select2();

      $('.select_all_item').on('click', function() {

          var rows = table.rows({ 'search': 'applied' }).nodes();
          $('input[name="id"]', rows).prop('checked', this.checked);

          var select_length = $(rows).find('input[name="id"]:checked').length;
          $(".select_count").text(select_length);

      });

      $('#datatable_wrapper tbody').on('change', 'input[name="id"]', function() {

        var rows = table.rows({ 'search': 'applied' }).nodes();
        
        var select_length = $(rows).find('input[name="id"]:checked').length;
        $(".select_count").text(select_length);

      });

  });

  @if($menu_super || $menu_delete)
    function delete_data(action, id, name)
    {
      if(confirm("ยืนยัน ต้องการลบโครงการ " + name + " ใช่ หรือ ไม่ ?")) {
        $('#action').val(action);
        $('input:checkbox[value='+id+']').prop('checked', true);
        $('#formInput').submit();
      }
    }
  @endif

</script>
<!-- end: JavaScript Event Handlers for this page -->
<!-- end: CLIP-TWO JAVASCRIPTS -->

@stop