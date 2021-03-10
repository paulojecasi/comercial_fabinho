/* formata campos  */
jQuery(document).ready(function(){
  jQuery('input').on('keyup',function(){
    if(jQuery(this).attr('name') === 'result'){
    return false;
    }

   // totalizador do ALTERAÇÃO DE ITENS DA VENDA 
	//$('#vlpreco_alt').mask('0000.00', {reverse: true});
  //$('#vl_troco').mask('0000,00', {reverse: true});

  });
});
