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
		}, 500) // 0,3 segundos 
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