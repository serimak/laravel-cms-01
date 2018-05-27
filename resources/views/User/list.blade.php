@php
    $menu  = \Request::get('permissions');

    if($menu[Request::segment(1)]['sub']) {

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
            <!--
            <div class="row margin-bottom-15">
              <div class="col-md-2">
                <div class="form-group">
                    <label>Gender:</label>
                    <p id="gender"></p>
                </div>
              </div>

              <div class="col-md-2">
                <div class="form-group">
                    <label>Group:</label>
                    <p id="group"></p>
                </div>
              </div>

              <div class="col-md-2">
                <div class="form-group">
                    <label>Role:</label>
                    <p id="role"></p>
                </div>
              </div>

              <div class="col-md-2">
                <div class="form-group">
                    <label>Status:</label>
                    <p id="status"></p>
                </div>
              </div>
            </div>
            -->
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

                @if($menu_super || $menu_write || $menu_delete)
                  <div class="margin-bottom-30">
                    <!--
                    <div class="btn-group">
                      <button type="button" class="btn btn-default">
                        เครื่องมือ (<span class="select_count">0</span>)
                      </button>
                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu" role="menu">
                        @if($menu_super || $menu_write)
                          <li><a onclick="selectdata_unsuspend('active');">แสดงข้อมูล</a></li>
                          <li><a onclick="selectdata_suspend('unactive');">ไม่แสดงข้อมูล</a></li>
                        @endif
                        @if($menu_super || $menu_delete)
                          <li><a onclick="selectdata_delete('delete_all');">ลบข้อมูล</a></li>
                        @endif
                      </ul>
                    </div>
                    -->
                    @if($menu_super || $menu_write)
                      <a class="btn btn-wide btn-success" href="{{ url('users_groups/user/add') }}"><i class="glyphicon glyphicon-plus"></i> เพิ่มข้อมูลกลุ่มผู้ใช้</a>
                    @endif
                  </div>
                @endif

                <form name="formInput" id="formInput" method="post" action="{{ url('users_groups/user/selected') }}">
                  {{ csrf_field() }}
                  <input type="hidden" name="action" id="action">

                  <table class="table table-striped table-bordered table-hover table-full-width" id="datatable">
                    
                    <thead>
                      <tr class="info">
                        <th hidden class="center" width="5"><input type="checkbox" class="select_all_item" style="margin-left:10px;"></th>
                        <th class="center">No.</th>
                        <th class="center">Username</th>
                        <th class="center">Name TH</th>
                        <th class="center">Name EN</th>
                        <th class="center">Gender</th>
                        <th class="center">Group</th>
                        <th class="center">Role</th>
                        <th class="center">Status</th>
                        <th class="center">Action</th>
                      </tr>
                    </thead>

                    <tbody>
                      @if (isset($result))
                        @php
                          $i=1;
                        @endphp
                        @foreach ($result as $row)
                          <tr>
                            <td hidden>{{ $row->id }}</td>
                            <td>{{ $i }}</td>
                            <td>{{ $row->username }}</td>
                            <td>{{ $row->firstname_th }} {{ $row->lastname_th }}</td>
                            <td>{{ $row->firstname_en }} {{ $row->lastname_en }}</td>
                            <td>{{ $row->gender }}</td>
                            <td>{{ @$row->getGroup->group_name_th }}</td>
                            <td>{{ @$row->getRole->role_name }}</td>
                            <td>{{ $row->active }}</td>
                            <td>{{ $row->id }}</td>
                            @php
                              $i++;
                            @endphp
                          </tr>
                        @endforeach
                      @endif

                    </tbody>

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
<script src="{{asset('core/vendor/DataTables/jquery.dataTables.columnFilter.js', env('REDIRECT_HTTPS'))}}"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->

<script>
  $(function () {

      var table = $('#datatable').DataTable({
        "pageLength": 25,
        "scrollX": true,
        "oLanguage"   : {
          "sLengthMenu" : "Show _MENU_ Rows",
          "sSearch"   : "",
          "oPaginate" : {
              "sPrevious" : "",
              "sNext" : ""
            }
        },
        'columnDefs': [{
            'targets': 0,
            'searchable':false,
            'orderable':false,
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
            'className':'dt-body-center'
          },
          {
            'targets': 5,
            'className':'dt-body-center'
          },
          {
            'targets': 8,
            'className':'dt-body-center',
            'render': function (data, type, full, meta) {

              switch(data) {
                  case "1":
                  color = "green";
                  data = "Active";
                  break;
                  case "0":
                  color = "red";
                  data = "Unactive";
                  break;
              }

              return "<font color="+color+">"+data+"</font>";
            }
          },
          {
            'targets': 9,
            'searchable':false,
            'orderable':false,
            'width': '160px',
            'className':'dt-body-center',
            'render': function (data, type, full, meta) {
               return '<a class="btn btn-warning" href="{{ url('users_groups/user/edit') }}/'
                      + $('<div/>').text(data).html() +'"><i class="glyphicon glyphicon-edit"></i> Edit</a>'
                    @if($menu_super || $menu_delete)
                      + ' <a class="btn btn-red" onclick="delete_data(&#39;delete&#39;,'
                      + $('<div/>').text(data).html() +');"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
                    @endif
            }
          }
        ]
      });

      $('#datatable_wrapper .dataTables_filter input').addClass("form-control input-sm").attr("placeholder", "กรอกข้อมูลเพื่อค้นหา");
      $('#datatable_wrapper .dataTables_length select').select2();

      $('#datatable').dataTable().columnFilter({
          sPlaceHolder : 'head:before',
          aoColumns:[
                      null,
                      null,
                      null,
                      null,
                      null,
                      null,
                      null,
                      null,
                      null,
                      null
                ]
      });

      $('.select_all_item').on('click', function() {

          var rows = table.rows({ 'search': 'applied' }).nodes();
          $('input[type="checkbox"]', rows).prop('checked', this.checked);

          var select_length = $('#datatable tbody input[type="checkbox"]:checked').length;
          $(".select_count").text(select_length);
      });

      $('#datatable_wrapper tbody').on('change', 'input[type="checkbox"]', function() {

        var select_length = $('#datatable tbody input[type="checkbox"]:checked').length;
        $(".select_count").text(select_length);

        if(!this.checked){

           var el = $('.select_all_item').get(0);
           if(el && el.checked && ('indeterminate' in el)) {

              el.indeterminate = true;
           }
        }
      });

      $(".select_filter").select2({
        minimumResultsForSearch: -1,
        placeholder: "- Select All -",
      });

  });

  @if($menu_super || $menu_delete)
    function delete_data(action, id)
    {
      if(confirm("Are you sure you want to delete this item?")) {

        $('#action').val(action);
        $('input:checkbox[value='+id+']').prop('checked', true);
        $('#formInput').submit();
      }
    }

    function selectdata_delete(action)
    {
      var checked_id = [];
      $("input:checkbox[name=id]:checked").each(function(){
        checked_id.push($(this).val());
      });

      if(confirm("Are you sure you want to delete this item?")) {

        $('input:checkbox[name=id]').val(JSON.stringify(checked_id));
        $('#action').val(action);
        $('#formInput').submit();
      }
    }
  @endif

  @if($menu_super || $menu_write)
    function selectdata_suspend(action)
    {
      var checked_id = [];
      $("input:checkbox[name=id]:checked").each(function(){
        checked_id.push($(this).val());
      });

      if(confirm("Unactive Data !. Are you sure ?")) {

        $('input:checkbox[name=id]').val(JSON.stringify(checked_id));
        $('#action').val(action);
        $('#formInput').submit();
      }
    }

    function selectdata_unsuspend(action)
    {
      var checked_id = [];
      $("input:checkbox[name=id]:checked").each(function(){
        checked_id.push($(this).val());
      });

      if(confirm("Active Data !. Are you sure ?")) {

        $('input:checkbox[name=id]').val(JSON.stringify(checked_id));
        $('#action').val(action);
        $('#formInput').submit();
      }
    }
  @endif
</script>

@stop