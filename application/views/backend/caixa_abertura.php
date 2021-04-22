<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12 text-center title-abertura-caixa">
            <h3> <?php echo $titulo ?></h3>
        </div>
   
    </div>
    <!-- /.row -->

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 panel-abertura-caixa">

                            <?php
                            // aqui vamos vericar os erros de validação
                            echo validation_errors('<div class="alert alert-warning">','</div>'); 
                            
                            echo form_open('admin/caixa/confirma_abertura/'.$idcaixa,'autocomplete="off"');
        
                            ?> 
                            <div class="form-group col-lg-12 text-center">  
                                  <label> Número do Caixa </label>
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
                                        <h4 class="btn-return"> <i class="fa fa-reply-all"> </i> Voltar</h4>
                                    </a>
                                </div>
                            </section>
                            
                            <?php 
                            // fechar o formulario 
                            echo form_close();
                            ?> 
                            
                        </div>
                        
                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>

    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper --> 