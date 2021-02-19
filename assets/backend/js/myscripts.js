$(document).ready(function(){
	$('#mtabela').DataTable({
		"language": {
			"lengthMenu": "Mostrando _MENU_  registro por página",
			"zeroRecords": "Nada encontrado",
			"info": "Mostrando página _PAGE_ de _PAGES_",
			"infoEmpty": "Nenhum registro disponível",
			"infoFiltered": "(Filtrado _MAX_ registros no total)"
		}
	});
});

/*
function calcular() {
  var valor1 = parseInt(document.getElementById('vl_total').value, 10);
  var valor2 = parseInt(document.getElementById('vl_recebido').value, 10);
  document.getElementById('vl_troco').value = valor2 - valor1;
}
*/









