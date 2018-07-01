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

    <div class="main-content" style="width: auto;">
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
                        <!--
                        <div class="col-xs-8 text-left form-group">
                            <div class="form-group">
                                <label class="control-label text-bold">
                                    Title : <span style="color:black;"></span>
                                </label>
                            </div>  
                        </div>
                        -->
                        <div class="col-xs-12">
                          <fieldset>
                              <legend>
                                หน่วยงานที่ทำงานวิจัย (คิดเป็น %)
                              </legend>
                              <div class="row">
                                <div class="col-sm-4 padding-left-0 padding-right-0 margin-bottom-15">
                                  <div id="pieLegend" class="chart-legend"></div>
                                </div>
                                <div class="col-sm-8 padding-left-0 padding-right-0 margin-top-15">
                                  <div class="text-center">
                                    <canvas id="pieChart" width="320" height="320" class="full-width"></canvas>
                                  </div>
                                </div>
                              </div>
                            </fieldset>
                          </div>
                          <!-- end: PIE CHART -->
    
                          <!-- start: BAR CHART -->
                          <div class="col-sm-12">
                            <fieldset>
                                <legend>
                                    หน่วยงานที่ทำงานวิจัย (จำนวนงานวิจัย)
                                </legend>
                                <div class="col-sm-12">
                                    <div class="row text-center" >                          
                                        <canvas id="barChart" class="full-width"></canvas>     
                                    </div>
                                </div>
                            </fieldset>
                          </div>
                        </div>        
                        <!-- end: BAR CHART -->

                    </div>
                </div>
            </div>
            <!-- end: DYNAMIC TABLE -->
        </div>
    </div>
@stop

@section('scripts')

<!-- Start Chart pie and ChartBar  -->
<script src="{{asset('core/vendor/Chart.js/ChartBar.js', env('REDIRECT_HTTPS')) }}"></script>
<script src="{{asset('core/vendor/Chart.js/Chart.min.js', env('REDIRECT_HTTPS')) }}"></script>

<script src="{{asset('core/vendor/bootstrap/js/bootstrap.min.js', env('REDIRECT_HTTPS')) }}"></script>  
<script src="{{asset('core/assets/js/main.js', env('REDIRECT_HTTPS')) }}"></script>
<!-- End Chart pie and ChartBar  -->

<script>
    $(function () {

      // modify table search input
      //$('#datatable_wrapper .dataTables_length select').select2();

    
    // $("#table-log").each(function() { 

    //     $(this).hide();

    //     if($(this).attr('data-id') == "Y") {
    //         $(this).show();

    //         $("#table-user").each(function() { 
    //             $(this).hide();
    //         }); 

    //     }else{

    //         $(this).hide();
    //          $("#table-user").each(function() { 
    //             $(this).show();
    //         }); 
    //     }
    // }); 


                
var data = ( @json($chart) ? @json($chart) : [] );
  
    //   {
    //     value: 3,
    //     color: '#F7464A',
    //     highlight: '#FF5A5E',
    //     label: 'choice1'
    //   }, {
    //     value: 0,
    //     color: '#46BFBD',
    //     highlight: '#5AD3D1',
    //     label: 'choice2 '
    //   }, {
    //     value: 0,
    //     color: '#FDB45C',
    //     highlight: '#FFC870',
    //     label: 'choice3'
    //   }
    // ];

    //Chart.js Options
    if(!this.value){this.value = 0;}
    var options = {

      responsive: true,
      maintainAspectRatio: false,
      segmentShowStroke: true,
      segmentStrokeColor: '#fff',
      segmentStrokeWidth: 2,
      percentageInnerCutout: 0, // This is 0 for Pie charts
      animationSteps: 100,
      animationEasing: 'easeOutBounce',
      animateRotate: true,
      animateScale: false,
    

     legendTemplate:
       "<ul class=\"<%=name.toLowerCase()%>-legend\">                                                      <% var total = segments.reduce(function(previousValue,currentValue)  {                                                                                            return previousValue + currentValue.value;},0                                               );                                                                                             for (var i=0; i<segments.length;i++){                                                                                       %>                                                                                                <li><span style=\"background-color:<%=segments[i].fillColor%>\"></span>                         <%if(segments[i].label && segments[i].value > 0 && total > 0 ){                                                                     %><%=segments[i].label%>  :  <%= (( ( parseInt( segments[i].value ) / parseInt( total ) * 100 ))).toFixed(2) %> %<%                }else{ %><%=segments[i].label%> : <%=0+'%'%> <% }                                                                                      %></li>          <%}%>                                                                                      </ul>   ",


      showTooltips: true,

     
      tooltipTemplate: "<%if (label){%><%=label%>: <%}%> <%= (circumference / 6.283 * 100).toFixed(2) %>%"

    };

    var ctx = $("#pieChart").get(0).getContext("2d");
    var pieChart = new Chart(ctx).Pie(data, options, {type: 'pie'});
    

    //generate the legend
    var legend = pieChart.generateLegend();
    $('#pieLegend').append(legend);

        /*  Get id report */

        $('body').on('click', 'button[name="btnback"]', function(){
            var dataId = $(this).data('id');
            top.location.href='{{ url("poll") }}/'+dataId;
        });

        /* End report */



   var data = ( @json($chartbar) ? @json($chartbar) : {} );
   // console.log(data);
    // var data = {
    //   labels: ["Test", "Test 2"],
    //   datasets: [
    //   {
    //       // fillColor: [ "#ac86c5", "#750b49"],
    //       // strokeColor: [ "rgba(151,187,205,0.8)", "#750b49"],
    //       // highlightFill: [ "rgba(151,187,205,0.75)", "#750b49"] ,
    //       // highlightStroke: [ "rgba(151,187,205,1)", "#750b49"] ,
    //       backgroundColor: ["red", "blue", "green", "blue", "red", "blue"],
    //       data: [10, 20]
    //   }
    
    //   ]
    // };
    // console.log(data);

    var options = {

      // Sets the chart to be responsive
      responsive: true,

      //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
      scaleBeginAtZero: true,

      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines: true,

      //String - Colour of the grid lines
      scaleGridLineColor: "rgba(0,0,0,.05)",

      //Number - Width of the grid lines
      scaleGridLineWidth: 1,

      //Boolean - If there is a stroke on each bar
      barShowStroke: true,

      //Number - Pixel width of the bar stroke
      barStrokeWidth: 2,

      //Number - Spacing between each of the X value sets
      barValueSpacing: 5,

      //Number - Spacing between data sets within X values
      barDatasetSpacing: 1,

      //String - A legend template
      legendTemplate: '<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>'
    };

    // Get context with jQuery - using jQuery's .get() method.
    var ctx = $("#barChart").get(0).getContext("2d");
    // This will get the first returned node in the jQuery collection.
    var barChart = new Chart(ctx).Bar(data, options);
    ;
    //generate the legend
    var legend = barChart.generateLegend();
    //and append it to your page somewhere
    $('#barLegend').append(legend);

    // window.onload = function(){
    //     var ctx = document.getElementById("barChart").getContext("2d");
    //      window.barFill = new Chart(ctx).Bar(data, options);

    //     barFill.datasets[0].bars[0].fillColor = "#ac86c5";
       

    //     barFill.update();
    // }

    });
</script>

@stop