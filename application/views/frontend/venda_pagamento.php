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

        <section class ="escolha-pagamento"> 
      
            <div class = "col-lg-2 col-sm-4">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 ">
                            <div class="form-group text-center text-center avista">
                                <a href="<?php echo base_url('venda/venda_pagamento/').$idcaixa.'/1' ?>" class="btn_click_shift_1">
                                    <img  src="<?php echo base_url('/assets/frontend/img/avista.png') ?>" >
                                </a> 
                                <h4> Dinheiro <br> <b class="atalho-front"> s1 </b>  </h4>
                            </div>

                        </div> 

                    </div>
                </div>
            </div>
            <div class = "col-lg-2 col-sm-4">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 ">
                            <div class="form-group nomeproduto text-center debito">
                                <a href="<?php echo base_url('venda/venda_pagamento/').$idcaixa.'/2' ?>" class="btn_click_shift_2">
                                    <img class="img-fluid" src="<?php echo base_url('/assets/frontend/img/card.png') ?>" >
                                </a> 
                                 <h4> Cartão Débito <br> <b class="atalho-front"> s2 </b>  </h4>
                            </div>
                        </div> 
                    </div>
                </div>
                 
            </div>
            <div class = "col-lg-2 col-sm-4 ">
                <div class="panel-body">
              
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 ">

                            <div class="form-group nomeproduto text-center credito">
                                <a href="<?php echo base_url('venda/venda_pagamento/').$idcaixa.'/3' ?>" class="btn_click_shift_3">
                                    <img class="img-fluid" src="<?php echo base_url('/assets/frontend/img/creditoc.png') ?>" >
                                </a> 
                                <h4> Cartão Crédito <br> <b class="atalho-front"> s3 </b> </h4>
                            </div>

                        </div> 

                    </div>
                </div>
            </div>

            <div class = "col-lg-2 col-sm-4">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12">
                            <div class="form-group nomeproduto text-center crediario">
                                <a href="<?php echo base_url('venda/venda_pagamento/').$idcaixa.'/4' ?>" class="btn_click_shift_4">
                                    <img class="img-fluid" src="<?php echo base_url('/assets/frontend/img/fiado.png') ?>" >
                                </a> 
                                <h4> Crediário <br> <b class="atalho-front"> s4 </b> </h4>
                            </div>

                        </div> 

                    </div>
                </div>
            </div>

            <div class = "col-lg-2 col-sm-4">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12">
                            <div class="form-group nomeproduto text-center crediario">
                                <a href="<?php echo base_url('venda/venda_pagamento/').$idcaixa.'/8' ?>" class="btn_click_shift_5">
                                    <img class="img-fluid" src="<?php echo base_url('/assets/frontend/img/car.png') ?>" >
                                </a> 
                                <h4> Venda Externa <br> <b class="atalho-front"> s5 </b> </h4>
                            </div>

                        </div> 

                    </div>
                </div>
            </div>

            <div class = "col-lg-2 col-sm-4">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12">
                            <div class="form-group nomeproduto text-center crediario">
                                <a href="<?php echo base_url('venda/venda_pagamento/').$idcaixa.'/11' ?>" class="btn_click_shift_6">
                                    <img class="img-fluid" src="<?php echo base_url('/assets/frontend/img/transf.png') ?>" >
                                </a> 
                                <h4> PIX / Transferencia <br> <b class="atalho-front"> s6 </b> </h4>
                            </div>

                        </div> 

                    </div>
                </div>
            </div>
        </section>
        <div class="form-group"> 
            <div class ="col-lg-12 text-center link-voltar link-voltar-esc-pagto">
                <a href="<?php echo base_url('venda') ?>" class="btn_click_shift_r">
                     <i class="fa fa-reply-all"> </i>
                        Voltar para Venda <b class="atalho-front"> sR </b>
                </a>
            </div>
        </div>
    </div>
    <?php 
    // fechar o formulario 
    //echo form_close();

    ?>
    
</div>


           

