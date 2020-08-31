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

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('font-awesome/css/font-awesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" href="{{asset('css/custom.css') }}" />
      <script type="text/javascript" src="{{ asset('js/modernizr.js') }}"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <link rel="stylesheet" href="{{asset('select/select2.min.css') }}" />
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
      <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
       <link href="{{ asset('css/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}" rel="stylesheet">
    <link href="{{ asset('/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
     <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">

    <link href="{{ asset('css/plugins/chosen/bootstrap-chosen.css') }}" rel="stylesheet">

    <link href="{{ asset('css/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}" rel="stylesheet">

    <link href="{{ asset('css/plugins/colorpicker/bootstrap-colorpicker.min.css') }}" rel="stylesheet">

    <link href="{{ asset('css/plugins/cropper/cropper.min.css') }}" rel="stylesheet">

    <link href="{{ asset('css/plugins/switchery/switchery.css') }}" rel="stylesheet">

    <link href="{{ asset('css/plugins/jasny/jasny-bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{ asset('css/plugins/nouslider/jquery.nouislider.css') }}" rel="stylesheet">

    <link href="{{ asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">

    <link href="{{ asset('css/plugins/ionRangeSlider/ion.rangeSlider.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/ionRangeSlider/ion.rangeSlider.skinFlat.css') }}" rel="stylesheet">

    <link href="{{ asset('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">

    <link href="{{ asset('css/plugins/clockpicker/clockpicker.css') }}" rel="stylesheet">

    <link href="{{ asset('css/plugins/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet">

    <!-- <link href="{{ asset('css/plugins/select2/select2.min.css" rel="stylesheet') }}"> -->

    <link href="{{ asset('css/plugins/touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet">

    <link href="{{ asset('css/plugins/dualListbox/bootstrap-duallistbox.min.css') }}" rel="stylesheet">

    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>

<body>
    <div id="wrapper">
      @include('includes.nurse_inc.leftmenu')

        <div id="page-wrapper" class="gray-bg dashbard-1">

    <!-- Main view  -->
    @yield('content')

        </div>

    </div>

    <!-- Mainly scripts -->
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="{{asset('js/ajaxscript.js')}}"></script>
   <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
    <!-- Mainly scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}" type="text/javascript"></script>
   <script src="{{ asset('js/plugins/steps/jquery.steps.min.js') }}"></script>
<script src="{{ asset('js/plugins/validate/jquery.validate.min.js') }}"></script>
<script src="{{ asset('js/plugins/datapicker/bootstrap-datepicker.js') }}" type="text/javascript"></script>



 <script src="{{ asset('js/plugins/datapicker/bootstrap-datepicker.js') }}" type="text/javascript"></script>
<script src="{{asset('js/ajaxscript.js')}}"></script>

    <!-- Custom and plugin javascript -->




    <!-- Custom and plugin javascript -->
<script src="{{ asset('js/plugins/pace/pace.min.js') }}" type="text/javascript"></script>
 <script src="{{ asset('select/select2.min.js') }}" type="text/javascript"></script>


    <!--  <script src="{{ asset('js/inspinia.js') }}" type="text/javascript"></script>-->





    <!-- Page-Level Scripts -->


    <script type="text/javascript">
           $(document).ready(function(){
           $('.multi-field-wrapper').each(function() {
               var $wrapper = $('.multi-fields', this);

               $(".add-field", $(this)).click(function(e) {
                   $('.multi-field:first-child', $wrapper).clone(true).appendTo($wrapper).find('input').val('').focus();


               });
               $('.multi-field .remove-field', $wrapper).click(function() {
                   if ($('.multi-field', $wrapper).length > 1)
                       $(this).parent('.multi-field').remove();
               });
           });



            $.ajaxSetup({
 headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
});
              $(".presc1").select2({
          placeholder: "Select revelant drugs...",
          minimumInputLength: 2,
          ajax: {
              url: '/tag/drugs',
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
      $(".observation").select2({
          placeholder: "Select observations...",
          minimumInputLength: 2,
          ajax: {
              url: '/tag/observation',
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
      $(".symptom").select2({
          placeholder: "Select symptom...",
          minimumInputLength: 2,
          ajax: {
              url: '/tag/symptom',
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
      $(".chief").select2({
          placeholder: "Select chief compliant...",
          minimumInputLength: 2,
          ajax: {
              url: '/tag/chief',
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

    
       });
    </script>
    <script type="text/javascript">
       $(document).ready(function(){
              $("#drug").hide();
               $("#food").hide();
                $("#latex").hide();
                 $("#mold").hide();
                  $("#pet").hide();
                   $("#pollen").hide();
                    $("#insect").hide();

$("input[name='drug']").change(function () {
   $("#drug").toggle(this.checked);
});


$("input[name='food']").change(function () {
   $("#food").toggle(this.checked);
});

$("input[name='latex']").change(function () {
   $("#latex").toggle(this.checked);
});

$("input[name='molds']").change(function () {
   $("#mold").toggle(this.checked);
});

$("input[name='pets']").change(function () {
   $("#pet").toggle(this.checked);
});

$("input[name='pollens']").change(function () {
   $("#pollen").toggle(this.checked);
});

$("input[name='insects']").change(function () {
   $("#insect").toggle(this.checked);
});

$("input[name='skull']").change(function () {
   $("#skull").toggle(this.checked);
});


                                 $('input[type="checkbox"]').on('change', function() {
    $('input[name="' + this.name + '"]').not(this).prop('checked', false);
});
$('#data_1 .input-group.date').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true,
                format: "yyyy-mm-dd"
            });

            $(document).ready(function(){
                $("button").click(function(){
                    $("#testR").toggle();
                });
            });
       });



   </script>



</script>



</body>
</html>
