
    </div> 
</container> 

<div class="footer-bottom-area">
        <div class="row">
            <div class="col-lg-3 text-center cactosdev">
                <p class="des-por"> Desenvolvido por </p>
                <h3> <img class="img-fluid cacto" src=" <?php echo base_url('assets/frontend/img/cactosdev.png'); ?>"> Cactos Dev </h3>
                <p> <img class="img-fluid email" src=" <?php echo base_url('assets/frontend/img/email.png'); ?>"> cactosdev@gmail.com 
                <img class="img-fluid whats" src=" <?php echo base_url('assets/frontend/img/whats.png'); ?>"> (86) 99973 3764  </p>
            </div>

            <div class="col-lg-9 text-center mensagem-sistema">
            	<h4>
                    <?php
                        $this->load->view('frontend/template/mensagem-alert');
                    ?> 
                </h4>
            </div>
        </div>
</div> <!-- End footer bottom area --> 
   


