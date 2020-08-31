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
          $('.modal-title').text('Make Payment');
          $('.deleteContent').hide();
          $('.editstuff').hide();
          $('.form-horizontal').show();
          $('#fid').val();
          $('#fid').val($(this).data('id'));
          $('#amount').val($(this).data('amount'));
          // $('#app').val($(this).data('app'));
          $('#ptid').val($(this).data('ptid'));
          $('#myModal').modal('show');
      });









});
