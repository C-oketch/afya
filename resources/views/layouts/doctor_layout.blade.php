<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Afyapepe- @yield('title') </title>


    <link rel="stylesheet" href="{{ asset('css/plugins/toastr/toastr.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('js/plugins/gritter/jquery.gritter.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/vendor.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <!-- FooTable -->
  <link rel="stylesheet" href="{{ asset('css/plugins/footable/footable.core.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('font-awesome/css/font-awesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}" />
    <link rel="stylesheet" href="{{asset('css/plugins/fullcalendar/fullcalendar.css')}}" />
    <link rel="stylesheet" media="print" href="{{asset('css/plugins/fullcalendar/fullcalendar.print.css')}}" />
    <link rel="stylesheet" href="{{asset('css/plugins/datapicker/datepicker3.css') }}" />
    <link rel="stylesheet" href="{{asset('css/plugins/clockpicker/clockpicker.css') }}" />
   <link rel="stylesheet" href="{{ asset('css/plugins/iCheck/custom.css') }}" />
     <link rel="stylesheet" href="{{ asset('css/plugins/steps/jquery.steps.css') }}" />
     <link rel="stylesheet" href="{{asset('select/select2.min.css') }}" />

<!-- <link rel="stylesheet" href="{{asset('css/plugins/codemirror/codemirror.css') }}" />
<link rel="stylesheet" href="{{asset('css/plugins/codemirror/ambiance.css') }}" /> -->


     <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
     <link rel="stylesheet" href="{{asset('css/custom.css') }}" />


@yield('styles')

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
  @include('includes.default.footer')
        </div>
    </div>
    <!-- Mainly scripts -->
    <!-- <script src="{{ asset('js/app.js') }}" type="text/javascript"></script> -->
    <!-- Mainly scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>




    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}" type="text/javascript"></script>

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

    <!-- Toastr -->
    <script src="{{ asset('js/plugins/toastr/toastr.min.js') }}" type="text/javascript"></script>

    <!-- Chosen -->
    <script src="{{ asset('js/plugins/chosen/chosen.jquery.js') }}"></script>

    <!-- Data picker -->
    <script src="{{ asset('js/plugins/datapicker/bootstrap-datepicker.js') }}" type="text/javascript"></script>
    <!-- Clock picker -->
    <script src="{{ asset('js/plugins/clockpicker/clockpicker.js') }}" type="text/javascript"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/custom.js') }}" type="text/javascript"></script>

    <script src="{{ asset('js/plugins/steps/jquery.steps.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/plugins/chosen/chosen.jquery.js') }}"></script>
    <script src="{{ asset('select/select2.min.js') }}" type="text/javascript"></script>

    <!-- <script src="{{ asset('js/plugins/validate/jquery.validate.min.js') }}" type="text/javascript"></script> -->

        <!-- Page-Level Scripts -->
        @yield('script-test')
        <script>
        $(".select2_demo_1").select2({ width: '100%' });
        </script>
      <script>
          $('#data_1 .input-group.date').datepicker({
                        todayBtn: "linked",
                        keyboardNavigation: false,
                        forceParse: false,
                        calendarWeeks: true,
                        autoclose: true
                    });

            $('.clockpicker').clockpicker();
            </script>
        <script>
          $('.d_list2').select2({
                placeholder: "Choose disease...",

                minimumInputLength: 2,
                ajax: {
                    url: '/doctor.diseases',
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
              $('.facility1').select2({
                  placeholder: "Select facility to .....",
                  minimumInputLength: 2,
                  ajax: {
                      url: '/facility2',
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
              $(document).ready(function(){
                  $('.dataTables-conditional').DataTable({
                      pageLength: 10,
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


              $(document).ready(function(){
                  $('.dataTables-main').DataTable({
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
        $(document).ready(function(){
                $('.dataTables-tests').DataTable({
                    pageLength: 15,
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
              $('.presc1').select2({
                  placeholder: "Select prescriptions...",
                  minimumInputLength: 2,
                  ajax: {
                      url: '/docss/drugs',
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
function printdiv(printpage)
{
var headstr = "<html><head><title></title></head><body>";
var footstr = "</body>";
var newstr = document.all.item(printpage).innerHTML;
var oldstr = document.body.innerHTML;
document.body.innerHTML = headstr+newstr+footstr;
window.print();
document.body.innerHTML = oldstr;
return false;
}
</script>





</body>
</html>
