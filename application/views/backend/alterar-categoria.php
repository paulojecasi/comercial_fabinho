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
                            echo form_open('admin/categoria/salvar_alteracoes');
            
                            foreach ($categoria as $categoria_alt)  {
            
                            ?> 
                                <div class="form-group">
                                    <label> Nome da Categoria </label>
                                    <input id="txt-categoria" name="txt-categoria" type="text" class = "form-control" placeholder ="Digite o nome da categoria"  value= "<?php echo $categoria_alt->titulo ?>" >
                                </div>
         
                                <div class="form-group">
                                    <label for="categoriadest"> Destacar no Site? </label>
                                    <select class="form-control" id="categoriadest" name="categoriadest">
                                  
                                      <?php 
                                      foreach ($opcoes as $opcao):
                                      ?>
                                          <option value ="<?php echo $opcao->idopcao ?> "
                                            <?php 
                                            if ($opcao->idopcao== $categoria_alt->categoriadest):?>
                                                    selected
                                                    <?php                               
                                            endif
                                              ?> 
                                          >
                                             <?php echo $opcao->desopcao ?>
                                          </option>

                                      <?php 
                                      endforeach; 
                                      ?>
                                    
                                    </select>
                                </div>

                                <br>
                              
                                <!-- INPUT OCULTO PARA ENVIAR O ID--> 
                                <input  type="hidden" id="txt-id" name="txt-id" value= "<?php echo $categoria_alt->id ?>" 
                                >
                                <button type="submit" class="btn btn-primary" > Atualizar </button> 
                            
                      
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
<!-- /#page-wrapper -->


<!--
<form role="form">
    <div class="form-group">
        <label>Titulo</label>
        <input class="form-control" placeholder="Entre com o texto">
    </div>
    <div class="form-group">
        <label>Foto Destaque</label>
        <input type="file">
    </div>
    <div class="form-group">
        <label>Conteúdo</label>
        <textarea class="form-control" rows="3"></textarea>
    </div>
   
    <div class="form-group">
        <label>Selects</label>
        <select class="form-control">
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
        </select>
    </div>
    <button type="submit" class="btn btn-default">Cadastrar</button>
    <button type="reset" class="btn btn-default">Limpar</button>
</form>

--> 