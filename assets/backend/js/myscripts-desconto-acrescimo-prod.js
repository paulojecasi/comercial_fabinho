jQuery(document).ready(function(){
  jQuery('input').on('keyup',function(){
    if(jQuery(this).attr('name') === 'result'){
    return false;
    }

    // VALOR DO TROCO 

    /* VALOR DESCONTO-ACRESCIMO DO PRODUTO */
    
    $('#vlpreco_alt').mask('0000.00', {reverse: true});
    
    var vl_preco_uni = (jQuery('#vlpreco_alt').val() == '' ? 0 : jQuery('#vlpreco_alt').val());
   
    var vl_preco_ata = (jQuery('#vlpreco_ata').val() == '' ? 0 : jQuery('#vlpreco_ata').val());
   
    var vl_preco_var = (jQuery('#vlpreco_var').val() == '' ? 0 : jQuery('#vlpreco_var').val());
   

    var quantidadeitens = (jQuery('#quantidadeitens_alt').val() == '' ? 0 : jQuery('#quantidadeitens_alt').val());
    
    var quantidadeitens_ata = (jQuery('#quantidadeitens_ata').val() == '' ? 0 : jQuery('#quantidadeitens_ata').val());
    
    var qt_da_venda =  ($('#quantidade_da_venda').val() == '' ? 0 : $('#quantidade_da_venda').val());

    var qt_saldo_item = ($('#saldo_atual_prod').val() == '' ? 0 : $('#saldo_atual_prod').val());

    if (quantidadeitens < 0){
        //alert("Quantidade de Itens NÃO pode ser MENOR que 01 (UM)!"); 
        //swal("ATENÇÃO! ","Quantidade de Itens NÃO pode ser MENOR que 01 (UM)!");
        var quantidadeitens =1
        jQuery('#quantidadeitens_alt').val(quantidadeitens);
    }

    var valordesconto= (jQuery('#valordesconto_alt').val() == '' ? 0 : jQuery('#valordesconto_alt').val());
    if (valordesconto < 0){
        alert("ATENÇÃO - Valor de Desconto não pode ser MENOR que ZERO !")
   
        var valordesconto=0;  
        jQuery('#valordesconto_alt').val(valordesconto);
    }

    var valoracrescimo = (jQuery('#valoracrescimo_alt').val() == '' ? 0 : jQuery('#valoracrescimo_alt').val());
    if (valoracrescimo < 0){
        alert("ATENÇÃO - Valor do Acrescimo não pode ser MENOR que ZERO !")
        var valoracrescimo=0;  
        jQuery('#valoracrescimo_alt').val(valoracrescimo);
    }

    var qt_saida =  (parseFloat(quantidadeitens) + parseFloat(qt_da_venda));
    qt_saldo_item = parseFloat(qt_saldo_item); 
    if (qt_saida > qt_saldo_item){
        alert("ATENCÃO - Produto não tem SALDO suficiente. Verifique o Estoque!")
        var quantidadeitens = (qt_saida - qt_saldo_item ); 

        if (quantidadeitens < 0)
        {
            quantidadeitens =1; 
        }
        jQuery('#quantidadeitens_alt').val(quantidadeitens);
    }
    
    valortotal = (quantidadeitens < quantidadeitens_ata) ? 
            (parseFloat(vl_preco_uni).toFixed(2) * parseFloat(quantidadeitens).toFixed(2)): 
            (parseFloat(vl_preco_ata).toFixed(2) * parseFloat(quantidadeitens).toFixed(2));

    var vlpreco_unit = (quantidadeitens < quantidadeitens_ata) ?
            parseFloat(vl_preco_var) : parseFloat(vl_preco_ata) ;  

    valortotal = (parseFloat(valortotal) 
                - parseFloat(valordesconto) 
                + parseFloat(valoracrescimo));

    //valortotal = valortotal.toLocaleString("pt-BR");
    var valortotal= parseFloat(valortotal).toFixed(2);
    var vlpreco_unit= parseFloat(vlpreco_unit).toFixed(2);
    $('#valortotal_alt').val(valortotal);  
    $('#vlpreco_alt').val(vlpreco_unit);

  });
});