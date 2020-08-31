<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Afyapepe- @yield('title') </title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/core.js"/>
    <link rel="stylesheet" href="{{ asset('css/plugins/toastr/toastr.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('js/plugins/gritter/jquery.gritter.css') }}" />
     <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('font-awesome/css/font-awesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" href="{!!asset('css/plugins/fullcalendar/fullcalendar.css')!!}" />
    <link rel="stylesheet" media="print" href="{!!asset('css/plugins/fullcalendar/fullcalendar.print.css')!!}" />
     <link rel="stylesheet" href="{{asset('css/custom.css') }}" />
     <link rel="stylesheet" href="{{asset('select/select2.min.css') }}" />

    <link rel="stylesheet" href="{!! asset('css/plugins/iCheck/custom.css') !!}" />
     <link rel="stylesheet" href="{{asset('css/plugins/steps/jquery.steps.css') }}" />

      <script type="text/javascript" src="{{ asset('js/modernizr.js') }}"></script>
 <link href="{{ asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
 <link href="{{ asset('css/plugins/chosen/bootstrap-chosen.css') }}" rel="stylesheet">

@yield('style')
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-109671979-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-109671979-1');
</script>

</head>

<body>
    <div id="wrapper">
    @yield('leftmenu')

        <div id="page-wrapper" class="gray-bg dashbard-1">

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


  <!-- Flot -->
    <script src="{{ asset('js/plugins/flot/jquery.flot.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.tooltip.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.spline.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.resize.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.pie.js') }}" type="text/javascript"></script>


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


    <!-- Toastr -->
    <script src="{{ asset('js/plugins/fullcalendar/moment.min.js') }}"></script>
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>


    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>


    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

    <!-- jQuery UI  -->
    <script src="{{ asset('js/plugins/jquery-ui/jquery-ui.min.js') }}"></script>

    <!-- iCheck -->
    <script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>

    <!-- Full Calendar -->
    <script src="{{ asset('js/plugins/fullcalendar/fullcalendar.min.js') }}"></script>
     <script src="{{ asset('js/custom.js') }}"></script>

  <script src="{{ asset('js/plugins/pace/pace.min.js') }}" type="text/javascript"></script>
      <script src="{{ asset('js/plugins/steps/jquery.steps.min.js') }}"</script>
      <script src="{{ asset('js/plugins/validate/jquery.validate.min.js') }}" type="text/javascript"></script>
    <!-- Custom and plugin javascript -->

<script type="text/javascript">
   $('input[type="checkbox"]').on('change', function() {
    $('input[name="' + this.name + '"]').not(this).prop('checked', false);
});
</script>

 <script src="{{ asset('js/plugins/datapicker/bootstrap-datepicker.js') }}" type="text/javascript"></script>

    <!-- Custom and plugin javascript -->




    <!-- Custom and plugin javascript -->
<script src="{{ asset('js/plugins/pace/pace.min.js') }}" type="text/javascript"></script>
    <!--  <script src="{{ asset('js/inspinia.js') }}" type="text/javascript"></script>-->

   <script src="{{ asset('select/select2.min.js') }}" type="text/javascript"></script>

    <script src="{{ asset('js/plugins/chosen/chosen.jquery.js') }}"></script>
  @yield('script')
    <script>

    $('#data_1 .input-group.date').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true
            });

            $(document).ready(function(){
                $("button").click(function(){
                    $("#testR").toggle();
                });
            });
    </script>

    <!-- Page-Level Scripts -->

     <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}" type="text/javascript"></script>
    <script>
        $(document).ready(function(){
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

        });

    </script>

</body>
</html>
