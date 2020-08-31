$(document).ready(function() {
  //EDIT MODAL
  // $(document).on('click', '.edit-modal', function() {
  //       $('#footer_action_button').text("Update");
  //       $('#footer_action_button').addClass('glyphicon-check');
  //       $('#footer_action_button').removeClass('glyphicon-trash');
  //       $('.actionBtn').addClass('btn-success');
  //       $('.actionBtn').removeClass('btn-danger');
  //       $('.actionBtn').addClass('edit');
  //       $('.modal-title').text('Edit');
  //       $('.deleteContent').hide();
  //       $('.form-horizontal').show();
  //       $('#fid').val($(this).data('id'));
  //       $('#n').val($(this).data('name'));
  //       $('#av').val($(this).data('avala'));
  //       $('#amnt').val($(this).data('amount'));
  //       $('#myModal').modal('show');
  //   });
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
          $('.form-horizontal').show();
          $('#fid').val();
          $('#fid').val($(this).data('id'));
          $('#name').val($(this).data('name'));
          $('#ptid').val($(this).data('ptid'));
          $('#catId').val($(this).data('catid'));
          $('#dep').val($(this).data('dep'));
          $('#afya').val($(this).data('afya'));
          $('#myModal').modal('show');
      });

//EDIT FUNCTION
    // $('.modal-footer').on('click', '.edit', function() {
    //
    //     $.ajax({
    //         type: 'post',
    //         url: '/editItem',
    //         data: {
    //             '_token': $('input[name=_token]').val(),
    //             'id': $("#fid").val(),
    //             'availability': $('#av').val(),
    //             'amount': $('#amnt').val(),
    //
    //
    //         },
    //         success: function(data) {
    //             $('.item' + data.testId).replaceWith("<tr class='item" + data.testId + "'><td>" + data.testId + "</td><td>" + data.name + "</td><td>" + data.sub + "</td><td>" + data.availability + "</td><td>" + data.amount + "</td><td><button class='edit-modal btn btn-info' data-id='" + data.id + "' data-name='" + data.name + "'><span class='glyphicon glyphicon-edit'></span> Edit</button></td></tr>");
    //         }
    //     });
    // });


    //ADD FUNCTION
        $('.modal-footer').on('click', '.save', function() {

            $.ajax({
                type: 'post',
                url: '/Radytest',
                data: {
                    '_token': $('input[name=_token]').val(),
                    'test': $('input[name=test]').val(),
                    'ptid': $('input[name=patient_test_id]').val(),
                    'clinical': $('textarea[name=clinical]').val(),
                    'cat_id': $('input[name=cat_id]').val(),
                    'target': $('select[name=target]').val(),
                    'dependant': $('input[name=dependant_id]').val(),
                    'afya_user': $('input[name=afya_user_id]').val(),

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
                    $('.item' + data.id).replaceWith("<tr class='item" + data.id + "'><td>" + data.id + "</td><td>" + data.name + "</td>><td><button class='btn btn-info'></span>ADDED</button></td></tr>");
                   }
                },
            });
        });


});
