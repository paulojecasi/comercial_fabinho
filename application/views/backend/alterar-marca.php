<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"> <?php echo "Administrar ".$subtitulo ?></h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    <div class="row">
        <div class="col-lg-6">
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
                                <button type="submit" class="btn btn-primary" > Atualizar </button> 
                            
                      
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
