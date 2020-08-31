<!DOCTYPE html>
<html>

<head>
   <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="_token" content="{!! csrf_token() !!}"/>

    <title>Afyapepe- @yield('title') </title>

<link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css') }}" />
<link rel="stylesheet" href="{{asset('select/select2.min.css') }}" />
<link rel="stylesheet" href="{{asset('css/plugins/chosen/bootstrap-chosen.css') }}" />
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{asset('font-awesome/css/font-awesome.css') }}" />
<link rel="stylesheet" href="{{asset('css/plugins/dataTables/datatables.min.css') }}" />
<link rel="stylesheet" href="{{asset('css/plugins/datapicker/datepicker3.css') }}" />
<link rel="stylesheet" href="{{asset('css/plugins/clockpicker/clockpicker.css') }}" />
<link rel="stylesheet" href="{{asset('owl-carousel/owl.carousel.css') }}" />


<link rel="stylesheet" href="{{asset('css/plugins/steps/jquery.steps.css') }}" />
<link rel="stylesheet" href="{{asset('css/animate.css') }}" />
<link rel="stylesheet" href="{{asset('css/style.css') }}" />
<link rel="stylesheet" href="{{asset('css/custom.css') }}" />

</head>

<body>
    <div id="wrapper">
    <?php $setUp= DB::table('facility_doctor')
      ->leftJoin('facilities', 'facility_doctor.facilitycode', '=', 'facilities.FacilityCode')
      ->where('facility_doctor.user_id', '=', Auth::user()->id)
      ->select('facilities.set_up')
      ->first();
      ?>
      @if($setUp->set_up == 'Partial')
      @include('includes.private_inc.leftmenu')
      @else
@include('includes.doc_inc.leftmenu')
      @endif
        <div id="page-wrapper" class="gray-bg dashbard-1">

    <!-- Main view  -->
    @yield('content')
@include('includes.default.footer')
        </div>
      </div>

    </div>

<!-- End wrapper-->
<meta name="_token" content="{!! csrf_token() !!}" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="{{asset('js/ajaxscript.js')}}"></script>

<!-- Chosen -->
<script src="{{ asset('js/plugins/chosen/chosen.jquery.js') }}"></script>

<!-- Mainly scripts -->
<script src="{{ asset('js/jquery-3.1.1.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>

<!-- Custom and plugin javascript -->
<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('select/select2.min.js') }}" type="text/javascript"></script>
<!-- Data picker -->
<script src="{{ asset('js/plugins/datapicker/bootstrap-datepicker.js') }}" type="text/javascript"></script>
<!-- Clock picker -->
<script src="{{ asset('js/plugins/clockpicker/clockpicker.js') }}" type="text/javascript"></script>
<!-- Custom and plugin javascript -->
<!-- <script src="{{ asset('js/inspinia.js') }}" type="text/javascript"></script> -->
<script src="{{ asset('js/plugins/pace/pace.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/custom.js') }}" type="text/javascript"></script>

<script src="{{ asset('js/plugins/steps/jquery.steps.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/plugins/validate/jquery.validate.min.js') }}" type="text/javascript"></script>




@yield('script')
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
  <script type="text/javascript">
  $.ajaxSetup({
     headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
  });
  </script>
   <script>
       $('.tag_list1').select2({
           placeholder: "Select test...",
           minimumInputLength: 2,
           ajax: {
               url: '/tags/tst',
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

       $('.d_list2 ').select2({
           placeholder: "Choose disease...",

           minimumInputLength: 2,
           ajax: {
               url: '/disis/find',
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
      $('.facility1').select2({
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
 $(document).ready(function() {
$('#prescb').click(function () {

   var data_id = '';
if (typeof $(this).data('id') !== 'undefined') {
      data_id = $(this).data('id');
   }
   $('#diag_id').val(data_id);
 })
});
</script>
<script>
$(document).ready(function() {
$('a[data-toggle=modal], button[data-toggle=modal]').click(function () {

  var data_id = '';
if (typeof $(this).data('id') !== 'undefined') {
     data_id = $(this).data('id');
  }
  var data_value = '';
if (typeof $(this).data('value') !== 'undefined') {
     data_value = $(this).data('value');
  }


  $('#edit-content').val(data_id);
  $('#diseaseid').val(data_value);
})
});


//fix modal force focus

$('#test-pt').select2({
    dropdownParent: $('#edit-modal')
});
</script>

</body>
</html>
