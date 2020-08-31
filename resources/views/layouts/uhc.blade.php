<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Afyapepe- @yield('title') </title>


    <link rel="stylesheet" href="{!! asset('css/plugins/toastr/toastr.min.css') !!}" />
    <link rel="stylesheet" href="{!! asset('js/plugins/gritter/jquery.gritter.css') !!}" />
    <link rel="stylesheet" href="{!! asset('css/vendor.css') !!}" />
    <link rel="stylesheet" href="{!! asset('css/app.css') !!}" />

    <link rel="stylesheet" href="{!! asset('css/bootstrap.min.css') !!}" />
    <link rel="stylesheet" href="{!! asset('font-awesome/css/font-awesome.css') !!}" />
    <link rel="stylesheet" href="{!! asset('css/plugins/dataTables/datatables.min.css') !!}" />
    <link rel="stylesheet" href="{!! asset('css/animate.css') !!}" />
    <link rel="stylesheet" href="{{asset('select/select2.min.css') }}" />

    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.css"/> -->

@yield('style')
<link rel="stylesheet" href="{!! asset('css/style.css') !!}" />
<link rel="stylesheet" href="{!! asset('css/custom.css') !!}" />
</head>

<body>
    <div id="wrapper">
      @include('includes.uhc.leftmenu')

<div id="page-wrapper" class="gray-bg">

    <!-- Main view  -->
    @yield('content')

    @include('includes.uhc.footer')

        </div>

    </div>


    <!-- Mainly scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>

      <!-- Custom and plugin javascript -->
        <script src="{{ asset('js/inspinia.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/plugins/pace/pace.min.js') }}" type="text/javascript"></script>
  <!-- ChartJS-->
        <script src="{{ asset('js/plugins/chartJs/Chart.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/demo/chartjs-demo.js') }}" type="text/javascript"></script>






</body>
</html>
