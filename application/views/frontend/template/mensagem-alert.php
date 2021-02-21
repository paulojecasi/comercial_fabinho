
<?php 
// BLOCO DE MENSAGENS 
if (!is_null($this->session->userdata('mensagem'))) 
{ 
	?>
	<div class="text-center mensagem">  
    <div class="alert alert-success" role="alert">
        <b> 
            <?php
             echo $this->session->userdata('mensagem'); 
            ?>
        </b>
    </div>
  </div>
    <?php 
    // encerrar a secao
    $this->session->unset_userdata('mensagem'); 
}

if (!is_null($this->session->userdata('mensagemErro'))):  
    $mens = $this->session->userdata('mensagemErro');
    
  echo '<script>

     
    swal("ATENCAO! ","'.$mens.'"); 

  
  </script>'; 

    // encerrar a secao
    $this->session->unset_userdata('mensagemErro'); 
endif;
?>
