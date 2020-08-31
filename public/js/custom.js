// // show radio divs
// $(document).ready(function () {
//   // $('#div1').hide();
//   $('#div2').hide();
//   $('#othertest').hide();
// $('#button1').click(function () {
// $('#div1').toggle('fast');
//                });
//  $('#button2').click(function () {
//     $('#othertest').toggle('fast');
//      });
//
//   });


// show checkbox divs
$(document).ready(function(){
 $('input[type="checkbox"]').click(function(){
       var inputValue = $(this).attr("value");

       $("." + inputValue).toggle();

   });

});

$(document).ready(function(){
 $('input[name="checkbox"]').click(function(){
       var inputValue = $(this).attr("value");

       $("." + inputValue).toggle();

   });

});
// show quick diagnosis divs
$(document).ready(function () {
$('#quickD').hide();

$('#button11').click(function () {
$('#quickD').toggle('fast');
$('#quickR').hide();
               });
});
// select test
$(".test-multiple").select2();

// wizzard for infants
$(document).ready(function(){
    $("#wizard").steps();

});


// diagnoses toogle
$(document).ready(function(){
  $("#confdiag").hide();
    $("#diag").click(function(){
        $("#confdiag").toggle();
    });
});

// diagnoses toogle
$(document).ready(function(){
  $("#supportive").hide();
    $("#diagSC").click(function(){
        $("#supportive").toggle();
    });
});

// discharge
document.getElementById('dcond').addEventListener('change', function () {
    var style = this.value == 1 ? 'block' : 'none';
    document.getElementById('hidden_div1').style.display = style;
    var style = this.value == 2 ? 'block' : 'none';
    document.getElementById('hidden_div2').style.display = style;
    var style = this.value == 3 ? 'block' : 'none';
    document.getElementById('hidden_div3').style.display = style;
    var style = this.value == 4 ? 'block' : 'none';
    document.getElementById('hidden_div4').style.display = style;
});
