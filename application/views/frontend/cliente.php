<div class = "row">

    <div class = "text-center titulo-tela-consulta-crediario">
        <h2> Cadastro e Manutenção de Clientes - Demonstração de Dividas </h2>
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
        
        echo form_open('cliente/consulta_cliente/cliente','id="form-cliente-crediario" autocomplete="off"');

        $idcliente  =  $this->session->userdata('idcliente');
        $nome       =  $this->session->userdata('nome');
        $apelido    =  $this->session->userdata('apelido');
        $cpf        =  $this->session->userdata('cpf');
        $endereco   =  $this->session->userdata('endereco');
        $pontoreferencia   =  $this->session->userdata('pontoreferencia'); 
        $vl_saldo   = $this->session->userdata('vl_saldo_devedor');

        // SESSOES SERÃO FECHADAS NO TEMPLATE "venda.php" e "cliente_cadastro.php"
        ?>
        
        <div class="panel-consulta-cliente col-lg-5">
            <div class ="form-group" id ="lista-cli-aberto">
                <?php
                if ($idcliente):
                    ?>
                    <a href="<?php echo base_url('cliente/manutencao_clientes/cliente_aberto') ?>">
                        <button class="btn btn-default" id="mostrar-clientes-aberto" value="1" type="button">
                            Mostrar Clientes com crédito aberto 
                            <i class="fa fa-hand-o-up" aria-hidden="true"></i> 
                        </button>
                    </a>
                    <?php
                endif;
                ?>

                <div id="mostrar-clientes-abertos" value="1" type="hidden"> 
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

            <div class ="resultado-cliente form-group col-lg-12">
                <div class= "form-group picklist-cliente resultado_cli" id="resultado_cli" onkeydown="javascript:EnterTab('btn_buscar',event)">
                    <select multiple class="form-control" id="idclientej" name="idclientej" size="8">
                        <option id="option-primeira-linha" disabled> CÓDIGO   &nbsp &nbsp   NOME </option>

                    </select>
                </div>
            </div>


            <input type="hidden" id="idcaixa" name="idcaixa"
            value= "<?php echo $idcaixa ?>" />

            <div class="form-group"> 
                <div class ="col-lg-12 btn-consulta-cliente">
                    <a href="">
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
                    <a href = "<?php echo base_url('cliente/consulta_crediario/').md5($idcliente).'/cliente'  ?> ">
                        <h4>
                             >> Consultar vendas em aberto
                        </h4>
                    </a>
                </div>
        
            </div>
            <?php
        else: 
        ?>
            <div class="col-lg-7 table-cliente-divida">
                <div class = "text-center">
                    <h4> CLIENTES COM CREDIÁRIO EM ABERTO </h3>
                </div>
                <table class="table table-hover" id="resultado_clientes"
                >
                    <thead>
                        <tr>
                            <th scope="col">CODIGO</th>
                            <th scope="col">NOME</th> 
                            <th scope="col">APELIDO</th> 
                            <th scope="col">CPF</th> 
                            <th scope="col">SALDO DEVEDOR</th> 
                            <th scope="col">CONSULTAR</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
                                
            </div>
 
    
        <?php 
        endif; 
        echo form_close();
        ?>
             

        <div class="form-group col-lg-12 btn-link-cadastro"> 
            
            <div class ="col-lg-4 col-sm-12 btn-finalizar-venda  btn-add-cliente text-center">
                <a href="<?php echo base_url('cliente/cadastro_cliente'); ?> ">
                    <button class="btn btn-success" type="submit"  > 
                        Cadastrar novo Cliente
                    </button> 
                </a>
            </div>


            <div class ="col-lg-4 text-center link-voltar link-voltar-tela-inicio">
                <a href="<?php echo base_url('venda') ?>" class="btn_click_shift_r">
                       <i class="fa fa-home" aria-hidden="true"></i> Ir para Venda <b class="atalho-front"> sR </b>
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

