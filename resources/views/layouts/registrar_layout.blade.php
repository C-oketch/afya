<!DOCTYPE html>
<html>

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="_token" content="{!! csrf_token() !!}" />

  <title>Afyapepe- @yield('title') </title>

  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
  <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/animate.css') }}" />
  <link rel="stylesheet" href="{!! asset('css/plugins/iCheck/custom.css') !!}" />
  <link rel="stylesheet" href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" />
  <link href="{{ asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
  <!-- <link href="{{ asset('css/plugins/datapicker/bootstrap-datetimepicker.min.css') }}" rel="stylesheet"> -->

  <link rel="stylesheet" href="{{asset('select/select2.min.css') }}" />
  <link rel="stylesheet" href="{{asset('css/plugins/dualListbox/bootstrap-duallistbox.min.css') }}" />


  <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
  <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
@yield('style')
  <!-- <link href="{{ asset('css/plugins/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet"> -->

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
    @include('includes.registrar.leftmenuprivate')

    <!-- Page wraper -->
    <div id="page-wrapper" class="gray-bg">

      <!-- Main view  -->
      @yield('content')
      <!-- Footer -->


      @include('includes.default.footer')
    </div>
  </div>
  <!-- Mainly scripts -->
  <script src="{{ asset('js/jquery-3.1.1.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}" type="text/javascript"></script>
  <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}" type="text/javascript"></script>


  <!-- Toastr -->
  <script src="{{ asset('js/plugins/datapicker/bootstrap-datepicker.js') }}" type="text/javascript"></script>
  <!-- <script src="{{ asset('js/plugins/datapicker/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script> -->

  <script src="{{ asset('select/select2.min.js') }}" type="text/javascript"></script>

  <!-- Custom and plugin javascript -->
  @yield('script-reg')


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
<script>
$(".select2_demo_1").select2({
  width: '100%',
  placeholder: "You can select more than one ",
  allowClear: true
 });


</script>
</body>
</html>
