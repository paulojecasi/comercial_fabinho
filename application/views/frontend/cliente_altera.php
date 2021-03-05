<div class = "row">

    <div class = "text-center titulo-tela-consulta-crediario">
        <h2> Alteração de Dados do Cliente </h2>
    </div>

    <?php
        /*
        foreach ($cliente_consultado as $clienteC) {
            $codigo = $clienteC->idcliente;
            $nome   = $clienteC->nome;
            $apelido= $clienteC->apelido;
            $cpf    = $clienteC->cpf;
            $endereco= $clienteC->endereco;
            $pontoreferencia= $clienteC->pontoreferencia;
        }
        */

        $codigo     =  $this->session->userdata('idcliente');
        $nome       =  $this->session->userdata('nome');
        $apelido    =  $this->session->userdata('apelido');
        $cpf        =  $this->session->userdata('cpf');
        $endereco   =  $this->session->userdata('endereco');
        $pontoreferencia   =  $this->session->userdata('pontoreferencia');
   

        // aqui vamos vericar os erros de validação
        echo validation_errors(
        '<h4> <div class="alert alert-warning text-center">','</div> </h4>'); 
        
        // vamos abrir o formulário,
        
        echo form_open('cliente/confirma_alteracao/'.md5($codigo),'class="form-alt-cliente" id="form-alt-cliente"');
    ?> 

    <div class = "col-lg-12 col-sm-12 tela-manutencao-cli">


        <div class="panel2-cadastro-cliente col-lg-12">
            <div class="form-group cliente_venda col-lg-10">
                <label for="cliente_venda"> Cliente </label>
                <input type="text" id="nome" name="nome" class="form-control" value = "<?php echo $nome; ?>" required onkeydown="javascript:EnterTab('apelido',event)" autofocus="true"   />
                <br> 
            </div>

            <div class="form-group cliente_venda col-lg-2">
                <label for="cliente_apelido"> Código </label>
                <input type="text" id="idcliente" name="idcliente" class="form-control" value = "<?php echo $codigo; ?>"  disabled />
                <br> 
            </div>

            <div class="form-group cliente_venda col-lg-6">
                <label for="cliente_apelido"> Apelido </label>
                <input type="text" id="apelido" name="apelido" class="form-control" value = "<?php echo $apelido; ?>"  onkeydown="javascript:EnterTab('cpf',event)" autofocus="true"  />
                <br> 
            </div>

            <div class="form-group cliente_venda col-lg-6">
                <label for="cliente_cpf"> CPF </label>
                <input type="text" id="cpf" name="cpf" class="form-control" value = "<?php echo $cpf; ?>" onkeydown="javascript:EnterTab('endereco',event)" autofocus="true"  />
                <br> 
            </div>

            <div class="form-group cliente_venda col-lg-12">
                <label for="cliente_ende"> Endereço </label>
                <input type="text" id="endereco" name="endereco" class="form-control" value = "<?php echo $endereco; ?>"   onkeydown="javascript:EnterTab('pontoreferencia',event)" autofocus="true" />
                <br> 
            </div>
            <div class="form-group cliente_venda col-lg-12">
                <label for="cliente_ende"> Ponto Referencia </label>
                <input type="text" id="pontoreferencia" name="pontoreferencia" class="form-control" value = "<?php echo $pontoreferencia; ?>" onkeydown="javascript:EnterTab('nome',event)" autofocus="true" />
                <br> 
            </div>

        </div>
         
      
        <div class="form-group col-lg-12 btn-link-casdatrar-cliente"> 
            
            <?php 
                $link_retorno =  base_url('cliente/manutencao_clientes');
            ?>

            <div class ="col-lg-6 text-center link-voltar link-voltar-tela-inicio">
                <a href="<?php echo $link_retorno ?>">
                       <i class="fa fa-reply" aria-hidden="true"></i> Voltar
                </a>
            </div>

            <div class ="col-lg-6 col-sm-12 btn-finalizar-venda  btn-add-cliente text-center">
                <a href="">
                    <button class="btn btn-success" type="submit" id="btn-alt-cliente" > 
                        Aplicar Alterações 
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


           

