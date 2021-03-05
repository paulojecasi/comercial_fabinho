jQuery(document).ready(function(){
  jQuery('input').on('keyup',function(){
    if(jQuery(this).attr('name') === 'result'){
    return false;
    }


    //---------------------CALCULA VALOR DO TROCO NO PAGAMENTO A VISTA 

    var vl_unitario = (jQuery('#vlunitario').val() == '' ? 0 : jQuery('#vlunitario').val());
 
    var quantidade = (jQuery('#quantidade').val() == '' ? 0 : jQuery('#quantidade').val());

    /*
    if (vl_total > vl_recebido_caixa){
        swal("ATENÇÃO! "," Valor recebido não pode ser MENOR que o valor da Venda!"); 
        var valorrecebido=vl_total;  
        jQuery('#vl_recebido_caixa').val(valorrecebido);
    }
    */

    var vl_total = (parseFloat(vl_unitario) * parseFloat(quantidade));
   
    var vl_total = vl_total.toLocaleString("pt-BR");
    
    jQuery('#vltotal').val(vl_total);



  });
});