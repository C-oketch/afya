<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Afyapepe- @yield('title') </title>


    <link rel="stylesheet" href="{{ asset('css/plugins/toastr/toastr.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('js/plugins/gritter/jquery.gritter.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/vendor.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <link rel="stylesheet" href="{{asset('select/select2.min.css') }}" />

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('font-awesome/css/font-awesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}" />

<link rel="stylesheet" href="{{ asset('css/plugins/datapicker/datepicker3.css') }}" />
<link rel="stylesheet" href="{{ asset('css/custom.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
 <link href="{{ asset('css/plugins/chosen/bootstrap-chosen.css') }}" rel="stylesheet">
</head>

<body>
    <div id="wrapper">
      @include('includes.manu_inc.leftmenu')

        <div id="page-wrapper" class="gray-bg dashlined-1">

    <!-- Main view  -->
    @yield('content')

        </div>

    </div>

    <!-- Mainly scripts -->
    <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
    <!-- Mainly scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('select/select2.min.js') }}" type="text/javascript"></script>
    <!-- Custom and plugin javascript -->
    <!-- <script src="{{ asset('js/inspinia.js') }}" type="text/javascript"></script> -->
    <!-- <script src="{{ asset('js/plugins/pace/pace.min.js') }}" type="text/javascript"></script> -->
  <!-- Flot -->
    <script src="{{ asset('js/plugins/flot/jquery.flot.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.tooltip.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.spline.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.resize.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.pie.js') }}" type="text/javascript"></script>

    <script src="{{ asset('js/plugins/flot/jquery.flot.time.js') }}"></script>



    <script src="{{ asset('js/demo/flot-demo.js') }}"></script>


    <!-- Peity -->
    <script src="{{ asset('js/plugins/peity/jquery.peity.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/demo/peity-demo.js') }}" type="text/javascript"></script>


    <!-- jQuery UI -->
    <script src="{{ asset('js/plugins/jquery-ui/jquery-ui.min.js') }}" type="text/javascript"></script>
    <!-- GITTER -->
    <script src="{{ asset('js/plugins/gritter/jquery.gritter.min.js') }}" type="text/javascript"></script>
    <!-- Sparkline -->
    <script src="{{ asset('js/plugins/sparkline/jquery.sparkline.min.js') }}" type="text/javascript"></script>
   <!-- Sparkline demo data  -->
    <script src="{{ asset('js/demo/sparkline-demo.js') }}" type="text/javascript"></script>


    <!-- ChartJS-->
    <script src="{{ asset('js/plugins/chartJs/Chart.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/demo/chartjs-demo.js') }}"></script>
    <!-- Data picker -->
   <script src="{{ asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>

    <!-- Toastr -->
    <script src="{{ asset('js/plugins/toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/plugins/chosen/chosen.jquery.js') }}"></script>
     <script src="{{ asset('select/select2.min.js') }}" type="text/javascript"></script>
    <!-- Page-Level Scripts -->
    // select test
    <script>
    $(".drugs-single").select2();
    </script>
    <script>
          $('.drugs1').select2({
              placeholder: "Select a drug...",
              minimumInputLength: 2,
              ajax: {
                  url: '/tags/drugs',
                  dataType: 'json',
                  data: function (params) {
                      return {
                          q: $.trim(params.term)
                      };
                  },
                  processResults: function (data) {
                      return {
                          results: data
                      };
                  },
                  cache: true
              }
          });
      </script>
        <script>
      // show radio divs
      $(document).ready(function () {
       $('#drugs').hide();
        $('#company').hide();

      $('#button1').click(function () {
        $('#drugs').hide();
      $('#company').toggle('fast');
                     });
       $('#button2').click(function () {
           $('#company').hide();
          $('#drugs').toggle('fast');
           });

        });
        </script>
    <script>
     $(document).ready(function(){
          $.datepicker.setDefaults({
               dateFormat: 'yy-mm-dd'
          });
          $(function(){
               $("#from_date").datepicker();
               $("#to_date").datepicker();
          });
          $('#filter').click(function(){
               var from_date = $('#from_date').val();
               var to_date = $('#to_date').val();
               if(from_date != '' && to_date != '')
               {
                    $.ajax({
                         url:"customsales.php",
                         method:"POST",
                         data:{from_date:from_date, to_date:to_date},
                         success:function(data)
                         {
                              $('#order_table').html(data);
                         }
                    });
               }
               else
               {
                    alert("Please Select Date");
               }
          });
     });
