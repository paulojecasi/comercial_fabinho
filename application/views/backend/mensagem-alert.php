
<?php 
if (!is_null($this->session->userdata('mensagemErro'))):  
    $mens = $this->session->userdata('mensagemErro');
    

  echo '<script>

     
    alert("'.$mens.'"); 

  
  </script>'; 

    // encerrar a secao
    $this->session->unset_userdata('mensagemErro'); 
endif;
?>
