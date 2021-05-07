<div class = "row"> 

    <?php
    echo validation_errors('<div class="alert alert-warning">','</div>'); 
    /*
    foreach ($venda_cliente as $venda_cli) {
        $idvenda    = $venda_cli->idvenda;
        $valorvenda = reais($venda_cli->valorvenda);
        $vlsaldo_crediario = reais($venda_cli->vlsaldo_crediario);
        $vlsaldo_crediario_sem_conversao = $venda_cli->vlsaldo_crediario; 
        $datavenda  = datebr($venda_cli->datavenda); 
        $idcliente = $venda_cli->idcliente; 
        //$this->session->set_userdata('vl_saldo_devedor',$vlsaldo_crediario_sem_conversao);
    }  */

    $nome       = $this->session->userdata('nome');
    $codigo     = $this->session->userdata('idcliente');
    $idvenda = "temp"; 

    echo form_open('cliente/pagamento_crediario_confirma/'.md5($codigo),'class="form-pagamento-cred" id="form-pagamento-cred"') ;
    ?>

    <div class = "col-lg-6 text-center tipo-de-pagamento-escolha tipo-de-pagamento-escolha-crediario">
        <h2> Pagamento de Crediário </h2>
    </div>
     
    <div class= "dados-cli col-lg-6 tipo-de-pagamento-escolha-crediario">
         
        <div class="form-group">
            <h4> Cliente: &nbsp <b> <?php echo $codigo. " - " .$nome ?> </b> 
            </h4>
        </div>
        
    </div>
    


    <div class = "col-lg-12 col-sm-12 tela-pagamento-crediario">
        <div class="row">

            <div class="col-lg-5 vendas-a-pagar">

                <div class="col-lg-12 panel-lista-vendas-pagamento">

                    <div class="form-group title-desc-vendas">
                        <div class="col-lg-1 title-desc">
                            <label> Sq</label>
                        </div>
                        <div class="col-lg-2 title-desc">
                            <label> Cod</label>
                        </div>
                        <div class="col-lg-3 title-desc">
                            <label> Valor Venda </label>
                        </div>
                        <div class="col-lg-3 title-desc">
                            <label> Valor Saldo</label>
                        </div>
                        <div class="col-lg-3 title-desc">
                            <label> Vl Pagamento</label>
                        </div>
                   
                        <?php
                    
                        $id_parcial =1; 
                        $valor_divida=0 ; 
                        foreach ($venda_cliente as $venda_cli) {
                            $idvenda    = $venda_cli->idvenda;
                            $valorvenda = $venda_cli->valorvenda;
                            $vlsaldo_crediario = reais($venda_cli->vlsaldo_crediario);
                            $vlsaldo_crediario_sc = $venda_cli->vlsaldo_crediario; 
                            $datavenda  = datebr($venda_cli->datavenda); 
                            $idcliente = $venda_cli->idcliente;

                            $valor_divida += $vlsaldo_crediario_sc; 

                            ?>
                            <div class="col-lg-1 info-vendas">
                                <?php echo $id_parcial  ?>
                            </div>
                            <div class="col-lg-1 info-vendas">
                                <?php echo $idvenda  ?>
                            </div>
                            <div class="col-lg-3 info-vendas">
                                <?php echo $valorvenda  ?>
                            </div>
                            <div class="col-lg-3 info-vendas info-saldo">
                                <?php echo $vlsaldo_crediario  ?>
                            </div>
                            <div class="col-lg-4 info-vendas">

                                <!-- id venda -->
                                <input type="hidden" name="<?php echo "id_ven_".$id_parcial ?>" id="<?php echo "id_ven_".$id_parcial ?>" 
                                    value="<?php echo $idvenda ?>">

                                <!-- vl saldo -->
                                <input type="hidden" 
                                    name="<?php echo "vl_ven_".$id_parcial ?>" 
                                    id="<?php echo "vl_ven_".$id_parcial ?>" 
                                    value="<?php echo $vlsaldo_crediario_sc ?>">

                                <input class= "" 
                                    type="number" id="<?php echo "pag_".$id_parcial ?>" 
                                    name="<?php echo "pag_".$id_parcial ?>" 
                                    value="<?php echo $vlsaldo_crediario_sc ?>"
                                    step ="0.01" 
                                    onkeydown="javascript:EnterTab('idpagamento',event)" required>
                            </div>


                            <?php 
                            $id_parcial++; 

                        }   

                        $valor_divida_sc = $valor_divida; 
                        $valor_divida = reais($valor_divida); 

                    //var_dump($venda_cliente); 
                    ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">   


                <div class= "panel-recebidos-cred2 col-lg-6">
                    <section>
                        <div class="col-lg-12 col-sm-12 campo-pag">
                                <h3> &nbsp Valor Pagamento R$ : </h3>
                        </div>
                        <div class="col-lg-12 col-sm-12">
                            <div class="form-group text-center valor-da-divida">
                                <h1 class="valor-recebido-troco-cred">
                                    <input id="vl_pg_crediario" name="vl_pg_crediario" type="text" class="form-control"  step="0.01" placeholder ="0.00" value = "<?php echo  $valor_divida ?>"  >
                                </h1>

                                <input id="vl_pg_crediariosc" name="vl_pg_crediariosc" type="hidden" class="form-control"  step="0.01" placeholder ="0.00" value = "<?php echo  $valor_divida_sc ?>"  >
                              
                            </div>
                        </div>
                    </section>


                    <section>
                        <div class="col-lg-12 col-sm-12 campo-pag">
                            <h3 id="campo-troco"> &nbsp TROCO R$ : </h3>
                        </div>
                        <div class="col-lg-12 col-sm-12 text-center">
                            <div class="form-group text-center">
                                <h1 class="valor-recebido-troco-cred"> 
                                    <!-- <?php echo $valortotal ?> --> 
                                    <input id="vl_troco_cred" name="vl_troco_cred" type="text" class="form-control"  step="0.01"  placeholder="0,00">
                                </h1>
                              
                            </div>
                        </div>
                    </section>
                    
                </div>                

                <div class="panel-recebidos-cred col-lg-6"> 

                    <section id ="tipopag-cre">
                        <div class="col-lg-5 col-sm-12 campo-pag">
                            <h3> Tipo Pag: </h3> 
                        </div>

                        <div class="form-group col-lg-7 tipo-pagamento-cred input-total-pag">
                            <select class="form-control" id="idpagamento" name="idpagamento"  onkeydown="javascript:EnterTab('vl_recebido_caixa_cred',event)" autofocus="true" >
                                <?php 
                                foreach ($tipo_pagamento as $tppagto): 
                                    $idpagamento    = $tppagto->id;
                                    $descricaopagt      = $tppagto->destipopagamento; 
                                ?> 
                                    <option  value =" <?php echo $idpagamento ?> "
                                    >
                                         <?php echo $descricaopagt ?>  
                                    </option>
                                <?php
                                endforeach; 
                                ?> 
                            </select>
                        </div>
                    </section>


                    <section id="recebido-cre">
                        <div class="col-lg-5 col-sm-12 campo-pag">
                            <h3>Vl Recebido R$ : </h3>
                        </div>
                  
                        <div class="col-lg-7 col-sm-12">
                            <div class="form-group input-total-pag">
                                <h1 class="valor-recebido-venda-cred">
                                    <input id="vl_recebido_caixa_cred" name="vl_recebido_caixa_cred" type="number" class="form-control" placeholder ="0" step="0.01"  onkeydown="javascript:EnterTab('vl_juros_caixa_cred',event)" required>
                                </h1>
                            </div>
                        </div> 
                    </section>

                    <section id="juros-cre">
                        <div class="col-lg-5 col-sm-12 campo-pag">
                            <h3>Vl Juros R$ : </h3>
                        </div>

                        <div class="col-lg-7 col-sm-12">
                            <div class="form-group input-total-pag">
                                <h1 class="valor-juros-venda-cred">
                                    <input id="vl_juros_caixa_cred" name="vl_juros_caixa_cred" type="number" class="form-control" placeholder ="0" step="0.01" autofocus="true"  onkeydown="javascript:EnterTab('vl_desconto_caixa_cred',event)">
                                </h1>
                            </div>
                        </div>
                    </section>

                    <section id = "desconto-cre">
                        <div class="col-lg-5 col-sm-12 campo-pag">
                            <h3>Vl Desconto R$ : </h3>
                        </div>

                        <div class="col-lg-7 col-sm-12">
                            <div class="form-group input-total-pag">
                                <h1 class="valor-desconto-venda-cred">
                                    <input id="vl_desconto_caixa_cred" name="vl_desconto_caixa_cred" type="number" class="form-control" placeholder ="0" step="0.01" autofocus="true"  onkeydown="javascript:EnterTab('idpagamento',event)">
                                </h1>
                            </div>
                        </div>
                    </section>

                    

                </div>

                <section class="total-pagto-cre col-lg-12" id="recebido-cre">
                    <div class="col-lg-3 col-sm-12 campo-pag">
                        <h3> Total Pagamento: </h3>
                    </div>
              
                    <div class="col-lg-7 col-sm-12">
                        <div class="form-group input-total-pag">
                            <h1 class="valor-total-venda-cred">
                                <input id="vl_total_pag_cred" name="vl_total_pag_cred" type="text" class="form-control" placeholder ="0" step="0.01" disabled>
                            </h1>
                        </div>
                    </div> 
                </section>

                <div class="form-group col-lg-12 btn-link"> 
                    <section class = "btn-retorno-pag-cred">
                        <div class ="col-lg-5 col-sm-12 btn-finalizar-venda btn-finalizar-pagto  text-center">
                            <a href="">
                                <button class="btn btn-success" type="submit" id="btn-pagamento-cred"> 
                                    Concluir Pagamento
                                </button> 
                            </a>
                        </div>

                        <?php 
                         
                            $link_retorno = base_url('cliente/consulta_crediario/').md5($codigo).'/cliente';
                            
                        ?>

                    
                        <div class ="col-lg-3 text-center link-voltar link-voltar-tela-inicio btn-finalizar-pagto">
                            <a href="<?php echo $link_retorno ?>">
                                   <i class="fa fa-reply" aria-hidden="true"></i> Voltar
                            </a>
                        </div>

                        <div class ="col-lg-4 text-center link-voltar link-voltar-tela-inicio btn-finalizar-pagto">
                            <a href="<?php echo base_url('venda') ?>">
                                   <i class="fa fa-home" aria-hidden="true"></i> Ir para Venda
                            </a>
                        </div>
                       
                    </section>
                </div>

            </div>

        </div>
    
    </div>

    <?php 
        echo form_close();
    ?>
    
    
</div>


           

