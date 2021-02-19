jQuery(document).ready(function(){
  jQuery('input').on('keyup',function(){
    if(jQuery(this).attr('name') === 'result'){
    return false;
    }

    // VALOR DO TROCO 
    var vl_total = (jQuery('#vl_total').val() == '' ? 0 : jQuery('#vl_total').val());
    
    var vl_recebido_caixa = (jQuery('#vl_recebido_caixa').val() == '' ? 0 : jQuery('#vl_recebido_caixa').val());

    /*
    if (vl_total > vl_recebido_caixa){
        swal("ATENÇÃO! "," Valor recebido não pode ser MENOR que o valor da Venda!"); 
        var valorrecebido=vl_total;  
        jQuery('#vl_recebido_caixa').val(valorrecebido);
    }
    */

    var vl_troco = (parseFloat(vl_recebido_caixa) - parseFloat(vl_total));
   
    var vl_troco = vl_troco.toLocaleString("pt-BR");
    
    jQuery('#vl_troco').val(vl_troco);

    if(vl_recebido_caixa==0){
        jQuery('#vl_troco').val(0);
    }


    /* VALOR DESCONTO-ACRESCIMO DO PRODUTO
    var vl_preco_uni = (jQuery('#vl_preco_alt').val() == '' ? 0 : jQuery('#vl_preco_alt').val());
    
    var quantidadeitens = (jQuery('#quantidadeitens_alt').val() == '' ? 0 : jQuery('#quantidadeitens_alt').val());
    
    var valordesconto= (jQuery('#valordesconto_alt').val() == '' ? 0 : jQuery('#valordesconto_alt').val());

    var valoracrescimo = (jQuery('#valoracrescimo_alt').val() == '' ? 0 : jQuery('#valoracrescimo_alt').val());

    valortotal = (parseFloat(vl_preco_uni) * parseFloat(quantidadeitens));

    valortotal = (parseFloat(valortotal) - parseFloat(valordesconto) + parseFloat(valoracrescimo));

    jQuery('#valortotal_alt').val(valortotal); */ 

  });
});