$(document).ready(function() {
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
        $('#fid').val($(this).data('id'));
        $('#n').val($(this).data('name'));
        $('#av').val($(this).data('avala'));
        $('#amnt').val($(this).data('amount'));
        $('#myModal').modal('show');
    });
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
          $('#n').val($(this).data('name'));
          $('#av').val('');
          $('#amnt').val('');
          $('#myModal').modal('show');
      });

//EDIT FUNCTION
    $('.modal-footer').on('click', '.edit', function() {

        $.ajax({
            type: 'post',
            url: '/editray',
            data: {
                '_token': $('input[name=_token]').val(),
                'id': $("#fid").val(),
                'availability': $('#av').val(),
                'amount': $('#amnt').val(),


            },
            success: function(data) {
                $('.item' + data.testId).replaceWith("<tr class='item" + data.testId + "'><td>" + data.testId + "</td><td>" + data.name + "</td><td>" + data.availability + "</td><td>" + data.amount + "</td><td><button class='edit-modal btn btn-info' data-id='" + data.id + "' data-name='" + data.name + "'><span class='glyphicon glyphicon-edit'></span> Edit</button></td></tr>");
            }
        });
    });


    //ADD FUNCTION
        $('.modal-footer').on('click', '.save', function() {

            $.ajax({
                type: 'post',
                url: '/addultra',
                data: {
                    '_token': $('input[name=_token]').val(),
                    'tests_id': $('input[name=tests_id]').val(),
                    'availability': $('input[name=availability]').val(),
                    'amount': $('input[name=amount]').val()
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
                    $('.item' + data.testId).replaceWith("<tr class='item" + data.testId + "'><td>" + data.testId + "</td><td>" + data.name + "</td><td>" + data.availability + "</td><td>" + data.amount + "</td><td><button class='edit-modal btn btn-info' data-id='" + data.id + "' data-name='" + data.name + "'><span class='glyphicon glyphicon-edit'></span> Edit</button></td></tr>");
                   }
                },
            });
        });


});
