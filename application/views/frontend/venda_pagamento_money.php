<div class = "row">

    <?php
    // aqui vamos vericar os erros de validação
    echo validation_errors('<div class="alert alert-warning">','</div>'); 
    
    // vamos abrir o formulário,
                // apontando para:admin/controlador/metodo
    //echo form_open('home/venda_pagamento');

    
    ?>

    <div class = "text-center tipo-de-pagamento-escolha">
        <h2> Pagamento em Dinheiro </h2>
    </div>

    <?php
    // tela VALOR DA VENDA
    $this->load->view('frontend/template/valor-venda');
    ?>

    <div class = "col-lg-12 col-sm-12 titulo-tela-tipopag">
        <div class="row">
            <div class="col-lg-3 col-sm-12">
                <div class="form-group">
                    <h2> Valor Recebido R$ : </h2>
                </div>
            </div>
            <div class="col-lg-9 col-sm-12">
                <div class="form-group">
                    <h1 class="valor-recebido-venda">
                        <input id="vl_recebido" name="vl_recebido" type="text" class="form-control" placeholder ="0,00">
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
                        <input id="vl_troco" name="vl_troco" type="text" class="form-control"  placeholder="0,00" />
                    </h1>
                  
                </div>
            </div>
        </div>

        <div class="form-group"> 
            <div class ="col-lg-12 text-center">
                <a href="<?php echo base_url('home/venda_pagamento/').$id_caixa ?>">
                    <button class="btn btn-info voltar-venda" id="voltar-venda" name="voltar-venda"> <?php echo img(base_url('assets/frontend/img/voltar.png')); ?>
                        Voltar para Escolher Pagamento
                    </button> 
                </a>
            </div>
        </div>
    
    </div>
    
    
</div>


           

