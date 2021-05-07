$(document).ready(function(){

    $("#btn-pagamento-cred").css("display","none");

  $('input').on('keyup',function(){

    if ($(this).attr('name') === 'result'){

        return false;

    }
    var vl_recebido_caixa_cred = ($('#vl_recebido_caixa_cred').val() == '' ? 0 :
                                 $('#vl_recebido_caixa_cred').val());
    var vl_juros_caixa_cred = ($('#vl_juros_caixa_cred').val() == '' ? 0 :
                                $('#vl_juros_caixa_cred').val());
    var vl_desconto_caixa_cred = ($('#vl_desconto_caixa_cred').val() == '' ? 0 : 
                                $('#vl_desconto_caixa_cred').val());
    var vl_saldo_crediario = (  $('#vl_saldo_crediario_sc').val() == '' ? 0 : 
                                $('#vl_saldo_crediario_sc').val());

    var idpagamento = ( $('#idpagamento').val() == '' ? 0 : 
                        $('#idpagamento').val());
    
    var vl_pg_crediario = 0; 

    var qt_vendas =1; 
    while (qt_vendas <=50)
    { 
        var pagvendas = ("pag_"+qt_vendas);
        
        pagvendas = ($('#'+pagvendas).val() == '' ? 0 : 
                    $('#'+pagvendas).val());
       
        if (pagvendas==null || !pagvendas){
            break; 
        }

        vl_pg_crediario = (vl_pg_crediario+ parseFloat(pagvendas));

        qt_vendas++; 
  
    }

    var vl_troco_cred = (   parseFloat(vl_recebido_caixa_cred)  - 
                            parseFloat(vl_pg_crediario) -
                            parseFloat(vl_juros_caixa_cred)     + 
                            parseFloat(vl_desconto_caixa_cred)); 
 

    var vl_total_pag_cred = (   parseFloat(vl_pg_crediario) + 
                                parseFloat(vl_juros_caixa_cred)     - 
                                parseFloat(vl_desconto_caixa_cred));

    if(vl_recebido_caixa_cred==0 | vl_troco_cred < 0) 
    {
        var vl_troco_cred =0;
    }
 
    if(vl_saldo_atual <=0) 
    {
        var vl_saldo_atual=0;
    }
   
    vl_troco_cred = parseFloat(vl_troco_cred).toFixed(2);
    vl_pg_crediario = parseFloat(vl_pg_crediario).toFixed(2); 
    vl_total_pag_cred = parseFloat(vl_total_pag_cred).toFixed(2); 
    vl_total_pag_cred = 
        vl_total_pag_cred.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});

  
    if (parseFloat(vl_recebido_caixa_cred) < parseFloat(vl_pg_crediario))
    {     
        $("#btn-pagamento-cred").css("display","none"); 
    }
    else
    {
        $("#btn-pagamento-cred").css("display","inline");
    }

    /*
    if ((parseFloat(idpagamento) == 5))
    {
         $('#vl_recebido_caixa_cred').prop('readonly', true);
         
    } 
    else
    {
          $('#vl_recebido_caixa_cred').prop('readonly', false);
    }
    */

    $('#vl_pg_crediario').val(vl_pg_crediario);
    $('#vl_troco_cred').val(vl_troco_cred);
    $('#vl_total_pag_cred').val(vl_total_pag_cred); 

  });
});

$("#btn-pagamento-cred").hover(function(){
    var idpagamento = ( $('#idpagamento').val() == '' ? 0 : 
                        $('#idpagamento').val());

    var vl_recebido_caixa_cred = ($('#vl_recebido_caixa_cred').val() == '' ? 0 :
                                 $('#vl_recebido_caixa_cred').val());

     if (parseFloat(idpagamento) == 5 && parseFloat(vl_recebido_caixa_cred) > 0)
     {
        alert("Informe tipo de pagamento");  
        //document.getElementById("vl_recebido_caixa_cred").select();
        $("#idpagamento").focus()
        $("#idpagamento").css("background-color","red");
     }
}); 

