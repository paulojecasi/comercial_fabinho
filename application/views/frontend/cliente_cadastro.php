<div class = "row">

    <div class = "text-center titulo-tela-consulta-crediario">
        <h2> Cadastrar Cliente </h2>
    </div>

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
        echo validation_errors(
        '<h4> <div class="alert alert-warning text-center">','</div> </h4>'); 
        
        // vamos abrir o formulário,
        echo form_open('cliente/inserir/'.$localchamado.'','class="form-add-cliente" id="form-add-cliente"');
    ?> 

    <div class = "col-lg-12 col-sm-12 tela-manutencao-cli">


        <div class="panel2-cadastro-cliente col-lg-12">
            <div class="form-group cliente_venda col-lg-10">
                <label for="cliente_venda"> Cliente </label>
                <input type="text" id="nome" name="nome" class="form-control" value = "<?php echo set_value('nome'); ?>" required onkeydown="javascript:EnterTab('apelido',event)" autofocus="true"   />
                <br> 
            </div>

            <div class="form-group cliente_venda col-lg-2">
                <label for="cliente_apelido"> Código </label>
                <input type="text" id="idcliente" name="idcliente" class="form-control" value = "<?php echo set_value('idcliente'); ?>"  disabled />
                <br> 
            </div>

            <div class="form-group cliente_venda col-lg-6">
                <label for="cliente_apelido"> Apelido </label>
                <input type="text" id="apelido" name="apelido" class="form-control" value = "<?php echo set_value('apelido'); ?>"  onkeydown="javascript:EnterTab('cpf',event)" autofocus="true"  />
                <br> 
            </div>

            <div class="form-group cliente_venda col-lg-6">
                <label for="cliente_cpf"> CPF </label>
                <input type="text" id="cpf" name="cpf" class="form-control" value = "<?php echo set_value('cpf'); ?>" onkeydown="javascript:EnterTab('endereco',event)" autofocus="true"  />
                <br> 
            </div>

            <div class="form-group cliente_venda col-lg-12">
                <label for="cliente_ende"> Endereço </label>
                <input type="text" id="endereco" name="endereco" class="form-control" value = "<?php echo set_value('endereco'); ?>"   onkeydown="javascript:EnterTab('pontoreferencia',event)" autofocus="true" />
                <br> 
            </div>
            <div class="form-group cliente_venda col-lg-12">
                <label for="cliente_ende"> Ponto Referencia </label>
                <input type="text" id="pontoreferencia" name="pontoreferencia" class="form-control" value = "<?php echo set_value('pontoreferencia'); ?>" onkeydown="javascript:EnterTab('nome',event)" autofocus="true" />
                <br> 
            </div>

        </div>
         
      
        <div class="form-group col-lg-12 btn-link-casdatrar-cliente"> 
            
            <?php 
            if ($localchamado == "crediario"):
                $link_retorno =  base_url('venda/venda_pagamento/').$idcaixa.'/4'; 
            else:
                $link_retorno =  base_url('cliente/manutencao_clientes');
            endif ;
            ?>

            <div class ="col-lg-6 text-center link-voltar link-voltar-tela-inicio">
                <a href="<?php echo $link_retorno ?>">
                       <i class="fa fa-reply" aria-hidden="true"></i> Voltar
                </a>
            </div>

            <div class ="col-lg-6 col-sm-12 btn-finalizar-venda  btn-add-cliente text-center">
                <a href="">
                    <button class="btn btn-success" type="submit" id="btn-add-cliente" > 
                        Cadastrar
                    </button> 
                </a>
            </div>

            <input type="hidden" id="idcliente_crediario" name="idcliente_crediario" value = ""/>  

         

        </div>
    </div>
    <?php 
        echo form_close();
    ?>
             
 

</div>


           

