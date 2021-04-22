<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12 text-center">
            <h3 class="page-header"> <?php echo "Administrar ".$subtitulo ?></h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    <div class="row">
        <div class="col-lg-5">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">


                        <!-- nao vamos utilizar a abertura do form, vamos usar o HELPER do
                        framework (form_open) --> 
              
                            <?php
                            // aqui vamos vericar os erros de validação
                            echo validation_errors('<div class="alert alert-warning">','</div>'); 
                            
                            // vamos abrir o formulário,
                                        // apontando para:admin/controlador/metodo
                            echo form_open('admin/usuarios/inserir','autocomplete="off"');
        
                            ?> 
                            
                            <div class = "form-group">
                                <label> Nome do Usuario </label>
                                <input id="txt-nome" name="txt-nome" type="text"class = "form-control campo-senha" placeholder ="Digite o nome do Usuario"
                                value = "<?php echo set_value('txt-nome') ?>" autofocus="true" required> 

                            </div>
                            <!-- 
                            <div class = "form-group">
                                <label> E-mail </label>
                                <input id="txt-email" name="txt-email" type="email" class = "form-control" placeholder ="Digite o e-mail"
                                value = "<?php echo set_value('txt-email') ?>" required>
                            </div>
                            --> 

                            <div class="form-group">
                              <label for="idtipo_acesso"> Tipo de Acesso do Usuário </label>
                              <select class="form-control" id="idtipo_acesso" name="idtipo_acesso">
                            
                                <?php 
                                foreach ($lista_tipo_acesso as $tipo_acesso) 

                                { ?> 
                                    <option  value ="<?php echo $tipo_acesso->id ?>"
                                        
                                    >
                                        <?php echo $tipo_acesso->desacesso ?>
                                    </option>
                                <?php
                                 }
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
                                <input id="txt-user" name="txt-user" type="text"class = "form-control  campo-senha" placeholder ="Digite o Login"
                                value = "<?php echo set_value('txt-user') ?>" required>
                            </div>
                            <div class = "form-group col-lg-6">
                                <label> Senha </label>
                                <input id="txt-senha" name="txt-senha" type="password"class = "form-control campo-senha" onfocus="this.removeAttribute('readonly');"  required>
                            </div>
                            <div class = "form-group col-lg-6">
                                <label> Confirmar Senha  </label>
                                <input id="txt-csenha campo-senha" name="txt-csenha" type="password"class = "form-control" onfocus="this.removeAttribute('readonly');" required>
                            </div>
                            
                            <!--
                            <div class = "form-group">
                                <label> Foto </label>
                                <input id="txt-img" name="txt-img" type="text"class = "form-control" placeholder ="Foto do Usuario">
                            </div>
                            --> 

                            <br>

                            <div class = "form-group col-lg-12">
                                <a href="">
                                    <button class="btn btn-primary person btn_click_shift_f4" > 
                                        &nbsp Cadastrar  &nbsp <b class="atl-alt-s"> &nbsp  sF4 &nbsp </b>
                                    </button> 
                                </a>
                            </div>
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

        <div class="col-lg-7">
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                   <h4> <?php echo "Manutenção de ".$subtitulo ?> </h4>
                </div>
                <div class="panel-body panel-cadastro-user">
                    <div class="row">
                        <div class="col-lg-12 fotos-usuarios">
                  
                            <!-- gerar tabela de usuarios pela framework PJCS --> 
                            <?php
                            $semFoto = "assets/frontend/img/usuarios/sem_foto.jpg";

                            $this->table->set_heading(  "Foto", "Login","Tipo Senha","Opera Caixa","Alterar",
                                                        "Excluir"); 
                            $id=0;
                            $foto = "";
                            $nomeuser ="";
                            $botaoalterar="";
                            $botaoexcluir="";
                            $notiposenha ="";
                            $tipo_acesso = 0;
                            $idcaixa_ope = 0;
                            foreach ($lista_usuarios as $usuario)
                            {   
                                $id = $usuario->id;
                                $tipo_acesso = $usuario->tipo_acesso; 
                                $idcaixa_ope = $usuario->idcaixa_autorizado; 

                                if ($usuario->img !=''){
                                    $foto   = img($usuario->img);
                                }else{
                                    $foto   = img($semFoto);
                                }

                                $notiposenha = "NENHUM";
                                $nomeuser   = $usuario->user;
                                foreach ($lista_tipo_acesso as $tipo_ace){
                                    if ($tipo_ace->id == $tipo_acesso){
                                        $notiposenha = $tipo_ace->desacesso; 
                                    }
                                
                                }
                                

                                $botaoalterar = anchor(base_url('admin/usuarios/alterar/'.md5($usuario->id)),
                                    '<h4 class="btn-alterar"><i class="fas fa-edit"> </i>   </h4>');
                                $botaoexcluir= '<button type="button" class="btn btn-link" data-toggle="modal" data-target=".excluir-modal-'.$id.'"> <h4 class="btn-excluir"><i class="fa fa-remove fa-fw"></i>    </h4> </button>';

                                echo $modal= ' <div class="modal fade excluir-modal-'.$id.'" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                                                </button>
                                                <h4 class="modal-title" id="myModalLabel2"> <i class="fa fa-remove fa-fw"></i> Exclusão de  Usuário </h4>
                                            </div>
                                            <div class="modal-body">
                                                <h4>Deseja Excluir o Usuário '.$nomeuser.'?</h4>
                                                <p>Após Excluida ao Usuário <b>'.$nomeuser.'</b> não ficara mais disponível no Sistema.</p>
                                                <p>Todos os itens relacionados ao Usuário <b>'.$nomeuser.'</b> serão afetados e não aparecerão no site até que sejam editados.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                                <a type="button" class="btn btn-danger" href="'.base_url('admin/usuarios/excluir/'.md5($id)).'">Excluir</a>
                                            </div>

                                        </div>
                                    </div>
                                </div>';

                                $this->table->add_row($foto,$nomeuser,$notiposenha, $idcaixa_ope,$botaoalterar,$botaoexcluir); 
                            }

                            $this->table->set_template(array(
                                'table_open' => '<table class="table table-striped">'
                            ));

                            echo $this->table->generate(); 
                            ?>
                                        
                        </div>
                        
                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper --> 