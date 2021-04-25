<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12 title-cadastro-prod text-center" >
            <h3 class="page-header"> <?php echo $subtitulo ?></h3>

        </div>
        
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    <div class="row"> 
        <div class="col-lg-12">   
            <div class="panel panel-default">
         
                <div class="row">
                    <div class="col-lg-12 layout-campos back-color-default panel-cadastro-prod">

                    <!-- nao vamos utilizar a abertura do form, vamos usar o HELPER do
                    framework (form_open) --> 
                        <h4 class="text-center"> 
                            <?php
                            echo validation_errors('<div class="alert alert-danger">','</div>'); 
                            ?>
                        </h4>
                        <?php 
                        
                        // vamos abrir o formulário,
                                    // apontando para:admin/controlador/metodo
                        echo form_open('admin/produto/inserir','id="form-cadastro-produto"');
        
                        ?> 

                        <div class="form-group col-lg-5">
                            <label> Codigo de Barras 
                                <i class="fa fa-barcode" aria-hidden="true"></i>
                            </label>
                            <input id="codbarras" name="codbarras" type="text"class = "form-control" placeholder ="Informe o Codigo de Barras" value="<?php echo set_value('codbarras') ?>" onkeydown="javascript:EnterTab('btn-add-produto',event)" autofocus="true">
                        </div> 

                        <div class="form-group col-lg-7">
                            <label> Descrição do Produto </label>
                            <input id="txt-desproduto" name="txt-desproduto" type="text"class = "form-control" placeholder ="Digite o nome do produto" value="<?php echo set_value('txt-desproduto') ?>" onkeydown="javascript:EnterTab('produtoativo',event)" required> 
                        </div>

                       

                        <div class="form-group col-lg-3">
                          <label for="produtoativo"> Produto Ativo? </label>
                          <select class="form-control" id="produtoativo" name="produtoativo"  onkeydown="javascript:EnterTab('idmarca',event)">
                        
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

                        <div class="form-group col-lg-3">
                          <label for="idmarca"> Marca do Produto </label>
                          <select class="form-control" id="idmarca" name="idmarca" onkeydown="javascript:EnterTab('corproduto',event)">
                        
                            <?php 
                            foreach ($marcas as $marca) 
                            { ?> 
                                <option  value =" <?php echo $marca->idmarca ?> "
                                  
                                >
                                    <?php echo $marca->desmarca ?>
                                </option>
                            <?php
                             }
                            ?> 
                          </select>
                        </div>

                        <div class="form-group col-lg-3">
                          <label for="corproduto"> Cor do Produto </label>
                          <select class="form-control" id="corproduto" name="corproduto" onkeydown="javascript:EnterTab('idcategoria',event)">
                        
                            <?php 
                            foreach ($cores as $cor) 
                            { ?> 
                                <option  value =" <?php echo $cor->idcor ?> "
                                 
                                >
                                    <?php echo $cor->descor ?>
                                </option>
                            <?php
                             }
                            ?> 
                          </select>
                        </div>

                        <div class="form-group col-lg-3" >
                          <label for="idcategoria"> Categoria do Produto </label>
                          <select class="form-control" id="idcategoria" name="idcategoria" onkeydown="javascript:EnterTab('vlpreco',event)">
                        
                            <?php 
                            foreach ($categorias as $categoria) 
                            { ?> 
                                <option value ="<?php echo $categoria->id ?> " 
                                  
                                >
                                    <?php echo $categoria->titulo ?>
                                </option>
                            <?php
                             }
                            ?> 
                          </select>
                        </div>
                       
                        <div class="form-group col-lg-6">  
                            <label> Preço R$ </label>
                            <input type="number" class="form-control" id="vlpreco" name="vlpreco" step="0.01" placeholder="0.00" value="<?php echo set_value('vlpreco') ?>" onkeydown="javascript:EnterTab('vlpromocao',event)" required>
                        </div>

                        <div class="form-group col-lg-6">
                            <label> Preço Promoção  R$ </label>
                            <input type="number" class="form-control" id="vlpromocao" name="vlpromocao" step="0.01" placeholder="0.00" value="<?php echo set_value('vlpromocao') ?>" onkeydown="javascript:EnterTab('vlprecoatacado',event)">
                        </div>

                        <div class="form-group col-lg-5">  
                            <label> Preço Atacado R$ </label>
                            <input type="number" class="form-control" id="vlprecoatacado" name="vlprecoatacado" step="0.01" placeholder="0.00" value="<?php echo set_value('vlprecoatacado') ?>" onkeydown="javascript:EnterTab('vlpromocaoatacado',event)">
                        </div>

                        <div class="form-group col-lg-5">
                            <label> Preço Promoção Atacado R$ </label>
                            <input type="number" class="form-control" id="vlpromocaoatacado" name="vlpromocaoatacado" step="0.01" placeholder="0.00" value="<?php echo set_value('vlpromocaoatacado') ?>" onkeydown="javascript:EnterTab('qtatacado',event)">
                        </div>
                        
                        <div class="form-group col-lg-2"> 
                            <label> Qt Itens Atacado </label>
                            <input type="number" class="form-control" id="qtatacado" name="qtatacado" placeholder="1.00" value="1.00" onkeydown="javascript:EnterTab('vllargura',event)">
                        </div>
                        <div class="form-group col-lg-3"> 
                            <label> Largura </label>
                            <input type="number" class="form-control" id="vllargura" name="vllargura" step="0.01" placeholder="0.00" value="<?php echo set_value('vllargura') ?>" onkeydown="javascript:EnterTab('vlaltura',event)">
                        </div>
                        <div class="form-group col-lg-3">
                            <label> Altura </label>
                            <input type="number" class="form-control" id="vlaltura" name="vlaltura" step="0.01" placeholder="0.00" value="<?php echo set_value('vlaltura') ?>" onkeydown="javascript:EnterTab('vlcomprimento',event)">
                        </div>
                        <div class="form-group col-lg-3">
                            <label> Comprimento </label>
                            <input type="number" class="form-control" id="vlcomprimento" name="vlcomprimento" step="0.01" placeholder="0.00" value="<?php echo set_value('vlcomprimento') ?>" onkeydown="javascript:EnterTab('vlpeso',event)">
                        </div>
                        <div class="form-group col-lg-3">  
                            <label> Peso </label>
                            <input type="number" class="form-control" id="vlpeso" name="vlpeso" step="0.01" placeholder="0.00" value="<?php echo set_value('vlpeso') ?>" onkeydown="javascript:EnterTab('txt-desproduto',event)">
                        </div>
                        
                        <section>
                            <div class="col-lg-8 text-center">
                                <br> 
                                <a href="">
                                    <button class="btn btn-primary person btn_click_shift_f4" id="btn-add-produto" placeholder="0.00" onkeydown="javascript:EnterTab('txt-desproduto',event)"> 
                                        &nbsp Salvar &nbsp <b class="atl-alt-s"> &nbsp  sF4 &nbsp </b>
                                    </button> 
                                </a>
                            </div>
                            <div class ="col-lg-4 text-center link-voltar-cadproduto">    
                                <a href ="<?php echo base_url('admin/produto') ?>">         
                                    <h4 class="btn-return"> <i class="fa fa-reply-all"> </i> Voltar Para Produtos</h4>
                                </a>
                            </div>
                        </section>
                  
                        <?php 
                        // fechar o formulario 
                        echo form_close();
                        ?> 
                        
                    </div>
                    
                </div>
                    <!-- /.row (nested) -->
                
            </div>
            <!-- /.panel -->
        </div>

        
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->

> 