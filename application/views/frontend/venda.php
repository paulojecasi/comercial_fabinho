
<div class = "row panel-geral-vendas">
    <div class = "col-lg-6 col-sm-6 panel-geral-vendas1">
        <div class="panel-vendas1">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12 col-sm-12 area-vendas1">

                        <?php  
                        // encerrar a secoes 
                        $this->session->unset_userdata('idcliente');
                        $this->session->unset_userdata('nome');
                        $this->session->unset_userdata('apelido'); 
                        $this->session->unset_userdata('cpf'); 
                        $this->session->unset_userdata('endereco'); 
                        $this->session->unset_userdata('pontoreferencia');
                        $this->session->unset_userdata('vl_saldo_devedor');

                        
                        // aqui vamos vericar os erros de validação
                        echo validation_errors('<div class="alert alert-warning">','</div>'); 
                        
                        // vamos abrir o formulário,
                                    // apontando para:admin/controlador/metodo
                        echo form_open('admin/estoque/buscar_produto/venda','id="form-caixa-vendas" autocomplete="off"');

                        ?>
                 
                        <div class="form-group nomeproduto ">
                            <label for="nomeproduto"> <i class="fa fa-search" aria-hidden="true"></i>  Pesquise Produto </label>
                            <input type="text" id="nomeproduto" name="nomeproduto" class="form-control nomeproduto" autofocos required placeholder="Passe o Leitor de Codigo de Barras, Descrição ou Codigo do Produto" onkeydown="javascript:EnterTab('idproduto_res',event)" autofocus="true" />
                            <br> 
                        </div> 
                        

                        <div class ="resultado-produto-venda form-group col-lg-12">
                            <div class= "form-group picklist-prod resultado select-item-venda" id="resultado" onkeydown="javascript:EnterTab('btn_buscar_item_venda',event)">
                                <select multiple class="form-control" id="idproduto_res" name="idproduto_res" size="6">
                                    
                                <option id="option-primeira-linha" disabled> CÓDIGO   &nbsp &nbsp   DESCRIÇÃO </option>

                                </select>
                            </div>
                        </div>


                        <div class="form-group"> 
                            <div class="col-lg-7 quantidade-ites text">
                                <label> Quantidade - <b class="atalho-front"> sF1 </b>  </label>
                                <input id="quantidade" name="quantidade" type="number" class="form-control" value="1,00" step="0.01" onkeydown="javascript:EnterTab('nomeproduto',event)">
                            </div>
                        </div>
                       

                        <div class="form-group"> 
                            <div class ="col-lg-5 text-center">
                                
                                    <button type="button" class="btn btn-info btn-consulta btn_buscar" id="btn_buscar_item_venda" name="btn_buscar_item_venda" onkeydown="javascript:EnterTab('nomeproduto',event)"> 
                                    <i class="fa fa-search" aria-hidden="true"></i> 
                                    Buscar
                                    </button> 
                                
                            </div>
                        </div>

                        <input type="hidden" id="lista_itens_temp_venda" name="lista_itens_temp_venda"
                                class="form-control" value = "<?php echo $idcaixa ?>" />

                    
                        <?php 
                        // fechar o formulario 
                        echo form_close();

                    ?>
                   
                    </div> 

                    <div>


                        <?php

                        $idcaixa = 1;  
                      
                        echo form_open('venda/venda_pagamento/'.$idcaixa);

                        ?> 

                       
                        <div class= "tela-numero-itens input-precos">
                            <div class="form-group col-lg-4 col-sm-12">  
                                <label> Nr Itens </label>
                                <!-- <h1> <?php echo $numero_itenst ?> </h1> -->
                                <input type="text" class = "quantidadeitens" id="quantidadeitens"/>
                                
                            </div>
                        </div>

                        <div class= "tela-preco-desconto input-precos">
                            <div class="form-group col-lg-4 col-sm-12">  
                                <label> Valor Desconto R$ </label>
                                <input type="text" class = "venda-desconto" id="venda-desconto" step="0,01"/>
                                
                            </div>
                        </div>
                        
                         <div class= "tela-preco-acrescimo input-precos">
                            <div class="form-group col-lg-4 col-sm-12">  
                                <label> Valor Acréscimo R$ </label>
                                <input type="text" class = "venda-juros" id="venda-juros" step="0,01"/>
                            </div>
                        </div>
                  

                        <div class= "tela-preco-total input-precost">
                            <div class="form-group col-lg-8 col-sm-12">  
                                <label> Valor Total Compra R$ </label>
                                <input type="text" class = "vl-venda-total" id="vl-venda-total" step="0,01" />
                                
                            </div>
                        </div>

                    
                        <div class ="col-lg-4 col-sm-12 btn-finalizar-venda" id="btn-venda">
                            <a href="">
                                <button class="btn btn-success btn_click_shift_f2" type="submit" id="btn-finaliza-venda" > 
                                    Finalizar Venda <b class="atalho-front"> sF2 </b>
                                </button> 
                            </a>
                        </div>
                        
                        <?php
                        // fechar o formulario 
                        echo form_close();
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-sm-6 panel-geral-vendas2">

        <div class="col-lg-12 col-sm-12 panel-vendas2">
        <?php
            echo form_open('admin/estoque/inserir_estoque_item');

                ?> 

            <div class = "panel-item-escolhido">
                <div class="form-group col-lg-12 descricao-prod-cx"> 
                    <input value= "Informe Produto" class="descricao-prod-caixa" id = "descricao-prod-caixa"/>
                </div>

                <div class= "desc-precos-compras">
                    <div class="form-group col-lg-5 col-sm-5">  
                        <label> Valor Unitario R$ </label>
                         <input type="text" class = "vl_unitario_ult" id="vl_unitario_ult" step="0,01"/>
                    </div>

                    <div class="form-group col-lg-2 col-sm-12">  
                        <label> Quantidade </label>
                        <input type="text" class = "quantidadeitens_ult" id="quantidadeitens_ult" step="0,01">
                    </div>

                    <div class="form-group col-lg-5 col-sm-12">  
                        <label> Valor Total R$ </label>
                        <input type="text" class = "vl-venda-total_ult" id="vl-venda-total_ult" step="0,01"/>
                        
                    </div>
                </div>
            </div>

        </div>

        <div class="panel panel-default panel-vendas2-1">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                  
                        <table class="table table table-striped resultado_itens_temp" id="resultado_itens_temp"
                        >
                            <thead>
                                <tr>
                                    <th scope="col">COD</th>
                                    <th scope="col">DESCRIÇÃO</th> 
                                    <th scope="col">UNI</th> 
                                    <th scope="col">DESC</th> 
                                    <th scope="col">ACRES</th> 
                                    <th scope="col">QTD</th>
                                    <th scope="col">TOTAL</th> 
                                    <th scope="col"> ALT </th> 
                                    <th scope="col"> EXC</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                                        
                    </div>
                    
                </div>
                <!-- /.row (nested) -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
        <!-- /.col-lg-12 -->
</div>


