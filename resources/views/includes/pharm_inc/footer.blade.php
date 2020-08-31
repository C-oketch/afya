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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<!-- <script src="{{-- asset('js/ajaxscript.js') --}}"></script> -->


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

@yield('date-script')

<script type="text/javascript">
$.ajaxSetup({
 headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
});
</script>

<script>
      $('.thedrugs').select2({
          placeholder: "Select drugs...",
          minimumInputLength: 2,
          ajax: {
              url: '/alldrugs',
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

<!-- Get doctors -->
  <script>
        $('.thedoctors').select2({
            placeholder: "Select doctor...",
            minimumInputLength: 2,
            ajax: {
                url: '/alldoctors',
                dataType: 'json',
                quietMillis: 250,
                data: function (params) {
                    return {
                        q: $.trim(params.term)  //search term
                        //page: page // page number
                    };
                },
                processResults: function (data) {
                  //var more = (page * 30) < data.total_count; // whether or not there are more results available
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
              url: '/tag/drug',
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

<!-- Get drug suppliers -->
  <script>
        $('.supplier1').select2({
            placeholder: "Select supplier...",
            minimumInputLength: 2,
            ajax: {
                url: '/supplier',
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
        $('.manufacturer1').select2({
            placeholder: "Select manufacturer...",
            minimumInputLength: 2,
            ajax: {
                url: '/manus',
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
    $(document).ready(function() {
  $('a[data-toggle=modal], button[data-toggle=modal]').click(function () {

      var data_manufacturer = '';
      var data_drug = '';
      var data_stock = '';
      var data_id = '';
if (typeof $(this).data('manufacturer') !== 'undefined') {
         data_manufacturer = $(this).data('manufacturer');
         data_drug = $(this).data('drug');
         data_stock = $(this).data('stock');
         data_id = $(this).data('id');
      }
      $('#deletion1').val(data_manufacturer);
      $('#deletion2').val(data_drug);
      $('#deletion3').val(data_stock);
      $('#deletion4').val(data_id);
    })
  });
  </script>

<script>
   $(document).ready(function(){
       $('.dataTables-example').DataTable({
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

   //For pharmacy inventory
   $(document).ready(function(){
       $('.dataTables-pharmacy').DataTable({
           pageLength: 10,
           responsive: true,
           dom: '<"html5buttons"B>lTfgitp',
           buttons: [
               { extend: 'copy', title: 'inventory_list'},
               {extend: 'csv', title: 'inventory_list',exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                }},
               {extend: 'excel', title: 'inventory_list',exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                }},
               {extend: 'pdf', title: 'inventory_list',exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                }},

               {extend: 'print',title: 'inventory_list',
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

<!-- <script>
 $('#weight,#quantity').keyup(function(){
 if((document.getElementById('weight1').value * document.getElementById('quantity').value) < document.getElementById('strength22').value)
 $('#subs').show();
 $('#first_reason').attr('required', true);
 else
 $('#subs').hide();
 $('#first_reason').removeAttr('required');
   });
 </script> -->

<script>
$(document).ready(function()
{
  var radios = document.getElementsByName('availability');

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

      // $('#dd').select2({
      //   placeholder: 'Select an item',
      //   ajax: {
      //     url: '/select2',
      //     dataType: 'json',
      //     delay: 250,
      //     processResults: function (data) {
      //       return {
      //         results:  $.map(data, function (item) {
      //               return {
      //                   text: item.drugname,
      //                   id: item.drug_id
      //               }
      //           })
      //       };
      //     },
      //     cache: true
      //   }
      // });

</script>

<script>
$('#date_2 ').datepicker({
            startView: 1,
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true,
            format: "yyyy-mm-dd"
        });


$('#date_1 ').datepicker({
            todayBtn: "linked",
            keyboardNavigation: true,
            forceParse: true,
            calendarWeeks: true,
            autoclose: true,
             format: "yyyy-mm-dd"

        });

        // $(document).ready(function(){
        //     $("button").click(function(){
        //         $("#testR").toggle();
        //     });
        // });
</script>
