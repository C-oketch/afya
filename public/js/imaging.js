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
          $('#myModal').modal('show');
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
              $('#fid2').val($(this).data('rtd'));
              $('#name2').val($(this).data('name'));
              $('#appId2').val($(this).data('appid'));
              $('#catId2').val($(this).data('cat_id'));
              $('#myModal2').modal('show');
          });





});