</script>
    <script>
        $(document).ready(function(){
          $('.dataTables-manucompe').DataTable({
              pageLength: 25,
              responsive: false,
              dom: '<"html5buttons"B>lTfgitp',
              buttons: [
                  { extend: 'copy'},
                  {extend: 'csv'},
                  {extend: 'excel', title: 'ExampleFile'},
                  {extend: 'pdf', title: 'ExampleFile'},

                  {extend: 'print',
                   customize: function (win){
                          $(win.document.body).addClass('white-bg');
                          $(win.document.body).css('font-size', '10px');

                          $(win.document.body).find('table')
                                  .addClass('compact')
                                  .css('font-size', 'inherit');
                  }
                  }
              ]

          });
            $('.dataTables-example').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    { extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'ExampleFile'},
                    {extend: 'pdf', title: 'ExampleFile'},

                    {extend: 'print',
                     customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                    }
                    }
                ]

            });

            <?php
           use Carbon\Carbon;
           $today= Carbon::now();
           $monday = Carbon::now()->startOfWeek();
           $mon=$monday->toDateString();
           $tuesday=  $monday->addDays(1);
           $tue=$tuesday->toDateString();
           $wednesday= $tuesday->addDays(1);
           $weno=$wednesday->toDateString();
           $thursday=$wednesday->addDays(1);
           $thurs=$thursday->toDateString();
           $friday=$thursday->addDays(1);
           $fridays=$friday->toDateString();
           $saturday=$friday->addDays(1);
           $sato=$saturday->toDateString();
           $sunday=$saturday->addDays(1);
           $sund= $sunday->toDateString();

$id=Auth::id();
$manufacturer=DB::table('manufacturers')->where('user_id', Auth::id())->first();
            if($manufacturer==''){
                $name = 'name';
            }
            else{
                $name=$manufacturer->name;
            }

            $from = date('Y-m-d' ." ". '08:00:00', time()); $to = date('Y-m-d' ." ". '09:59:59', time());
            $from1 = date('Y-m-d' ." ". '10:00:00', time()); $to1 = date('Y-m-d' ." ". '12:59:59', time());
            $from2 = date('Y-m-d' ." ". '13:00:00', time()); $to2 = date('Y-m-d' ." ". '15:59:59', time());
            $from3 = date('Y-m-d' ." ". '16:00:00', time()); $to3 = date('Y-m-d' ." ". '18:59:59', time());
            $from4 = date('Y-m-d' ." ". '19:00:00', time()); $to4 = date('Y-m-d' ." ". '21:59:59', time());
            $from5 = date('Y-m-d' ." ". '22:00:00', time()); $to5 = date('Y-m-d' ." ". '00:59:59', time());
            $from6 = date('Y-m-d' ." ". '01:00:00', time()); $to6 = date('Y-m-d' ." ". '03:59:59', time());
            $from7 = date('Y-m-d' ." ". '05:00:00', time()); $to7 = date('Y-m-d' ." ". '07:59:59', time());
            $fri1= date('.$fridays.' ." ". '00:00:00', time()); $fri2 = date('.$fridays.' ." ". '23:59:59', time());
//Today

$d1=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereBetween('prescription_filled_status.created_at', array($from, $to))->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->first();
        $d2=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereBetween('prescription_filled_status.created_at', array($from1, $to1))->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->first();
        $d3=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereBetween('prescription_filled_status.created_at', array($from2, $to2))->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->first();
         $d4=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereBetween('prescription_filled_status.created_at', array($from3, $to3))->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->first();
          $d5=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereBetween('prescription_filled_status.created_at', array($from4, $to4))->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->first();
           $d6=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereBetween('prescription_filled_status.created_at', array($from5, $to5))->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->first();
            $d7=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereBetween('prescription_filled_status.created_at', array($from6, $to6))->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->first();
             $d8=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereBetween('prescription_filled_status.created_at', array($from7, $to7))->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->first();
