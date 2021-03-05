
<?php 
// BLOCO DE MENSAGENS 
if (!is_null($this->session->userdata('mensagem'))):
 
  $mens =  $this->session->userdata('mensagem'); 
  $this->session->set_userdata('ultimoAviso',$mens); 
	?>
	<div class="text-center mensagem">  
    <div class="alert alert-success" role="alert">
        <b> 
            <?php
              $mens; 
            ?>
        </b>
    </div>
  </div>
    <?php 
    // encerrar a secao
    $this->session->unset_userdata('mensagem'); 
endif;

if (!is_null($this->session->userdata('mensagemErro'))):  
    $mens = $this->session->userdata('mensagemErro');
    // gravar a ultima mensagem, para fica no rodapé
    $this->session->set_userdata('ultimoAviso',$mens); 
    
  echo '<script>

    swal({
      title: "ATENÇÃO !",
      text: "'.$mens.'",
      icon: "warning",
      buttons: false,
      dangerMode: true,
    })

  </script>'; 

  // atualiza pagina
  header("Refresh: 2");
  // encerrar a secao
  $this->session->unset_userdata('mensagemErro'); 
endif;

if (!is_null($this->session->userdata('mensagemAlert'))):  
    $mens = $this->session->userdata('mensagemAlert');
    $this->session->set_userdata('ultimoAviso',$mens); 
    
  echo '<script>

  
    swal("'.$mens.'", " ", "success");
  
  </script>'; 

  // atualiza pagina
  header("Refresh: 2");
  // encerrar a secao
  $this->session->unset_userdata('mensagemAlert'); 
endif;
?>



