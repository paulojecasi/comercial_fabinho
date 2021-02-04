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
                            echo form_open('admin/usuarios/salvar_alteracoes');
            
                            foreach ($lista_usuario as $usuario_alt)  :
                            ?>
                            <div class = "form-group">
                                <label> Nome do Usuario </label>
                                <input id="txt-nome" name="txt-nome" type="text"class = "form-control" placeholder ="Digite o nome do Usuario"
                                value = "<?php echo $usuario_alt->nome?>"> 

                            </div>
                            <div class = "form-group">
                                <label> E-mail </label>
                                <input id="txt-email" name="txt-email" type="email" class = "form-control" placeholder ="Digite o e-mail"
                                value = "<?php echo $usuario_alt->email ?>">
                            </div>

                            <div class = "form-group">
                                <label> Historico </label>
                                <textarea id="txt-historico" name="txt-historico" type="text"class = "form-control" placeholder ="Digite Historico">
                                    <?php echo $usuario_alt->historico ?>
                                </textarea>
                            </div>
                            <div class = "form-group">
                                <label> Login </label>
                                <input id="txt-user" name="txt-user" type="text"class = "form-control" placeholder ="Digite o Login do Usuario"
                                value = "<?php echo $usuario_alt->user ?>">
                            </div>
                            <div class = "form-group">
                                <label> Senha </label>
                                <input id="txt-senha" name="txt-senha" type="password"class = "form-control" >
                            </div>
                            <div class = "form-group">
                                <label> Confirmar Senha  </label>
                                <input id="txt-csenha" name="txt-csenha" type="password"class = "form-control" >
                            </div>

                            <!-- INPUT OCULTO PARA ENVIAR O ID--> 
                            <input  type="hidden" id="txt-id" name="txt-id" value= "<?php echo $usuario_alt->id ?>" 
                            >
                            <button type="submit" class="btn btn-primary" > Alterar </button> 
                      
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

        <!-- PARA FOTOS --> 

        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                   Foto do Usuário 
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <?php 
                            $semFoto = "assets/frontend/img/usuarios/sem_foto.jpg";
                            if ($usuario_alt->img!=''){
                                echo img($usuario_alt->img); 
                            } else {
                                echo img($semFoto);
                            }
                        
                            ?>
                        </div>
                    </div>
                    <br> 
                    <div class="row">
                        <div class="col-lg-12">
                                <?php

                                $divopen = '<div class="form-group">';
                                $divclose= '</div>';

                                echo form_open_multipart('admin/usuarios/nova_imagem'); 
                                echo form_hidden('id', md5($usuario_alt->id)); 
                                echo $divopen;
                                $imagem = array('name'=>'userfile', 
                                                'id'=>'userfile',
                                                'class'=>'form-control'); 
                                echo form_upload($imagem);
                                echo $divclose;

                                echo $divopen;
                                $button = array('name'=>'btn-adicionar', 
                                                'id'=>'btn-adicionar',
                                                'class'=>'btn btn-default',
                                                'value'=>'Adicionar Imagem'); 
                                echo form_submit($button);
                                echo $divclose; 
                                echo form_close();
                                 
                            endforeach;  // fechamento do ultimo foreach 
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