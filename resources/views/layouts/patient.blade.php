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
    <link href="{{ asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" href="{{asset('css/custom.css') }}" />
      <script type="text/javascript" src="{{ asset('js/modernizr.js') }}"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <link rel="stylesheet" href="{{asset('select/select2.min.css') }}" />
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
      <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


</head>

<body>


  <div id="wrapper">
  @include('includes.patient_inc.leftmenu')

      <div id="page-wrapper" class="gray-bg dashbard-1">

  <!-- Main view  -->
  @yield('content')
@include('includes.default.footer')
      </div>

  </div>


 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="{{asset('js/ajaxscript.js')}}"></script>
   <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
    <!-- Mainly scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}" type="text/javascript"></script>
     <script src="{{ asset('js/jquery-3.1.1.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}" type="text/javascript"></script>

   <script src="{{ asset('js/plugins/steps/jquery.steps.min.js') }}"></script>
<script src="{{ asset('js/plugins/validate/jquery.validate.min.js') }}"></script>
<script src="{{ asset('js/plugins/datapicker/bootstrap-datepicker.js') }}" type="text/javascript"></script>



<script src="{{asset('js/ajaxscript.js')}}"></script>

    <!-- Custom and plugin javascript -->




    <!-- Custom and plugin javascript -->
<script src="{{ asset('js/plugins/pace/pace.min.js') }}" type="text/javascript"></script>
 <script src="{{ asset('select/select2.min.js') }}" type="text/javascript"></script>

    <!-- Page-Level Scripts -->
    <script>
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
             $("input[name='type']").change(function () {
                  if($(this).val() == "yes")
                       $("#embedcode").show();
                  else
                       $("#embedcode").hide();
             });
       });
   </script>



</body>
</html>
