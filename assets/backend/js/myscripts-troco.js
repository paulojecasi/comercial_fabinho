jQuery(document).ready(function(){
  jQuery('input').on('keyup',function(){
    if(jQuery(this).attr('name') === 'result'){
    return false;
    }


    //---------------------CALCULA VALOR DO TROCO NO PAGAMENTO A VISTA 

    var vl_total = (jQuery('#vl_total').val() == '' ? 0 : jQuery('#vl_total').val());
 
    var vl_recebido_caixa = (jQuery('#vl_recebido_caixa').val() == '' ? 0 : jQuery('#vl_recebido_caixa').val());

    var vl_troco = (parseFloat(vl_recebido_caixa) - parseFloat(vl_total));
   
    if(vl_recebido_caixa==0 | vl_troco < 0 ){
        var vl_troco =0 ;
    }

   
    var vl_troco = parseFloat(vl_troco).toFixed(2); 
    
    jQuery('#vl_troco').val(vl_troco);

    //jQuery('#vl_troco').mask('0000,00', {reverse: true});


  });
});

