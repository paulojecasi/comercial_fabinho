
/*
var piscando = document.getElementById('pisca');
var interval = window.setInterval(function(){
    if(piscando.style.visibility == 'hidden'){
        piscando.style.visibility = 'visible';
    }else{
        piscando.style.visibility = 'hidden';
    }
}, 1000);
*/

// checkbox para gerar nota automatica 

$(document).ready(function(){
	var nr_nota_auto = (jQuery('#nrnota_aut').val() == '' ? 0 : jQuery('#nrnota_aut').val());
	var nr_nota_auto = parseInt(nr_nota_auto); 
	$('#check-sem-nota').click(function() {
    if ($(this).is(':checked')) {
      jQuery('#nrnota').val(nr_nota_auto +1); 
      jQuery('#serie').val("SIS");
      jQuery('#emitente').val("SISTEMA");
      $('#nrnota').prop('readonly', true);
      $('#serie').prop('readonly', true);
      $('#emitente').prop('readonly', true);
    }
    if (!$(this).is(':checked')) {
      jQuery('#nrnota').val("");
      jQuery('#serie').val("");
      jQuery('#emitente').val("");
      $('#nrnota').prop('readonly', false);
      $('#serie').prop('readonly', false);
      $('#emitente').prop('readonly', false);
    }
  });
});









 










