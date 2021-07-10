
<table width="615" border="0" cellspacing="0" cellpadding="3" vspace="0" hspace="0" height="10" align="center">
   <FORM method=POST id=form1 name=form1 action="acordo_credor_frame.asp" target=frame01 onsubmit="return Form1_OnSubmit();">
    <tr> 




 <SCRIPT LANGUAGE="javascript">
function txtContrato_OnFocus(){
	parent.frames['frame01'].location.href = "_blank.htm";
	document.form1.txtContrato.select();
}

function txtDataAcordo_OnFocus(){
	parent.frames['frame01'].location.href = "_blank.htm";
	document.form1.txtDataAcordo.select();
}

function Form1_OnSubmit(){
	
	da = document.form1.txtDataAcordo.value
	var QtdDiasFuturos = "<%= QtdDiasFuturos%>"

	//pega a data atual					
		hoje = new Date();
		dia = hoje.getDate()
		diasDiff = 0;
		semanasDiff  = 0;
		ano = hoje.getFullYear();
		
		if(dia < 10) //se o dia for menor que 10 adiciona um 0 ao dia
			dia = "0" + dia;
		
		mes = (hoje.getMonth() + 1)
		
		if(mes < 10) //se o mes for menor que 10 adiciona um 0 ao mes
			mes = "0" + mes; 
		
		dataHj = dia+ '/' + mes + '/' + ano; //monta a data formatada
	if ((QtdDiasFuturos != "") && (DifDatasDias(da, dataHj) > QtdDiasFuturos)) {
	    alert('Data do acordo futura não pode ser superior a ' + QtdDiasFuturos + ' dias.');
		return false;
	} else if(document.form1.txtContrato.value == ""){
		alert("É necessário informar o Contrato!");
		document.form1.txtContrato.focus();
		return false;
	} else if(document.form1.txtDataAcordo.value == ""){
		alert("É necessário informar a data do acordo!");
		document.form1.txtDataAcordo.focus();
		return false;
	} else{
		 if(!IsDate(document.form1.txtDataAcordo.value)){
			alert("Data do acordo Inválida!");
			document.form1.txtDataAcordo.focus();
			return false;
		}	
	}
	if(Len(document.form1.txtDataAcordo.value) != 10){
		alert("A Data deve ser informada no formato: DD/MM/AAAA");
		document.form1.txtDataInicial.value = "DD/MM/AAAA";
		document.form1.txtDataInicial.select();
		return false;
	}else if(!IsDate(document.form1.txtDataAcordo.value)){
		alert("Data informada inválida");
		document.form1.txtDataInicial.value = "DD/MM/AAAA";
		document.form1.txtDataInicial.select();
		return false;
	}else{ 
		if (da.substr(6,10) >= 2080){
			alert("Ano inválido")
			return false;
			}
	}
}

</SCRIPT>

<input type="radio" onclick="AlteraLabel(this);" name="rdCtraConta" id="RdContrato" value="Contrato" checked="checked"/>Contrato&nbsp&nbsp&nbsp

 <script language="javascript">

        function btIncluir_OnClick() {
            document.form1.cbCarteira.value = "0";
            document.form1.cbContratante.value = "0";
            document.form1.hdOp.value = ""
            document.form1.submit();
        }

        function btAlterar_OnClick() {
            if (document.form1.cbContratante.value == 0) {
                alert("Selecione a Empresa que deseja excluir");
                parent.frame01.location.href = "_blank.htm";
                document.form1.cbContratante.focus();
                return false;
            }else if (document.form1.cbCarteira.value == 0) {
                alert("Selecione a Carteira que deseja alterar");
                parent.frame01.location.href = "_blank.htm";
                document.form1.cbCarteira.focus();
                return false;
            }
            document.form1.hdOp.value = "Alt";
            document.form1.submit();
        }



            <input type="button" id="btIncluir" value="Inclui" class="texto1" onclick="btIncluir_OnClick();">
                    <input type="button" id="btAlterar" value="Altera" class="texto1" onclick="btAlterar_OnClick();">
                    <input type="button" id="btExcluir" value="Exclui" class="texto1" onclick="btExcluir_OnClick();">
                    <input type="button" id="btCopiar"  value="Copiar Definições" class="texto1" onclick="btCopiar_OnClick();">