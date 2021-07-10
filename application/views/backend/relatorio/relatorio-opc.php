<div id="page-wrapper">
    <div class="col-lg-12 text-center title-caixa_rel">
        <h4 class="page-header"> <?php echo "Informe Periodo e o tipo de relatório " ?>
            
        </h4>
    </div>
        <!-- /.col-lg-12 -->
     
   
    <div class="row panel-rel-cx">
        <div class="col-lg-12">
            <div class="panel-default panel-dados-rel-cx">
                 
                    <div class="row">
                        <div class="col-lg-12">
                        <?php 

                            // aqui vamos vericar os erros de validação
                            echo validation_errors('<div class="alert alert-warning">','</div>'); 
                            
                            // vamos abrir o formulário,
                                        // apontando para:admin/controlador/metodo
                            echo form_open('admin/relatorios/rel_opc','autocomplete="off"');

                            ?>

                            <input class="form-caixa-rel" value="11" type="hidden" id="form-caixa-rels">
                            <div class="panel-body back-color-default">
                                
                                <section id="label-cons-est">
                                    <div class="form-group col-lg-2">
                                      <label for="caixas"> Caixa </label>
                                      <select class="form-control" id="idcaixa_rel" name="idcaixa_rel"  onkeydown="javascript:EnterTab('datainicial_rel',event)">
                                    
                                        <?php foreach ($lista_caixas as $caixa)
                                        {
                                        ?>
                                            <option value ="<?php echo $caixa->numerocaixa ?> ">
                                               <?php echo $caixa->numerocaixa ?>
                                            </option>
                    
                                        <?php 
                                        }
                                        ?>
                                      
                                      </select>
                                    </div>
                                    <div class="form-group col-lg-5 campo-data-rel">
                                        <label >Data Inicial</label>
                                        <input type="date" id="datainicial_rel" name="datainicial_rel" maxlength="10" class="form-control" value="<?php echo date('Y-m-d', strtotime('-1 month')); ?>"  onkeydown="javascript:EnterTab('datafinal_rel',event)" autofocus="true" />

                                    </div>
                              
                                    <div class="form-group col-lg-5 campo-data-rel">
                                        <label >Data Final</label>
                                        <input type="date" id="datafinal_rel" name="datafinal_rel" class="form-control" value="<?php echo date('Y-m-d'); ?>"  onkeydown="javascript:EnterTab('nomeproduto',event)" autofocus="true" />
                                    
                                    </div>
                                </section>

                                

                                <!-- 
                                <section id="opc-rel-cx" class="form-group col-lg-12">
                                    <br>
                                    <div class="form-group col-lg-4 col-sm-2 check-relatorio text-center">
                                        <label> Fechamento do Caixa </label>
                                        <br>
                                        <input class="form-check-input-rel check-rel" type="checkbox" id="check-rel-fechamento-cx" name="opc-rel-caixa" value="1">
                                    </div>

                                    <div class="form-group col-lg-4 col-sm-2 check-relatorio text-center">
                                        <label> Compra-Venda-Lucro / Por Produto</label>
                                        <br>
                                        <input class="form-check-input-rel check-rel" type="checkbox" id="check-rel-vendas-prod-cx" name="opc-rel-caixa" value="2">
                                    </div>

                                    <div class="form-group col-lg-4 col-sm-2 check-relatorio text-center nao-def">
                                        <label> Não Definido </label>
                                        <br>
                                        <input class="form-check-input-rel check-rel" type="checkbox">
                                    </div>
                                    <div class="form-group col-lg-4 col-sm-2 check-relatorio text-center" >
                                        <b class="cre"> CREDIÁRIO </b> <label>  - TODOS / Por produto </label>
                                        <br>
                                        <input class="form-check-input-rel check-rel" type="checkbox" id="check-rel-vendas-cred" name="opc-rel-caixa" value="3">
                                    </div>
                                    <div class="form-group col-lg-4 col-sm-2 check-relatorio text-center" >
                                        <b class="cre"> CREDIÁRIO </b> <label>  - QUITADOS / Por produto </label>
                                        <br>
                                        <input class="form-check-input-rel check-rel" type="checkbox" id="check-rel-vendas-cred-q" name="opc-rel-caixa" value="4">
                                    </div>
                                    <div class="form-group col-lg-4 col-sm-2 check-relatorio text-center" >
                                        <b class="cre"> CREDIÁRIO </b> <label>  - NÃO PAGOS / Por produto </label>
                                        <br>
                                        <input class="form-check-input-rel check-rel" type="checkbox" id="check-rel-vendas-cred-a" name="opc-rel-caixa" value="5">
                                    </div>

                                    <div class="form-group col-lg-4 col-sm-2 check-relatorio text-center" >
                                        <b class="cre"> CREDIÁRIO </b> <label> -Vendidos & Recebidos / Por Venda</label>
                                        <br>
                                        <input class="form-check-input-rel check-rel" type="checkbox" id="check-rel-vendas-cred-rec" name="opc-rel-caixa" value="6">
                                    </div>
                                    
                                    <div class="form-group col-lg-4 col-sm-2 check-relatorio text-center nao-def">
                                        <label> Não Definido </label>
                                        <br>
                                        <input class="form-check-input-rel check-rel" type="checkbox">
                                    </div>
                                    <div class="form-group col-lg-4 col-sm-2 check-relatorio text-center nao-def">
                                        <label> Não Definido </label>
                                        <br>
                                        <input class="form-check-input-rel check-rel" type="checkbox">
                                    </div>
                                    <div class="form-group col-lg-4 col-sm-2 check-relatorio text-center nao-def">
                                        <label> Não Definido </label>
                                        <br>
                                        <input class="form-check-input-rel check-rel" type="checkbox">
                                    </div>

                                </section>
                            -->
                                <section class= "col-lg-12" id="select-relatorio-section">
                                    <div class="col-lg-4 text-center select-relatorio"> 
                                            <h4> Selecione o tipo de relatório </h4>
                                    </div>
                                    <div class="col-lg-6 text-center select-relatorio"> 
                                        <?php $posic =0 ?>
                                        <select class="form-select" name= "opc-rel-caixa" id= "opc-rel-caixa">
                                            <option value="1" selected>       <?php $posic = $posic+1; echo $posic." - ";?> CAIXA  - Fechamento do Caixa detalhado</option>
                                            <option value="7"> <b class="cre"><?php $posic = $posic+1; echo $posic." - ";?> CREDIÁRIO </b> - Clientes por faixa de dias de atraso </option>
                                            <option value="5"> <b class="cre"><?php $posic = $posic+1; echo $posic." - ";?> CREDIÁRIO </b> - NÃO PAGOS / Por produto </option>
                                            <option value="3"> <b class="cre"><?php $posic = $posic+1; echo $posic." - ";?> CREDIÁRIO </b> - TODOS     / Por produto </option>
                                            <option value="4"> <b class="cre"><?php $posic = $posic+1; echo $posic." - ";?> CREDIÁRIO </b> - QUITADOS  / Por produto </option>
                                            <option value="6"> <b class="cre"><?php $posic = $posic+1; echo $posic." - ";?> CREDIÁRIO </b> - Vendidos & Recebidos / Por Venda e Cliente </option>
                                            <option value="2">                <?php $posic = $posic+1; echo $posic." - ";?> VENDAS - Custo / Venda / Lucro</option>
                                        </select>
                                    </div>
                                </section>

                                <section>
                                    <div class="col-lg-12 text-center btn-rel-gera">
                                        <br> 
                                        <a href="">
                                            <button class="btn btn-primary person" id="btn-gera-rel" type="submit" > 
                                                Gerar Relatório 
                                                <i class="fa fa-file-text-o" aria-hidden="true"></i>
                                            </button> 
                                        </a>
                                    </div>
                                   
                                </section>
                              
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

       
    </div>
</div>


