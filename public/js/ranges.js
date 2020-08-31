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
        $('#fid').val();
        $('#fid').val($(this).data('id'));
        $('#n').val($(this).data('tname'));
        $('#scat').val($(this).data('scat'));
        $('#unit').val($(this).data('unit'));
        $('#lf').val($(this).data('lf'));
        $('#hf').val($(this).data('hf'));
        $('#lm').val($(this).data('lm'));
        $('#hm').val($(this).data('hm'));
        $('#mnm').val($(this).data('mnm'));
        $('#mid').val($(this).data('mid'));


        $('#facility').val($(this).data('facid'));
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
          $('#n').val($(this).data('tname'));
          $('#scat').val($(this).data('scat'));
          $('#facility').val($(this).data('facid'));
        $('#myModal').modal('show');
      });

//EDIT FUNCTION
    $('.modal-footer').on('click', '.edit', function() {

        $.ajax({
            type: 'post',
            url: '/updtranges',
            data: {
                '_token': $('input[name=_token]').val(),
                  // 'machine_id':$("#mid").val(),
                  'machine_id':$('#machineId').val(),
                // 'machine_name' = $('#machineId').find(":selected").text(),
                 'tranges_id': $("#fid").val(),
                 'low_male':$("#lm").val(),
                 'high_male':$("#hm").val(),
                 'low_female':$("#lf").val(),
                 'high_female':$("#hf").val(),
                 'unit':$("#unit").val(),

                  },
  success: function(data) {
    if ((data.errors)){
      $('.error').removeClass('hidden');
        // $('.error').text(data.errors.availability);
        // $('.error').text(data.errors.amount);

         alert('All fields are required\nCharges must be number?')
    }
$('.item' + data.testId).replaceWith("<tr class='item" + data.testId + "'><td>" + data.testId + "</td><td>" + data.tname + "</td><td>" + data.subname + "</td><td>" + data.machine + "</td><td>" + data.low_female + "</td><td>" + data.high_female + "</td><td>" + data.low_male + "</td><td>" + data.high_male + "</td><td>" + data.units + "</td><td><button class='btn btn-info' ><span class='glyphicon glyphicon-edit'></span>Done</button></td></tr>");

            }
        });
    });


    //ADD FUNCTION
        $('.modal-footer').on('click', '.save', function() {

            $.ajax({
                type: 'post',
                url: '/rangesadd',
                data: {
                  '_token': $('input[name=_token]').val(),
                  //'machine_name':$('input[name=machine_name]').val(),
                    'machine_name':$('#machineId').val(),
                  // 'machine_name' = $('#machineId').find(":selected").text(),
                  'test_id': $('input[name=test_id]').val(),
                  'facility_id':$('input[name=facility_id]').val(),
                  'low_male':$('input[name=low_male]').val(),
                  'high_male':$('input[name=high_male]').val(),
                  'low_female':$('input[name=low_female]').val(),
                  'high_female':$('input[name=high_female]').val(),
                  'units':$('input[name=units]').val()
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
$('.item' + data.testId).replaceWith("<tr class='item" + data.testId + "'><td>" + data.testId + "</td><td>" + data.tname + "</td><td>" + data.subname + "</td><td>" + data.machine + "</td><td>" + data.low_female + "</td><td>" + data.high_female + "</td><td>" + data.low_male + "</td><td>" + data.high_male + "</td><td>" + data.units + "</td><<td>" + data.units + "</td<td><button class='edit-modal btn btn-info' data-id='" + data.id + "' data-name='" + data.name + "'><span class='glyphicon glyphicon-edit'></span> EDIT</button></td></tr>");









                   }
                },
            });
        });


});
