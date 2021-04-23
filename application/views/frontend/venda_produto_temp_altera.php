
    <div class="row panel-principal-altera-itens-da-venda"> 
         <div class="col-lg-12 text-center altera-itens-venda-titulo">
            <h2 class="page-header"> Alteraçao de Itens da Vendas </h2>
        </div>


        <div class="col-lg-12">   
            
            <?php
            // aqui vamos vericar os erros de validação
            echo validation_errors('<div class="alert alert-warning">','</div>'); 
            
            // vamos abrir o formulário,
                        // apontando para:admin/controlador/metodo
            echo form_open('venda/salvar_alteracoes_produto_temp','class="form-alt-produto-temp" id="form-alt-produto-temp"');

            foreach ($produto_temp_altera as $pro_ten_alt) :
                $id         = $pro_ten_alt->id; 
                $desc       = $pro_ten_alt->desproduto;
                $codpro     = $pro_ten_alt->codproduto; 
                $vlunit     = $pro_ten_alt->vlpreco;
                $vldesc     = reais($pro_ten_alt->valordesconto);
                $vlacres    = reais($pro_ten_alt->valoracrescimo);
                $vltot      = reais($pro_ten_alt->valortotal);
                $qtd        = $pro_ten_alt->quantidadeitens;  
                $qtdatacado = $pro_ten_alt->qtatacado;
                $vlatacado  = $pro_ten_alt->vlprecoatacado; 
                $vlvarejo   = $pro_ten_alt->vlpreco;

                $vlunit = $qtdatacado>$qtd ? $vlunit : $vlatacado; 

                $vlunit = reais($vlunit);    
            ?> 
            
                <input id="quantidade_da_venda" name="quantidade_da_venda" type="hidden"class = "form-control"  value="<?php echo $quantidade_da_venda ?> " disabled> 

                 <input id="saldo_atual_prod" name="saldo_atual_prod" type="hidden"class = "form-control"  value="
                 <?php echo $saldo_atual_prod ?> " disabled> 
             
                <div class="form-group col-lg-2">
                    <label> Codigo do Produto  
                    </label>
                    <input id="codproduto_alt" name="codproduto_alt" type="text"class = "form-control"  value="<?php echo $codpro ?>" disabled>
                </div>

                <div class="form-group col-lg-7">
                    <label> Descrição </label>
                    <input id="desproduto_alt" name="desproduto_alt" type="text"class = "form-control"  value="<?php echo $desc ?> " disabled> 
                </div>
                
                <div class="form-group col-lg-3">  
                    <label> Valor Unitario </label>
                    <input type="text" class="form-control" id="vlpreco_alt" name="vlpreco_alt" step="0.01" placeholder="0.00" value="<?php echo $vlunit ?>" readonly>
                    <input type="hidden" class="form-control" id="vlpreco_ata" name="vlpreco_ata" step="0.01" placeholder="0.00" value="<?php echo $vlatacado ?>">

                    <input type="hidden" class="form-control" id="vlpreco_var" name="vlpreco_var" step="0.01" placeholder="0.00" value="<?php echo $vlvarejo ?>">
                </div>

               
                <div class="form-group col-lg-4 input-alt-itens-venda"> 
                    <label> Quantidade de itens </label>
                    <input type="number" class="form-control" id="quantidadeitens_alt" name="quantidadeitens_alt" step="0.01" placeholder="0" value="<?php echo $qtd ?>" autofocus="true" onkeydown="javascript:EnterTab('valordesconto_alt',event)"  >
                    <input type="hidden" class="form-control" id="quantidadeitens_ata" name="quantidadeitens_ata" step="0.01" placeholder="0" value="<?php echo $qtdatacado ?>"   >
                </div>


                
                <div class="form-group col-lg-4 offset:3 input-alt-itens-venda">  
                    <label> Valor Desconto R$ </label>
                    <input type="number" class="form-control" id="valordesconto_alt" name="valordesconto_alt" step="0.01" placeholder="0,00" value="<?php echo $vldesc ?>"  onkeydown="javascript:EnterTab('valoracrescimo_alt',event)"  >
                </div>

                <div class="form-group col-lg-4 input-alt-itens-venda">  
                    <label> Valor Acrescimo R$  </label>
                    <input type="number" class="form-control" id="valoracrescimo_alt" name="valoracrescimo_alt" step="0.01" placeholder="0,00" value="<?php echo $vlacres ?>" onkeydown="javascript:EnterTab('quantidadeitens_alt',event)">
                </div>

                <div class="form-group col-lg-12 text-center input-alt-itens-vendat">  
                    <label> Valor Total R$ </label>
                    <input type="text" class="form-control" id="valortotal_alt" name="valortotal_alt" step="0.01" placeholder="0,00" value="<?php echo $vltot ?>">
                </div>

                <input type="hidden" id="id_produto_temp" name="id_produto_temp" value="<?php echo $id ?>" />
               
            <?php 
            endforeach;
            ?> 
           
            <div class="form-group col-lg-12 btn-link panel-btn-aplicar-voltar"> 
                <div class ="col-lg-6 col-sm-12 btn-finalizar-venda text-center">
                    <a href=" ">
                        <button class="btn btn-success" type="submit" id="btn-alt-produto_temp" > 
                            Aplicar alterações 
                        </button> 
                    </a>
                </div>

                <div class ="col-lg-6 text-center link-voltar">
                    <a href="<?php echo base_url('venda') ?>">
                         <i class="fa fa-reply-all"> </i>
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

