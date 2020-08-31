<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Afyapepe- @yield('title') </title>


<meta name="_token" content="{{ csrf_token() }}" />
<link rel="stylesheet" href="{{ asset('css/plugins/toastr/toastr.min.css') }}" />
<link rel="stylesheet" href="{{ asset('js/plugins/gritter/jquery.gritter.css') }}" />
<link rel="stylesheet" href="{{ asset('css/vendor.css') }}" />
<link rel="stylesheet" href="{{ asset('css/app.css') }}" />
<link rel="stylesheet" href="{{asset('select/select2.min.css') }}" />

<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
<link rel="stylesheet" href="{{ asset('font-awesome/css/font-awesome.css') }}" />
<link rel="stylesheet" href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" />
<link rel="stylesheet" href="{{ asset('css/animate.css') }}" />
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
@yield('styles')
</head>

<body>
<div id="wrapper">
@include('includes.facilityadmin.leftmenu')

<div id="page-wrapper" class="gray-bg dashbard-1">


@yield('content')
@include('includes.admin_inc.footer')





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
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}" type="text/javascript"></script>
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
    <script src="{{ asset('js/plugins/toastr/toastr.min.js') }}" type="text/javascript"></script>
   <script src="{{ asset('js/custom.js') }}" type="text/javascript"></script>
    <!-- Page-Level Scripts -->


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
          @yield('script')
</body>
</html>
