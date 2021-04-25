<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12 text-center">
            <h4 class="page-header"> <?php echo "Informe Periodo e o Produto Para Consulta do Movimento de Estoque" ?></h4>
        </div>
        <!-- /.col-lg-12 -->
    </div>
   
    <div class="row">
        <div class="col-lg-12">
            <div class="panel-default panel-dados-cons-estoque">
                 
                    <div class="row">
                        <div class="col-lg-12">
                        <?php 

                            // aqui vamos vericar os erros de validação
                            echo validation_errors('<div class="alert alert-warning">','</div>'); 
                            
                            // vamos abrir o formulário,
                                        // apontando para:admin/controlador/metodo
                            echo form_open('admin/estoque/buscar_produto/consulta-estoque','autocomplete="off"');

                            ?>
                            <div class="panel-body back-color-default">
                                
                                <div class="form-group col-lg-3 campo-data">
                                    <label >Data Inicial</label>
                                    <input type="date" id="datainicial" name="datainicial" maxlength="10" class="form-control" value="<?php echo date('Y-m-d'); ?>"  onkeydown="javascript:EnterTab('datafinal',event)" autofocus="true" />

                                </div>
                          
                                <div class="form-group col-lg-3 campo-data">
                                    <label >Data Final</label>
                                    <input type="date" id="datafinal" name="datafinal" class="form-control" value="<?php echo date('Y-m-d'); ?>"  onkeydown="javascript:EnterTab('nomeproduto',event)" autofocus="true" />
                                
                                </div>
                         
                                <div class="form-group col-lg-6 nomeproduto-admin">
                                    <label for="nomeproduto"> Informe Produto </label>
                                    <input type="text" id="nomeproduto" name="nomeproduto" class="form-control nomeproduto" required placeholder="Passe o Leitor de Codigo de Barras" onkeydown="javascript:EnterTab('idproduto_res',event)" autofocus="true" />
                                    <br> 
                                </div>
                                
                                <!--
                                <div class="form-group col-lg-10 resultado resultado-consulta-estoque" id="resultado" onkeydown="javascript:EnterTab('btn_consulta_est',event)"  autofocus="true" >
                                </div> -->

                                <div class ="resultado-produto form-group col-lg-10">
                                    <div class= "form-group picklist-prod resultado resultado-consulta-estoque" id="resultado" onkeydown="javascript:EnterTab('btn_consulta_est',event)" autofocus="true">
                                        <select multiple class="form-control" id="idproduto_res" name="idproduto_res" size="4">

                                        </select>
                                    </div>
                                </div>
                           
                                <div class ="col-lg-2 text-center btn-consulta-est">
                                    <a href="">
                                        <button class="btn btn-info consulta" id="btn_consulta_est">  <i class="fa fa-search" aria-hidden="true"></i> 
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
                        
                    </div>
                    <!-- /.row (nested) -->
           
                
            </div>
            <!-- /.panel -->
        </div>

        <?php

        if ($estoque_mov) : 
        ?>
        
            <div class="col-lg-12">
                <div class="panel panel-default panel-mov-est">
                    <div class="text-left">

                        <?php
                        foreach ($produto_est_mov as $produto_mv):
                            $desproduto = $produto_mv->desproduto; 
                            $codproduto = $produto_mv->codproduto; 

                        endforeach; 

                        foreach ($estoque_mov as $estov) :
                            // pegar data inicial 
                            if ($estov == reset($estoque_mov)):
                                $datainicial=date("d/m/Y", strtotime($estov->datamovimento));
                            endif;
                            // pegar data final 
                            if ($estov == end($estoque_mov)):
                                $datafinal=date("d/m/Y", strtotime($estov->datamovimento));
                            endif; 
                        endforeach; 
                        ?> 

                        <div class="title-itens-mov col-lg-12">
                            <div class="col-lg-12">
                                <h4 class= "title-itens-nota">
                                    <?php echo "  Movimento(s) do Produto :  <b> ". $codproduto." - ".$desproduto."</b>"?> 
                                </h4>
                            </div>
                            <div class="col-lg-6">
                                <h4 class= "title-itens-nota"> 
                                    <?php echo "Periodo do Movimento : <b>".$datainicial." a ".$datafinal."</b>" ?> 
                                </h4>
                            </div>
                            <div class="col-lg-6">
                                <h4 class= "title-itens-nota title-saldo"> 
                                    <?php echo "  Saldo Atual :  <b> ".$estoque_saldo_atual."</b>"
                                ?> 
                                </h4>
                            </div>
                        </div>

                    </div>
                    <div class="panel-body">
                        <div class="row">
                                              
                                <!-- gerar tabela de categorias pela framework PJCS --> 
                                <?php

                                $this->table->set_heading("Nr Nota","Dt/Ho Movimento","Tp Movimento","Qtd Entrada","Qtd Saida","Saldo"); 
                                ?>
                                
                                <div class="col-lg-12 panel-estoque-scroll">
                                <?php
                                foreach ($estoque_mov as $movimento)
                                { 
                                    $nrnota = $movimento->nrnota;  
                                    $tipomovimento = $movimento->tipomovimento;
                                    $desmovimento  = $movimento->desmovimento; 
                                   
                                    if ($tipomovimento ==1 || $tipomovimento ==2 ){
                                        $qtd_entrada    = $movimento->quantidade;
                                        $desmovimento   = '<p class="field-qt-entrada">'.$desmovimento.'</p>';
                                    } else {
                                        $qtd_entrada    = 0;
                                    }
                                    $qtd_entrada    = '<p class="field-qt-entrada">'.$qtd_entrada.'</p>';

                                    if ($tipomovimento ==3 || $tipomovimento ==4){
                                        $qtd_saida      = $movimento->quantidade;
                                        $desmovimento   = '<p class="field-qt-saida">'.$desmovimento.'</p>';
                                    }else {
                                        $qtd_saida    = 0;
                                    }
                                    $qtd_saida    = '<p class="field-qt-saida">'.$qtd_saida.'</p>';

                                    $datamovimento = $movimento->datamovimento; 
                                    $datamovimento=date("d/m/Y H:m", strtotime($datamovimento));

                                    $saldo  = $movimento->saldo; 
                                    $saldo    = '<p class="field-saldo">'.$saldo.'</p>';

                                    $this->table->add_row($nrnota, $datamovimento, $desmovimento, $qtd_entrada, $qtd_saida,  $saldo); 
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
        <?php
        else:
            if ($produto_est_mov):
                foreach ($produto_est_mov as $produto_mv):
                    $desproduto = $produto_mv->desproduto; 
                    $codproduto = $produto_mv->codproduto; 
                endforeach;
            ?>
                <h2 class= "text-center mens-nao-estoque"> 
                    Não ha Movimento no periodo informado, para o Produto :
                    <br> 
                    <b>
                        <?php echo $codproduto." - ".$desproduto?>
                    </b>
                </h2>
            <?php
            endif;
        endif; 
        ?>
    
    </div>
</div>


