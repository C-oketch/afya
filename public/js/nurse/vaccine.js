$(document).ready(function() {
  //EDIT MODAL
  $(document).on('click', '.edit-modal', function() {
        $('#footer_action_button').text("Update");
        $('#footer_action_button').addClass('glyphicon-check');
        $('#footer_action_button').removeClass('glyphicon-trash');
        $('.actionBtn').addClass('btn-success');
        $('.actionBtn').removeClass('btn-danger');
        $('.actionBtn').addClass('edit');
        $('.modal-title').text('Vaccine');
        $('.deleteContent').hide();
        $('.form-horizontal').show();
        $('#n1').val($(this).data('name'));
        $('#ant1').val($(this).data('antgen'));
        $('#yesdate1').val($(this).data('yesdate'));
        $('#vacname1').val($(this).data('vacname'));
        $('#myModaledit').modal('show');
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
          $('#afyaid').val($(this).data('afya'));
          $('#n').val($(this).data('name'));
          $('#ant').val($(this).data('antgen'));
          $('#fid').val($(this).data('id'));
         $('#myModal').modal('show');
      });


    //ADD FUNCTION
        $('.modal-footer').on('click', '.save', function() {

            $.ajax({
              type: 'post',
                url: '/vaccinesave',
                data: {
                    '_token': $('input[name=_token]').val(),
                    'afya_user_id': $('input[name=afya_user_id]').val(),
                    'vaccine_id': $('input[name=vaccine_id]').val(),
                    'vaccine_name': $('input[name=vaccine_name]').val()
                     },


                success: function(data) {

                  if ((data.errors)){
                    $('.error').removeClass('hidden');

                       alert('All fields are required\nCharges must be number?')
                  }
                  else {
                      $('.error').addClass('hidden');
                    $('.item' + data.id).replaceWith("<tr class='item" + data.id + "'><td>" + data.id + "</td><td>" + data.disease + "</td><td>" + data.antigen + "</td><td><button class='edit-modal btn btn-info' data-name='" + data.disease + "' data-antgen='" + data.antigen + "' data-yesdate='" + data.yesdate + "' data-vacname='" + data.vaccine_name + "'>View</button></td></tr>");
                   }
                },
            });
        });


});
