$(document).ready(function() {

    //ADD MODAL LAB TEST
    $(document).on('click', '.add-modal', function() {
          $('#footer_action_button').text("SUBMIT");
          $('#footer_action_button').addClass('glyphicon-check');
          $('#footer_action_button').removeClass('glyphicon-trash');
          $('.actionBtn').addClass('btn-success');
          $('.actionBtn').removeClass('btn-danger');
          $('.actionBtn').removeClass('edit');
          $('.actionBtn').addClass('save');
          $('.modal-title').text('ADD TEST');
          $('.deleteContent').hide();
          $('.form-horizontal').show();
          $('#fid').val($(this).data('id'));
          $('#n').val($(this).data('tname'));
          $('#scat').val($(this).data('scat'));
          $('#cat').val($(this).data('cat'));
          $('#appId').val($(this).data('appid'));
          $('#docnote').val('');
        $('#myModal').modal('show');
      });




});
