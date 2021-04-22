<div class = "row">

    <?php
    // aqui vamos vericar os erros de validação
    echo validation_errors('<div class="alert alert-warning">','</div>'); 
    
    // vamos abrir o formulário,
                // apontando para:admin/controlador/metodo
    echo form_open('venda/finalizar_venda/1/'.$idcaixa.'','class="form-pag-money" id="form-pag-money"');

    ?>

    <div class = "text-center tipo-de-pagamento-escolha">
        <h2> Pagamento em Dinheiro </h2>
    </div>

    <?php
    // tela VALOR DA VENDA
    $this->load->view('frontend/template/valor-venda');
    ?>

    <div class = "col-lg-12 col-sm-12 titulo-tela-tipopag3">
        <div class="row panel-valores-money">
            <div class="col-lg-3 col-sm-12">
                <div class="form-group">
                    <h2> Valor Recebido R$ : </h2>
                </div>
            </div>
            <div class="col-lg-9 col-sm-12">
                <div class="form-group">
                    <h1 class="valor-recebido-venda">
                        <input id="vl_recebido_caixa" name="vl_recebido_caixa" type="number" class="form-control" placeholder ="0,00" step="0.01" autofocus="true" required>
                    </h1>
                  
                </div>
            </div> 

            <div class="col-lg-3 col-sm-12">
                <div class="form-group">
                    <h2> TROCO R$ : </h2>
                </div>
            </div>
            <div class="col-lg-9 col-sm-12">
                <div class="form-group">
                    <h1 class="valor-recebido-troco">
                        <!-- <?php echo $valortotal ?> --> 
                        <input id="vl_troco" name="vl_troco" type="text" class="form-control"  placeholder="0,00" step="0.01">
                    </h1>
                  
                </div>
            </div>
        </div>

        <div class="form-group col-lg-12 btn-link"> 
            <div class ="col-lg-6 col-sm-12 btn-finalizar-venda btn-finalizar-venda-money text-center">
                <a href="">
                    <button class="btn btn-success" type="submit" id="btn-concluir-pgto" > 
                        Concluir Pagamento
                    </button> 
                </a>
            </div>

            <div class ="col-lg-6 text-center link-voltar">
                <a href="<?php echo base_url('venda/venda_pagamento/').$idcaixa ?>" class="btn_click_shift_r" >
                     <i class="fa fa-reply-all"> </i>
                        Voltar para Escolher Pagamento  <b class="atalho-front"> sR </b>
                </a>
            </div>
        </div>
    
    </div>

    <?php 
        echo form_close();
    ?>
    
</div>


           

