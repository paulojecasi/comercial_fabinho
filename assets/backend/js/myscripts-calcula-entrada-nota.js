$(document).ready(function(){
  $('input').on('keyup',function(){
    if($(this).attr('name') === 'result'){
    return false;
    }


    //---------------------CALCULA VALOR DO TROCO NO PAGAMENTO A VISTA 

    var vl_unitario = ($('#vlunitario').val() == '' ? 0 : $('#vlunitario').val());
 
    var quantidade = ($('#quantidade').val() == '' ? 0 : $('#quantidade').val());

    /*
    if (vl_total > vl_recebido_caixa){
        swal("ATENÇÃO! "," Valor recebido não pode ser MENOR que o valor da Venda!"); 
        var valorrecebido=vl_total;  
        jQuery('#vl_recebido_caixa').val(valorrecebido);
    }
    */

    var vl_total = (parseFloat(vl_unitario) * parseFloat(quantidade));
   
    //var vl_total = vl_total.toLocaleString("pt-BR");
    var vl_total = parseFloat(vl_total).toFixed(2); 
    
    $('#vltotal').val(vl_total);



  });
});