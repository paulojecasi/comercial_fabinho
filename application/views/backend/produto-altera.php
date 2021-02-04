
<div id="page-wrapper">
	<div class="row">
    <div class="col-lg-12 text-center">
        <h3 class="page-header"> <?php echo $subtitulo." - Alteração" ?></h3>
    </div>
    <!-- /.col-lg-12 -->
	</div>

	<div class="row">
	  <div class="col-lg-8">
	    <div class="panel panel-default">
	      <div class="panel-heading">
	         <?php echo $subtitulo ?>
	      </div>
	      <div class="panel-body">
	        <div class="row">
	          <div class="col-lg-12 layout-campos">

		          <!-- nao vamos utilizar a abertura do form, vamos usar o HELPER do
		          framework (form_open) --> 

		          <?php
		          // aqui vamos vericar os erros de validação
		          echo validation_errors('<div class="alert alert-warning">','</div>'); 
		          
		          // vamos abrir o formulário,
		                      // apontando para:admin/controlador/metodo
		          echo form_open('admin/produto/salvar_alteracoes');

		          foreach ($produto as $produto_alt):
		          ?> 

		            <div class="form-group">
		                <label> Descrição do Produto </label>
		                <input id="txt-desproduto" name="txt-desproduto" type="text"class = "form-control" placeholder ="Digite o nome do produto" value = "<?php echo $produto_alt->desproduto ?>">
		            </div>

		            <div class="form-group protected-field">
                  <label> Codigo do Produto </label>
                  <input id="codproduto" name="codproduto" type="text"class = "form-control" placeholder ="Codigo Gerado Automaticamente Pelo Sistema" value="<?php echo $produto_alt->codproduto ?>">
              	</div>

              	<div class="form-group">
                    <label> Codigo de Barras 
                        <i class="fa fa-barcode" aria-hidden="true"></i>
                    </label>
                    <input id="codbarras" name="codbarras" type="text"class = "form-control" placeholder ="Informe o Codigo de Barras" value="<?php echo $produto_alt->codbarras ?>">
                </div>

                <div class="form-group col-lg-4">
	                <label for="idmarca"> Marca do Produto </label>
	                <select class="form-control" id="idmarca" name="idmarca">
	              
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
	                <select class="form-control" id="corproduto" name="corproduto">
	              
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
	                <select class="form-control" id="idcategoria" name="idcategoria">
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
		              <label> Preço Varejo</label>
		              <input type="number" class="form-control" id="vlpreco" name="vlpreco" step="0.01" placeholder="0.00" value = "<?php echo $produto_alt->vlpreco ?>">
		            </div>

		            <div class="form-group col-lg-5">
                    <label> Preço Promoção Varejo </label>
                    <input type="number" class="form-control" id="vlpromocao" name="vlpromocao" step="0.01" placeholder="0.00" value="<?php echo $produto_alt->vlpromocao ?>">
                </div>

                <div class="form-group col-lg-5">  
                    <label> Preço Atacado </label>
                    <input type="number" class="form-control" id="vlprecoatacado" name="vlprecoatacado" step="0.01" placeholder="0.00" value="<?php echo $produto_alt->vlprecoatacado ?>">
                </div>

                <div class="form-group col-lg-5">
                    <label> Preço Promoção Atacado </label>
                    <input type="number" class="form-control" id="vlpromocaoatacado" name="vlpromocaoatacado" step="0.01" placeholder="0.00" value="<?php echo $produto_alt->vlpromocaoatacado ?>">
                </div>

                <div class="form-group col-lg-2"> 
                    <label> Qt Itens</label>
                    <input type="number" class="form-control" id="qtatacado" name="qtatacado" placeholder="0" value="<?php echo $produto_alt->qtatacado ?>">
                </div>

		            <div class="form-group col-lg-6"> 
		              <label> Largura </label>
		              <input type="number" class="form-control" id="vllargura" name="vllargura" step="0.01" placeholder="0.00" value = "<?php echo $produto_alt->vllargura ?>">
		            </div>

		            <div class="form-group col-lg-6">
		              <label> Altura </label>
		              <input type="number" class="form-control" id="vlaltura" name="vlaltura" step="0.01" placeholder="0.00" value = "<?php echo $produto_alt->vlaltura ?>">
		            </div>

		            <div class="form-group col-lg-6">
		              <label> Comprimento </label>
		              <input type="number" class="form-control" id="vlcomprimento" name="vlcomprimento" step="0.01" placeholder="0.00" value = "<?php echo $produto_alt->vlcomprimento ?>">
		            </div>

		            <div class="form-group col-lg-6">  
		              <label> Peso </label>
		              <input type="number" class="form-control" id="vlpeso" name="vlpeso" step="0.01" placeholder="0.00" value = "<?php echo $produto_alt->vlpeso ?>">
		            </div>

		            <div class="form-group col-lg-6">
		              <label> Valor Promoção </label>
		              <input type="number" class="form-control" id="vlpromocao" name="vlpromocao" step="0.01" placeholder="0.00" value = "<?php echo $produto_alt->vlpromocao ?>">
		            </div>

	              <div class="form-group col-lg-6">
	                <label for="produtoativo"> Produto Ativo? </label>
	                <select class="form-control" id="produtoativo" name="produtoativo">
	              
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
	          
		          	
	              <div class="form-group col-lg-6">
	                <label for="produtodestaque"> Produto Destaque? </label>
	                <select class="form-control" id="produtodestaque" name="produtodestaque">
	              
	                  <?php 
	                  foreach ($opcoes as $opcao):
	                  ?>
	                      <option value ="<?php echo $opcao->idopcao ?> "
	                        <?php 
	                      	if ($opcao->idopcao==$produto_alt->produtodestaque):?>
	                      			selected
	                      			<?php                                          
	                      	endif
		                      ?> 
	                      >
	                         <?php echo $opcao->desopcao ?>
	                      </option>

	                  <?php 
	                  endforeach; 
	                  ?>
	                
	                </select>
	              </div>
		        
	              <div class="form-group col-lg-6">
	                <label for="actproduct"> Produto no Site? </label>
	                <select class="form-control" id="produtosite" name="produtosite">
	                  <?php 
	                  foreach ($opcoes as $opcao):
	                  ?>
                      <option value ="<?php echo $opcao->idopcao ?> "
                      	<?php 
                      	if ($opcao->idopcao==$produto_alt->produtosite): ?>
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
		       
	            	<!-- INPUT OCULTO PARA ENVIAR O ID--> 
	              <input  type="hidden" id="idproduto" name="idproduto" value= "<?php echo $produto_alt->idproduto ?>" 
	              >
		            <br> 
		            <div class="text-center">
			            <a href="" >
			                <button class="btn btn-primary" > 
			                    Alterar Produto
			                </button> 
			            </a>
			          </div>
		      
		            <?php 
		            // fechar o formulario 
		            echo form_close();
		            ?> 
		                
		            
            </div>
            <!-- /.col-lg-->
          </div>
            <!-- /.row (nested) -->
        </div>
          <!-- /.panel-body -->
      </div>
      <!-- /.panel -->
    </div>

  	<!-- PARA FOTOS --> 

    <div class="col-lg-4">
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
                                'class'=>'btn btn-primary',
                                'value'=>'Adicionar Imagem'); 
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