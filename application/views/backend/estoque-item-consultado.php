
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                   <h4 class = "title-itens"> <?php echo "-Cadastro de Itens do Estoque/Notas" ?> </h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 cadnota">
                        <?php 

                            // aqui vamos vericar os erros de validação
                            echo validation_errors('<div class="alert alert-warning">','</div>'); 
                            
                            // vamos abrir o formulário,
                                        // apontando para:admin/controlador/metodo
                            echo form_open('admin/estoque/buscar_produto');
  
                            $this->load->view('backend/mensagem');
                
                            ?>
                            <?php
                            //print_r($produto);
                            //exit; 
                            foreach ($produto as $produto_con):
                                $codbar = $produto_con->codbarras;
                                $codpro = $produto_con->codproduto;
                                $nomepro= $produto_con->desproduto;  
                           
                                ?>
                                <div class="form-group col-lg-3 cons-item"> 
                                    <label> Codigo de Barras </label>
                                    <input id="codbarras" name="codbarras" type="text" class="form-control" value="<?php echo $codbar?>">
                                </div>

                                <div class="form-group col-lg-3 cons-item"> 
                                    <label> Codigo do Produto </label>
                                    <input id="codproduto" name="codproduto" type="text" class="form-control" value="<?php echo $codpro?>">
                                </div>


                                <div class="form-group col-lg-6 cons-item"> 
                                    <label> Nome  </label>
                                    <input id="desproduto" name="desproduto" type="text" class="form-control" value="<?php echo $nomepro?>">
                                </div>
                                <?php
                            endforeach;
                            ?> 

                            <div class="form-group col-lg-6 col-sm-12 vercons">  
                                <label> Valor da Nota </label>
                                <input type="number" class="form-control" id="valornota" name="valornota" step="0.01" placeholder="0.00" value="<?php echo set_value('valornota') ?>">
                            </div>

                            <div class ="col-lg-12 col-sm-12 ">
                                <a href="">
                                    <button class="btn btn-primary" > 
                                        Adicionar Estoque/Nota
                                    </button> 
                                </a>
                            </div>
                            <?php 
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
                        
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading ">
                   <h4 class= "title-itens"> <?php echo " -Itens da Nota" ?> </h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                  
                            <!-- gerar tabela de categorias pela framework PJCS --> 
                            <?php
                            $this->table->set_heading("Id Produto","Quantidade", "Vl Unitario","Vl Total"); 

                            foreach ($estoque_itens as $estoque_item)
                            { 
                                $id     = $estoque_item->id_produto; 
                                $qtd    = $estoque_item->quantidade;
                                $vluni  = $estoque_item->vlunitario; 
                                $vltot  = $estoque_item->vltotal; 
                           
                                $botaoalterar = anchor(base_url('admin/estoque/alterar/'.md5($estoque_item->id)),
                                    '<i class="fas fa-edit"> </i> Alterar');
                                $botaoexcluir = anchor(base_url('admin/estoque/excluir/'.md5($estoque_item->id)),
                                    '<i class="fa fa-remove fa-fw"> </i> Excluir');

                                $this->table->add_row($id,$qtd,$vluni,$vltot,$botaoalterar,$botaoexcluir); 
                            }

                            $this->table->set_template(array(
                                'table_open' => '<table class="table table-striped">'
                            ));

                            echo $this->table->generate(); 
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

</div>


















