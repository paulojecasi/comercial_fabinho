
	<div class="text-center text-uppercase">  
			<?php 
      // BLOCO DE MENSAGENS 
      if (!is_null($this->session->userdata('mensagem'))) 
      { 
      ?>
          <div class="alert alert-success" role="alert">
              <b> 
                  <?php
                   echo $this->session->userdata('mensagem'); 
                  ?>
              </b>
          </div>
          <?php 
          // encerrar a secao
          $this->session->unset_userdata('mensagem'); 
      }
      ?> 

      <?php
      if (!is_null($this->session->userdata('mensagemErro'))) 
      { 
      ?>
          <div class="alert alert-warning" role="alert">
              <b> 
                  <?php
                   echo $this->session->userdata('mensagemErro'); 
                  ?>
              </b>
          </div>
          <?php 
          // encerrar a secao
          $this->session->unset_userdata('mensagemErro'); 
      }
      ?>
 
  </div>
