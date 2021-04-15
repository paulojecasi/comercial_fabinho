// para que o cursor vá para o proximo campo definido no INPUT - PJCS 
function EnterTab(InputId,Evento){

    if(Evento.keyCode == 13){       

        document.getElementById(InputId).focus();

    }

}

// quando passar o leitor, daremos um pequeno delay para que o produto possa ser carregado
// e em seguida um ENTER é acionado automaticamente - PJCS 
$(".btn_buscar").focus(function(){
		
		var teclarEnter = function() {	
				$('.btn_buscar').click();
		} 
		setTimeout(function() {
    	teclarEnter();
		}, 1000) // 1 segundo 
});	

$("#btn_buscar_item").focus(function(){
        
        var teclarEnter = function() {  
                $('#btn_buscar_item').click();
        } 
        setTimeout(function() {
        teclarEnter();
        }, 1000)  
});

$("#btn_consulta_est").focus(function(){
        
        var teclarEnter = function() {  
                $('#btn_consulta_est').click();
        } 
        setTimeout(function() {
        teclarEnter();
        }, 1000) 
});


// nao permite que o botao SUBMIT "CADASTRAR" seja acionado ao teclar <ENTER> 
$("#form-add-cliente").bind("keypress", function (e) {
    if (e.keyCode == 13) {
        $("#btn-add-cliente").attr('value');
        //add more buttons here
        return false;
    }
}); 

// nao permite que o botao SUBMIT "APLICAR ALTERAÇÕES" seja acionado ao teclar <ENTER> 
$("#form-alt-cliente").bind("keypress", function (e) {
    if (e.keyCode == 13) {
        $("#btn-alt-cliente").attr('value');
        //add more buttons here
        return false;
    }
});

$("#form-alt-produto-temp").bind("keypress", function (e) {
    if (e.keyCode == 13) {
        $("#btn-alt-produto_temp").attr('value');
        //add more buttons here
        return false;
    }
});

$("#form-pag-money").bind("keypress", function (e) {
    if (e.keyCode == 13) {
        $("#btn-concluir-pgto").attr('value');
        //add more buttons here
        return false;
    }
});

$("#form-pagamento-cred").bind("keypress", function (e) {
    if (e.keyCode == 13) {
        $("#btn-pagamento-cred").attr('value');
        //add more buttons here
        return false;
    }
});

// na entrada de podutos no estoque
$("#form-add-item-estoque").bind("keypress", function (e) {
    $('#vltotal').prop('readonly', true);
    if (e.keyCode == 13) {
        $("#btn-add-item-estoque").attr('value');
        //add more buttons here
        return false;
    }
});

$("#form-cadastro-produto").bind("keypress", function (e) {
    if (e.keyCode == 13) {
        $("#btn-add-produto").attr('value');
        //add more buttons here
        return false;
    }
});

$("#form-altera-produto").bind("keypress", function (e) {
    if (e.keyCode == 13) {
        $("#button-altera-produto").attr('value');
        //add more buttons here
        return false;
    }
});


$("#form-retirada-valor").bind("keypress", function (e) {
    if (e.keyCode == 13) {
        $("#button-altera-produto").attr('value');
        return false;
    }
});

$("#form-fechamento-caixa").bind("keypress", function (e) {
    if (e.keyCode == 13) {
        $("#btn-add-fecha-cx").attr('value');
        return false;
    }
});



