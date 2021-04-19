<?php 
	$usuario_permissao 	= $this->session->userdata('userLogado')->tipo_acesso;
?>

<div class="menu-vendas">

   <a class="nav-link" data-toggle="collapse"  aria-controls="menulinks" data-target="#menulinks"><i class="fa fa-bars" aria-hidden="true"></i> 
   </a>
    
   <div id="menulinks" class="nav nav-pills collapse">
      
      <a style="width: 100%;" href="<?php echo base_url('cliente/manutencao_clientes') ?>"  class="nav-link ">  Clientes </a>
      
      <?php
      if ($usuario_permissao ==3):
      ?>
     	  <a style="width: 100%;" href="<?php echo base_url('caixa/movimentos_caixa') ?>"  class="nav-link ">  Valores </a>
        <?php
      endif; 
      ?>
      
      <a style="width: 100%;" href="<?php echo base_url('caixa/movimentos_produtos') ?>"  class="nav-link ">  Produtos </a>
     	<?php
     	if ($usuario_permissao ==3):
     	?>
     		<a style="width: 100%;" href="<?php echo base_url('caixa/movimento_cancel_mov_caixa') ?>">  Movimento do dia-Cancelamento </a>
     	<?php
     	endif; 
     	?>

      <?php
      if ($usuario_permissao ==3):
      ?>
        <a style="width: 100%;" href="<?php echo base_url('admin/home') ?>"> Ir para a ADM </a>
      <?php
      endif; 
      ?>

     	<a style="width: 100%;" href="<?php echo base_url('venda') ?>"  class="nav-link "> <i class="fa fa-home" aria-hidden="true"></i> Ir para Venda </a>

     	<a style="width: 100%;" href="<?php echo base_url('admin/usuarios/logout') ?>"  class="nav-link "> <i class="fa fa-sign-out fa-fw"></i>  Sair do Sistema </a>
   
      
   </div>

</div>




 



