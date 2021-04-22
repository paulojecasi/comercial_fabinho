$(document).ready(function(){
  $('input').on('keyup',function(){
    if($(this).attr('name') === 'result'){
    return false;
    }


    //---------------------CALCULA VALOR DO TROCO NO PAGAMENTO A VISTA 

    var vl_unitario = ($('#vlunitario').val() == '' ? 0 : $('#vlunitario').val());
 
    var quantidade = ($('#quantidade').val() == '' ? 0 : $('#quantidade').val());

    var vl_venda_atual_perc_est = ($('#vl_venda_atual_perc_est').val() == '' ? 0 : $('#vl_venda_atual_perc_est').val());

    var vl_atacado_atual_perc_est = ($('#vl_atacado_atual_perc_est').val() == '' ? 0 : $('#vl_atacado_atual_perc_est').val());


    var vl_venda_atual = (vl_unitario/100 * vl_venda_atual_perc_est)+ parseFloat(vl_unitario); 

    var vl_atacado_atual = (vl_unitario/100 * vl_atacado_atual_perc_est)+ parseFloat(vl_unitario);

    var vl_total = (parseFloat(vl_unitario) * parseFloat(quantidade));
   
    //var vl_total = vl_total.toLocaleString("pt-BR");
    var vl_total = parseFloat(vl_total).toFixed(2); 

    var vl_venda_atual = parseFloat(vl_venda_atual).toFixed(2);

    var vl_atacado_atual = parseFloat(vl_atacado_atual).toFixed(2);  
    
    $('#vltotal').val(vl_total);
    if (vl_venda_atual_perc_est > 0){
        $('#vl_venda_atual_est').val(vl_venda_atual);
    } 
    if (vl_atacado_atual_perc_est > 0){
        $('#vl_atacado_atual_est').val(vl_atacado_atual);
    } 



  });
});