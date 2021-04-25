
<div id="page-wrapper">
 
  <div class="col-lg-12 text-center titulo-alteracao-prod">
      <h3 class="page-header"> <?php echo $subtitulo." - Alteração" ?></h3>
  </div>
    
	<div class="row">
	  <div class="col-lg-10">
	    <div class="panel panel-default panel-altera-pro">
	    
        <div class="col-lg-12 layout-campos back-color-default">

          <!-- nao vamos utilizar a abertura do form, vamos usar o HELPER do
          framework (form_open) --> 

          <?php
          // aqui vamos vericar os erros de validação
          echo validation_errors('<div class="alert alert-warning">','</div>'); 
          
          // vamos abrir o formulário,
                      // apontando para:admin/controlador/metodo
          echo form_open('admin/produto/salvar_alteracoes','id="form-altera-produto"');

          foreach ($produto as $produto_alt):
          ?> 

          	<section id = "panel-alterar-product">
	            <div class="form-group col-lg-9">
	                <label> Descrição do Produto </label>
	                <input id="txt-desproduto" name="txt-desproduto" type="text"class = "form-control" placeholder ="Digite o nome do produto" value = "<?php echo $produto_alt->desproduto ?>"  onkeydown="javascript:EnterTab('produtoativo',event)" autofocus="true" required>
	            </div>

	             <div class="form-group col-lg-3">
                <label for="produtoativo"> Produto Ativo? </label>
                <select class="form-control" id="produtoativo" name="produtoativo"  onkeydown="javascript:EnterTab('codbarras',event)">
              
                  <?php 
                  foreach ($opcoes as $opcao):
                  ?>
                    <option value ="<?php echo $opcao->idopcao ?> "
                      <?php 
                    	if ($opcao->idopcao==$produto_alt->produtoativo): ?>
                    			selected
                    			<?php                                          
                    	endif;
                      ?> 
                     >
                       <?php echo $opcao->desopcao ?>
                    </option>
                  <?php 
                  endforeach;
                  ?>
                
                </select>
              </div>

	            <div class="form-group protected-field col-lg-5">
                <label> Codigo do Produto </label>
                <input id="codproduto" name="codproduto" type="text" class = "form-control" value="<?php echo $produto_alt->codproduto ?>" readonly>
            	</div>

            	<div class="form-group col-lg-7">
                  <label> Codigo de Barras 
                      <i class="fa fa-barcode" aria-hidden="true"></i>
                  </label>
                  <input id="codbarras" name="codbarras" type="text"class = "form-control" placeholder ="Informe o Codigo de Barras" value="<?php echo $produto_alt->codbarras ?>"  onkeydown="javascript:EnterTab('idmarca',event)">
              </div>

              <div class="form-group col-lg-4">
                <label for="idmarca"> Marca do Produto </label>
                <select class="form-control" id="idmarca" name="idmarca"  onkeydown="javascript:EnterTab('corproduto',event)">
              
                  <?php 
                  foreach ($marcas as $marca): 
                   ?> 
                    <option  value =" <?php echo $marca->idmarca ?> "
                    	<?php 
                    	if ($marca->idmarca==$produto_alt->idmarca): ?>
                    			selected
                    			<?php                                          
                    	endif;
                    	?> 
                    > 
                      <?php echo $marca->desmarca ?>
                    </option>
                  <?php
                  endforeach;
                  ?> 
                </select>
              </div>

              <div class="form-group col-lg-4">
                <label for="corproduto"> Cor do Produto </label>
                <select class="form-control" id="corproduto" name="corproduto"  onkeydown="javascript:EnterTab('idcategoria',event)">
              
                  <?php 
                  foreach ($cores as $cor): 
                   ?> 
                    <option  value =" <?php echo $cor->idcor ?> "
                    	<?php 
                    	if ($cor->idcor==$produto_alt->corproduto): ?>
                    			selected
                    			<?php                                          
                    	endif;
                    	?> 
                    > 
                      <?php echo $cor->descor ?>
                    </option>
                  <?php
                  endforeach;
                  ?> 
                </select>
              </div>
	        
              <div class="form-group col-lg-4">
                <label for="idcategoria"> Categoria do Produto </label>
                <select class="form-control" id="idcategoria" name="idcategoria"  onkeydown="javascript:EnterTab('vlpreco',event)">
                  <?php 
                  foreach ($categorias as $categoria):
                   ?> 
                    <option value ="<?php echo $categoria->id ?>"
                    	<?php 
                    	if ($categoria->id==$produto_alt->idcategoria): ?>
                    			selected
                    			<?php                                          
                    	endif;
                    	?> 
                    >
                       <?php echo $categoria->titulo ?>
                    </option>
                  <?php
                  endforeach;
                  ?> 

                </select>
              </div>

	            <div class="form-group col-lg-6">  
	              <label> Preço </label>
	              <input type="number" class="form-control" id="vlpreco" name="vlpreco" step="0.01" placeholder="0.00" value = "<?php echo $produto_alt->vlpreco ?>"  onkeydown="javascript:EnterTab('vlpromocao',event)">
	            </div>

	            <div class="form-group col-lg-5">
                  <label> Preço Promoção </label>
                  <input type="number" class="form-control" id="vlpromocao" name="vlpromocao" step="0.01" placeholder="0.00" value="<?php echo $produto_alt->vlpromocao ?>"  onkeydown="javascript:EnterTab('vlprecoatacado',event)">
              </div>

              <div class="form-group col-lg-5">  
                  <label> Preço Atacado </label>
                  <input type="number" class="form-control" id="vlprecoatacado" name="vlprecoatacado" step="0.01" placeholder="0.00" value="<?php echo $produto_alt->vlprecoatacado ?>"  onkeydown="javascript:EnterTab('vlpromocaoatacado',event)">
              </div>

              <div class="form-group col-lg-5">
                  <label> Preço Promoção Atacado </label>
                  <input type="number" class="form-control" id="vlpromocaoatacado" name="vlpromocaoatacado" step="0.01" placeholder="0.00" value="<?php echo $produto_alt->vlpromocaoatacado ?>"  onkeydown="javascript:EnterTab('qtatacado',event)">
              </div>

              <div class="form-group col-lg-2"> 
                  <label> Qt Itens</label>
                  <input type="number" class="form-control" id="qtatacado" name="qtatacado" placeholder="0" value="<?php echo $produto_alt->qtatacado ?>"  onkeydown="javascript:EnterTab('vllargura',event)">
              </div>

	            <div class="form-group col-lg-3"> 
	              <label> Largura </label>
	              <input type="number" class="form-control" id="vllargura" name="vllargura" step="0.01" placeholder="0.00" value = "<?php echo $produto_alt->vllargura ?>"  onkeydown="javascript:EnterTab('vlaltura',event)">
	            </div>

	            <div class="form-group col-lg-3">
	              <label> Altura </label>
	              <input type="number" class="form-control" id="vlaltura" name="vlaltura" step="0.01" placeholder="0.00" value = "<?php echo $produto_alt->vlaltura ?>"  onkeydown="javascript:EnterTab('vlcomprimento',event)">
	            </div>

	            <div class="form-group col-lg-3">
	              <label> Comprimento </label>
	              <input type="number" class="form-control" id="vlcomprimento" name="vlcomprimento" step="0.01" placeholder="0.00" value = "<?php echo $produto_alt->vlcomprimento ?>"  onkeydown="javascript:EnterTab('vlpeso',event)">
	            </div>

	            <div class="form-group col-lg-3">  
	              <label> Peso </label>
	              <input type="number" class="form-control" id="vlpeso" name="vlpeso" step="0.01" placeholder="0.00" value = "<?php echo $produto_alt->vlpeso ?>"  onkeydown="javascript:EnterTab('vlpromocao',event)">
	            </div>

	       
            	<!-- INPUT OCULTO PARA ENVIAR O ID--> 
              <input  type="hidden" id="idproduto" name="idproduto" value= "<?php echo $produto_alt->idproduto ?>" 
              >
	            <br> 
	            <section>
		            <div class="text-center col-lg-6">
			            <a href="" >
			                <button class="btn btn-primary person btn_click_shift_f4" id="button-altera-produto" > 
			                    &nbsp Salvar Alterações &nbsp <b class="atl-alt-s"> &nbsp  sF4 &nbsp </b>
			                </button> 
			            </a>
			          </div>
			          <div class ="col-lg-6 text-center link-voltar-cadproduto">    
					        <a href ="<?php echo base_url('admin/produto') ?>">         
					            <h4 class="btn-return"> <i class="fa fa-reply-all"> </i> Voltar Para Produtos</h4>
					        </a>
					    	</div>
	      			</section>
	      		</section>
            <?php 
            // fechar o formulario 
            echo form_close();
            ?> 
              
        </div>
      </div>
      <!-- /.panel -->
    </div>

  	<!-- PARA FOTOS --> 

    <div class="col-lg-2">
      <div class="panel panel-default">
        <div class="panel-heading">
           Foto do Produto
        </div>
        <div class="panel-body">
          <div class="row">
            <div class="col-lg-12 product-img text-center">
                <?php 
                $semFoto = "assets/frontend/img/products/sem_foto.jpg";
                if ($produto_alt->img!=''){
                    echo img($produto_alt->img); 
                } else {
                    echo img($semFoto);
                }
                ?>
            </div>
          </div>
          <br> 
          <div class="row">
            <div class="col-lg-12">
                <?php

                $divopen = '<div class="form-group">';
                $divclose= '</div>';

                echo form_open_multipart('admin/produto/nova_imagem'); 
                echo form_hidden('id_produto', md5($produto_alt->idproduto)); 
                echo $divopen;
                $imagem = array('name'=>'userfile', 
                                'id'=>'userfile',
                                'class'=>'form-control'); 
                echo form_upload($imagem);
                echo $divclose;

                echo $divopen;
                $button = array('name'=>'btn-adicionar', 
                                'id'=>'btn-adicionar',
                                'class'=>'btn btn-success btn-add-imagem',
                                'value'=>'Add Imagem'); 
                echo form_submit($button);
                echo $divclose; 
                echo form_close(); 

              endforeach;   // fechamento do ultimo foreach 
              ?>
          	</div>
            
        	</div>
          <!-- /.row (nested) -->
      	</div>
        <!-- /.panel-body -->
    	</div>
    	<!-- /.panel -->
  	</div>
  </div>
  <!-- /.row -->
</div>
