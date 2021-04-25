<div id="page-wrapper">
    <div class="row panel-title-estoque">
        <div class="col-lg-12 text-center">
            <h4 class="page-header"> <?php echo "Entrada de Produtos no Estoque - Itens" ?></h4>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    <div class="row panel-dados-itens-scroll">
        <div class="col-lg-12">
            <div class="row panel panel-default panel-dados-itens">
                <div class="text-center panel-dados-itens-title">
                   <h4 class = "title-itens"> <?php echo "Dados da Nota" ?> </h4>
                </div>
                 
                <div class="row col-lg-12">
                    <div class="dados-notagravada">

                        <?php
                        $situacao=0; 
                        $disabledC ="";
                        $disabledF =""; 
                        $idestoque_entrada=0;
                        $nrnota=0;
                        $serie=0;
                        $valornota=0;
                        $dataentrada=0; 
                        foreach ($estoque_entrada as $estoque):
                            $idestoque_entrada = $estoque->id; 
                            $nrnota = $estoque->nrnota; 
                            $serie = $estoque->serie; 
                            $emitente = $estoque->emitente ; 
                            $valornota= number_format($estoque->valornota,2,",","."); 
                            $situacao = $estoque->situacao; 
                            $dataentrada=date("d-m-Y", strtotime($estoque->dataentrada));

                            foreach ($situacao_nota as $sitnota) {
                                if ($situacao == $sitnota->tiposituacao)
                                {
                                    $nosituacao_nt = $sitnota->dessituacao; 
                                    if ($situacao  == 0)
                                    {
                                        $nosituacao_nt =
                                        '<b class="field-aberta">'
                                            .$nosituacao_nt.'
                                        </b>';
                                    }
                                    elseif ($situacao  == 1)
                                    {
                                        $nosituacao_nt=
                                        '<b class="field-fechada">'
                                            .$nosituacao_nt.'
                                        </b>';
                                    }
                                    elseif ($situacao  == 2)
                                    {
                                        $nosituacao_nt=
                                        '<b class="field-cancelada">'
                                            .$nosituacao_nt.'
                                        </b>';
                                    }
                                }
                            }
        

                            // fechada ou cancelada, os botoes estarão desativados
                            if ($situacao ==1 || $situacao==2): 
                                $disabledC = "disabled";
                                $disabledF = "disabled";
                            else:
                                $disabledF = " ";
                                $disabledC = " ";
                            endif;

                            // se a nota nao tiver itens poderá ser cancelada
                            // mas nao poderá ser fechada
                            if (!$estoque_entrada_itens):
                                $disabledC = " ";
                                $disabledF = "disabled"; 
                            endif;

                            // Se a nota tiver itens, so poderá ser cancelada depois
                            // que todos os itens forem cancelados.
                            // Se os itens estiverem cancelados, a nota não poderá
                            // ser fechada. 

                            if ($estoque_entrada_itens && $situacao ==0):
                                foreach ($estoque_entrada_itens as $itensnt):
                                    if ($itensnt->tiposituacao==0):
                                        // tem notas em aberto, não pode ser cancelada,
                                        // somente fechada. 
                                        $disabledC="disabled";
                                        $disabledF=""; 
                                        break;
                                    else:
                                        $disabledC="";
                                        $disabledF="disabled"; 
                                    endif; 
                                    
                                endforeach;
                            endif;
                        ?>
                        <section id="dados-nota-gravada">
                            <div class="form-group col-lg-6 verentrada"> 
                                <h4> 
                                    Numero da Nota de Controle : 
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
                                    
                                    <?php echo $nosituacao_nt  ?> 
                                
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
                        </section>

                        <?php
                        endforeach;
                        ?>
                    
                        
                    </div>

                    <div class ="col-lg-12 panel-btn-estoque">

                        <div class ="col-lg-6 col-md-4 col-sm-4 text-center link-voltar-cadnota">    
                            <a href ="<?php echo base_url('admin/estoque') ?>">         
                                <h4 class="btn-return"> <i class="fa fa-reply-all"> </i> Voltar Para o Cadastro de Notas </h4>
                            </a>
                        </div>

                        <div class ="col-lg-3 col-md-4 col-sm-4 text-center" >    
                            <a href ="<?php echo base_url('admin/estoque/fechar_cancelar_nota/1/').md5( $idestoque_entrada) ?>">         
                                <button class="btn btn-fechar-nt" <?php echo $disabledF;?> > <i class="fa fa-check"> </i> Finalizar Nota </button>
                            </a>
                        </div>
                        <div class ="col-lg-3 col-md-4 col-sm-4 text-center">    
                            <a href ="<?php echo base_url('admin/estoque/fechar_cancelar_nota/2/').md5( $idestoque_entrada) ?>">         
                                <button class="btn btn-cancelar-nt"  <?php echo $disabledC;?> > <i class="fa fa-ban"> </i> Cancelar Nota </button>
                            </a>
                        </div>
                  
                    </div>


                    
                </div>
                <!-- /.row (nested) -->
                 
                
            </div>
            <!-- /.panel -->
        </div>

         
        <?php
        if ($situacao ==0): 
            ?>

            <div class="col-lg-12 panel-dados-nota">
                <div class="panel-dados-cad">
                    <div class="title-cadastro-itens-nota text-center">
                       <h4 class = "title-itens"> <?php echo "Cadastro de Itens da Nota " ?> 
                        </h4>
                    </div>
                     
                    <div class="row">
                        <div class="col-lg-12 cadnota2">
                            <?php 
                            echo validation_errors('<div class="alert alert-warning">','</div>'); 

                            $this->load->view('frontend/template/mensagem-alert');
                            ?>
                             
                            <div class="panel panel-default title-itens-c col-lg-5 panel-consulta-prod">
                                <div class="panel-body">
                                    <div class="form-group nomeproduto-admin-it">
                                        <label> Buscar Produto (Codigo, Nome ou Cod Barras)  </label>
                                        <input type="text" id="nomeproduto" name="nomeproduto" class="form-control nomeproduto" autofocos required placeholder="Passe o Leitor de Codigo de Barras" onkeydown="javascript:EnterTab('idproduto_res',event)" autofocus="true" />
                                        <br> 
                                    </div>
                                    
                                    <!--
                                    <div class="form-group resultado" id="resultado" onkeydown="javascript:EnterTab('btn_buscar_item',event)">
                                    </div> -->

                                    
                                    <div class= "form-group picklist-prod resultado resultado-consulta-itens-it" id="resultado" onkeydown="javascript:EnterTab('btn_buscar_item',event)" autofocus="true">
                                        <select multiple class="form-control" id="idproduto_res" name="idproduto_res" size="9">

                                        </select>
                                    </div>
                                    


                                    <!-- INPUT OCULTO PARA ENVIAR O ID--> 
                                    <input type="hidden" id="idestoque_entrada" name="idestoque_entrada" value= "<?php echo $idestoque_entrada ?>" >
                        
                                    <div class ="col-lg-12 col-sm-12 text-center btn-busca-item" onkeydown="javascript:EnterTab('vlunitario',event)">
                                        <a>
                                            <button class="btn btn-info consulta" id="btn_buscar_item" value="<?php echo $this->input->post('idproduto_res'); ?>">  <i class="fa fa-search" aria-hidden="true"></i> 
                                                Buscar
                                            </button> 
                                        </a>
                                    </div>
                        
                                </div>
                            </div>
                          

                            <div class="panel panel-default title-itens-c col-lg-7 panel-prod-consultado">
                                <?php

                                echo form_open('admin/estoque/inserir_estoque_item','id="form-add-item-estoque" autocomplete="off"');
      
                                $this->load->view('backend/mensagem');
                                
                                ?> 

                                <!--
                                <div class="form-group resultado_prod_item" id="resultado_prod_item" onkeydown="javascript:EnterTab('vlunitario',event)">
                                </div> --> 
                                <div class="form-group col-lg-9 cons-item"> 
                                    <label> Descrição  </label>
                                    <input id="desproduto_est" name="desproduto_est" type="text" class="form-control">
                                </div>

                                <div class="form-group col-lg-3 cons-item"> 
                                    <label> Cod Produto </label>
                                    <input id="codproduto_est" name="codproduto_est" type="text" class="form-control">
                                </div>

                                <section id="vl-atual-venda">
                                    <div class="form-group col-lg-4 cons-item"> 
                                        <label> Valor atual para Venda</label>
                                        <input id="vlvenda_est" name="vlvenda_est" type="text" class="form-control" >
                                    </div>

                                    <div class="form-group col-lg-2 cons-item"> 
                                        <label> % </label>
                                        <input id="percent_vl_venda" name="percent_vl_venda" type="text" class="form-control">
                                    </div>
                                </section>

                                <section id="vl-atual-atacado">
                                    <div class="form-group col-lg-4 cons-item"> 
                                        <label> Valor atual para atacado </label>
                                        <input id="vlatacado_est" name="vlatacado_est" type="text" class="form-control" >
                                    </div>
                                    <div class="form-group col-lg-2 cons-item"> 
                                        <label> %  </label>
                                        <input id="percent_vl_atac" name="percent_vl_atac" type="text" class="form-control">
                                    </div>
                                </section>

                                <input type="hidden" id="idproduto_est" name="idproduto_est"> 

                                <div class="form-group col-lg-4 col-sm-12 vercons">  
                                    <label> Valor Unitario </label>
                                    <input type="number" class="form-control" id="vlunitario" name="vlunitario" step="0.01" placeholder="0.00" value="<?php echo set_value('vlunitario') ?>" onkeydown="javascript:EnterTab('quantidade',event)" required>
                                </div>

                                <div class="form-group col-lg-3 col-sm-12 vercons">  
                                    <label> Quantidade </label>
                                    <input type="number" step="0.01" class="form-control" id="quantidade" name="quantidade"   placeholder="0" value="<?php echo set_value('quantidade') ?>" onkeydown="javascript:EnterTab('vlunitario',event)" required>
                                </div>

                                <div class="form-group col-lg-5 col-sm-12 vercons">  
                                    <label> Valor Total </label>
                                    <input type="number" class="form-control" id="vltotal" name="vltotal" step="0.01" placeholder="0.00" value="<?php echo set_value('vltotal') ?>" >
                                </div>

                                <div class="form-group col-lg-12" id="panel-atualiza-vl-itens-entrada">
                                    <div class="form-group col-lg-5 vercons2">  
                                        <label id="title-p1"> Atualizar Vl da Venda: </label>
                                    </div>
                                    <div class="form-group col-lg-3 vercons2"> 
                                        <label> %   </label> 
                                        <input type="number" step="0.01" class="form-control" id="vl_venda_atual_perc_est" name="vl_venda_atual_perc_est"   placeholder="0" value="<?php echo set_value('vl_venda_atual_perc_est') ?>" onkeydown="javascript:EnterTab('vl_venda_atual_est',event)" >
                                    </div>

                                    <div class="form-group col-lg-4  vercons2"> 
                                        <label> Valor a atualizar  </label>  
                                        <input type="number" class="form-control" id="vl_venda_atual_est" name="vl_venda_atual_est" step="0.01" placeholder="0.00" value="<?php echo set_value('vl_venda_atual_est') ?>" onkeydown="javascript:EnterTab('vl_atacado_atual_perc_est',event)" >
                                    </div>

                                    <div class="form-group col-lg-5 vercons2">  
                                        <label id="title-p2"> Atualizar Vl Atacado :  </label>
                                    </div>
                                    <div class="form-group col-lg-3 vercons2"> 
                                        <input type="number" step="0.01" class="form-control" id="vl_atacado_atual_perc_est" name="vl_atacado_atual_perc_est"   placeholder="0" value="<?php echo set_value('vl_atacado_atual_perc_est') ?>" onkeydown="javascript:EnterTab('vl_atacado_atual_est',event)" >
                                    </div>

                                    <div class="form-group col-lg-4  vercons2"> 
                                        <input type="number" class="form-control" id="vl_atacado_atual_est" name="vl_atacado_atual_est" step="0.01" placeholder="0.00" value="<?php echo set_value('vl_atacado_atual_est') ?>"  onkeydown="javascript:EnterTab('vl_venda_atual_perc_est',event)">
                                    </div>
                                </div>



                                <input type="hidden" id="idestoque_entrada" name="idestoque_entrada" value= "<?php echo $idestoque_entrada ?>" 
                                >
                                <input type="hidden" id="nrnota" name="nrnota" value= "<?php echo $nrnota ?>" 
                                >

                                <div class ="col-lg-12 col-sm-12 btn-add-item-estoque text-center">
                                  
                                        <button class="btn btn-primary person btn_click_shift_f4" id ="btn-item-estoque" type="submit" > 
                                           &nbsp Adicionar Item &nbsp <b class="atl-alt-s"> &nbsp  sF4 &nbsp </b>  
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
                <!-- /.panel -->
            </div>

            <?php
        endif;
        ?>
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="text-center title-itens-da-nota">
                   <h4 class= "title-itens"> <?php echo "Itens da Nota" ?> </h4>
                </div>
            
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12 scroll-itens-nt panel-table-nt-itens">
                  
                            <!-- gerar tabela de categorias pela framework PJCS --> 
                            <?php
                            $this->table->set_heading("Id","Codigo Produto","Descrição","Situação","Quantidade", "Vl Unitario","Vl Total","Cancelar"); 

                            foreach ($estoque_entrada_itens as $estoque_item)
                            { 
                                $idestoque_item         = $estoque_item->id;
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
                           
                                if ($tpsituacao==0):
                                    $botaocancelar= '<button type="button" class="btn btn-link" data-toggle="modal" data-target=".excluir-modal-'.$idproduto.'"> <h4 class="btn-excluir"><i class="fa fa-remove fa-fw"></i>  Cancelar Item </h4> </button>';

                                else:
                                    $botaocancelar = "-"; 
                                endif;

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
                                                <a type="button" class="btn btn-danger" href="'.base_url('admin/estoque/cancelar_item/'.md5($idestoque_item).'/'.md5($idproduto)).'/'.md5($idestoque_entrada).'"> Confirmar </a>
                                            </div>

                                        </div>
                                    </div>
                                </div>';

                                $this->table->add_row($idestoque_item,$codproduto,$desproduto,$dessituacao,$qtd,$vluni,$vltot,$botaocancelar); 
                            }

                            $this->table->set_template(array(
                                'table_open' => '<table class="table table-hover table-uper-case">'
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



















