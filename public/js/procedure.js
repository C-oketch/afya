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
          $('.modal-title').text('Add');
          $('.deleteContent').hide();
          $('.editstuff').hide();
          $('.form-horizontal').show();
          $('#fid').val();
          $('#fid').val($(this).data('id'));
          $('#n').val($(this).data('code'));
          $('#av').val($(this).data('desc'));
          $('#app').val($(this).data('app'));
          $('#nt').val($(this).data(''));
          $('#myModal').modal('show');
      });

    //ADD FUNCTION
        $('.modal-footer').on('click', '.save', function() {

            $.ajax({
                type: 'post',
                url: '/addprocedure',
                data: {
                    '_token': $('input[name=_token]').val(),
                    'proc_id': $('input[name=procId]').val(),
                    'appId': $('input[name=appoId]').val(),
                    'notes': $('input[name=note]').val(),
                    'status': $('select[name=status]').val()
                     },


                success: function(data) {

                  if ((data.errors)){
                    $('.error').removeClass('hidden');
                      // $('.error').text(data.errors.availability);
                      // $('.error').text(data.errors.amount);

                       alert('All fields are required\nCharges must be number?')
                  }
                  else {
                      $('.error').addClass('hidden');
                    $('.item' + data.id).replaceWith("<tr class='item" + data.id + "'><td>" + data.code + "</td><td>" + data.icd10_codes + "</td><td>" + data.description + "</td><td><button class='btn btn-info'>ADDED</button></td></tr>");
                   }
                },
            });
        });

        //EDIT MODAL
        $(document).on('click', '.edit-modal', function() {
              $('#footer_action_button').text("Update");
              $('#footer_action_button').addClass('glyphicon-check');
              $('#footer_action_button').removeClass('glyphicon-trash');
              $('.actionBtn').addClass('btn-success');
              $('.actionBtn').removeClass('btn-danger');
              $('.actionBtn').addClass('edit');
              $('.modal-title').text('Edit');
              $('.deleteContent').hide();
              $('.form-horizontal').show();
              $('.editstuff').show();
              $('#fid').val();
              $('#fid').val($(this).data('id'));
              $('#n').val($(this).data('code'));
              $('#av').val($(this).data('desc'));
              $('#app').val($(this).data('app'));
              $('#dat').val($(this).data('date1'));
              $('#dath').val($(this).data('date2'));
              $('#dc').val($(this).data('doc'));
              $('#nt').val($(this).data('note'));
              $('#stat').val($(this).data(''));
              $('#myModal').modal('show');
          });

          //EDIT FUNCTION
              $('.modal-footer').on('click', '.edit', function() {

                  $.ajax({
                      type: 'post',
                      url: '/editprocedure',
                      data: {
                          '_token': $('input[name=_token]').val(),
                          'id': $("#fid").val(),
                          'doc_id': $('#dc').val(),
                         'datp': $('#dath').val(),
                         'stat': $('input[name=status]:checked').val(),
                              },
                      success: function(data) {
                      $('.item' + data.id).replaceWith("<tr class='item" + data.id + "'><td>" + data.code + "</td><td>" + data.icd10_codes + "</td><td>" + data.description + "</td><td>" + data.created_at + "</td><td>" + data.procedure_date + "</td><td><button class='btn btn-info'><span class='glyphicon glyphicon-edit'></span>Updated</button></td></tr>");

                      }
                  });
              });

              // DELETE MODAL
                $(document).on('click', '.delete-modal', function() {
                    $('#footer_action_button').text(" Delete");
                    $('#footer_action_button').removeClass('glyphicon-check');
                    $('#footer_action_button').addClass('glyphicon-trash');
                    $('.actionBtn').removeClass('btn-success');
                    $('.actionBtn').addClass('btn-danger');
                    $('.actionBtn').addClass('delete');
                    $('.modal-title').text('Delete');
                    $('.deleteContent').show();
                    $('.form-horizontal').show();
                    $('#fid').val();
                    $('#fid').val($(this).data('id'));
                    $('#n').val($(this).data('code'));
                    $('#av').val($(this).data('desc'));
                    $('#app').val($(this).data('app'));
                    $('#dat').val($(this).data('date1'));
                    $('#dath').val($(this).data('date2'));
                    $('#dc').val($(this).data('doc'));
                    $('#nt').val($(this).data('note'));
                    $('#myModal').modal('show');
                });

                // Delete Function
                  $('.modal-footer').on('click', '.delete', function() {
                      $.ajax({
                          type: 'post',
                          url: '/deleteprocedure',
                          data: {
                              '_token': $('input[name=_token]').val(),
                            'id': $('input[name=procId]').val(),
                          },
                          success: function(data) {
                              $('.item' + data.id).remove();

                          }
                      });
                  });







});
