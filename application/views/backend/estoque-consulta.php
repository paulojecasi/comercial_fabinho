<div id="page-wrapper">
   

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default panel-dados-cons-estoque">
                <div class="panel-heading text-center title-cons">
                   <h4 class = "title-itens"> <?php echo "Informe o Produto Para Consulta do Movimento de Estoque" ?> </h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                        <?php 

                            // aqui vamos vericar os erros de validação
                            echo validation_errors('<div class="alert alert-warning">','</div>'); 
                            
                            // vamos abrir o formulário,
                                        // apontando para:admin/controlador/metodo
                            echo form_open('admin/estoque/buscar_produto/consulta-estoque');

                            ?>
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

                               
                                <div class="form-group col-lg-6 campo-data">
                                    <label >Data Inicial</label>

                                    <input type="date" id="datainicial" name="datainicial" maxlength="10" class="form-control" value="<?php echo date('Y-m-d'); ?>" />

                                </div>
                          
                                <div class="form-group col-lg-6 campo-data">
                                    <label >Data Final</label>
                                   
                                    <input type="date" id="datafinal" name="datafinal" class="form-control" value="<?php echo date('Y-m-d'); ?>"/>
                                
                                </div>
                         
                                <div class ="col-lg-12 col-sm-12 text-center ">
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
                        
                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
                
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
                            <div class="col-lg-12">
                      
                                <!-- gerar tabela de categorias pela framework PJCS --> 
                                <?php

                                $this->table->set_heading("Nr Nota","Dt/Ho Movimento","Tp Movimento","Qtd Entrada","Qtd Saida","Saldo"); 

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
                    Não ha Estoque para o Produto 
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


















