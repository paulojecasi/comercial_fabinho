
      <div class = "container"> 
        <div class = "row header-titulo">
          <div class="logo-marca text-center col-lg-1 col-md-1 col-sm-1">
              <?php 
                $this->load->view('frontend/template/sidebar');
              ?>
          </div>
        	<div class="logo-marca text-center col-lg-3 col-sm-3">
                <h3> 
                    Comercial Fabinho
                </h3>
          </div>
          <div class="logo-titulo text-center col-lg-5 col-sm-5">
              <h1 class = "desc-titulo"> 
                  Sistema de Vendas
              </h1>
          </div>

        
          <div class="usuario-caixa col-lg-2 col-sm-2">
              <h4 class = "desc-operador text-center"> 
                  Operador 
              </h4>

              <h4 class = "desc-operador2 text-center">
              	<?php echo $this->session->userdata('userLogado')->nome;?>
            	</h4>

              <h4 class = "desc-operador3 text-center">
                <a  href=" <?php echo base_url('admin/usuarios/logout') ?>">
                          <i class="fa fa-sign-out fa-fw"></i>
                           Sair do Sistema
                </a>
              </h4>
          </div>     

          <div class="usuario-caixa-foto col-lg-1 col-sm-1">
            <?php

              $semFoto = "assets/frontend/img/usuarios/sem_foto.jpg";

              if ($this->session->userdata('userLogado')->img !=''){
                  echo img($this->session->userdata('userLogado')->img) ;
              }else{
                  echo img($semFoto); 
              }
            ?>
        
          </div>
     
        </div> 
 

   