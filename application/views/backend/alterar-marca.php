<div id="page-wrapper">
    
    <div class="col-lg-12 text-center title-marca-prod">
        <h3 class="page-header"> <?php echo $subtitulo ?></h3>
    </div>
  
    <div class="row">
        <div class="col-lg-12 panel-atualiza-marca">
            <div class="panel panel-default">
                <div class="panel-heading">
                   <?php echo $subtitulo ?>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">

                            <?php
                            // aqui vamos vericar os erros de validação
                            echo validation_errors('<div class="alert alert-warning">','</div>'); 
                            
                            // vamos abrir o formulário,
                                        // apontando para:admin/controlador/metodo
                            echo form_open('admin/marca/salvar_alteracoes');
            
                            foreach ($marca as $marca_alt):
            
                            ?> 
                                <div class="form-group">
                                    <label> Nome da Marca </label>
                                    <input id="desmarca" name="desmarca" type="text" class = "form-control" placeholder ="Digite o nome da Marca"  value= "<?php echo $marca_alt->desmarca ?>" >
                                </div>
         
                                
                                <br>
                              
                                <!-- INPUT OCULTO PARA ENVIAR O ID--> 
                                <input  type="hidden" id="idmarca" name="idmarca" value= "<?php echo $marca_alt->idmarca ?>" 
                                >
                    
                                <div class = "col-lg-6 col-md-6 col-sm-6"> 
                                    <button type="submit" class="btn btn-primary person btn_click_shift_f4" > &nbsp Atualizar  &nbsp <b class="atl-alt-s"> &nbsp  sF4 &nbsp </b> </button> 
                                </div>

                                <div class ="col-lg-6 col-md-6 col-sm-6 text-center link-voltar-cadastro">    
                                    <a href ="<?php echo base_url('admin/marca') ?>">         
                                        <button class="btn btn-default btn-return" id="btn-return-cad-cli" type="button"> <i class="fa fa-reply-all"> </i> 
                                            Voltar para o Cadastro 
                                        </button>
                                    </a>
                                </div>
                            
                      
                            <?php 
                            endforeach; 
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
