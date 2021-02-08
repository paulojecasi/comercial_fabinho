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
                            echo form_open('admin/estoque/buscar_produto/itens-nota');
  
                            $this->load->view('backend/mensagem');
                
                            ?>
                            <div class="panel panel-default title-itens-c">
                                <div class="panel-heading text-center">
                                   <h4 class= ""> <?php echo " Consulta de Produtos " ?> 
                                    </h4>
                                </div>

                                <div class="panel-body">

                                     <div class="form-group col-lg-3">
                                        <label for="idcodbarras"> Informe CODBARRA</label>
                                        <select class="form-control" id="idcodbarras" name="idcodbarras">
                                            <option value=""> Passe o Leitor </option>
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

                                    <div class="form-group col-lg-4">
                                        <label for="idcodproduto"> ou COD PRODUTO</label>
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

                                    <div class="form-group col-lg-5">
                                        <label for="iddesproduto"> ou NOME DO PRODUTO </label>
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



                                    <div class ="col-lg-12 col-sm-12 text-center ">
                                        <a href="">
                                            <button class="btn btn-info consulta"> <?php echo img(base_url('assets/frontend/img/lupa.png')); ?>
                                                Buscar
                                            </button> 
                                        </a>
                                    </div>
                        
                                </div>
                            </div>

                            <?php 
                            // fechar o formulario 
                            echo form_close();
                            ?> 

                            <?php
                   

                            echo form_open('admin/estoque/inserir_estoque_item');
  
                            $this->load->view('backend/mensagem');
                
                            if ($produtoitem):
                                foreach ($produtoitem as $produto_con):
                                    $codbar = $produto_con->codbarras;
                                    $codpro = $produto_con->codproduto;
                                    $nomepro= $produto_con->desproduto;
                                    $idproduto = $produto_con->idproduto;   
                               
                                    ?>
                                    <div class="form-group col-lg-3 cons-item"> 
                                        <label> Codigo de Barras </label>
                                        <input id="idcodbarras" name="idcodbarras" type="text" class="form-control" value="<?php echo $codbar?>">
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

                                <div class="form-group col-lg-5 col-sm-12 vercons">  
                                    <label> Valor Unitario </label>
                                    <input type="number" class="form-control" id="vlunitario" name="vlunitario" step="0.01" placeholder="0.00" value="<?php echo set_value('vlunitario') ?>">
                                </div>

                                <div class="form-group col-lg-2 col-sm-12 vercons">  
                                    <label> Quantidade </label>
                                    <input type="number" class="form-control" id="quantidade" name="quantidade"   placeholder="0" value="<?php echo set_value('quantidade') ?>">
                                </div>

                                <div class="form-group col-lg-5 col-sm-12 vercons">  
                                    <label> Valor Total </label>
                                    <input type="number" class="form-control" id="vltotal" name="vltotal" step="0.01" placeholder="0.00" value="<?php echo set_value('vltotal') ?>">
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

                                <input type="hidden" id="idproduto" name="idproduto" value= "<?php echo $idproduto ?>" 
                                >

                                <div class ="col-lg-12 col-sm-12 ">
                                    <a href="">
                                        <button class="btn btn-primary" > 
                                            Adicionar Produto 
                                        </button> 
                                    </a>
                                </div>
                                <?php
                            endif;

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
                <div class="text-center">
                   <h4 class= "title-itens-nota"> <?php echo "  Itens da Nota" ?> </h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                  
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


















