
    </div> 
</container> 

<div class="col-lg-12 footer-bottom-area">
    <div class="row">
        <div class="logo-marca-pss text-center col-lg-3 col-sm-12">
            <h3> 
                 <img  src="<?php echo base_url('/assets/frontend/img/_PS_Solucoes2.png') ?>" height="30" width="190" >
            </h3>
        </div>

        <div class="col-lg-9 text-center mensagem-sistema">
            <?php
                // vai alertar !!
                $mensagem = $this->load->view('frontend/template/mensagem-alert');

                // vai ficar no rodapé 
            ?> 
            <div class=" col-lg-11 alert alert-warning" role="alert" id="mensagem_rodape">
                <a class ="btn btn-info" id="av3" type="button" onclick="calculator_OnClick()"><i class="fa fa-calculator" aria-hidden="true"></i> Calculadora </a> &nbsp &nbsp &nbsp &nbsp
                <b id="av1"> Ultimo aviso do Sistema : </b>
                <b id="av2"> <?php echo $this->session->userdata('ultimoAviso')  ?> </b>
            </div>

            <input type="hidden" class="base_url" value="<?php echo base_url() ?>">

        </div>
    </div>
</div> <!-- End footer bottom area --> 

<script type="text/javascript">

    function calculator_OnClick()
    { 
        base_url = $('.base_url').val()
     
        window.close()
        return window.open(base_url + 'calculadora', '', 'toolbar=no,width=400,height=440,top=80,left=300,location=no,toolbar=no,menubar=no,directories=no,status=no,scrollbars=yes,resizable=no,copyhistory=no');
         //return window.open(url,'','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no');
      
    }
  
</script>
   


