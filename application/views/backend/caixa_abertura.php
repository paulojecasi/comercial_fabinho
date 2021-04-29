<div id="page-wrapper">
    
    <!-- /.row -->

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default panel-abertura-cx">

                <div class="abertura-caixa-title">
                    <div class="text-center title-abertura-caixa">
                        <h3> <?php echo $titulo ?></h3>
                    </div>
                </div>
               
                <div class="col-lg-12 panel-abertura-caixa">

                    <?php
                    // aqui vamos vericar os erros de validação
                    echo validation_errors('<div class="alert alert-warning">','</div>'); 
                    
                    echo form_open('admin/caixa/confirma_abertura/'.$idcaixa,'autocomplete="off"');

                    ?> 
                    <div class="form-group col-lg-6 text-center">  
                          <h2> Numero do Caixa : </h2>
                    </div>
                    <div class="form-group col-lg-6 text-center">  
                          <h3> <?php echo $idcaixa ?> </h3>
                    </div>

                    <div class="form-group col-lg-12">  
                          <label> Informe Valor do Troco Inicial </label>
                          <input type="number" class="form-control" id="vltrocoini" name="vltrocoini" step="0.01" placeholder="0.00">
                    </div>

                    <section>
                        <div class="col-lg-6 text-center">
                            <br> 
                            <a href="">
                                <button class="btn btn-primary person" id="btn-add-abertura-cx" type="submit" > 
                                    Abrir Caixa 
                                </button> 
                            </a>
                        </div>

                        <div class ="col-lg-6 col-md-4 col-sm-4 text-center link-voltar-cadproduto">    
                            <a href ="<?php echo base_url('admin/caixa') ?>">         
                               <button class="btn btn-default btn-return" id="btn-return-cx" type="button"> <i class="fa fa-reply-all"> </i> 
                                Voltar 
                                </button>
                            </a>
                        </div>
                    </section>
                    
                    <?php 
                    // fechar o formulario 
                    echo form_close();
                    ?> 
                    
                </div>
                        
            
            </div>
            <!-- /.panel -->
        </div>

    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper --> 