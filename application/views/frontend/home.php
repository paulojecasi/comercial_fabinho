              
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
                         
                                <div class="form-group nomeproduto ">
                                    <label for="nomeproduto"> Informe Produto </label>
                                    <input type="text" id="nomeproduto" name="nomeproduto" class="form-control" autofocos required placeholder="Passe o Leitor de Codigo de Barras" />
                                    <br> 
                                </div>

                                <div class="form-group resultado" id="resultado">
                                </div>

                                <div class="form-group"> 
                                    <div class="col-lg-7 quantidade-ites text">
                                        <label> Quantidade  </label>
                                        <input id="quantidade" name="quantidade" type="number" class="form-control" placeholder ="0" value="1">
                                    </div>
                                </div>
                               
                                <div class="form-group"> 
                                    <div class ="col-lg-5 text-center">
                                        <a href="">
                                            <button class="btn btn-info consulta" id="btn_buscar" name="btn_buscar"> <?php echo img(base_url('assets/frontend/img/lupa.png')); ?>
                                                Buscar
                                            </button> 
                                        </a>
                                    </div>
                                </div>
                             

                                <?php 
                                // fechar o formulario 
                                echo form_close();

                            ?>
                           
                            </div> 

                            <div>


                                <?php

                                $id_caixa = 1;  
                              
                                echo form_open('home/venda_pagamento/'.md5($id_caixa));

                                $valor_total =0; 
                                $vl_tot_desc=0;
                                $vl_tot_acre =0; 
                                $numero_itens =0; 
                                if ($produtos_temp):    
                                    foreach ($produtos_temp as $totaliza):

                                        $vl_tot_desc +=$totaliza->valordesconto;
                                        
                                        $vl_tot_acre +=$totaliza->valoracrescimo;
                                        
                                        $valor_total += $totaliza->valortotal; 

                                        $numero_itens += $totaliza->quantidadeitens;

                                    endforeach; 
                                    $valor_total = ($valor_total + 
                                                    $vl_tot_acre -
                                                    $vl_tot_desc); 

                                    $valor_total = reais($valor_total); 
                                    $vl_tot_desc = reais($vl_tot_desc);
                                    $vl_tot_acre = reais($vl_tot_acre); 
                                   

                                endif;
                                ?> 

                                <div class= "tela-numero-itens">
                                    <div class="form-group col-lg-2 col-sm-12">  
                                        <label> Nr Itens </label>
                                        <h1> <?php echo $numero_itens ?> </h1>
                                        
                                    </div>
                                </div>

                                <div class= "tela-preco-desconto">
                                    <div class="form-group col-lg-5 col-sm-12">  
                                        <label> Valor Desconto R$ </label>
                                        <h1> <?php echo $vl_tot_desc ?> </h1>
                                        
                                    </div>
                                </div>
                                
                                 <div class= "tela-preco-acrescimo">
                                    <div class="form-group col-lg-5 col-sm-12">  
                                        <label> Valor Acréscimo R$ </label>
                                        <h1> <?php echo $vl_tot_acre ?> </h1>
                                        
                                    </div>
                                </div>

                                <div class= "tela-preco-total">
                                    <div class="form-group col-lg-8 col-sm-12">  
                                        <label> Valor Total Compra R$ </label>
                                        <h1> <?php echo $valor_total ?> </h1>
                                        
                                    </div>
                                </div>

                                <div class ="col-lg-4 col-sm-12 btn-finalizar-venda ">
                                    <a href=" ">
                                        <button class="btn btn-success" type="submit" > 
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
                            $vlpreco =reais($vlpreco);
                            $vlprecototal= reais($vlprecototal); 

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

                        <div class="form-group col-lg-12 text-left"> 
                            <h3 class="descricao-prod-caixa">
                                SELECIONE UM PRODUTO   
                            </h3>
                        </div>

                        <div class= "desc-precos-compras">
                            <div class="form-group col-lg-5 col-sm-5">  
                                <label> Vl Unitario R$ </label>
                                <h3> 0,00  </h3>
                            </div>

                            <div class="form-group col-lg-2 col-sm-2">  
                                <label> Quantidade </label>
                                <h3> 0 </h3>
                            </div>

                            <div class="form-group col-lg-5 col-sm-5">  
                                <label> Vl Total R$ </label>
                                <h3> 0,00 </h3>
                                
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

                                        $vlpreco =reais($vlpreco);
                                        $valordesconto =reais($valordesconto);
                                        $valoracrescimo =reais($valoracrescimo);
                                        $valortotal =
                                            '<b>'.reais($valortotal).'</b>';

                                        $botaoexcluir= '<button type="button" class="btn btn-link" data-toggle="modal" data-target=".excluir-modal-'.$id.'"> <h4 class="btn-excluir"><i class="fa fa-remove fa-fw"></i> </h4> </button>';

                                        echo $modal= ' <div class="modal fade excluir-modal-'.$id.'" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-sm">
                                                <div class="modal-content">

                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                                                        </button>
                                                        <h4 class="modal-title text-center" id="myModalLabel2"> <i class="fa fa-remove fa-fw"></i> Exclusão de Item </h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h4>Deseja Excluir o Item '.$desproduto.'?</h4>
                                                        <p>Após Excluido, o Item <b>'.$desproduto.'</b> não ficara mais disponível na Venda.</p>
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
