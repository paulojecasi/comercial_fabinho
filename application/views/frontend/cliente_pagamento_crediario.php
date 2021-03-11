<div class = "row">

    <?php
    echo validation_errors('<div class="alert alert-warning">','</div>'); 
    
    foreach ($venda_cliente as $venda_cli) {
        $idvenda    = $venda_cli->idvenda;
        $valorvenda = reais($venda_cli->valorvenda);
        $vlsaldo_crediario = reais($venda_cli->vlsaldo_crediario);
        $vlsaldo_crediario_sem_conversao = $venda_cli->vlsaldo_crediario; 
        $datavenda  = datebr($venda_cli->datavenda); 
        $idcliente = $venda_cli->idcliente; 
        //$this->session->set_userdata('vl_saldo_devedor',$vlsaldo_crediario_sem_conversao);
    }  

    $nome       = $this->session->userdata('nome');
    $codigo     = $this->session->userdata('idcliente');

    echo form_open('cliente/pagamento_crediario_confirma/'.md5($idvenda).'/'.md5($idcliente),'class="form-pagamento-cred" id="form-pagamento-cred"') ;
    ?>

    <div class = "text-center tipo-de-pagamento-escolha tipo-de-pagamento-escolha-crediario">
        <h2> Pagamento de Crediário </h2>
    </div>


    <div class = "col-lg-12 col-sm-12 tela-pagamento-crediario">
        <div class="row">
            <section>
                <div class= "dados-venda col-lg-12">
                    <div class="col-lg-4 col-sm-12">
                        <div class="form-group">
                            <h3> Cliente: <b> <?php echo $codigo. " - " .$nome ?> </b> 
                            </h3>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12">
                        <div class="form-group">
                            <h3> Codigo da Venda:  <b> <?php echo $idvenda ?> </b>  
                            </h3>
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-12">
                        <div class="form-group">
                            <h3> Valor da Venda R$:  <b id="valor-venda-cred-pag"> <?php echo $valorvenda ?> </b>  
                            </h3>
                        </div>
                    </div>
                </div>
            </section>
            

            <div class="panel-recebidos-cred col-lg-6"> 

                <section id="recebido-cre">
                    <div class="col-lg-5 col-sm-12 campo-pag">
                        <h3>Valor Recebido R$ : </h3>
                    </div>
              
                    <div class="col-lg-7 col-sm-12">
                        <div class="form-group">
                            <h1 class="valor-recebido-venda-cred">
                                <input id="vl_recebido_caixa_cred" name="vl_recebido_caixa_cred" type="number" class="form-control" placeholder ="0" step="0.01" autofocus="true"  onkeydown="javascript:EnterTab('vl_juros_caixa_cred',event)" required>
                            </h1>
                        </div>
                    </div> 
                </section>

                <div id="juros-cre">
                    <div class="col-lg-5 col-sm-12 campo-pag">
                        <h3>Valor Juros R$ : </h3>
                    </div>

                    <div class="col-lg-7 col-sm-12">
                        <div class="form-group">
                            <h1 class="valor-juros-venda-cred">
                                <input id="vl_juros_caixa_cred" name="vl_juros_caixa_cred" type="number" class="form-control" placeholder ="0" step="0.01" autofocus="true"  onkeydown="javascript:EnterTab('vl_desconto_caixa_cred',event)">
                            </h1>
                        </div>
                    </div>
                </div>

                <section id = "desconto-cre">
                    <div class="col-lg-5 col-sm-12 campo-pag">
                        <h3>Valor Desconto R$ : </h3>
                    </div>

                    <div class="col-lg-7 col-sm-12">
                        <div class="form-group">
                            <h1 class="valor-desconto-venda-cred">
                                <input id="vl_desconto_caixa_cred" name="vl_desconto_caixa_cred" type="number" class="form-control" placeholder ="0" step="0.01" autofocus="true"  onkeydown="javascript:EnterTab('idpagamento',event)">
                            </h1>
                        </div>
                    </div>
                </section>

                <section id ="tipopag-cre">
                    <div class="col-lg-5 col-sm-12 campo-pag">
                        <h3> Tipo Pagamento: </h3>
                    </div>

                    <div class="form-group col-lg-7 tipo-pagamento-cred">
                        <select class="form-control" id="idpagamento" name="idpagamento"  onkeydown="javascript:EnterTab('vl_recebido_caixa_cred',event)">
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

            </div>

            <div class= "panel-recebidos-cred2 col-lg-6">
                <section>
                    <div class="col-lg-5 col-sm-12 campo-pag">
                            <h3> Valor Divida R$ : </h3>
                    </div>
                    <div class="col-lg-7 col-sm-12">
                        <div class="form-group">
                            <h1>
                                <?php echo $vlsaldo_crediario ?>
                            </h1>

                            <input id="vl_saldo_crediario" name="vl_saldo_crediario" type="hidden" class="form-control"  step="0.01" placeholder ="0.00" value = "<?php echo $vlsaldo_crediario_sem_conversao ?>"  >
                          
                        </div>
                    </div>
                </section>

                <section>
                    <div class="col-lg-5 col-sm-12 campo-pag">
                        <h3> Divida Atualizada R$ : </h3>
                    </div>

                    <div class="col-lg-7 col-sm-12">
                        <div class="form-group">
                            <h1 class="valor-saldo-atual-cred">
                                <!-- <?php echo $valortotal ?> --> 
                                <input id="vl_saldo_atual" name="vl_saldo_atual" type="text" class="form-control"  step="0.01"  placeholder="0,00" value="<?php echo $vlsaldo_crediario ?>" disabled>
                            </h1>

                            <input id="vl_real_amortizacao" name="vl_real_amortizacao" type="hidden" class="form-control"  value = "<?php echo $vlsaldo_crediario_sem_conversao ?>"  >
                          
                        </div>
                    </div>
                </section>

                <section>
                    <div class="col-lg-5 col-sm-12 campo-pag">
                        <h3> TROCO R$ : </h3>
                    </div>
                    <div class="col-lg-7 col-sm-12">
                        <div class="form-group">
                            <h1 class="valor-recebido-troco-cred"> 
                                <!-- <?php echo $valortotal ?> --> 
                                <input id="vl_troco_cred" name="vl_troco_cred" type="text" class="form-control"  step="0.01"  placeholder="0,00">
                            </h1>
                          
                        </div>
                    </div>
                </section>
                
            </div>

        </div>

        <div class="col-lg-6 total-pagto-cre"> 
            <section id="recebido-cre">
                <div class="col-lg-5 col-sm-12 campo-pag">
                    <h3> Total Pagamento R$ : </h3>
                </div>
          
                <div class="col-lg-7 col-sm-12">
                    <div class="form-group">
                        <h1 class="valor-total-venda-cred">
                            <input id="vl_total_pag_cred" name="vl_total_pag_cred" type="text" class="form-control" placeholder ="0" step="0.01" disabled>
                        </h1>
                    </div>
                </div> 
            </section>
        </div>



        <div class="form-group col-lg-6 btn-link"> 
            <section class = "btn-retorno-pag-cred">
                <div class ="col-lg-5 col-sm-12 btn-finalizar-venda  text-center">
                    <a href="">
                        <button class="btn btn-success" type="submit" id="btn-pagamento-cred" > 
                            Concluir Pagamento
                        </button> 
                    </a>
                </div>

                <?php 
                 
                    $link_retorno = base_url('cliente/consulta_crediario/').md5($idcliente).'/cliente';
                    
                ?>

                <div class ="col-lg-3 text-center link-voltar link-voltar-tela-inicio">
                    <a href="<?php echo $link_retorno ?>">
                           <i class="fa fa-reply" aria-hidden="true"></i> Voltar
                    </a>
                </div>

                <div class ="col-lg-4 text-center link-voltar link-voltar-tela-inicio">
                    <a href="<?php echo base_url('venda') ?>">
                           <i class="fa fa-home" aria-hidden="true"></i> Ir para Venda
                    </a>
                </div>
            </section>


        </div>
    
    </div>

    <?php 
        echo form_close();
    ?>
    
    
</div>


           

