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

        $idcliente  =  $this->session->userdata('idcliente');
        $nome       =  $this->session->userdata('nome');
        $apelido    =  $this->session->userdata('apelido');
        $cpf        =  $this->session->userdata('cpf');
        $endereco   =  $this->session->userdata('endereco');
       // encerrar a secoes 
        $this->session->unset_userdata('idcliente');
        $this->session->unset_userdata('nome'); 
        $this->session->unset_userdata('apelido'); 
        $this->session->unset_userdata('cpf'); 
        $this->session->unset_userdata('endereco'); 

        // aqui vamos vericar os erros de validação
        echo validation_errors('<div class="alert alert-warning">','</div>'); 
        
        // vamos abrir o formulário,
        
        echo form_open('cliente/consulta_cliente');
        
        ?>
        
        <div class="panel-consulta-cliente col-lg-6">
            <div class= "panel-top-cliente col-lg-12">
                <div class="form-group valor-venda-crediario col-lg-6">
                    <h4>
                        Valor da Venda R$: <b>  <?php echo reais($valortotal) ?> </b>
                    </h4>
                </div>
                <div class="form-group cadastro-cliente-crediario col-lg-6 text-center">
                    <a href = "">
                        <h4>
                             <!-- texto está no AFTER do CSS --> 
                        </h4>
                    </a>
                </div>
            </div>

            <div class="form-group nomecliente col-lg-12">
                <label for="nomecliente"> Informe o Cliente </label>
                <input type="text" id="nomecliente" name="nomecliente" class="form-control" autofocos required placeholder="Digite Codigo do Cliente, CPF ou Nome"  autofocus="true" />
                <br> 
            </div>

            <div class="form-group resultado_cli col-lg-12 " id="resultado_cli">
            </div>


            <input type="hidden" id="idcaixa" name="idcaixa"
            value= "<?php echo $id_caixa ?>" />

            <div class="form-group"> 
                <div class ="col-lg-12 btn-consulta-cliente">
                    <a href="">
                        <button class="btn btn-info btn-consulta btn_buscar_cliente" id="btn_buscar" name="btn_buscar"> <?php echo img(base_url('assets/frontend/img/lupa.png')); ?>
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
                <div class="form-group cliente_venda col-lg-12">
                    <label for="cliente_venda"> Cliente </label>
                    <input type="text" id="cliente_venda" name="cliente_venda" class="form-control" value = "<?php echo $nome; ?>" disabled />
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
                    <input type="number" id="cliente_saldo" name="cliente_saldo" class="form-control" placeholder="0,00" disabled/>
                    <br> 
                </div>

                <div class="form-group col-lg-6">
                    <input type="hidden" id="idcliente" name="idcliente" value = "<?php echo $idcliente ?>"/>   
                </div>

                <div class="form-group cadastro-cliente-aberto col-lg-6 text-center">
                    <a href = "">
                        <h4>
                             <!-- texto está no AFTER do CSS --> 
                        </h4>
                    </a>
                </div>
        
            </div>
            <?php
        endif 
        ?>
 
    

        <?php 
        // fechar o formulario 
            echo form_close();
        ?>
       
      

        <div class="form-group col-lg-12 btn-link"> 
            <div class ="col-lg-6 col-sm-12 btn-finalizar-venda  btn-finalizar-venda-cliente text-center">
                <a href="<?php echo base_url('venda/finalizar_venda/').'4/'.$id_caixa ?>">
                    <button class="btn btn-success" type="submit" > 
                        Concluir Venda Crediário
                    </button> 
                </a>
            </div>

            <div class ="col-lg-6 text-center link-voltar">
                <a href="<?php echo base_url('venda/venda_pagamento/').$id_caixa ?>">
                     <?php echo img(base_url('assets/frontend/img/voltar2.png')); ?>
                        Voltar para Escolher Pagamento
                </a>
            </div>
        </div>
    </div>
 

</div>


           

