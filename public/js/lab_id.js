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
          $('.modal-title').text('Payments');
          $('.deleteContent').hide();
          $('.form-horizontal').show();
          $('#appid').val($(this).data('appid'));
          $('#m').val($(this).data('name'));
          $('#n').val($(this).data('amount'));
          $('#ptid').val($(this).data('ptid'));
          $('#ptdid').val($(this).data('ptdid'));

          $('#myModal').modal('show');
      });


      //ADD MODAL
      $(document).on('click', '.add-modall', function() {
            $('#footer_action_button').text("SUBMIT");
            $('#footer_action_button').addClass('glyphicon-check');
            $('#footer_action_button').removeClass('glyphicon-trash');
            $('.actionBtn').addClass('btn-success');
            $('.actionBtn').removeClass('btn-danger');
            $('.actionBtn').removeClass('edit');
            $('.actionBtn').addClass('save');
            $('.modal-title').text('Payments');
            $('.deleteContent').hide();
            $('.form-horizontal').show();
            $('#appidl').val($(this).data('appid'));
            $('#ml').val($(this).data('name'));
            $('#nl').val($(this).data('amount'));
            $('#ptidl').val($(this).data('ptid'));
            $('#ptdidl').val($(this).data('ptdid'));

            $('#myModall').modal('show');
        });




});
