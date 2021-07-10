
 <?php  
 
    echo form_open('id="form-calc" autocomplete="off"');

?>  

    <div class = "calculadora col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class= "form-group col-lg-8 col-md-8 col-sm-8 col-xs-12 input_calc">
            <input type="text-center" id="input_c" name="input_c" disabled>
        </div>
        <div class= "form-group col-lg-4 col-md-4 col-sm-4 col-xs-12 input_calc">
            <input type="text-center" id="input_resc" name="input_resc" value=0.00 disabled>
        </div>
        <div class ="col-lg-12 text-center">

            <div class="form-group col-lg-9 col-md-9 col-sm-9 col-xs-9 btn-number-calc btn-item">
                <button class="btn btn-default" id="btn_CE" name="btn_CE" type="button" onclick="limpa_OnClick()" > Limpar </button>
            </div>
            <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3 btn-number-calc btn-item">
                <button class="btn btn-default" id="btn_porc" name="btn_porc" type="button" onclick="display_OnClick('%')"> % </button>
            </div>


            <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3  btn-number-calc">
                <button class="btn btn-default" id="btn_7" name="btn_7" type="button" value="7" onclick="display_OnClick('7')"> 7 </button>
            </div>
            <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3 btn-number-calc">
                <button class="btn btn-default" id="btn_8" name="btn_8" type="button" value="8" onclick="display_OnClick('8')"> 8 </button>
            </div>
            <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3 btn-number-calc">
                <button class="btn btn-default" id="btn_9" name="btn_9" type="button" value="9" onclick="display_OnClick('9')"> 9 </button>
            </div>

            <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3 btn-number-calc btn-item">
                <button class="btn btn-default" id="btn_div" name="btn_div" type="button" value="÷" onclick="display_OnClick('÷')"> ÷ </button>
            </div>

            <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3 btn-number-calc">
                <button class="btn btn-default" id="btn_4" name="btn_4" type="button" value="4" onclick="display_OnClick('4')"> 4 </button>
            </div>

            <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3 btn-number-calc">
                <button class="btn btn-default" id="btn_5" name="btn_5" type="button" value="5" onclick="display_OnClick('5')"> 5 </button>
            </div>
            <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3 btn-number-calc">
                <button class="btn btn-default" id="btn_6" name="btn_6" type="button" value="6" onclick="display_OnClick('6')"> 6 </button>
            </div>

            <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3 btn-number-calc btn-item">
                <button class="btn btn-default" id="btn_mult" name="btn_mult" type="button" value="x" onclick="display_OnClick('x')"> x </button>
            </div>

            <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3 btn-number-calc">
                <button class="btn btn-default" id="btn_1" name="btn_1" type="button" value="1" onclick="display_OnClick('1')"> 1 </button>
            </div>
            <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3 btn-number-calc">
                <button class="btn btn-default" id="btn_2" name="btn_2" type="button" value="2" onclick="display_OnClick('2')"> 2 </button>
            </div>
            <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3 btn-number-calc">
                <button class="btn btn-default" id="btn_3" name="btn_3" type="button" value="3" onclick="display_OnClick('3') "> 3 </button>
            </div>
            <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3 btn-number-calc btn-item">
                <button class="btn btn-default" id="btn_sub" name="btn_sub" type="button" value="-" onclick="display_OnClick('-')"> - </button>
            </div>
          
            <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3 btn-number-calc">
                <button class="btn btn-default" id="btn_0" name="btn_0" type="button" value="0" onclick="display_OnClick('0') "> 0 </button>
            </div>

            <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3 btn-number-calc">
                <button class="btn btn-default" id="btn_ponto" name="btn_ponto" type="button" value="." onclick="display_OnClick('.')"> . </button>
            </div>

            <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3 btn-number-calc btn-item">
                <button class="btn btn-default" id="btn_som" name="btn_som" type="button" value="+" onclick="display_OnClick('+')"> + </button>
            </div>

            <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3 btn-number-calc btn-item">
                <button class="btn btn-default" id="btn_resultado" name="btn_resultado" type="button" value="=" onclick="display_OnClick('=')"> = </button>
            </div>

        </div>
        <!-- /.col-lg-12 -->
    </div>
<?php 
    // fechar o formulario 
    echo form_close();

?>

<script type="text/javascript">
 
    var display1="";  
    var totalizacao = 0; 
    var valor=[];
    var contador =0;
    var valorDaVez=0; 
    var valorTotal =0; 
    var ultimaOperacao="";
    var operacao = "";
    var lastValue =""; 
    var naoMostraOpe = false;
    var porCent = false; 


    function display_OnClick(value){

      
        if (value == "=" && lastValue=="=")
        {
            return; 
        }
        
        // mostrar no display 1 tudo que foi digitado 
        display1 = display1 + value; 
        $("#input_c").val(display1) ;

        if (value==1||value==2||value==3||value==4||value==5||value==6||value==7||value==8||value==9||value==0||value==".")
        {
            valorDaVez =  valorDaVez + value;
            return; 
        }
   
        if ((value=="+"|| value=="-"|| value=="x"|| value=="="|| value=="÷") && valorTotal==0)
        {
            valorTotal = parseFloat(valorDaVez);
        }

        if (lastValue == "+")
        {       
            if (value == "%")
            {
                valorTotal = parseFloat(valorTotal) + (parseFloat(valorTotal)/100) * parseFloat(valorDaVez);
            }
            else
            { 
                valorTotal = parseFloat(valorTotal) + parseFloat(valorDaVez);
            }
            
        }

        if (lastValue == "-")
        {     
            if (value == "%")
            {
                valorTotal = parseFloat(valorTotal) - (parseFloat(valorTotal)/100) * parseFloat(valorDaVez);
            }
            else
            {  
                valorTotal = parseFloat(valorTotal) - parseFloat(valorDaVez);
            }
        }

        if (lastValue == "x")
        {    
            if (value == "%")
            {
                valorTotal = parseFloat(valorTotal) * (parseFloat(valorTotal)/100) * parseFloat(valorDaVez);
            }
            else
            {   
                valorTotal = parseFloat(valorTotal) * parseFloat(valorDaVez);
            }
        }

        if (lastValue == "÷")
        {   
            if (value == "%")
            {
                valorTotal = parseFloat(valorTotal) / (parseFloat(valorTotal)/100) * parseFloat(valorDaVez);
            }
            else
            {    
                valorTotal = parseFloat(valorTotal) / parseFloat(valorDaVez);
            }
        }

        valorDaVez =0;
        lastValue = value; 
        valorTotalResc = parseFloat(valorTotal).toFixed(2);
        $("#input_resc").val(valorTotalResc);
        
    }

    function limpa_OnClick(){

        display1="";  
        totalizacao = 0; 
        valor=[];
        contador =0;
        valorDaVez=0; 
        valorTotal =0; 
        ultimaOperacao="";
        operacao = "";
        lastValue =""; 
        naoMostraOpe = false;
        porCent = false; 
        $("#input_resc").val(valorTotal);
        $("#input_c").val(display1) ;

    }

   

</script>


