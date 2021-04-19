jQuery(document).ready(function(){
  jQuery('input').on('keyup',function(){
    if(jQuery(this).attr('name') === 'result'){
    return false;
    }

    //---------------------CALCULA VALOR DO TROCO E SALDO DO CREDIARIO
    var vl_saldo_crediario = (  jQuery('#vl_saldo_crediario').val() == '' ? 0 : 
                                jQuery('#vl_saldo_crediario').val());
 
    var vl_recebido_caixa_cred = (jQuery('#vl_recebido_caixa_cred').val() == '' ? 0 :
                                 jQuery('#vl_recebido_caixa_cred').val());

    var vl_juros_caixa_cred = (jQuery('#vl_juros_caixa_cred').val() == '' ? 0 :
                                jQuery('#vl_juros_caixa_cred').val());

    var vl_desconto_caixa_cred = (jQuery('#vl_desconto_caixa_cred').val() == '' ? 0 : 
                                jQuery('#vl_desconto_caixa_cred').val());

    var vl_troco_cred = (   parseFloat(vl_recebido_caixa_cred)  - 
                            parseFloat(vl_saldo_crediario)      -
                            parseFloat(vl_juros_caixa_cred)     +
                            parseFloat(vl_desconto_caixa_cred));
   
    var vl_saldo_atual = (  parseFloat(vl_saldo_crediario) - 
                            parseFloat(vl_recebido_caixa_cred));

    var vl_recebido_caixa_cred = parseFloat(vl_recebido_caixa_cred);

    var vl_saldo_crediario = parseFloat(vl_saldo_crediario); 

    // calcular o valor da amortização 
    if (vl_recebido_caixa_cred < vl_saldo_crediario)
    {
        var vl_real_amortizacao = parseFloat(vl_recebido_caixa_cred); 
    }
     else
    {
        var vl_real_amortizacao = parseFloat(vl_saldo_crediario); 
    }
    
    var vl_total_pag_cred = (   parseFloat(vl_recebido_caixa_cred) +
                                parseFloat(vl_juros_caixa_cred)     - 
                                parseFloat(vl_desconto_caixa_cred)); 

    if (vl_troco_cred > 0){
        var vl_total_pag_cred = (   parseFloat(vl_total_pag_cred) - 
                                    parseFloat(vl_troco_cred)); 
        //var vl_troco_cred = vl_troco_cred.toLocaleString("pt-BR");
        
    }

    if(vl_recebido_caixa_cred==0 | vl_troco_cred < 0) 
    {
        var vl_troco_cred =0;
    }
 
    if(vl_saldo_atual <=0) 
    {
        var vl_saldo_atual=0;
    }


    var vl_troco_cred = parseFloat(vl_troco_cred).toFixed(2); 
    var vl_saldo_atual = parseFloat(vl_saldo_atual).toFixed(2); 
    var vl_total_pag_cred = parseFloat(vl_total_pag_cred).toFixed(2); 
    
    jQuery('#vl_real_amortizacao').val(vl_real_amortizacao);
    jQuery('#vl_troco_cred').val(vl_troco_cred);
    jQuery('#vl_saldo_atual').val(vl_saldo_atual);
    jQuery('#vl_total_pag_cred').val(vl_total_pag_cred); 

    if (vl_recebido_caixa_cred<0)
    {
        alert("ATENÇÃO - Valor do Recebimento NÃO pode ser NEGATIVO ou ZERO!") 
        jQuery('#vl_recebido_caixa_cred').val("");
        
    }
 
  });
});