//presc

$dp1=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereBetween('prescription_filled_status.created_at', array($from, $to))->whereNull('prescription_filled_status.substitute_presc_id')->count();
        $dp2=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereBetween('prescription_filled_status.created_at', array($from1, $to1))->whereNull('prescription_filled_status.substitute_presc_id')->count();
        $dp3=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereBetween('prescription_filled_status.created_at', array($from2, $to2))->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->count();
         $dp4=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereBetween('prescription_filled_status.created_at', array($from3, $to3))->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->count();
          $dp5=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereBetween('prescription_filled_status.created_at', array($from4, $to4))->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->count();
           $dp6=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereBetween('prescription_filled_status.created_at', array($from5, $to5))->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->count();
            $dp7=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereBetween('prescription_filled_status.created_at', array($from6, $to6))->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->count();
             $dp8=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereBetween('prescription_filled_status.created_at', array($from7, $to7))->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->count();
    //This week

 $mon=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                 ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereDate('prescription_filled_status.created_at','=',$mon)->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->first();
 $tue=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereDate('prescription_filled_status.created_at','=',$tue)->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->first();
 $wed=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
  ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereDate('prescription_filled_status.created_at','=',$weno)->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->first();
 $thur=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%') ->whereDate('prescription_filled_status.created_at','=',$thurs)->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->first();
 $fri=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','>=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereDate('prescription_filled_status.created_at','=',$fridays)->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->first();
 $sat=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereDate('prescription_filled_status.created_at','=',$sato)->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->first();
 $sun=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                 ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereDate('prescription_filled_status.created_at','=',$sund)->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->first();
//presc



//This Month
          $monthstart = $today->startOfMonth();
           $monthstarts=$monthstart->toDateString();
           $first= $monthstart->addDays(7);
           $firsts=$first->toDateString();
           $second=$first->addDays(7);
          $seconds=$second->toDateString();
           $third=$second->addDays(7);
           $thirds= $third->toDateString();
          $monthend = $today->endOfMonth();
           $monthends= $monthend->toDateString();

