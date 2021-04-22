<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12 text-center">
            <h3 class="page-header"> <?php echo "Alteração de Dados do Usuario do Sistema" ?></h3>
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
                                    <input id="txt-nome" name="txt-nome" type="text"class = "form-control campo-senha" placeholder ="Digite o nome do Usuario"
                                    value = "<?php echo $usuario_alt->nome?>" autofocus ="true" required> 

                                </div>
                                <!--
                                <div class = "form-group">
                                    <label> E-mail </label>
                                    <input id="txt-email" name="txt-email" type="email" class = "form-control" placeholder ="Digite o e-mail"
                                    value = "<?php echo $usuario_alt->email ?>">
                                </div> --> 


                                <div class="form-group">
                                  <label for="idtipo_acesso"> Tipo de Acesso do Usuário </label>
                                  <select class="form-control" id="idtipo_acesso" name="idtipo_acesso">
                                
                                    <?php 
                                     foreach ($lista_tipo_acesso as $tipo_acesso): 
                                       ?> 
                                        <option  value =" <?php echo $tipo_acesso->id ?> "
                                            <?php 
                                            if ($tipo_acesso->id==$usuario_alt->tipo_acesso): ?>
                                                    selected
                                                    <?php                                          
                                            endif;
                                            ?> 
                                        > 
                                          <?php echo $tipo_acesso->desacesso ?>
                                        </option>
                                      <?php
                                      endforeach;
                                    ?> 
                                  </select>
                                </div>

                                <div class="form-group">
                                  <label for="idtipo_acesso"> Caixa do Usuário </label>
                                  <select class="form-control" id="idcaixa_autorizado" name="idcaixa_autorizado">
                                
                                    <?php 
                                    foreach ($lista_caixas as $lista_caixa) 
                                    { ?> 
                                        <option  value ="<?php echo $lista_caixa->idcaixa ?>"
                                            <?php
                                            if ($usuario_alt->idcaixa_autorizado = $lista_caixa->idcaixa ): 
                                                ?>
                                                selected
                                                <?php
                                            endif;
                                            ?>
                                        >
                                            <?php echo "Caixa -" .$lista_caixa->idcaixa ?>
                                        </option>
                                    <?php
                                     }
                                    ?> 
                                  </select>
                                </div>

                                <div class = "form-group col-lg-12">
                                    <label> Login </label>
                                    <input id="txt-user" name="txt-user" type="text"class = "form-control campo-senha" placeholder ="Digite o Login do Usuario"
                                    value = "<?php echo $usuario_alt->user ?>" required>
                                </div>
                                <div class = "form-group col-lg-6">
                                    <label> Senha </label>
                                    <input id="txt-senha" name="txt-senha" type="password"class = "form-control"  required>
                                </div>
                                <div class = "form-group col-lg-6">
                                    <label> Confirmar Senha  </label>
                                    <input id="txt-csenha" name="txt-csenha" type="password"class = "form-control" required>
                                </div>

                                <!-- INPUT OCULTO PARA ENVIAR O ID--> 
                                <input  type="hidden" id="txt-id" name="txt-id" value= "<?php echo $usuario_alt->id ?>" 
                                >
                                <div class = "form-group col-lg-6 col-md-6 col-sm-6 text-center">
                                    <button type="submit" class="btn btn-primary person btn_click_shift_f4" > &nbsp Atualizar  &nbsp <b class="atl-alt-s"> &nbsp  sF4 &nbsp </b>  </button> 
                                </div>

                                <div class ="col-lg-6 col-md-6 col-sm-6 text-center link-voltar-cadproduto">    
                                    <a href ="<?php echo base_url('admin/usuarios') ?>">         
                                        <h4 class="btn-return"> <i class="fa fa-reply-all"> </i> Voltar Para o Cadastro</h4>
                                    </a>
                                </div>
                    
                                <?php 
                                // fechar o formulario 
                                // OBS --- o FOREACH termina mais abaixo 
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