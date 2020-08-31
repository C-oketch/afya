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
          $('.form-horizontal').show();
          $('.adds').show();
          $('#fid').val();
          $('#fid').val($(this).data('id'));
          $('#name').val($(this).data('name'));
          $('#appId').val($(this).data('appid'));
          $('#catId').val($(this).data('catid'));
          $('#docnote').val('');
          $('#myModal1').modal('show');
      });
      // DELETE MODAL
          $(document).on('click', '.delete-modal', function() {
              $('#footer_action_button').text(" Delete");
              $('#footer_action_button').removeClass('glyphicon-check');
              $('#footer_action_button').addClass('glyphicon-trash');
              $('.actionBtn').removeClass('btn-success');
              $('.actionBtn').addClass('btn-danger');
              $('.actionBtn').addClass('delete');
              $('.modal-title').text('You Are a bout to Delete Test');
              $('.deleteContent').show();
              $('.form-horizontal').show();
              $('.adds').hide();
              $('#fid').val($(this).data('rtd'));
              $('#name').val($(this).data('name'));
              $('#catId').val($(this).data('cat_id'));
              $('#myModal').modal('show');
          });

    //ADD FUNCTION
        $('.modal-footer').on('click', '.save', function() {
         var path=window.location.href.match(/^.*\//);
          $.ajax({
                type: 'post',
                url: '/Radtest',
                data: {
                    '_token': $('input[name=_token]').val(),
                    'test': $('input[name=test]').val(),
                    'appointment': $('input[name=appointment]').val(),
                    'clinical': $('textarea[name=clinical]').val(),
                    'cat_id': $('input[name=cat_id]').val(),
                    'target': $('select[name=target]').val(),
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
                    $('.item' + data.id).replaceWith("<tr class='item" + data.id + "'><td>" + data.id + "</td><td>" + data.name + "</td><td><button class='delete-modal btn btn-danger' data-rtd='" + data.rtd + "' data-name='" + data.name + "' data-cat_id='" + data.test_cat_id + "' ><span class='glyphicon glyphicon-minus'></span> Remove</button></td></tr>");
                   }
                },
            });
        });

        // Delete Function
        $('.modal-footer').on('click', '.delete', function() {
             var path=window.location.href.match(/^.*\//);
          $.ajax({
                type: 'post',
                url: '/Radremove',
                data: {
                    '_token': $('input[name=_token]').val(),
                    'test': $('input[name=test]').val(),
                    'cat_id': $('input[name=cat_id]').val(),
                    },


                    success: function(data) {
                      if (data == "refresh"){
                        window.location.reload(); // This is not jQuery but simple plain ol' JS
                      }
                    }
            });
        });


});
