
	<div class="panel panel-default">
    <div class="panel-heading text-center">
       <h1>
       		<?php echo $titulo ?>
       </h1>
    </div>
    <h2>
	    <?php
	    	$this->load->view('backend/mensagem');
	    ?> 
  	</h2>
    <div class="panel-body">

			<div class = "btn-acesso"> 
				<div class ="col-lg-6 col-sm-12 btn-acesso text-center">
				    <a href="<?php echo base_url('venda') ?> ">
				        <button class="btn btn-success" type="submit" > 
				            Vendas
				        </button> 
				    </a>
				</div>
				<div class ="col-lg-6 col-sm-12 btn-acesso text-center">
				    <a href="<?php echo base_url('admin') ?>">
				        <button class="btn btn-success" type="submit" > 
				            Administração 
				        </button> 
				    </a>
				</div>
			</div>
		</div>

		<div class="panel-heading text-center">
			<div class="text-center cactosdev_acesso">
	      <p class="des-por"> Desenvolvido por </p>
	      <h3> <img class="img-fluid cacto" src=" <?php echo base_url('assets/frontend/img/cactosdev.png'); ?>"> Cactos Dev </h3>
	      <p> <img class="img-fluid email" src=" <?php echo base_url('assets/frontend/img/email.png'); ?>"> cactosdev@gmail.com 
	      <img class="img-fluid whats" src=" <?php echo base_url('assets/frontend/img/whats.png'); ?>"> (86) 99973 3764  </p>
	  	</div>
	  </div>


	</div>