$week1=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereDate('prescription_filled_status.created_at','>=', $monthstarts)->whereDate('prescription_filled_status.created_at','<=',$firsts)->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->first();
$week2=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%') ->where('prescription_filled_status.created_at','>',$firsts)->where('prescription_filled_status.created_at','<=',$seconds)->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->first();
$week3=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->where('prescription_filled_status.created_at','>',$seconds)->where('prescription_filled_status.created_at','<=',$thirds)->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->first();
$week4=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->where('prescription_filled_status.created_at','>',$thirds)->where('prescription_filled_status.created_at','<=',$monthends)->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->first();


               ?>

    var lineData = {
        labels: ["8-9 am", "10-12 pm", "1-3 pm", "4-6 pm", "7-9 pm", "10-12 am", "1-3 am"
        , "5-7 am"],
        datasets: [

            {
                label: "Today Sales",
                backgroundColor: 'rgba(26,179,148,0.5)',
                borderColor: "rgba(26,179,148,0.7)",
                pointBackgroundColor: "rgba(26,179,148,1)",
                pointBorderColor: "#fff",
                data: [<?php echo $d1->total; ?>,<?php echo $d2->total; ?>,<?php echo $d3->total; ?>,<?php echo $d4->total; ?>,<?php echo $d5->total; ?>, <?php echo $d6->total; ?>, <?php echo $d7->total; ?>,<?php echo $d8->total; ?>]
            }
        ]
    };

    var lineOptions = {
        responsive: true,
        scales: {
        yAxes: [{
            ticks: {
                beginAtZero: true,
                 interval: 20
            }
        }]
    }

    };



    var ctx = document.getElementById("lineChart").getContext("2d");
    new Chart(ctx, {type: 'line', data: lineData, options:lineOptions});


         var lineDatas = {
        labels: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"
        ],
        datasets: [

            {
                label: "Sales This Week",
                backgroundColor: 'rgba(26,179,148,0.5)',
                borderColor: "rgba(26,179,148,0.7)",
                pointBackgroundColor: "rgba(26,179,148,1)",
                pointBorderColor: "#fff",
                data: [<?php echo $mon->total; ?>,<?php echo $tue->total; ?>,<?php echo $wed->total; ?>,<?php echo $thur->total; ?>,<?php echo $fri->total; ?>, <?php echo $sat->total; ?>, <?php echo $sun->total; ?>]
            }
        ]
    };

    var lineOptions = {
        responsive: true,
        scales: {
        yAxes: [{
            ticks: {
                beginAtZero: true
            }
        }]
    }
    };


    var ctx = document.getElementById("lineCharts").getContext("2d");
    new Chart(ctx, {type: 'line', data: lineDatas, options:lineOptions});

  var lineDatam = {
        labels: ["Week 1", "Week 2", "Week 3", "Week 4"],
        datasets: [

            {
                label: "Sales This Month",
                backgroundColor: 'rgba(26,179,148,0.5)',
                borderColor: "rgba(26,179,148,0.7)",
                pointBackgroundColor: "rgba(26,179,148,1)",
                pointBorderColor: "#fff",
                data: [<?php echo $week1->total; ?>,<?php echo $week2->total; ?>,<?php echo $week3->total; ?>,<?php echo $week4->total; ?>]
            }
        ]
    };

    var lineOptions = {
        responsive: true,
        scales: {
        yAxes: [{
            ticks: {
                beginAtZero: true
            }
        }]
    }
    };


    var ctx = document.getElementById("lineChartm").getContext("2d");
    new Chart(ctx, {type: 'line', data: lineDatam, options:lineOptions});

    var ctx = document.getElementById("lineCharts").getContext("2d");
    new Chart(ctx, {type: 'line', data: lineDatas, options:lineOptions});
    <?php

$jan=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereMonth('prescription_filled_status.created_at','=','01')->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->first();

