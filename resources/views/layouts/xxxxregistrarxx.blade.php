<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="_token" content="{!! csrf_token() !!}" />


    <title>Afyapepe- @yield('title') </title>


    <link rel="stylesheet" href="{{ asset('css/plugins/toastr/toastr.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('js/plugins/gritter/jquery.gritter.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/vendor.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" href="{!!asset('css/plugins/fullcalendar/fullcalendar.css')!!}" />
    <link rel="stylesheet" media="print" href="{!!asset('css/plugins/fullcalendar/fullcalendar.print.css')!!}" />

    <link rel="stylesheet" href="{!! asset('css/plugins/iCheck/custom.css') !!}" />
     <link rel="stylesheet" href="{!! asset('css/plugins/steps/jquery.steps.css') !!}" />
      <script type="text/javascript" src="{{ asset('js/modernizr.js') }}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="{{asset('js/ajaxscript.js')}}"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> -->
  <link rel="stylesheet" href="/resources/demos/style.css">

  <link rel="stylesheet" href="{{asset('select/select2.min.css') }}" />

   <link href="{{ asset('css/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}" rel="stylesheet">
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


    <link href="{{ asset('css/plugins/touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet">

    <link href="{{ asset('css/plugins/dualListbox/bootstrap-duallistbox.min.css') }}" rel="stylesheet">

    <link href="{{ asset('css/plugins/fullcalendar/fullcalendar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/fullcalendar/fullcalendar.print.css') }}" rel='stylesheet' media='print'>
    
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

   <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-109671979-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-109671979-1');
