<div id="page-wrapper">
    <div class="row panel-title-estoque">
        <div class="col-lg-12 text-center">
            <h4 class="page-header"> <?php echo "Entrada de Produtos no Estoque - Itens" ?></h4>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default panel-dados">
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
            <div class="panel panel-default panel-dados-cad">
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
                            //echo form_open('admin/estoque/buscar_produto/itens-nota');
  
                            //$this->load->view('backend/mensagem');

                            $this->load->view('frontend/template/mensagem-alert');
                            ?>
                            <div class="panel panel-default title-itens-c col-lg-6 panel-consulta-prod">
                                <div class="panel-body">
                                    <div class="form-group nomeproduto-admin">
                                        <label for="nomeproduto"> Informe Produto </label>
                                        <input type="text" id="nomeproduto" name="nomeproduto" class="form-control nomeproduto" autofocos required placeholder="Passe o Leitor de Codigo de Barras" onkeydown="javascript:EnterTab('idproduto_res',event)" autofocus="true" />
                                        <br> 
                                    </div>
                                    
                                    <div class="form-group resultado" id="resultado" onkeydown="javascript:EnterTab('btn_buscar_item',event)">
                                    </div>


                                    <?php
                                    foreach ($estoque_entrada as $estoque):
                                        $idestoque_entrada = md5($estoque->id); 
                                        ?>
                                        <!-- INPUT OCULTO PARA ENVIAR O ID--> 
                                        <input type="hidden" id="idestoque_entrada" name="idestoque_entrada" value= "<?php echo $idestoque_entrada ?>" 
                                        >
                                       
                                        <?php 
                                    endforeach; 
                                    
                                    ?>

                                    <div class ="col-lg-12 col-sm-12 text-center btn-busca-item" onkeydown="javascript:EnterTab('vlunitario',event)">
                                        <a>
                                            <button class="btn btn-info consulta" id="btn_buscar_item" value="<?php echo $this->input->post('idproduto_res'); ?>"> <?php echo img(base_url('assets/frontend/img/lupa.png')); ?>
                                                Buscar
                                            </button> 
                                        </a>
                                    </div>
                        
                                </div>
                            </div>

                            <?php 
                            // fechar o formulario 
                            //echo form_close();
                            ?> 

                            <div class="panel panel-default title-itens-c col-lg-6 panel-prod-consultado">
                                <?php

                                echo form_open('admin/estoque/inserir_estoque_item','id="form-add-item-estoque"');
      
                                $this->load->view('backend/mensagem');
                                
                                ?> 

                                <div class="form-group resultado_prod_item" id="resultado_prod_item" onkeydown="javascript:EnterTab('vlunitario',event)">
                                    </div>

                                <div class="form-group col-lg-8 col-sm-12 vercons">  
                                    <label> Valor Unitario </label>
                                    <input type="number" class="form-control" id="vlunitario" name="vlunitario" step="0.01" placeholder="0.00" value="<?php echo set_value('vlunitario') ?>" onkeydown="javascript:EnterTab('quantidade',event)" required>
                                </div>

                                <div class="form-group col-lg-4 col-sm-12 vercons">  
                                    <label> Quantidade </label>
                                    <input type="number" step="0.01" class="form-control" id="quantidade" name="quantidade"   placeholder="0" value="<?php echo set_value('quantidade') ?>" onkeydown="javascript:EnterTab('vlunitario',event)" required>
                                </div>

                                <div class="form-group col-lg-8 col-sm-12 vercons">  
                                    <label> Valor Total </label>
                                    <input type="number" class="form-control" id="vltotal" name="vltotal" step="0.01" placeholder="0.00" value="<?php echo set_value('vltotal') ?>" >
                                </div>

                                <!-- INPUT OCULTO PARA ENVIAR O ID--> 
                                <?php
                                foreach ($estoque_entrada as $estoqu):
                                    $idestoque_entrada = $estoqu->id; 
                                    $nrnota = $estoqu->nrnota; 
                                    ?>
                                    <!-- INPUT OCULTO PARA ENVIAR O ID--> 
                                    <input type="hidden" id="idestoque_entrada" name="idestoque_entrada" value= "<?php echo $idestoque_entrada ?>" 
                                    >
                                    <input type="hidden" id="nrnota" name="nrnota" value= "<?php echo $nrnota ?>" 
                                    >
                                    <?php 
                                endforeach; 
                                ?>

                                <div class ="col-lg-4 col-sm-12 btn-add-item-estoque">
                                  
                                        <button class="btn btn-primary" id ="btn-item-estoque" type="submit" > 
                                            Adicionar Produto 
                                        </button> 
                                     
                                </div>
                                <?php
                                

                                // fechar o formulario 
                                echo form_close();
                                ?>
                            </div>
                            
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
                <div class="text-center">
                   <h4 class= "title-itens-nota"> <?php echo "  Itens da Nota" ?> </h4>
                </div>
            
                 
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 scroll">
                  
                            <!-- gerar tabela de categorias pela framework PJCS --> 
                            <?php
                            $this->table->set_heading("Codigo","Descrição","Situação","Quantidade", "Vl Unitario","Vl Total","Cancelar"); 

                            foreach ($estoque_entrada_itens as $estoque_item)
                            { 
                                $id         = $estoque_item->id;
                                $idproduto    = $estoque_item->idproduto;
                                $idestoque_entrada = $estoque_item->idestoque_entrada; 
                                $desproduto = $estoque_item->desproduto;  
                                $codproduto = $estoque_item->codproduto;

                                $tpsituacao = $estoque_item->tiposituacao;
                                foreach ($situacao_nota as $situacao_nt): 
                                    if ($situacao_nt->tiposituacao == $tpsituacao):
                                        $dessituacao = $situacao_nt->dessituacao;
                                        if ($tpsituacao==0):  
                                            $dessituacao  = 
                                            '<p class="field-aberta">'
                                                .$dessituacao.'
                                            </p>';
                                        endif; 
                                        if ($tpsituacao==1):  
                                            $dessituacao  = 
                                            '<p class="field-fechada">'
                                                .$dessituacao.'
                                            </p>';
                                        endif; 
                                        if ($tpsituacao==2):  
                                            $dessituacao  = 
                                            '<p class="field-cancelada">'
                                                .$dessituacao.'
                                            </p>';
                                        endif;
                                    endif;  
                                endforeach; 
                                 
                                $qtd    = $estoque_item->quantidade;
                                $vluni  = $estoque_item->vlunitario; 
                                $vltot  = $estoque_item->vltotal; 
                           
                                $botaocancelar= '<button type="button" class="btn btn-link" data-toggle="modal" data-target=".excluir-modal-'.$idproduto.'"> <h4 class="btn-excluir"><i class="fa fa-remove fa-fw"></i>  Cancelar Item </h4> </button>';

                                echo $modal= ' <div class="modal fade excluir-modal-'.$idproduto.'" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                                                </button>
                                                <h4 class="modal-title" id="myModalLabel2"> <i class="fa fa-remove fa-fw"></i> Cancelamento de Itens da Nota de Entrada </h4>
                                            </div>
                                            <div class="modal-body">
                                                <h4>Deseja Cancelar o Item <p> <b>'.$desproduto.'? </b> </h4>
                                                <p>Após cancelado, o Item <b>'.$desproduto.'</b> não ficara mais disponível no Sistema.</p>
                                                <p> O saldo do Item '.$desproduto.'</b> será reduzido no estoque.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                                <a type="button" class="btn btn-danger" href="'.base_url('admin/estoque/cancelar_item/'.md5($id).'/'.md5($idproduto)).'/'.md5($idestoque_entrada).'"> Confirmar </a>
                                            </div>

                                        </div>
                                    </div>
                                </div>';

                                $this->table->add_row($codproduto,$desproduto,$dessituacao,$qtd,$vluni,$vltot,$botaocancelar); 
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



