$feb=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereMonth('prescription_filled_status.created_at','=','02')->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->first();
$mar=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereMonth('prescription_filled_status.created_at','=','03')->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->first();
$apr=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereMonth('prescription_filled_status.created_at','=','04')->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->first();
$may=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereMonth('prescription_filled_status.created_at','=','05')->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->first();
$jun=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereMonth('prescription_filled_status.created_at','=','06')->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->first();
$jul=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereMonth('prescription_filled_status.created_at','=','07')->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->first();
$aug=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereMonth('prescription_filled_status.created_at','=','08')->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->first();
$sep=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereMonth('prescription_filled_status.created_at','=','09')->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->first();
$oct=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereMonth('prescription_filled_status.created_at','=','10')->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->first();
$nov=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereMonth('prescription_filled_status.created_at','=','11')->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->first();
$dec=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereMonth('prescription_filled_status.created_at','=','12')->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->first();
    ?>

  var lineDatay = {
        labels: ["January", "February", "March", "April"
        , "May", "June", "July", "August", "September", "October", "November","December"],
        datasets: [

            {
                label: "Sales This Year",
                backgroundColor: 'rgba(26,179,148,0.5)',
                borderColor: "rgba(26,179,148,0.7)",
                pointBackgroundColor: "rgba(26,179,148,1)",
                pointBorderColor: "#fff",
                data: [<?php echo $jan->total; ?>,<?php echo $feb->total; ?>,<?php echo $mar->total; ?>,<?php echo $apr->total; ?>,<?php echo $may->total; ?>,<?php echo $jun->total; ?>,<?php echo $jul->total; ?>,<?php echo $aug->total; ?>,<?php echo $sep->total; ?>,<?php echo $oct->total; ?>,<?php echo $nov->total; ?>,<?php echo $dec->total; ?>]
            }
        ]
    };

    var lineOptions = {
        responsive: true,
        scales: {
        yAxes: [{
            ticks: {
                beginAtZero: true
            }
        }]
    }
    };


    var ctx = document.getElementById("lineCharty").getContext("2d");
    new Chart(ctx, {type: 'line', data: lineDatay, options:lineOptions});


     var lineDatap = {
        labels: ["8-9 am", "10-12 pm", "1-3 pm", "4-6 pm", "7-9 pm", "10-12 am", "1-3 am"
        , "5-7 am"],
        datasets: [

            {
                label: "Today Prescription",
                backgroundColor: 'rgba(26,179,148,0.5)',
                borderColor: "rgba(26,179,148,0.7)",
                pointBackgroundColor: "rgba(26,179,148,1)",
                pointBorderColor: "#fff",
                data: [<?php echo $dp1; ?>,<?php echo $dp2; ?>,<?php echo $dp3; ?>,<?php echo $dp4; ?>,<?php echo $dp5; ?>, <?php echo $dp6; ?>, <?php echo $dp7; ?>,<?php echo $dp8; ?>]
            }
        ]
    };

    var lineOptions = {
        responsive: true,
        scales: {
        yAxes: [{
            ticks: {
                beginAtZero: true
            }
        }]
    }
    };


    var ctx = document.getElementById("lineChartp").getContext("2d");
    new Chart(ctx, {type: 'line', data: lineDatap, options:lineOptions});
    <?php
     $monday = Carbon::now()->startOfWeek();
           $mon=$monday->toDateString();
           $tuesday=  $monday->addDays(1);
           $tue=$tuesday->toDateString();
           $wednesday= $tuesday->addDays(1);
           $weno=$wednesday->toDateString();
           $thursday=$wednesday->addDays(1);
           $thurs=$thursday->toDateString();
           $friday=$thursday->addDays(1);
           $fridays=$friday->toDateString();
           $saturday=$friday->addDays(1);
           $sato=$saturday->toDateString();
           $sunday=$saturday->addDays(1);
           $sund= $sunday->toDateString();
      $mn=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')->where('druglists.Manufacturer','like', '%' .$name . '%')->whereDate('prescription_filled_status.created_at','=',$mon)->whereNull('prescription_filled_status.substitute_presc_id')->count();
 $te=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereDate('prescription_filled_status.created_at','=',$tue)->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->count();
 $wd=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
 ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereDate('prescription_filled_status.created_at','=',$weno)->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->count();
 $thr=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereDate('prescription_filled_status.created_at','=',$thurs)->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->count();
 $fr=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereDate('prescription_filled_status.created_at','=',$fridays)->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->count();
 $st=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereDate('prescription_filled_status.created_at','=',$sato)->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->count();
 $sn=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereDate('prescription_filled_status.created_at','=',$sund)->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->count();
//presc




    ?>


         var lineDatasp = {
        labels: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"
        ],
        datasets: [

            {
                label: "Prescription This Week",
                backgroundColor: 'rgba(26,179,148,0.5)',
                borderColor: "rgba(26,179,148,0.7)",
                pointBackgroundColor: "rgba(26,179,148,1)",
                pointBorderColor: "#fff",
                data: [<?php echo $mn; ?>,<?php echo $te; ?>,<?php echo $wd; ?>,<?php echo $thr; ?>,<?php echo $fr; ?>, <?php echo $st; ?>, <?php echo $sn; ?>]
            }
        ]
    };

    var lineOptions = {
        responsive: true,
        scales: {
        yAxes: [{
            ticks: {
                beginAtZero: true
            }
        }]
    }
    };


    var ctx = document.getElementById("lineChartsp").getContext("2d");
    new Chart(ctx, {type: 'line', data: lineDatasp, options:lineOptions});
    <?php

    $wk1=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereDate('prescription_filled_status.created_at','>=',$monthstarts)->whereDate('prescription_filled_status.created_at','<=',$firsts)->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->count();
