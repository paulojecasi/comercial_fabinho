<div class = "row">

    <div class = "text-center tipo-de-pagamento-escolha tipo-de-pagamento-escolha-cliente">
        <h2> Cadastro e Manutenção de Clientes </h2>
    </div>

    <?php
    // tela VALOR DA VENDA
    //$this->load->view('frontend/template/valor-venda');
    ?>

    <div class = "col-lg-12 col-sm-12 tela-manutencao-cli">

        <?php
        // aqui vamos vericar os erros de validação
        echo validation_errors('<div class="alert alert-warning">','</div>'); 
        
        // vamos abrir o formulário,
        
        echo form_open('cliente/consulta_cliente/cliente');

        $idcliente  =  $this->session->userdata('idcliente');
        $nome       =  $this->session->userdata('nome');
        $apelido    =  $this->session->userdata('apelido');
        $cpf        =  $this->session->userdata('cpf');
        $endereco   =  $this->session->userdata('endereco');
        $pontoreferencia   =  $this->session->userdata('pontoreferencia');
        $vl_saldo   = $this->session->userdata('vl_saldo_devedor');

       // encerrar a secoes 
        $this->session->unset_userdata('idcliente');
        $this->session->unset_userdata('nome'); 
        $this->session->unset_userdata('apelido'); 
        $this->session->unset_userdata('cpf'); 
        $this->session->unset_userdata('endereco'); 
        $this->session->unset_userdata('pontoreferencia');
        $this->session->unset_userdata('vl_saldo_devedor');

        
        ?>
        
        <div class="panel-consulta-cliente col-lg-5">
           
            <div class="form-group nomecliente col-lg-12">
                <label for="nomecliente"> Informe o Cliente </label>
                <input type="text" id="nomecliente" name="nomecliente" class="form-control" autofocos required placeholder="Digite Codigo do Cliente, CPF ou Nome"  autofocus="true" />
                <br> 
            </div>

            <div class="form-group resultado_cli col-lg-12 " id="resultado_cli">
            </div>


            <input type="hidden" id="idcaixa" name="idcaixa"
            value= "<?php echo $idcaixa ?>" />

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
      
            <div class="panel2-consulta-cliente col-lg-7">
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
                <div class="form-group cliente_venda col-lg-12">
                    <label for="cliente_ende"> Ponto Referencia </label>
                    <input type="text" id="pontoreferencia" name="pontoreferencia" class="form-control" value = "<?php echo $pontoreferencia; ?>"  disabled />
                    <br> 
                </div>

                <div class="form-group cliente_venda col-lg-6">
                    <label for="cliente_saldo"> Saldo Devedor </label>
                    <input type="text" id="cliente_saldo" name="cliente_saldo" class="form-control" placeholder="0,00" value = "<?php echo reais($vl_saldo); ?>" disabled/>
                    <br> 
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
        echo form_close();
        ?>
             

        <div class="form-group col-lg-12 btn-link"> 
            
            <div class ="col-lg-4 col-sm-12 btn-finalizar-venda  btn-add-cliente text-center">
                <a href="<?php echo base_url('cliente/cadastro_cliente'); ?> ">
                    <button class="btn btn-success" type="submit"  > 
                        Cadastrar novo Cliente
                    </button> 
                </a>
            </div>


            <div class ="col-lg-4 text-center link-voltar link-voltar-tela-inicio">
                <a href="<?php echo base_url('venda') ?>">
                       <i class="fa fa-home" aria-hidden="true"></i> Tela Inicial
                </a>
            </div>

            <?php

            if ($idcliente):
                ?>
                <div class ="col-lg-4 col-sm-12 btn-finalizar-venda  btn-alterar-cliente text-center">
                    <a href="<?php echo base_url('cliente/altera_cliente/').md5($idcliente); ?>">
                        <button class="btn btn-success" type="submit" > 
                            Alterar dados do Cliente
                        </button> 
                    </a>
                </div>

                <?php
            endif;

            ?>
  
        </div>
    </div>
 

</div>


           

