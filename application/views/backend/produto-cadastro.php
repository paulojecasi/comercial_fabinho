<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="page-header"> <?php echo $subtitulo ?></h2>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    <div class="row"> 
        <div class="col-lg-12">   
            <div class="panel panel-default">
         
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
                            echo form_open('admin/produto/inserir');
            
                            ?> 

                            <div class="form-group">
                                <label> Descrição do Produto </label>
                                <input id="txt-desproduto" name="txt-desproduto" type="text"class = "form-control" placeholder ="Digite o nome do produto" value="<?php echo set_value('txt-desproduto') ?>"> 
                            </div>

                            <div class="form-group">
                                <label> Codigo de Barras 
                                    <i class="fa fa-barcode" aria-hidden="true"></i>
                                </label>
                                <input id="codbarras" name="codbarras" type="text"class = "form-control" placeholder ="Informe o Codigo de Barras" value="<?php echo set_value('codbarras') ?>">
                            </div>

                            <div class="form-group col-lg-4">
                              <label for="idmarca"> Marca do Produto </label>
                              <select class="form-control" id="idmarca" name="idmarca">
                            
                                <?php 
                                foreach ($marcas as $marca) 
                                { ?> 
                                    <option  value =" <?php echo $marca->idmarca ?> "
                                        <?php 
                                        if ($marca->desmarca=="PADRAO"): ?>
                                                selected
                                            <?php                                  
                                        endif;
                                        ?>
                                    >
                                        <?php echo $marca->desmarca ?>
                                    </option>
                                <?php
                                 }
                                ?> 
                              </select>
                            </div>

                            <div class="form-group col-lg-4">
                              <label for="corproduto"> Cor do Produto </label>
                              <select class="form-control" id="corproduto" name="corproduto">
                            
                                <?php 
                                foreach ($cores as $cor) 
                                { ?> 
                                    <option  value =" <?php echo $cor->idcor ?> "
                                        <?php 
                                        if ($cor->descor=="PADRAO"): ?>
                                                selected
                                            <?php                                  
                                        endif;
                                        ?>
                                    >
                                        <?php echo $cor->descor ?>
                                    </option>
                                <?php
                                 }
                                ?> 
                              </select>
                            </div>

                            <div class="form-group col-lg-4" >
                              <label for="idcategoria"> Categoria do Produto </label>
                              <select class="form-control" id="idcategoria" name="idcategoria">
                            
                                <?php 
                                foreach ($categorias as $categoria) 
                                { ?> 
                                    <option value ="<?php echo $categoria->id ?> " 
                                        <?php 
                                        if ($categoria->titulo=="OUTROS"): ?>
                                                selected
                                            <?php                                  
                                        endif;
                                        ?>
                                    >
                                        <?php echo $categoria->titulo ?>
                                    </option>
                                <?php
                                 }
                                ?> 
                              </select>
                            </div>
                           
                            <div class="form-group col-lg-6">  
                                <label> Preço Varejo </label>
                                <input type="number" class="form-control" id="vlpreco" name="vlpreco" step="0.01" placeholder="0.00" value="<?php echo set_value('vlpreco') ?>">
                            </div>

                            <div class="form-group col-lg-6">
                                <label> Preço Promoção Varejo </label>
                                <input type="number" class="form-control" id="vlpromocao" name="vlpromocao" step="0.01" placeholder="0.00" value="<?php echo set_value('vlpromocao') ?>">
                            </div>

                            <div class="form-group col-lg-5">  
                                <label> Preço Atacado </label>
                                <input type="number" class="form-control" id="vlprecoatacado" name="vlprecoatacado" step="0.01" placeholder="0.00" value="<?php echo set_value('vlprecoatacado') ?>">
                            </div>

                            <div class="form-group col-lg-5">
                                <label> Preço Promoção Atacado </label>
                                <input type="number" class="form-control" id="vlpromocaoatacado" name="vlpromocaoatacado" step="0.01" placeholder="0.00" value="<?php echo set_value('vlpromocaoatacado') ?>">
                            </div>
                            
                            <div class="form-group col-lg-2"> 
                                <label> Qt Itens Atacado </label>
                                <input type="number" class="form-control" id="qtatacado" name="qtatacado" placeholder="0" value="<?php echo set_value('qtatacado') ?>">
                            </div>
                            <div class="form-group col-lg-6"> 
                                <label> Largura </label>
                                <input type="number" class="form-control" id="vllargura" name="vllargura" step="0.01" placeholder="0.00" value="<?php echo set_value('vllargura') ?>">
                            </div>
                            <div class="form-group col-lg-6">
                                <label> Altura </label>
                                <input type="number" class="form-control" id="vlaltura" name="vlaltura" step="0.01" placeholder="0.00" value="<?php echo set_value('vlaltura') ?>">
                            </div>
                            <div class="form-group col-lg-6">
                                <label> Comprimento </label>
                                <input type="number" class="form-control" id="vlcomprimento" name="vlcomprimento" step="0.01" placeholder="0.00" value="<?php echo set_value('vlcomprimento') ?>">
                            </div>
                            <div class="form-group col-lg-6">  
                                <label> Peso </label>
                                <input type="number" class="form-control" id="vlpeso" name="vlpeso" step="0.01" placeholder="0.00" value="<?php echo set_value('vlpeso') ?>">
                            </div>
                            
                                                   
                            <div class="form-group col-lg-6">
                              <label for="produtoativo"> Produto Ativo? </label>
                              <select class="form-control" id="produtoativo" name="produtoativo" >
                            
                                <?php foreach ($opcoes as $opcao)
                                {
                                ?>
                                    <option value ="<?php echo $opcao->idopcao ?> ">
                                       <?php echo $opcao->desopcao ?>
                                    </option>
            
                                <?php 
                                }
                                ?>
                              
                              </select>
                            </div>
                        
                            <div class="form-group col-lg-6">
                              <label for="produtodestaque"> Produto Destaque? </label>
                              <select class="form-control" id="produtodestaque" name="produtodestaque">
                            
                                <?php foreach ($opcoes as $opcao)
                                {
                                ?>
                                    <option value ="<?php echo $opcao->idopcao ?> ">
                                       <?php echo $opcao->desopcao ?>
                                    </option>
            
                                <?php 
                                }
                                ?>
                              
                              </select>
                            </div>
                        
                            <div class="form-group col-lg-6">
                              <label for="actproduct"> Produto no Site? </label>
                              <select class="form-control" id="produtosite" name="produtosite">
                            
                                <?php foreach ($opcoes as $opcao)
                                {
                                ?>
                                    <option value ="<?php echo $opcao->idopcao ?> ">
                                       <?php echo $opcao->desopcao ?>
                                    </option>
            
                                <?php 
                                }
                                ?>
                              
                              </select>
                            </div>
                    
                            <div class="col-lg-12 text-center">
                                <br> 
                                <a href="">
                                    <button class="btn btn-primary" > 
                                        Adicionar Produto
                                    </button> 
                                </a>
                            </div>
                      
                            <?php 
                            // fechar o formulario 
                            echo form_close();
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
<!-- /#page-wrapper -->

> 