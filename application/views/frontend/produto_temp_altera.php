<div class = "panel-principal-altera-itens-da-venda">
    <div class="row">
        <div class="col-lg-12 text-center altera-itens-venda-titulo">
            <h2 class="page-header"> Alteraçao de Itens da Vendas </h2>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    <div class="row"> 
        <div class="col-lg-12">   
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12 panel-dados-item">

                    <!-- nao vamos utilizar a abertura do form, vamos usar o HELPER do
                    framework (form_open) --> 
          
                        <?php
                        // aqui vamos vericar os erros de validação
                        echo validation_errors('<div class="alert alert-warning">','</div>'); 
                        
                        // vamos abrir o formulário,
                                    // apontando para:admin/controlador/metodo
                        echo form_open('admin/produto/inserir');

                        foreach ($produto_temp_altera as $pro_ten_alt) :
                            $desc       = $pro_ten_alt->desproduto;
                            $codpro     = $pro_ten_alt->codproduto; 
                            $vlunit     = reais($pro_ten_alt->vlpreco);
                            $vldesc     = reais($pro_ten_alt->valordesconto);
                            $vlacres    = reais($pro_ten_alt->valoracrescimo);
                            $vltot      = reais($pro_ten_alt->valortotal);
                            $qtd        = $pro_ten_alt->quantidadeitens;  

                        ?> 

                            <div class="form-group col-lg-2">
                                <label> Codigo do Produto  
                                </label>
                                <input id="codproduto" name="codproduto" type="text"class = "form-control"  value="<?php echo $codpro ?>" disabled>
                            </div>

                            <div class="form-group col-lg-7">
                                <label> Descrição </label>
                                <input id="desproduto" name="desproduto" type="text"class = "form-control"  value="<?php echo $desc ?> " disabled> 
                            </div>

                            
                            <div class="form-group col-lg-3">  
                                <label> Valor Unitario </label>
                                <input type="text" class="form-control" id="vlpreco" name="vlpreco" step="0.01" placeholder="0.00" value="<?php echo $vlunit ?>" disabled>
                            </div>

                           
                            <div class="form-group col-lg-4"> 
                                <label> Quantidade de itens </label>
                                <input type="number" class="form-control" id="quantidadeitens" name="quantidadeitens" placeholder="0" value="<?php echo $qtd ?>" autofocus="true" >
                            </div>

                            
                            <div class="form-group col-lg-4">  
                                <label> Valor Desconto R$ </label>
                                <input type="number" class="form-control" id="valordesconto" name="valordesconto" step="0.01" placeholder="0.00" value="<?php echo $vldesc ?>">
                            </div>

                            <div class="form-group col-lg-4">  
                                <label> Valor Acrescimo R$  </label>
                                <input type="number" class="form-control" id="valoracrescimo" name="valoracrescimo" step="0.01" placeholder="0.00" value="<?php echo $vlacres ?>">
                            </div>

                            <div class="form-group col-lg-12 text-center">  
                                <label> Valor Total R$ </label>
                                <input type="text" class="form-control" id="valortotal" name="valortotal" step="0.01" placeholder="0.00" value="<?php echo $vltot ?>" disabled>
                            </div>

                        <?php 
                        endforeach;
                        ?> 
                       
                        <div class="form-group col-lg-12 btn-link"> 
                            <div class ="col-lg-6 col-sm-12 btn-finalizar-venda text-center">
                                <a href=" ">
                                    <button class="btn btn-success" type="submit" > 
                                        Aplicar alterações 
                                    </button> 
                                </a>
                            </div>

                            <div class ="col-lg-6 text-center link-voltar">
                                <a href="<?php echo base_url('venda') ?>">
                                     <?php echo img(base_url('assets/frontend/img/voltar2.png')); ?>
                                        Voltar para a Venda 
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
            <!-- /.panel-body -->
        </div>

        
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->