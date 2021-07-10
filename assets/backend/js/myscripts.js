
/*
var piscando = document.getElementById('pisca');
var interval = window.setInterval(function(){
    if(piscando.style.visibility == 'hidden'){
        piscando.style.visibility = 'visible';
    }else{
        piscando.style.visibility = 'hidden';
    }
}, 1000);
*/

if ($('#form-entrada-nota-est').val() ==10) {
// checkbox para gerar nota automatica 

  $(document).ready(function(){
  	var nr_nota_auto = ($('#nrnota_aut').val() == '' ? 0 : $('#nrnota_aut').val());
  	var nr_nota_auto = parseInt(nr_nota_auto); 
  	$('#check-sem-nota').click(function() {
      if ($(this).is(':checked')) {
        $('#nrnota').val(nr_nota_auto +1); 
        $('#serie').val("SIS");
        $('#emitente').val("SISTEMA");
        $('#nrnota').prop('readonly', true);
        $('#serie').prop('readonly', true);
        $('#emitente').prop('readonly', true);
        document.getElementById("valornota").select();
      }
      if (!$(this).is(':checked')) {
        $('#nrnota').val("");
        $('#serie').val("");
        $('#emitente').val("");
        $('#nrnota').prop('readonly', false);
        $('#serie').prop('readonly', false);
        $('#emitente').prop('readonly', false);
        document.getElementById("nrnota").select();

      }
    });


  });
}

if ($('#form-cadastro-produt').val() ==10) {
  // TELA CADASTRO DE PRODUTOS

  $('#vlpreco').keyup(function(){
    var vl_preco_uni = ($('#vlpreco').val() == '' ? 0 : $('#vlpreco').val());
    var vl_preco_uni = parseFloat(vl_preco_uni).toFixed(2);
    $('#vlprecoatacado').val(vl_preco_uni);

  }); 
}


// links selecionados 
for (var i = 0; i < document.links.length; i++) {
    if (document.links[i].href == document.URL) {
        document.links[i].className = 'linkAtivo';
    }
}
  
  /*
if ($('#form-acesso-gera').val() ==1) {
  $(document).ready(function(){
  //alert("HAHA"); 
    base_url = $('.base_url').val()
    //alert(base_url); 
    var w = 200;
          var h = 200;
          var left = Number((screen.width/2)-(w/2));
          var tops = Number((screen.height/2)-(h/2));

    window.close()
    if ($('#acesso').val() != 1){
      $('#acesso').val(1)
      return window.open(base_url + 'admin/empresa/login_empresa', '', 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no');
     //return window.open(url,'','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no');
    }

  });

} 


if ($('#form-caixa-rels').val() ==11) {
  function OpenWindow() { //v2.0
    var theURL = $('.base-url').val() + 'admin/caixa/rel_caixa_fecha';

    return window.open(theURL, 
    "toolbar=no,width=660,height=430,top=40,left=40,location=no,toolbar=no,menubar=no,directories=no,status=no,scrollbars=yes,resizable=no,copyhistory=no");

  }
} 

*/


// tela opcoes de relatorios 
if ($('.form-caixa-rel').val() ==11) {

  $('#datainicial_fecha').prop('readonly', true);
  $('#datafinal_fecha').prop('readonly', true);

}










 










