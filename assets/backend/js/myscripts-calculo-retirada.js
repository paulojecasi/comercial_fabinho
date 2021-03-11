jQuery(document).ready(function(){
  jQuery('input').on('keyup',function(){
    if(jQuery(this).attr('name') === 'result'){
    return false;
    }


    //---------------------CALCULA VALOR DO TROCO NO PAGAMENTO A VISTA 

    var vl_retirada_disponivel = (jQuery('#vl_retirada_disponivel').val() == '' ? 0 : jQuery('#vl_retirada_disponivel').val());
 
    var vl_retirada_caixa = (jQuery('#vl_retirada_caixa').val() == '' ? 0 : jQuery('#vl_retirada_caixa').val());

    var vl_saldo = (parseFloat(vl_retirada_disponivel) - parseFloat(vl_retirada_caixa));
    
    var vl_saldo = parseFloat(vl_saldo).toFixed(2); 
    
    jQuery('#vl_saldo_caixa_ret').val(vl_saldo);

    if(parseFloat(vl_retirada_caixa) > parseFloat(vl_retirada_disponivel))
    {
        swal({
          title: "ATENÇÃO !",
          text: "Valor da RETIRADA não pode ser MAIOR que o Saldo do Caixa !",
          icon: "warning",
          buttons: true,
          dangerMode: false,
        })

        var vl_retirada_disponivel = parseFloat(vl_retirada_disponivel).toFixed(2); 
        jQuery('#vl_retirada_caixa').val(null);
        jQuery('#vl_saldo_caixa_ret').val(vl_retirada_disponivel);
    }

    if(parseFloat(vl_retirada_caixa) <= 0)
    {
        swal({
          title: "ATENÇÃO !",
          text: "Valor da RETIRADA não pode ser menor ou igual a ZERO",
          icon: "warning",
          buttons: true,
          dangerMode: false,
        })

        var vl_retirada_disponivel = parseFloat(vl_retirada_disponivel).toFixed(2); 
        jQuery('#vl_retirada_caixa').val(null);
        jQuery('#vl_saldo_caixa_ret').val(vl_retirada_disponivel);
    }

  });
});

