$(document).ready(function() {

    //ADD MODAL Imaging
    $(document).on('click', '.add-modal1', function() {
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
      // DELETE MODAL Imaging
          $(document).on('click', '.delete-modal11', function() {
              $('#footer_action_button').text(" Delete");
              $('#footer_action_button').removeClass('glyphicon-check');
              $('#footer_action_button').addClass('glyphicon-trash');
              $('.actionBtn').removeClass('btn-success');
              $('.actionBtn').addClass('btn-danger');
              $('.actionBtn').addClass('delete1');
              $('.modal-title').text('You Are a bout to Delete Test');
              $('.deleteContent').show();
              $('.form-horizontal').show();
              $('#fid11').val($(this).data('rtd'));
              $('#appId11').val($(this).data('appid'));
              $('#name11').val($(this).data('name'));
              $('#catId11').val($(this).data('cat_id'));
              $('#myModal11').modal('show');
          });



        //ADD MODAL LAB TEST
        $(document).on('click', '.add-modal2', function() {
              $('#footer_action_button').text("SUBMIT");
              $('#footer_action_button').addClass('glyphicon-check');
              $('#footer_action_button').removeClass('glyphicon-trash');
              $('.actionBtn').addClass('btn-success');
              $('.actionBtn').removeClass('btn-danger');
              $('.actionBtn').removeClass('edit');
              $('.actionBtn').addClass('save2');
              $('.modal-title').text('ADD TEST');
              $('.deleteContent').hide();
              $('.form-horizontal').show();
              $('#fid2').val($(this).data('id2'));
              $('#n2').val($(this).data('tname2'));
              $('#scat2').val($(this).data('scat2'));
              $('#cat2').val($(this).data('cat2'));
              $('#appId2').val($(this).data('appid2'));
              $('#docnote2').val('');
            $('#myModal2').modal('show');
          });


//Delete LABTEST
                  $(document).on('click', '.delete-modal22', function() {
                    $('#footer_action_button').text("Delete");
                    $('#footer_action_button').removeClass('glyphicon-check');
                    $('#footer_action_button').addClass('glyphicon-trash');
                    $('.actionBtn').removeClass('btn-success');
                    $('.actionBtn').addClass('btn-danger');
                    $('.actionBtn').addClass('delete2');
                    $('.modal-title').text('You Are a bout to Delete Test');
                    $('.deleteContent').show();
                    $('.form-horizontal').show();
                    $('#fid22').val($(this).data('id2'));
                    $('#n22').val($(this).data('tname2'));
                    $('#scat22').val($(this).data('scat2'));
                    $('#cat22').val($(this).data('cat2'));
                      $('#appId22').val($(this).data('appid2'));

                  $('#myModal22').modal('show');
                    });







});
