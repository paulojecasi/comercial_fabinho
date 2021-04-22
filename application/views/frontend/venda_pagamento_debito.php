<div class = "row">

    <?php
    // aqui vamos vericar os erros de validação
    echo validation_errors('<div class="alert alert-warning">','</div>'); 
    
    //echo form_open('venda/finalizar_venda/1/'.$idcaixa.'','class="form-pag-money" id="form-pag-money"');

    ?>

    <div class = "text-center tipo-de-pagamento-escolha tipo-de-pagamento-debito">
        <h2> Pagamento no Cartão de Débito </h2>
    </div>

    <?php
    // tela VALOR DA VENDA
    $this->load->view('frontend/template/valor-venda');
    ?>

    <div class = "col-lg-12 col-sm-12 titulo-tela-tipopag4">

       
        <div class="col-lg-12 col-sm-12 card-debit text-center">
            <div class="form-group">
                <h3> 
                    Só confirme o pagamento após o cartão do Cliente ser aprovado 
            
                </h3>
                <br> 
                <h6> 
                     <b id="pisca">  Clique na Máquina para confirmar o pagamento </b>  
                </h6>
               
                <a href="<?php echo base_url('venda/finalizar_venda/2/').$idcaixa ?>"> 
                    <img class="img-fluid" src="<?php echo base_url('/assets/frontend/img/maquina.png') ?>" >
                </a> 
            </div>
        </div> 
 

        <section class="btn-retorno-pag-deb"> 
            <div class="form-group col-lg-12 btn-link"> 
                <div class ="col-lg-12 text-center link-voltar">
                    <a href="<?php echo base_url('venda/venda_pagamento/').$idcaixa ?>" class="btn_click_shift_r">
                         <i class="fa fa-reply-all"> </i>
                            Voltar para Escolher Pagamento <b class="atalho-front"> sR </b>
                    </a>
                </div>
            </div>
        </section>
    </div>
    <?php 
        //echo form_close();
    ?>
    
</div>
