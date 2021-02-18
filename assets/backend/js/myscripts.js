$(document).ready(function(){
	$('#mtabela').DataTable({
		"language": {
			"lengthMenu": "Mostrando _MENU_  registro por página",
			"zeroRecords": "Nada encontrado",
			"info": "Mostrando página _PAGE_ de _PAGES_",
			"infoEmpty": "Nenhum registro disponível",
			"infoFiltered": "(Filtrado _MAX_ registros no total)"
		}
	});
});

/*
function calcular() {
  var valor1 = parseInt(document.getElementById('vl_total').value, 10);
  var valor2 = parseInt(document.getElementById('vl_recebido').value, 10);
  document.getElementById('vl_troco').value = valor2 - valor1;
}
*/

// VALOR DO TROCO 
jQuery(document).ready(function(){
  jQuery('input').on('keyup',function(){
    if(jQuery(this).attr('name') === 'result'){
    return false;
    }

    var vl_total = (jQuery('#vl_total').val() == '' ? 0 : jQuery('#vl_total').val());
    
    var vl_recebido = (jQuery('#vl_recebido').val() == '' ? 0 : jQuery('#vl_recebido').val());

    var vl_troco = (parseFloat(vl_recebido) - parseFloat(vl_total));
   
    var vl_troco = vl_troco.toLocaleString("pt-BR");
    
    jQuery('#vl_troco').val(vl_troco);

    if(vl_recebido==0){
    	jQuery('#vl_troco').val(0);
    }

  });
});

// formata campos 
jQuery(function($){
   $("#vl_recebido").mask('###0.00', {reverse: true});
});


function EnterTab(InputId,Evento){

    if(Evento.keyCode == 13){       

        document.getElementById(InputId).focus();

    }

}



