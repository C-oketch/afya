<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Afyapepe- @yield('title') </title>


    <meta name="_token" content="{!! csrf_token() !!}" />
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css" type="text/css" />


    <link rel="stylesheet" href="{{ asset('css/plugins/toastr/toastr.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('js/plugins/gritter/jquery.gritter.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/vendor.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/plugins/steps/jquery.steps.css') }}" />

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('font-awesome/css/font-awesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" href="{{asset('css/custom.css') }}" />
      <script type="text/javascript" src="{{ asset('js/modernizr.js') }}"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <link rel="stylesheet" href="{{asset('select/select2.min.css') }}" />
    <!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
      <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->

</head>

<body>
    <div id="wrapper">
      @include('includes.facilityadmin.leftmenu')

        <div id="page-wrapper" class="gray-bg dashbard-1">

    <!-- Main view  -->
    @yield('content')

    @include('includes.admin_inc.footer')

        </div>

    </div>

    <!-- Mainly scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>

    <!-- End wrapper-->
    <meta name="_token" content="{!! csrf_token() !!}" />
    <script src="{{asset('js/ajaxscript.js')}}"></script>


    <!-- Data picker js https://jqueryui.com/datepicker/#date-range -->
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
      <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('select/select2.min.js') }}" type="text/javascript"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/custom.js') }}" type="text/javascript"></script>

    <script src="{{ asset('js/plugins/steps/jquery.steps.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/plugins/validate/jquery.validate.min.js') }}" type="text/javascript"></script>
    <!-- ChartJS-->
    <script src="{{ asset('js/plugins/chartJs/Chart.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/demo/chartjs-demo.js') }}"></script>
  @yield('script')
    <script>
    function myFunction() {
    document.getElementById("labp").style.display = "block";
    }
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

    <script type="text/javascript">
    $.ajaxSetup({
     headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
    });
    </script>


    <!-- Page-Level Scripts -->


     <script>
            $('.facility').select2({
                placeholder: "Select facility to .....",
                minimumInputLength: 2,
                ajax: {
                    url: '/tags/fac',
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
        $('.doc').select2({
                placeholder: "Select doctor to .....",
                minimumInputLength: 2,
                ajax: {
                    url: '/tags/doc',
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
       // Lab add personnel toogle
       $(document).ready(function(){
         $("#technician").hide("fast");
           $("#labadd").click(function(){
               $("#technician").show();
                $("#labpersonnel").hide();
           });
       });
       </script>


        <script>
             $('.constituency').select2({
                 placeholder: "Select constituency...",
                 minimumInputLength: 2,
                 ajax: {
                     url: '/tag/constituency',
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
             $('.constituencyr').select2({
                 placeholder: "Select constituency...",
                 minimumInputLength: 2,
                 ajax: {
                     url: '/tag/constituencyr',
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
                  pageLength: 5,
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


</body>
</html>
