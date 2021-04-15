
      <div class = "container"> 
        <div class = "row header-titulo">
        
        	<div class="logo-marca text-center col-lg-2 col-sm-2">
                <h3> 
                    M F
                </h3>
          </div>
          <div class="logo-titulo text-center col-lg-7 col-sm-7">
              <h1 class = "desc-titulo"> 
                  Sistema de Vendas
              </h1>
          </div>


          <section id="usuario-sistema">         
            <div class="usuario-caixa col-lg-2 col-sm-2">
                <h4 class = "desc-operador text-center"> 
                    Operador 
                </h4>

                <h4 class = "desc-operador2 text-center">
                	<?php echo $this->session->userdata('userLogado')->nome;?>
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
          </section>
          
          <div class="logo-marca text-center col-lg-11">
                <?php 
                  $this->load->view('frontend/template/sidebar');
                ?>
          </div>

        </div> 
       
      
 

   