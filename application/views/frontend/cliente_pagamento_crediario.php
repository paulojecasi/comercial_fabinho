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
        $this->session->set_userdata('vl_saldo_devedor',$vlsaldo_crediario_sem_conversao);
    }

    $nome       = $this->session->userdata('nome');
    $codigo     = $this->session->userdata('idcliente');

    echo form_open('cliente/pagamento_crediario_confirma/'.md5($idvenda)) ;
    ?>

    <div class = "text-center tipo-de-pagamento-escolha tipo-de-pagamento-escolha-crediario">
        <h2> Pagamento de Crediário </h2>
    </div>


    <div class = "col-lg-12 col-sm-12 tela-pagamento-crediario">
        <div class="row">

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

            <div class="col-lg-3 col-sm-12">
                <div class="form-group">
                    <h2> Valor Saldo R$ : </h2>
                </div>
            </div>
            <div class="col-lg-9 col-sm-12">
                <div class="form-group">
                    <h1 class="valorsaldo">
                        <?php echo $vlsaldo_crediario ?>
                    </h1>

                    <input id="vl_saldo_crediario" name="vl_saldo_crediario" type="hidden" class="form-control" placeholder ="0.00" value = "<?php echo $vlsaldo_crediario_sem_conversao ?>"  >
                  
                </div>
            </div>

            <div class="col-lg-3 col-sm-12">
                <div class="form-group">
                    <h2> Valor Recebido R$ : </h2>
                </div>
            </div>
            <div class="col-lg-9 col-sm-12">
                <div class="form-group">
                    <h1 class="valor-recebido-venda-cred">
                        <input id="vl_recebido_caixa_cred" name="vl_recebido_caixa_cred" type="number" class="form-control" placeholder ="0,00" step="0.01" autofocus="true">
                    </h1>
                  
                </div>
            </div> 

            <div class="col-lg-3 col-sm-12">
                <div class="form-group">
                    <h2> Saldo Atual R$ : </h2>
                </div>
            </div>
            <div class="col-lg-3 col-sm-12">
                <div class="form-group">
                    <h1 class="valor-saldo-atual-cred">
                        <!-- <?php echo $valortotal ?> --> 
                        <input id="vl_saldo_atual" name="vl_saldo_atual" type="text" class="form-control"  placeholder="0,00" value="<?php echo $vlsaldo_crediario ?>" disabled>
                    </h1>

                    <input id="vl_real_amortizacao" name="vl_real_amortizacao" type="number" class="form-control"  value = "<?php echo $vlsaldo_crediario_sem_conversao ?>"  >
                  
                </div>
            </div>

            <div class="col-lg-3 col-sm-12">
                <div class="form-group text-right">
                    <h2> TROCO R$ : </h2>
                </div>
            </div>
            <div class="col-lg-3 col-sm-12">
                <div class="form-group">
                    <h1 class="valor-recebido-troco-cred">
                        <!-- <?php echo $valortotal ?> --> 
                        <input id="vl_troco_cred" name="vl_troco_cred" type="text" class="form-control"  placeholder="0,00" disabled>
                    </h1>
                  
                </div>
            </div>
        </div>

        <div class="form-group col-lg-12 btn-link"> 
            <div class ="col-lg-6 col-sm-12 btn-finalizar-venda btn-finalizar-venda-money text-center">
                <a href="">
                    <!--
                    <button class="btn btn-success" type="submit" > 
                        Concluir Pagamento
                    </button>  -->
                </a>
            </div>

            <?php 
             
                $link_retorno = base_url('cliente/consulta_crediario/').md5($idcliente).'/cliente';
                
            ?>

            <div class ="col-lg-6 text-center link-voltar link-voltar-tela-inicio">
                <a href="<?php echo $link_retorno ?>">
                       <i class="fa fa-reply" aria-hidden="true"></i> Voltar
                </a>
            </div>
        </div>
    
    </div>
    
    
</div>


           

