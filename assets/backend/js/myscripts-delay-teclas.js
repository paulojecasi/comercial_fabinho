
// quando passar o leitor, daremos um pequeno delay para que o produto possa ser carregado
$(".btn_buscar").focus(function(){
		
		var teclarEnter = function() {	
				$('.btn_buscar').click();
		} 
		setTimeout(function() {
    	teclarEnter();
		}, 500) // 0,3 segundos 
});	