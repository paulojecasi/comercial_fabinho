<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12 text-center">
            <h3 class="page-header"> <?php echo "Categoria do Produto - Alteração" ?></h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    <div class="row">
        <div class="col-lg-12">
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
                            echo form_open('admin/categoria/salvar_alteracoes');
            
                            foreach ($categoria as $categoria_alt)  {
            
                            ?> 
                                <div class="form-group">
                                    <label> Nome da Categoria </label>
                                    <input id="txt-categoria" name="txt-categoria" type="text" class = "form-control" placeholder ="Digite o nome da categoria"  value= "<?php echo $categoria_alt->titulo ?>" >
                                </div>
        

                                <br>
                              
                                <!-- INPUT OCULTO PARA ENVIAR O ID--> 
                                <input  type="hidden" id="txt-id" name="txt-id" value= "<?php echo $categoria_alt->id ?>" 
                                >

                                <div class = "col-lg-6 col-md-6 col-sm-6"> 
                                    <button type="submit" class="btn btn-primary person btn_click_shift_f4" > &nbsp Atualizar  &nbsp <b class="atl-alt-s"> &nbsp  sF4 &nbsp </b>  </button> 
                                </div>

                                <div class ="col-lg-6 col-md-6 col-sm-6 text-center link-voltar-cadproduto">    
                                    <a href ="<?php echo base_url('admin/categoria') ?>">         
                                        <h4 class="btn-return"> <i class="fa fa-reply-all"> </i> Voltar Para o Cadastro</h4>
                                    </a>
                                </div>
                            
                      
                            <?php 
                            }
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
