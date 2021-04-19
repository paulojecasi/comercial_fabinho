
    </div> 
</container> 

<div class="col-lg-12 footer-bottom-area">
    <div class="row">
        <div class="col-lg-3 text-center cactosdev">
            <p class="des-por"> Desenvolvido por </p>
            <h3> <img class="img-fluid cacto" src=" <?php echo base_url('assets/frontend/img/cactosdev.png'); ?>"> Cactos Dev </h3>
            <p> <img class="img-fluid email" src=" <?php echo base_url('assets/frontend/img/email.png'); ?>"> cactosdev@gmail.com 
            <img class="img-fluid whats" src=" <?php echo base_url('assets/frontend/img/whats.png'); ?>"> (86) 99973 3764  </p>
        </div>

        <div class="col-lg-9 text-center mensagem-sistema">
            <?php
                // vai alertar !!
                $mensagem = $this->load->view('frontend/template/mensagem-alert');

                // vai ficar no rodapé 
            ?> 
            <div class=" col-lg-11 alert alert-warning" role="alert" id="mensagem_rodape">
                <b id="av1"> Ultimo aviso do Sistema : </b>
                <b id="av2"> <?php echo $this->session->userdata('ultimoAviso')  ?> </b>
            </div>

        </div>
    </div>
</div> <!-- End footer bottom area --> 
   


