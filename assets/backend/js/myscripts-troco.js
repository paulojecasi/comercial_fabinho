jQuery(document).ready(function(){
  jQuery('input').on('keyup',function(){
    if(jQuery(this).attr('name') === 'result'){
    return false;
    }

    //---------------------CALCULA VALOR DO TROCO NO PAGAMENTO A VISTA 

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


/*
    //---------------------CALCULA VALOR DO TROCO E SALDO DO CREDIARIO
    var vl_saldo_crediario = (jQuery('#vl_saldo_crediario').val() == '' ? 0 : jQuery('#vl_saldo_crediario').val());
 
    var vl_recebido_caixa_cred = (jQuery('#vl_recebido_caixa_cred').val() == '' ? 0 : jQuery('#vl_recebido_caixa_cred').val());

    var vl_troco_cred = (parseFloat(vl_recebido_caixa_cred) - parseFloat(vl_saldo_crediario));
   
    var vl_saldo_atual = (parseFloat(vl_saldo_crediario) - parseFloat(vl_recebido_caixa_cred));


    // calcular o valor da amortização 
    alert(vl_recebido_caixa_cred); 
    alert(vl_saldo_crediario); 
    if (vl_recebido_caixa_cred < vl_saldo_crediario){
        var vl_real_amortizacao = parseFloat(vl_recebido_caixa_cred); 
        alert("ENTROU"); 
    } else{
        var vl_real_amortizacao = parseFloat(vl_saldo_crediario); 
    }
    
    if (vl_troco_cred > 0){
        var vl_troco_cred = vl_troco_cred.toLocaleString("pt-BR");
    }

     if (vl_saldo_atual > 0){
        var vl_saldo_atual = vl_saldo_atual.toLocaleString("pt-BR");
    }
    
    jQuery('#vl_real_amortizacao').val(vl_real_amortizacao);
    jQuery('#vl_troco_cred').val(vl_troco_cred);
    jQuery('#vl_saldo_atual').val(vl_saldo_atual);


    if(vl_recebido_caixa_cred==0 | vl_troco_cred < 0) 
    {
        jQuery('#vl_troco_cred').val(0);
    }

    if(vl_saldo_atual <=0) 
    {
        jQuery('#vl_saldo_atual').val(0);
    }
*/
    
    var vl_saldo_crediario      = parseFloat(document.getElementById('vl_saldo_crediario').value, 10);
    var vl_recebido_caixa_cred  = parseFloat(document.getElementById('vl_recebido_caixa_cred').value, 10);
    
    var vl_troco_cred = (vl_recebido_caixa_cred - vl_saldo_crediario);

    var vl_saldo_atual = (vl_saldo_crediario - vl_recebido_caixa_cred )

    if (vl_recebido_caixa_cred < vl_saldo_crediario)
    {
        var vl_real_amortizacao =  vl_recebido_caixa_cred; 
    }
    else
    {
        var vl_real_amortizacao =  vl_saldo_crediario; 
    }

    if (vl_troco_cred > 0)
    {
        var vl_troco_cred = vl_troco_cred.toLocaleString("pt-BR");
    }

    if (vl_saldo_atual > 0)
    {
        var vl_saldo_atual = vl_saldo_atual.toLocaleString("pt-BR");
    }

    document.getElementById('vl_troco_cred').value = vl_troco_cred;
    document.getElementById('vl_saldo_atual').value = vl_saldo_atual; 
    document.getElementById('vl_real_amortizacao').value = vl_real_amortizacao; 

    if(vl_recebido_caixa_cred==0 | vl_troco_cred < 0) 
    {
        alert("OLA");
        document.getElementById('vl_troco_cred').value=0;
    }

    if(vl_saldo_atual <=0) 
    {
        document.getElementById('vl_saldo_atual').value=0; 
    }

  });
});

