
<?php 
// BLOCO DE MENSAGENS 

// somente vai carregar a ultima mensagem, geralmente usado nas chamadas JQUERY
if (!is_null($this->session->userdata('mensagemjq'))):
 
  $mens =  $this->session->userdata('mensagemjq');  
  $this->session->set_userdata('ultimoAviso',$mens); 
  $this->session->unset_userdata('mensagemjq'); 
endif;

// vai demonstrar no formulario a mensagem 
if (!is_null($this->session->userdata('mensagem'))):
 
  $mens =  $this->session->userdata('mensagem');  
  $this->session->set_userdata('ultimoAviso',$mens); 
  /*
  ?>
	<div class="text-center mensagem">  
    <div class="alert alert-success" role="alert">
        <b> 
            <?php */ /*
              $mens; 
            ?>
        </b>
    </div>
  </div>
    <?php  */
    // encerrar a secao
    $this->session->unset_userdata('mensagem'); 
endif;

// vamos exibir um ALERTA 
if (!is_null($this->session->userdata('mensagemErro'))):  
    $mens = $this->session->userdata('mensagemErro');
    // gravar a ultima mensagem, para fica no rodapé
    $this->session->set_userdata('ultimoAviso',$mens); 
     
  echo '<script>

       
    alert("'.$mens.'"); 


  </script>'; 


  $this->session->unset_userdata('mensagemErro'); 
endif;

if (!is_null($this->session->userdata('mensagemAlert'))):  
    $mens = $this->session->userdata('mensagemAlert');
    $this->session->set_userdata('ultimoAviso',$mens); 
    $this->session->unset_userdata('mensagemAlert'); 

    echo '
    <script>
      alert("'.$mens.'"); 
    </script>';
  

endif;

?>


 


