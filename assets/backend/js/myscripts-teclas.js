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

$(".btn_buscar_item_venda").focus(function(){
        
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

// TEMPLATE CADASTRO DE PRODUTOS 
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


var pressedShift = false;


document.onkeyup=function(c){
    if(c.which == 16)
        pressedShif =false;
}
document.onkeydown=function(c){
    if(c.which == 16){
        pressedShif = true;
    }

    // SHIFT + F1
    if(c.which == 112 && pressedShif == true) {
        document.getElementById("quantidade").select();
    }

    // SHIFT + F2 
    if(c.which == 113 && pressedShif == true) {
        $('.btn_click_shift_f2').click();
    }

    // SHIFT + F4 
    if(c.which == 115 && pressedShif == true) {
        $('.btn_click_shift_f4').click();
    }

    // SHIFT + A
    if(c.which == 65 && pressedShif == true) {
        $("a.btn_click_shift_a")[0].click();
    }

    // SHIFT + B
    if(c.which == 66 && pressedShif == true) {
        $('.btn_click_shift_b').click();
    }

     // SHIFT + C
    if(c.which == 67 && pressedShif == true) {
        $('.btn_click_shift_c').click();
    }

     // SHIFT + D
    if(c.which == 68 && pressedShif == true) {
        $("a.btn_click_shift_d")[0].click();
    }

    // SHIFT + F
    if(c.which == 66 && pressedShif == true) {
        $('.btn_click_shift_f').click();
    }

    // SHIFT + P
    if(c.which == 80 && pressedShif == true) {
        $("a.btn_click_shift_p")[0].click();
    }

    // SHIFT + E
    if(c.which == 69 && pressedShif == true) {
        $("a.btn_click_shift_e")[0].click();
    }

    // SHIFT + T
    if(c.which == 84 && pressedShif == true) {
        $("a.btn_click_shift_t")[0].click();
    }


    // SHIFT + M
    if(c.which == 77 && pressedShif == true) {
        $("a.btn_click_shift_m")[0].click();
    }

    // SHIFT + R
    if(c.which == 82 && pressedShif == true) {
        $("a.btn_click_shift_r")[0].click();
    }

    // SHIFT + U
    if(c.which == 85 && pressedShif == true) {
        $("a.btn_click_shift_u")[0].click();
    }

    // SHIFT + V
    if(c.which == 86 && pressedShif == true) {
        $("a.btn_click_shift_v")[0].click();
    }

    // SHIFT + 1
    if(c.which == 49 && pressedShif == true) {
        $("a.btn_click_shift_1")[0].click();
    }

    // SHIFT + 2
    if(c.which == 50 && pressedShif == true) {
        $("a.btn_click_shift_2")[0].click();
    }

    // SHIFT + 3
    if(c.which == 51 && pressedShif == true) {
        $("a.btn_click_shift_3")[0].click();
    }

    // SHIFT + 4
    if(c.which == 52 && pressedShif == true) {
        $("a.btn_click_shift_4")[0].click();
    }

    // SHIFT + 5
    if(c.which == 53 && pressedShif == true) {
        $("a.btn_click_shift_5")[0].click();
    }

    // SHIFT + 6
    if(c.which == 54 && pressedShif == true) {
        $("a.btn_click_shift_6")[0].click();
    }


}
        
     
 





