          
<div class = "row">
    <div class = "col-lg-6 col-sm-6">
        <div class="panel panel-default panel-vendas1">
          
            <div class="panel-body">
          
                <div class="row">
                    <div class="col-lg-12 col-sm-12 area-vendas1">

                        <?php
                        // aqui vamos vericar os erros de validação
                        echo validation_errors('<div class="alert alert-warning">','</div>'); 
                        
                        // vamos abrir o formulário,
                                    // apontando para:admin/controlador/metodo
                        echo form_open('admin/estoque/buscar_produto/venda');

                        ?>
                        <!--
                        <div class="form-group"> 
                            <label> Codigo de Barras  </label>
                            <input id="codbarras" name="codbarras" type="text"class = "form-control" placeholder ="Passe o leitor no Produto">
                        </div>

                        <div class="form-group"> 
                            <label> Informe Código do Produto  </label>
                            <input id="codbarras" name="codbarras" type="text"class = "form-control" placeholder ="Digite Código do Produto">
                        </div>
                        -->

                        <div class="form-group flexline">
                            <label for="idcodbarras"> Codigo Barras  </label>
                            <select class="form-control" id="idcodbarras" name="idcodbarras">
                                <option value=""> Passe o Leitor no Código de Barras do Produto </option>
                                <?php 
                                foreach ($produtos as $produto):
                                    $id = md5($produto->idproduto); 
                                    $nome = $produto->desproduto; 
                                    $codb = $produto->codbarras; 
                                
                                 ?> 
                                    <option  value ="<?php echo $id ?> ">
                                        <?php echo $codb." - ".$nome?>
                                    </option>
                                <?php
                                endforeach;
                                ?> 
                            </select>
                           
                        </div>

                        
                        <div class="form-group flexline">
                            <label for="idcodproduto"> Codigo Produto  </label>
                            <select class="form-control" id="idcodproduto" name="idcodproduto">
                                <option value=""> Digite Código do Produto </option>

                                <?php 
                                foreach ($produtos as $produto):
                                    $id = md5($produto->idproduto); 
                                    $nome = $produto->desproduto; 
                                    $cod  = $produto->codproduto; 
                                
                                 ?> 
                                    <option  value ="<?php echo $id ?> ">
                                        <?php echo $cod." - ".$nome?>
                                    </option>
                                <?php
                                endforeach;
                                ?> 
                            </select>
                           
                        </div>

                        <div class="form-group flexline">
                            <label for="iddesproduto"> Nome Produto   </label>
                            <select class="form-control" id="iddesproduto" name="iddesproduto">

                                <option value=""> Digite Nome do Produto </option>
                            
                                <?php 
                                foreach ($produtos as $produto):
                                    $id = md5($produto->idproduto); 
                                    $nome = $produto->desproduto; 
                                    $cod  = $produto->codproduto; 

                                    if (set_value('iddesproduto')==$id):
                                         echo $cod." - ".$nome;
                                    endif;
                                 ?> 
                                    <option  value ="<?php echo $id ?> ">
                                        <?php echo $nome." - ".$cod ?>
                                    </option>
                                <?php
                                endforeach;
                                ?> 
                            </select>
                        
                        </div>

                        <div class="form-group flexline"> 
                            <div class="col-lg-8 col-sm-7 ">
                                <label> Quantidade  </label>
                                <input id="quantidade" name="quantidade" type="number"class = "form-control" placeholder ="0" value="1">
                            </div>
                            <div class="col-lg-4 col-sm-5 ">
                                <a href="">
                                    <button class="btn btn-info qtitem-maior"> <?php echo img(base_url('assets/frontend/img/subtrair.png')); ?>
                                    </button> 
                                </a>
                                <a href="">
                                    <button class="btn btn-info qtitem-maior"> <?php echo img(base_url('assets/frontend/img/somar.png')); ?>
                                    </button> 
                                </a>
                            </div>
                        </div>

                        <div class ="col-lg-12 col-sm-12 text-center">
                            <a href="">
                                <button class="btn btn-info consulta"> <?php echo img(base_url('assets/frontend/img/lupa.png')); ?>
                                    Buscar
                                </button> 
                            </a>
                        </div>
                  
                        <?php 
                        // fechar o formulario 
                        echo form_close();

                    ?>

                    </div>

                    <div>
                        <?php 
                        $valor_total =0; 
                        if ($produtos_temp):    
                            foreach ($produtos_temp as $totaliza):
                                $valor_total += $totaliza->valortotal; 
                            endforeach; 
                            $valor_total = number_format($valor_total,2,",",".");

                        endif;
                        ?> 

                        <div class="form-group col-lg-5 col-sm-12">
                            <label for="iddesproduto"> Tipo de Pagamento   </label>
                            <select class="form-control" id="iddesproduto" name="iddesproduto">

                                <option value=""> Informe Tipo de Pagamento </option>
                            
                                <?php 
                                foreach ($tipo_pagamento as $tppagamento):
                                    $id =  $tppagamento->id;
                                    $tipopagamento = $tppagamento->tipopagamento;
                                    $despagamento = $tppagamento->despagamento;

                                 ?> 
                                    <option  value ="<?php echo $id ?> ">
                                        <?php echo $despagamento ?>
                                    </option>
                                <?php
                                endforeach;
                                ?> 
                            </select>

                            <div class="footer-card-icon text-center">
                                <i class="fa fa-cc-discover"></i>
                                <i class="fa fa-cc-mastercard"></i>
                                <i class="fa fa-cc-paypal"></i>
                                <i class="fa fa-cc-visa"></i>
                            </div>
                        
                        </div>

                        <div class= "tela-preco-total">
                            <div class="form-group col-lg-7 col-sm-12">  
                                <label> Valor Total Compra R$ </label>
                                <h1> <?php echo $valor_total ?> </h1>
                                
                            </div>
                        </div>

                        <div class="form-group col-lg-5 ">  
                            <label> Valor Recebido </label>
                            <input type="number" class="form-control" id="vlpreco" name="vlpreco" step="0.01" placeholder="0.00" value="<?php echo set_value('vlpreco') ?>">
                        </div>

                        <div class= "tela-preco-troco">

                            <div class="form-group col-lg-7 col-sm-12">  
                                <label> Troco R$ </label>
                                <h1> <?php echo 0?> </h1>
                                
                            </div>
                        </div>

                        <div class="form-group col-lg-9">
                            <label for="idcodbarras"> Cliente  </label>
                            <select class="form-control" id="idcodbarras" name="idcodbarras">
                                <option value=""> Informe Cliente </option>
                                <?php 
                                foreach ($produtos as $produto):
                                    $id = md5($produto->idproduto); 
                                    $nome = $produto->desproduto; 
                                    $codb = $produto->codbarras; 
                                
                                 ?> 
                                    <option  value ="<?php echo $id ?> ">
                                        <?php echo $codb." - ".$nome?>
                                    </option>
                                <?php
                                endforeach;
                                ?> 
                            </select>
                           
                        </div>

                        <div class ="col-lg-3 col-sm-12 btn-finalizar-venda ">
                                <a href="">
                                    <button class="btn btn-success" > 
                                        Finalizar Venda
                                    </button> 
                                </a>
                            </div>
                        <?php

                            // fechar o formulario 
                        echo form_close();
                        ?>

                    </div>

                    
                </div>
            </div>
        </div>

    </div>
    <div class="col-lg-6 col-sm-6">

        <div class="col-lg-12 col-sm-12 area-vendas2">
        <?php
            echo form_open('admin/estoque/inserir_estoque_item');

            $this->load->view('backend/mensagem');
            if ($produtoitem):
                foreach ($produtoitem as $produto_con):
                    $codbar = $produto_con->codbarras;
                    $codpro = $produto_con->codproduto;
                    $nomepro= $produto_con->desproduto;
                    $idproduto = $produto_con->idproduto;  
                    $vlpreco = $produto_con->vlpreco; 
                    $quantidade = $quantidade_item;
                    $vlprecototal = $vlpreco*$quantidade; 
                    $vlpreco =number_format($vlpreco,2,",",".");
                    $vlprecototal=number_format($vlprecototal,2,",","."); 

                endforeach;

                ?> 


                <div class = "panel-item-escolhido">
                    <div class="form-group col-lg-12  text-left"> 
                        <h3 class="descricao-prod-caixa">
                            <?php echo $codpro." - ".$nomepro ?> 
                        </h3>
                    </div>

                    <div class= "desc-precos-compras">
                        <div class="form-group col-lg-5 col-sm-5">  
                            <label> Valor Unitario R$ </label>
                            <h3> <?php echo $vlpreco ?> </h3>
                        </div>

                        <div class="form-group col-lg-2 col-sm-12">  
                            <label> Quantidade </label>
                            <h3> <?php echo $quantidade ?> </h3>
                        </div>

                        <div class="form-group col-lg-5 col-sm-12">  
                            <label> Valor Total R$ </label>
                            <h3> <?php echo $vlprecototal ?> </h3>
                            
                        </div>
                    </div>
                </div>

               <?php
            else:
                ?>

                <div class="form-group col-lg-12  text-left"> 
                    <h3 class="descricao-prod-caixa">
                        SELECIONE UM PRODUTO   
                    </h3>
                </div>

                <div class= "desc-precos-compras">
                    <div class="form-group col-lg-5 col-sm-5">  
                        <label> Valor Unitario R$ </label>
                        <h3> 0  </h3>
                    </div>

                    <div class="form-group col-lg-2 col-sm-12">  
                        <label> Quantidade </label>
                        <h3> 0 </h3>
                    </div>

                    <div class="form-group col-lg-5 col-sm-12">  
                        <label> Valor Total R$ </label>
                        <h3> 0 </h3>
                        
                    </div>
                </div>
                <?php 
            endif;
        ?>
    </div>




        <div class="panel panel-default panel-vendas2">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                  
                            <!-- gerar tabela de categorias pela framework PJCS --> 
                        <?php
                        if ($produtos_temp):
                           
                            $this->table->set_heading("COD", "Descrição", 
                                                        "vl Uni","Vl desc","Vl Acres",
                                                        "Qtd","Valor Total"); 

                            foreach ($produtos_temp as $produto_t):
                                $id = $produto_t->id; 
                                $idproduto = $produto_t->idproduto; 
                                $codproduto = $produto_t->codproduto; 
                                $desproduto = $produto_t->desproduto; 
                                $vlpreco    = $produto_t->vlpreco;
                                $valordesconto    = $produto_t->valordesconto;
                                $valoracrescimo    = $produto_t->valoracrescimo;
                                $quantidadeitens = $produto_t->quantidadeitens;
                                $valortotal = $produto_t->valortotal;

                                $vlpreco =number_format($vlpreco,2,",",".");
                                $valordesconto =number_format($valordesconto,2,",",".");
                                $valoracrescimo =number_format($valoracrescimo,2,",",".");
                                $valortotal =number_format($valortotal,2,",",".");


                                $botaoexcluir= '<button type="button" class="btn btn-link" data-toggle="modal" data-target=".excluir-modal-'.$id.'"> <h4 class="btn-excluir"><i class="fa fa-remove fa-fw"></i> </h4> </button>';

                                echo $modal= ' <div class="modal fade excluir-modal-'.$id.'" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                                                </button>
                                                <h4 class="modal-title" id="myModalLabel2"> <i class="fa fa-remove fa-fw"></i> Exclusão de Categoria </h4>
                                            </div>
                                            <div class="modal-body">
                                                <h4>Deseja Excluir o Item '.$desproduto.'?</h4>
                                                <p>Após Excluida o Item <b>'.$desproduto.'</b> não ficara mais disponível na Venda.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                                <a type="button" class="btn btn-danger" href="'.base_url('home/excluir_produto_temp/'.md5($id)).'">Excluir</a>
                                            </div>

                                        </div>
                                    </div>
                                </div>';

                                $this->table->add_row($codproduto,$desproduto,$vlpreco,$valordesconto, $valoracrescimo,$quantidadeitens,$valortotal,$botaoexcluir); 
                         
                            endforeach; 

                            $this->table->set_template(array(
                                'table_open' => '<table class="table table-striped">'
                            ));

                            echo $this->table->generate(); 
                      
                        endif;
                        ?>
                                        
                    </div>
                    
                </div>
                <!-- /.row (nested) -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
        <!-- /.col-lg-12 -->
</div>
