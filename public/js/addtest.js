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
          $('.modal-title').text('ADD TESTS');
          $('.deleteContent').hide();
          $('.editstuff').hide();
          $('.form-horizontal').show();
          $('#fid').val();
          $('#fid').val($(this).data('id'));
          $('#name').val($(this).data('name'));
          $('#cat').val($(this).data('cat'));
          $('#ptid').val($(this).data('ptid'));
          $('#afya').val($(this).data('afya'));
          $('#dep').val($(this).data('dep'));


          $('#myModal').modal('show');
      });



});
