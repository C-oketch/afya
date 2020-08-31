<div class="footer">

    <div class="pull-right">
        Afyapepe <strong>Health</strong> Platform.
    </div>
    <div>
        <strong>Copyright</strong> afyapepe.co.ke &copy; 2016-2017
    </div>
</div>

<!-- Mainly scripts -->
<script src="{{ asset('js/jquery-3.1.1.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>

<!-- End wrapper-->
<meta name="_token" content="{!! csrf_token() !!}" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
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

<script type="text/javascript">
$.ajaxSetup({
 headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
});
</script>

<script>
      $('.facility').select2({
          placeholder: "Select facility...",
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