</script>
@yield('style')
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
      <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Mainly scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}" type="text/javascript"></script>

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
    <script src="{{ asset('js/plugins/datapicker/bootstrap-datepicker.js') }}" type="text/javascript"></script>
    <script src="{{ asset('select/select2.min.js') }}" type="text/javascript"></script>
    <!-- Clock picker -->
    <script src="{{ asset('js/plugins/clockpicker/clockpicker.js') }}" type="text/javascript"></script>
    <!-- Steps -->
    <script src="{{ asset('js/plugins/steps/jquery.steps.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/plugins/chosen/chosen.jquery.js') }}"></script>
  @yield('script-reg')
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
            $('.chronic1').select2({
                placeholder: "Select chronic disease  .....",
                minimumInputLength: 2,
                ajax: {
                    url: '/registrar.diseases',
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
            $('.constituency2').select2({
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
  $( function() {
    var availableTags = [
   "Mombasa",
"Kwale",
"Kilifi",
"Tana River",
"Lamu",
"Taita Taveta",
"Garissa",
"Wajir",
"Mandera",
"Marsabit",
"Isiolo",
"Meru",
"Tharaka Nithi",
"Embu",
"Kitui",
"Machakos",
"Makueni",
"Nyandarua",
"Nyeri",
"Kirinyaga",
"Muranga",
"Kiambu",
"Turkana",
"West Pokot",
"Uasin Gishu",
"Trans-Nzoia",
"Samburu",
"Nandi",
"Elgeyo-Marakwet",
"Baringo",
"Laikipia",
"Nakuru",
"Narok",
"Kajiado",
"kericho",
"Bomet",
"Kakamega",
"Vihiga",
"Bungoma",
"Busia",
"Siaya",
"Kisumu",
"Homa Bay",
"Migori",
"Kisii",
"Nyamira",
"Nairobi"
    ];
    $( "#tags" ).autocomplete({
      source: availableTags
    });
  } );
  </script>

    <script>
    $('.clockpicker').clockpicker();
    $('#data_2 .input-group.date').datepicker({
                startView: 1,
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true,
                format: "yyyy-mm-dd"
            });


    $('#data_1 .input-group.date').datepicker({
                todayBtn: "linked",
                keyboardNavigation: true,
                forceParse: true,
                calendarWeeks: true,
                autoclose: true,
                 format: "yyyy-mm-dd"

            });

            $(document).ready(function(){
                $("button").click(function(){
                    $("#testR").toggle();
                });
            });
    </script>

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
           });
           </script>

<script type="text/javascript">
       $(document).ready(function(){
             $("#embedcode").hide();
             //$("#embedcode2").show();
             $("input[name='type']").change(function () {
                  if($(this).val() == "Yes")
                       $("#embedcode").show();
                       $("#embedcode2").hide();
                  else
                       $("#embedcode").hide();
                       //$("#embedcode2").show();
             });
       });
   </script>

   <script>
   $(document).ready(function()
   {
     var radios = document.getElementsByName('type');

   for (var i=0; i<radios.length; i++)
   {
     if (radios[i].type == 'radio')
     {
       radios[i].checked = false;
     }
   }
   });
   </script>


   <script type="text/javascript">
$.ajaxSetup({
 headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
});
</script>



   <script>

       $(document).ready(function() {

               $('.i-checks').iCheck({
                   checkboxClass: 'icheckbox_square-green',
                   radioClass: 'iradio_square-green'
               });

           /* initialize the external events
            -----------------------------------------------------------------*/


           $('#external-events div.external-event').each(function() {

               // store data so the calendar knows to render an event upon drop
               $(this).data('event', {
                   title: $.trim($(this).text()), // use the element's text as the event title
                   stick: true // maintain when user navigates (see docs on the renderEvent method)
               });

               // make the event draggable using jQuery UI
               $(this).draggable({
                   zIndex: 1111999,
                   revert: true,      // will cause the event to go back to its
                   revertDuration: 0  //  original position after the drag
               });

           });


           /* initialize the calendar
            -----------------------------------------------------------------*/
           var date = new Date();
           var d = date.getDate();
           var m = date.getMonth();
           var y = date.getFullYear();

           $('#calendar').fullCalendar({
               header: {
                   left: 'prev,next today',
                   center: 'title',
                   right: 'month,agendaWeek,agendaDay'
               },
               editable: true,
               droppable: true, // this allows things to be dropped onto the calendar
               drop: function() {
                   // is the "remove after drop" checkbox checked?
                   if ($('#drop-remove').is(':checked')) {
                       // if so, remove the element from the "Draggable Events" list
                       $(this).remove();
                   }
               },
               events: [
                   {
                       title: 'All Day Event',
                       start: new Date(y, m, 1)
                   },
                   {
                       title: 'Long Event',
                       start: new Date(y, m, d-5),
                       end: new Date(y, m, d-2)
                   },
                   {
                       id: 999,
                       title: 'Repeating Event',
                       start: new Date(y, m, d-3, 16, 0),
                       allDay: false
                   },
                   {
                       id: 999,
                       title: 'Repeating Event',
                       start: new Date(y, m, d+4, 16, 0),
                       allDay: false
                   },
                   {
                       title: 'Meeting',
                       start: new Date(y, m, d, 10, 30),
                       allDay: false
                   },
                   {
                       title: 'Lunch',
                       start: new Date(y, m, d, 12, 0),
                       end: new Date(y, m, d, 14, 0),
                       allDay: false
                   },
                   {
                       title: 'Birthday Party',
                       start: new Date(y, m, d+1, 19, 0),
                       end: new Date(y, m, d+1, 22, 30),
                       allDay: false
                   },
                   {
                       title: 'Click for Google',
                       start: new Date(y, m, 28),
                       end: new Date(y, m, 29),
                       url: 'http://google.com/'
                   }
               ]
           });


       });

   </script>

<!-- Mainly scripts -->
<script src="{{ asset('js/plugins/fullcalendar/moment.min.js') }}"></script>

<!-- Full Calendar -->
<script src="{{ asset('js/plugins/fullcalendar/fullcalendar.min.js') }}"></script>

<script>

    $(document).ready(function() {

            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green'
            });

        /* initialize the external events
         -----------------------------------------------------------------*/


        $('#external-events div.external-event').each(function() {

            // store data so the calendar knows to render an event upon drop
            $(this).data('event', {
                title: $.trim($(this).text()), // use the element's text as the event title
                stick: true // maintain when user navigates (see docs on the renderEvent method)
            });

            // make the event draggable using jQuery UI
            $(this).draggable({
                zIndex: 1111999,
                revert: true,      // will cause the event to go back to its
                revertDuration: 0  //  original position after the drag
            });

        });


        /* initialize the calendar
         -----------------------------------------------------------------*/
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();

        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            editable: true,
            droppable: true, // this allows things to be dropped onto the calendar
            drop: function() {
                // is the "remove after drop" checkbox checked?
                if ($('#drop-remove').is(':checked')) {
                    // if so, remove the element from the "Draggable Events" list
                    $(this).remove();
                }
            },
            events: [
                {
                    title: 'All Day Event',
                    start: new Date(y, m, 1)
                },
                {
                    title: 'Long Event',
                    start: new Date(y, m, d-5),
                    end: new Date(y, m, d-2)
                },
                {
                    id: 999,
                    title: 'Repeating Event',
                    start: new Date(y, m, d-3, 16, 0),
                    allDay: false
                },
                {
                    id: 999,
                    title: 'Repeating Event',
                    start: new Date(y, m, d+4, 16, 0),
                    allDay: false
                },
                {
                    title: 'Meeting',
                    start: new Date(y, m, d, 10, 30),
                    allDay: false
                },
                {
                    title: 'Lunch',
                    start: new Date(y, m, d, 12, 0),
                    end: new Date(y, m, d, 14, 0),
                    allDay: false
                },
                {
                    title: 'Birthday Party',
                    start: new Date(y, m, d+1, 19, 0),
                    end: new Date(y, m, d+1, 22, 30),
                    allDay: false
                },
                {
                    title: 'Click for Google',
                    start: new Date(y, m, 28),
                    end: new Date(y, m, 29),
                    url: 'http://google.com/'
                }
            ]
        });


    });

</script>


</body>
</html>