$wk2=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->whereDate('prescription_filled_status.created_at','>',$firsts)->whereDate('prescription_filled_status.created_at','<=',$seconds)->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->count();
$wk3=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereDate('prescription_filled_status.created_at','>',$seconds)->whereDate('prescription_filled_status.created_at','<=',$thirds)->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->count();
$wk4=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereDate('prescription_filled_status.created_at','>',$thirds)->whereDate('prescription_filled_status.created_at','<=',$monthends)->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->count();





    ?>

  var lineDatamp = {
        labels: ["Week 1", "Week 2", "Week 3", "Week 4"],
        datasets: [

            {
                label: "Prescription This Month",
                backgroundColor: 'rgba(26,179,148,0.5)',
                borderColor: "rgba(26,179,148,0.7)",
                pointBackgroundColor: "rgba(26,179,148,1)",
                pointBorderColor: "#fff",
                data: [<?php echo $wk1; ?>,<?php echo $wk2; ?>,<?php echo $wk3; ?>,<?php echo $wk4; ?>]
            }
        ]
    };

    var lineOptions = {
        responsive: true,
        scales: {
        yAxes: [{
            ticks: {
                beginAtZero: true
            }
        }]
    }
    };


    var ctx = document.getElementById("lineChartmp").getContext("2d");
    new Chart(ctx, {type: 'line', data: lineDatamp, options:lineOptions});

    <?php

$janp=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereMonth('prescription_filled_status.created_at','=','01')->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->count();

$febp=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereMonth('prescription_filled_status.created_at','=','02')->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->count();
$marp=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereMonth('prescription_filled_status.created_at','=','03')->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->count();
$aprp=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereMonth('prescription_filled_status.created_at','=','04')->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->count();
$mayp=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereMonth('prescription_filled_status.created_at','=','05')->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->count();
$junp=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereMonth('prescription_filled_status.created_at','=','06')->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->count();
$julp=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereMonth('prescription_filled_status.created_at','=','07')->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->count();
$augp=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereMonth('prescription_filled_status.created_at','=','08')->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->count();
$sepp=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereMonth('prescription_filled_status.created_at','=','09')->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->count();
$octp=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereMonth('prescription_filled_status.created_at','=','10')->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->count();
$novp=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereMonth('prescription_filled_status.created_at','=','11')->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->count();
$decp=DB::table('prescription_filled_status')->join('prescription_details','prescription_details.id','=','prescription_filled_status.presc_details_id')->join('druglists','druglists.id','=','prescription_details.drug_id')
                ->where('druglists.Manufacturer','like', '%' .$name . '%')->whereMonth('prescription_filled_status.created_at','=','12')->selectRaw('SUM(price * quantity) as total')->whereNull('prescription_filled_status.substitute_presc_id')->count();
    ?>




  var lineDatayp = {
        labels: ["January", "February", "March", "April"
        , "May", "June", "July", "August", "September", "October", "November","December"],
        datasets: [

            {
                label: "Prescription This Year",
                backgroundColor: 'rgba(26,179,148,0.5)',
                borderColor: "rgba(26,179,148,0.7)",
                pointBackgroundColor: "rgba(26,179,148,1)",
                pointBorderColor: "#fff",
                data: [<?php echo $janp; ?>,<?php echo $febp; ?>,<?php echo $marp; ?>,<?php echo $aprp; ?>,<?php echo $mayp; ?>,<?php echo $junp; ?>,<?php echo $julp; ?>,<?php echo $augp; ?>,<?php echo $sepp; ?>,<?php echo $octp; ?>,<?php echo $novp; ?>,<?php echo $decp; ?>]
            }
        ]
    };

    var lineOptions = {
        responsive: true,
        scales: {
        yAxes: [{
            ticks: {
                beginAtZero: true
            }
        }]
    }
    };


    var ctx = document.getElementById("lineChartyp").getContext("2d");
    new Chart(ctx, {type: 'line', data: lineDatayp, options:lineOptions});


        });
$('.chosen-select').chosen({width: "100%"});
    </script>
</body>
</html>
