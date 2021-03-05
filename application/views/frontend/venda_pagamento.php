<div class = "row">

    <?php
    // aqui vamos vericar os erros de validação
    echo validation_errors('<div class="alert alert-warning">','</div>'); 
    // encerrar a secoes 
    $this->session->unset_userdata('idcliente');
    $this->session->unset_userdata('nome');
    $this->session->unset_userdata('apelido'); 
    $this->session->unset_userdata('cpf'); 
    $this->session->unset_userdata('endereco'); 
    $this->session->unset_userdata('pontoreferencia');
    $this->session->unset_userdata('vl_saldo_devedor');
                                
    $this->load->view('frontend/template/valor-venda');
    ?>
   

    <div class = "panel-body tipo-de-pagamento col-lg-12"> 
        <div class = "text-center">
            <h2> Escolha a Forma de Pagamento </h2>
        </div>
        <section>
            <div class = "col-lg-3 col-sm-6">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 ">
                            <div class="form-group text-center text-center avista">
                                <a href="<?php echo base_url('venda/venda_pagamento/').$idcaixa.'/1' ?>">
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
                                <a href="<?php echo base_url('venda/venda_pagamento/').$idcaixa.'/2' ?>">
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
                                <a href="<?php echo base_url('venda/venda_pagamento/').$idcaixa.'/3' ?>">
                                    <img class="img-fluid" src="<?php echo base_url('/assets/frontend/img/creditoc.png') ?>" >
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
                                <a href="<?php echo base_url('venda/venda_pagamento/').$idcaixa.'/4' ?>">
                                    <img class="img-fluid" src="<?php echo base_url('/assets/frontend/img/fiado.png') ?>" >
                                </a> 
                                <h4> Crediário </h4>
                            </div>

                        </div> 

                    </div>
                </div>
            </div>
        </section>
        <div class="form-group"> 
            <div class ="col-lg-12 text-center link-voltar">
                <a href="<?php echo base_url('venda') ?>">
                     <?php echo img(base_url('assets/frontend/img/voltar2.png')); ?>
                        Voltar para Venda
                </a>
            </div>
        </div>
    </div>
    <?php 
    // fechar o formulario 
    //echo form_close();

    ?>
    
</div>


           

