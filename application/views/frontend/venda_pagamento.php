<div class = "row">

    <?php
    // aqui vamos vericar os erros de validação
    echo validation_errors('<div class="alert alert-warning">','</div>'); 
    
    // vamos abrir o formulário,
                // apontando para:admin/controlador/metodo
    //echo form_open('home/venda_pagamento');

    // tela VALOR DA VENDA
    $this->load->view('frontend/template/valor-venda');
    ?>
   

    <div class = "panel-body tipo-de-pagamento col-lg-12"> 
        <div class = "text-center">
            <h2> Escolha a Forma de Pagamento </h2>
        </div>
        <div class = "col-lg-3 col-sm-6">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12 col-sm-12 ">
                        <div class="form-group text-center text-center avista">
                            <a href="<?php echo base_url('home/venda_pagamento/').$id_caixa.'/money' ?>">
                                <img  src="<?php echo base_url('/assets/frontend/img/avista.png') ?>" >
                            </a> 
                            <h4> Dinheiro  </h4>
                        </div>

                    </div> 

                </div>
            </div>
        </div>
        <div class = "col-lg-3 col-sm-6">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12 col-sm-12 ">
                        <div class="form-group nomeproduto text-center debito">
                            <a href="<?php base_url('home/venda_pagamentooo/').md5($id_caixa).'/money' ?>">
                                <img class="img-fluid" src="<?php echo base_url('/assets/frontend/img/card.png') ?>" >
                            </a> 
                             <h4> Cartão Débito </h4>
                        </div>
                    </div> 
                </div>
            </div>
             
        </div>
        <div class = "col-lg-3 col-sm-6 ">
            <div class="panel-body">
          
                <div class="row">
                    <div class="col-lg-12 col-sm-12 ">

                        <div class="form-group nomeproduto text-center credito">
                            <a href="<?php echo base_url('home'); ?>">
                                <img class="img-fluid" src="<?php echo base_url('/assets/frontend/img/credit.png') ?>" >
                            </a> 
                            <h4> Cartão Crédito </h4>
                        </div>

                    </div> 

                </div>
            </div>
        </div>

        <div class = "col-lg-3 col-sm-6">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12 col-sm-12">
                        <div class="form-group nomeproduto text-center crediario">
                            <a href="<?php echo base_url('home'); ?>">
                                <img class="img-fluid" src="<?php echo base_url('/assets/frontend/img/crediario.png') ?>" >
                            </a> 
                            <h4> Crediário </h4>
                        </div>

                    </div> 

                </div>
            </div>
        </div>
        <div class="form-group"> 
            <div class ="col-lg-12 text-center">
                <a href="<?php echo base_url('home') ?>">
                    <button class="btn btn-info voltar-venda" id="voltar-venda" name="voltar-venda"> <?php echo img(base_url('assets/frontend/img/voltar.png')); ?>
                        Voltar para Venda
                    </button> 
                </a>
            </div>
        </div>
    </div>
    <?php 
    // fechar o formulario 
    //echo form_close();

    ?>
    
</div>


           

