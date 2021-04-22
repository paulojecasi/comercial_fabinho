
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
	var nr_nota_auto = ($('#nrnota_aut').val() == '' ? 0 : $('#nrnota_aut').val());
	var nr_nota_auto = parseInt(nr_nota_auto); 
	$('#check-sem-nota').click(function() {
    if ($(this).is(':checked')) {
      $('#nrnota').val(nr_nota_auto +1); 
      $('#serie').val("SIS");
      $('#emitente').val("SISTEMA");
      $('#nrnota').prop('readonly', true);
      $('#serie').prop('readonly', true);
      $('#emitente').prop('readonly', true);
      document.getElementById("valornota").select();
    }
    if (!$(this).is(':checked')) {
      $('#nrnota').val("");
      $('#serie').val("");
      $('#emitente').val("");
      $('#nrnota').prop('readonly', false);
      $('#serie').prop('readonly', false);
      $('#emitente').prop('readonly', false);
      document.getElementById("nrnota").select();

    }
  });


});

// TELA CADASTRO DE PRODUTOS

$('#vlpreco').keyup(function(){
  var vl_preco_uni = ($('#vlpreco').val() == '' ? 0 : $('#vlpreco').val());
  var vl_preco_uni = parseFloat(vl_preco_uni).toFixed(2);
  $('#vlprecoatacado').val(vl_preco_uni);

}); 
  











 










