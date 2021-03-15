
<div class="col-lg-12 text-center mensagem-sistema">
    <?php
        // vai alertar !!
        $mensagem = $this->load->view('frontend/template/mensagem-alert');

        // vai ficar no rodapé 
    ?> 
    
        <b id="av1"> Ultimo aviso do Sistema : </b>
        <b id="av2"> <?php echo $this->session->userdata('ultimoAviso')  ?> </b>

</div>
        