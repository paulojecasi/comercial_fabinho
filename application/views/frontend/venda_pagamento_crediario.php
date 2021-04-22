<div class = "row">

    <div class = "text-center tipo-de-pagamento-escolha tipo-de-pagamento-escolha-crediario">
        <h2> Crediário </h2>
    </div>

    <?php
    // tela VALOR DA VENDA
    //$this->load->view('frontend/template/valor-venda');
    ?>

    <div class = "col-lg-12 col-sm-12 titulo-tela-tipopag2">

        <?php
        // aqui vamos vericar os erros de validação
        echo validation_errors('<div class="alert alert-warning">','</div>'); 
        
        // vamos abrir o formulário,
        
        echo form_open('cliente/consulta_cliente','id="form-crediario-venda-cli" autocomplete="off"');

        $idcliente  =  $this->session->userdata('idcliente');
        $nome       =  $this->session->userdata('nome');
        $apelido    =  $this->session->userdata('apelido');
        $cpf        =  $this->session->userdata('cpf');
        $endereco   =  $this->session->userdata('endereco');
        $vl_saldo   = $this->session->userdata('vl_saldo_devedor');

        ?>
        
        <div class="panel-consulta-cliente col-lg-6">
            <div class= "panel-top-cliente col-lg-12">
                <div class="form-group valor-venda-crediario col-lg-6">
                    <h4>
                        Valor da Venda R$: <b>  <?php echo reais($valortotal) ?> </b>
                    </h4>
                </div>
                <div class="form-group cadastro-cliente-crediario col-lg-6 text-center">
                    <a href = "<?php echo base_url('cliente/cadastro_cliente/crediario') ?>" class= "btn_click_shift_d">
                        <h4>
                            Cliente não tem CADASTRO?  <b class="atalho-front"> sD </b>
                        </h4>
                    </a>
                </div>
            </div>

            <div class="form-group nomecliente col-lg-12">
                <label for="nomecliente"> Informe o Cliente </label>
                <input type="text" id="nomecliente" name="nomecliente" class="form-control" autofocos required placeholder="Digite Codigo do Cliente, CPF ou Nome"  autofocus="true" onkeydown="javascript:EnterTab('idclientej',event)" />
                <br> 
            </div>

            <!--
            <div class="form-group resultado_cli col-lg-12 " id="resultado_cli" onkeydown="javascript:EnterTab('btn_buscar',event)">
            </div>
            -->

            <div class ="resultado-cliente-venda-cred form-group col-lg-12">
                <div class= "form-group picklist-cliente resultado_cli" id="resultado_cli" onkeydown="javascript:EnterTab('btn_buscar',event)">
                    <select multiple class="form-control" id="idclientej" name="idclientej" size="6">
                        <option id="option-primeira-linha" disabled> CÓDIGO   &nbsp &nbsp   NOME </option>

                    </select>
                </div>
            </div>


            <input type="hidden" id="idcaixa" name="idcaixa"
            value= "<?php echo $idcaixa ?>" />

            <div class="form-group"> 
                <div class ="col-lg-12 btn-consulta-cliente">
                    <a>
                        <button class="btn btn-info btn-consulta btn_buscar_cliente" id="btn_buscar" name="btn_buscar"> <i class="fa fa-search" aria-hidden="true"></i>
                            Buscar
                        </button> 
                    </a>
                </div>
            </div>
    
        </div>

        <?php
        if ($idcliente):
            ?>
      
            <div class="panel2-consulta-cliente col-lg-6">
                <div class="form-group cliente_venda col-lg-10">
                    <label for="cliente_venda"> Cliente </label>
                    <input type="text" id="cliente_venda" name="cliente_venda" class="form-control" value = "<?php echo $nome; ?>" disabled />
                    <br> 
                </div>

                <div class="form-group cliente_venda col-lg-2">
                    <label for="cliente_apelido"> Código </label>
                    <input type="text" id="cliente_codigo" name="cliente_codigo" class="form-control" value = "<?php echo $idcliente; ?>"  disabled />
                    <br> 
                </div>

                <div class="form-group cliente_venda col-lg-6">
                    <label for="cliente_apelido"> Apelido </label>
                    <input type="text" id="cliente_apelido" name="cliente_apelido" class="form-control" value = "<?php echo $apelido; ?>"  disabled />
                    <br> 
                </div>

                <div class="form-group cliente_venda col-lg-6">
                    <label for="cliente_cpf"> CPF </label>
                    <input type="text" id="cliente_cpf" name="cliente_cpf" class="form-control" value = "<?php echo $cpf; ?>"   disabled/>
                    <br> 
                </div>

                <div class="form-group cliente_venda col-lg-12">
                    <label for="cliente_ende"> Endereço </label>
                    <input type="text" id="cliente_ende" name="cliente_ende" class="form-control" value = "<?php echo $endereco; ?>"  disabled />
                    <br> 
                </div>

                <div class="form-group cliente_venda col-lg-6">
                    <label for="cliente_saldo"> Saldo Devedor </label>
                    <input type="text" id="cliente_saldo" name="cliente_saldo" class="form-control" placeholder="0,00" value = "<?php echo reais($vl_saldo); ?>" disabled/>
                    <br> 
                </div>


                <div class="form-group cadastro-cliente-aberto col-lg-6 text-center">
                    <a href = "<?php echo base_url('cliente/consulta_crediario/').md5($idcliente).'/pagamento'  ?>" class= "btn_click_shift_a">
                        <h4>
                             
                            >> Consultar vendas em aberto <b class="atalho-front"> sA </b>

                        </h4>
                    </a>
                </div>
        
            </div>
            <?php
        endif 
        ?>

        <?php 
        echo form_close();


        echo form_open('venda/finalizar_venda/4/'.$idcaixa);
        ?>
       
       <input type="hidden" id="idcliente_crediario" name="idcliente_crediario" value = "<?php echo $idcliente ?>"/>   
      

        <div class="form-group col-lg-12 btn-link"> 
            <div class ="col-lg-6 col-sm-12 btn-finalizar-venda text-center">
                <?php
                if ($idcliente):
                    ?>
                    <a href="">
                        <button class="btn btn-success" type="submit" > 
                            Concluir Venda Crediário
                        </button> 
                    </a>
                    <?php
                endif;
                ?>


            </div>

            <div class ="col-lg-6 text-center link-voltar">
                <a href="<?php echo base_url('venda/venda_pagamento/').$idcaixa ?>" class="btn_click_shift_r">
                     <i class="fa fa-reply-all"> </i>
                        Voltar para Escolher Pagamento <b class="atalho-front"> sR </b>
                </a>
            </div>
        </div>

        <?php 
        echo form_close();
        ?>
    </div>
 

</div>


           

