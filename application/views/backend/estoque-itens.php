<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12 text-center">
            <h4 class="page-header"> <?php echo "Entrada de Produtos no Estoque - Itens" ?></h4>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    <div class="row">

        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                   <h4 class = "title-itens"> <?php echo "-Dados da Nota" ?> </h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 dados-notagravada">

                            <?php
                            foreach ($estoque_entrada as $estoque):
                                $nrnota = $estoque->nrnota; 
                                $serie = $estoque->serie; 
                                $emitente = $estoque->emitente ; 
                                $valornota= number_format($estoque->valornota,2,",","."); 
                                $situacao = $estoque->situacao; 
                                $dataentrada=date("d-m-Y", strtotime($estoque->dataentrada));
                            ?>
                                <div class="form-group col-lg-6 verentrada"> 
                                    <h4> 
                                        Numero da Nota/Estoque : 
                                        <b>
                                            <?php echo $nrnota ?> 
                                        </b>
                                    </h4>
                                </div>

                                <div class="form-group col-lg-6 verentrada"> 
                                    <h4> 
                                        Série : 
                                        <b>
                                            <?php echo $serie ?> 
                                        </b>
                                    </h4>
                                </div>

                                <div class="form-group col-lg-6 verentrada"> 
                                    <h4> 
                                        Emitente : 
                                        <b>
                                            <?php echo $emitente ?> 
                                        </b>
                                    </h4>
                                </div>

                                <div class="form-group col-lg-6 verentrada"> 
                                    <h4> 
                                        Valor R$ : 
                                        <b>
                                            <?php echo $valornota ?> 
                                        </b>
                                    </h4>
                                </div>

                                <div class="form-group col-lg-6 verentrada"> 
                                    <h4> 
                                        Situacao : 
                                        <b>
                                            <?php echo $situacao ?> 
                                        </b>
                                    </h4>
                                </div>

                                <div class="form-group col-lg-6 verentrada"> 
                                    <h4> 
                                        Data Entrada  : 
                                        <b>
                                            <?php echo $dataentrada ?> 
                                        </b>
                                    </h4>
                                </div>

                            <?php
                            endforeach;
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
                            echo form_open('admin/estoque/inserir');
        
                            ?>
                            <div class="form-group col-lg-5 col-sm-11 vercons"> 
                                <label> Numero da Nota </label>
                                <input id="nrnota" name="nrnota" type="text"class = "form-control" placeholder ="Digite o Numero da Nota" value="<?php echo set_value('nrnota') ?>">

                            </div>

                            <div class="form-group col-lg-1 col-sm-1 ">
                                <label> Sem Nota </label>
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                </div> 
                            </div>

                            <div class="form-group col-lg-6 col-sm-12 vercons"> 
                                <label> Serie  </label>
                                <input id="serie" name="serie" type="text"class = "form-control" placeholder ="Digite o serie da Nota" value="<?php echo set_value('serie') ?>">
                            </div>

                            <div class="form-group col-lg-6 col-sm-12 vercons"> 
                                <label> Emitente  </label>
                                <input id="emitente" name="emitente" type="text"class = "form-control" placeholder ="Digite o Emitente da Nota" value="<?php echo set_value('emitente') ?>">
                            </div>

                            <div class="form-group col-lg-6 col-sm-12 vercons">  
                                <label> Valor da Nota </label>
                                <input type="number" class="form-control" id="valornota" name="valornota" step="0.01" placeholder="0.00" value="<?php echo set_value('valornota') ?>">
                            </div>

                            <br>

                            <div class ="col-lg-12 col-sm-12 ">
                                <a href="">
                                    <button class="btn btn-primary" > 
                                        Adicionar Estoque/Nota
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
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading ">
                   <h4> <?php echo " -Itens da Nota" ?> </h4>
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


















