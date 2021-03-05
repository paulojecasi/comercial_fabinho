jQuery(document).ready(function(){
  jQuery('input').on('keyup',function(){
    if(jQuery(this).attr('name') === 'result'){
    return false;
    }

    // VALOR DO TROCO 

    /* VALOR DESCONTO-ACRESCIMO DO PRODUTO */
    
    var vl_preco_uni = (jQuery('#vlpreco_alt').val() == '' ? 0 : jQuery('#vlpreco_alt').val());
   
    var quantidadeitens = (jQuery('#quantidadeitens_alt').val() == '' ? 0 : jQuery('#quantidadeitens_alt').val());
    
    if (quantidadeitens < 0){
        //alert("Quantidade de Itens NÃO pode ser MENOR que 01 (UM)!"); 
        //swal("ATENÇÃO! ","Quantidade de Itens NÃO pode ser MENOR que 01 (UM)!");
        var quantidadeitens =1
        jQuery('#quantidadeitens_alt').val(quantidadeitens);
    }

    var valordesconto= (jQuery('#valordesconto_alt').val() == '' ? 0 : jQuery('#valordesconto_alt').val());
    if (valordesconto < 0){
        swal({
          title: "ATENÇÃO !",
          text: "Valor de Desconto não pode ser MENOR que ZERO !",
          icon: "warning",
          buttons: true,
          dangerMode: false,
        })
        var valordesconto=0;  
        jQuery('#valordesconto_alt').val(valordesconto);
    }

    var valoracrescimo = (jQuery('#valoracrescimo_alt').val() == '' ? 0 : jQuery('#valoracrescimo_alt').val());
    if (valoracrescimo < 0){
        swal({
          title: "ATENÇÃO !",
          text: "Valor do Acrescimo não pode ser MENOR que ZERO !",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        var valoracrescimo=0;  
        jQuery('#valoracrescimo_alt').val(valoracrescimo);
    }


    valortotal = (parseFloat(vl_preco_uni) * parseFloat(quantidadeitens));

    valortotal = (parseFloat(valortotal) - parseFloat(valordesconto) + parseFloat(valoracrescimo));


    //valortotal = valortotal.toLocaleString("pt-BR");
    var valortotal= parseFloat(valortotal).toFixed(2);
    jQuery('#valortotal_alt').val(valortotal);  

  });
});