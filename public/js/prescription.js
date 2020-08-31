$(document).ready(function() {

    //ADD MODAL
    $(document).on('click', '.add-modal', function() {
          $('#footer_action_button').text("SUBMIT");
          $('#footer_action_button').addClass('glyphicon-check');
          $('#footer_action_button').removeClass('glyphicon-trash');
          $('.actionBtn').addClass('btn-success');
          $('.actionBtn').removeClass('btn-danger');
          $('.actionBtn').removeClass('edit');
          $('.actionBtn').addClass('save');
          $('.modal-title').text('Add Prescription');
          $('.deleteContent').hide();
          $('.form-horizontal').show();
          $('#appid').val($(this).data('appid'));
          $('#facility').val($(this).data('facility'));
          $('#drug').val('');

          $('#myModal').modal('show');
      });


    // //ADD FUNCTION
    //     $('.modal-footer').on('click', '.save', function() {
    //
    //         $.ajax({
    //             type: 'post',
    //             url: '/insert-presc-detail',
    //             data: {
    //                 '_token': $('input[name=_token]').val(),
    //                 'appointment': $('input[name=appointment]').val(),
    //                 'drug': $('input[name=drug]').val(),
    //                 'disease': $('input[name=disease]').val(),
    //                 'facility': $('input[name=facility]').val(),
    //                 'state': $('input[name=state]').val(),
    //                 'routes': $('select[name=routes]').val(),
    //                 'frequent': $('select[name=frequent]').val(),
    //                 'strength': $('select[name=strength]').val(),
    //                 'unit': $('select[name=unit]').val(),
    //                  },
    //
    //
    //             success: function(data) {
    //
    //               if ((data.errors)){
    //                 $('.error').removeClass('hidden');
    //
    //                    alert('All fields are required\nCharges must be number?')
    //               }
    //               else {
    //                   $('.error').addClass('hidden');
    //          $('#table').append("<tr class='item" + data.presc_details_id + "'><td>" + data.name + "</td><td>" + data.drug_id + "</td><td>" + data.abbreviation + data.rotename + "</td><td>" + data.frequencyname  +
    //           "</td><td><button class='delete-modal btn btn-danger' data-id='" + data.id + "' data-name='" + data.name + "'><span class='glyphicon glyphicon-trash'></span> Delete</button></td></tr>");
    //                }
    //             },
    //         });
    //     });

        // // DELETE MODAL
        //   $(document).on('click', '.delete-modal', function() {
        //       $('#footer_action_button').text(" Delete");
        //       $('#footer_action_button').removeClass('glyphicon-check');
        //       $('#footer_action_button').addClass('glyphicon-trash');
        //       $('.actionBtn').removeClass('btn-success');
        //       $('.actionBtn').addClass('btn-danger');
        //       $('.actionBtn').addClass('delete');
        //       $('.modal-title').text('Delete');
        //       $('.deleteContent').show();
        //       $('.form-horizontal').show();
        //       $('#fid').val();
        //       $('#fid').val($(this).data('id'));
        //       $('#n').val($(this).data('code'));
        //       $('#av').val($(this).data('desc'));
        //       $('#app').val($(this).data('app'));
        //       $('#dat').val($(this).data('date1'));
        //       $('#dath').val($(this).data('date2'));
        //       $('#dc').val($(this).data('doc'));
        //       $('#nt').val($(this).data('note'));
        //       $('#myModal').modal('show');
        //   });

        //   Delete Function
            // $('.modal-footer').on('click', '.delete', function() {
            //     $.ajax({
            //         type: 'post',
            //         url: '/deleteprocedure',
            //         data: {
            //             '_token': $('input[name=_token]').val(),
            //           'id': $('input[name=procId]').val(),
            //         },
            //         success: function(data) {
            //             $('.item' + data.id).remove();
            //
            //         }
            //     });
            // });






});
