<div class = "row">

    <?php
    // aqui vamos vericar os erros de validação
    echo validation_errors('<div class="alert alert-warning">','</div>'); 
    
    //echo form_open('venda/finalizar_venda/1/'.$idcaixa.'','class="form-pag-money" id="form-pag-money"');

    ?>

    <div class = "text-center tipo-de-pagamento-escolha tipo-de-pagamento-externa pagto-pix">
        <h2> Pagamento via PIX - Transferencia </h2>
    </div>

    <?php
    // tela VALOR DA VENDA
    $this->load->view('frontend/template/valor-venda');
    ?>

    <div class = "col-lg-12 col-sm-12 titulo-tela-tipopag6">

       
        <div class="col-lg-12 col-sm-12 venda-externa text-center">
            <div class="form-group">
                <br/>
                <h3> 
                    Só <b> confirme </b> o pagamento após o valor do recebimento já estiver creditado na conta. 
                </h3>
                
                
                <div class ="col-lg-12 btn-finalizar-venda btn-finaliza-externa">
                    <a href="<?php echo base_url('venda/finalizar_venda/11/').$idcaixa ?>">
                        <button class="btn btn-success" type="submit" > 
                            Confirmar Pagamento 
                        </button> 
                    </a>
                </div>
               
            </div>
        </div> 
 

        <section class="btn-retorno-pag-deb"> 
            <div class="form-group col-lg-12 btn-link"> 
                <div class ="col-lg-12 text-center link-voltar">
                    <a href="<?php echo base_url('venda/venda_pagamento/').$idcaixa ?>" class="btn_click_shift_r">
                         <i class="fa fa-reply-all"> </i>
                            Voltar para Escolher Pagamento  <b class="atalho-front"> sR </b>
                    </a>
                </div>
            </div>
        </section>
    </div>
    <?php 
        //echo form_close();
    ?>
    
</div>
