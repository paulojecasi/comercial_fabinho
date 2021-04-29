 
<div class = "container img">  
    <div class="col-md-4 col-md-offset-4">
        <div class="login-panel panel panel-default senha-usuario-acesso">
            <div class="text-center">
                <h1> Login do Sistema </h1>
                <br> 
                <h3 class="panel-title-login"> <?php echo $subtitulo ?> </h3>
            </div>
            <div class="panel-body">
                <?php
                // aqui vamos vericar os erros de validação
                echo validation_errors('<div class="alert alert-warning">','</div>'); 
                
                // vamos abrir o formulário,
                            // apontando para:admin/controlador/metodo
                echo form_open('admin/usuarios/login','autocomplete="off"');

                ?>


                <fieldset>
                    <div class="form-group input-usuario" >
                        <i class="fa fa-user" aria-hidden="true"></i>
                        <input class="form-control campo-senha" placeholder="Usuário" name="txt-user" type="text" id="input-login" autofocus required>
                    </div>
                    <div class="form-group input-usuario">
                        <i class="fa fa-lock" aria-hidden="true"></i>
                        <input class="form-control campo-senha" placeholder="Senha" name="txt-senha" type="password" value="" id="input-senha" required>
                    </div>
                    <!-- Change this to a button or input when using this as a form -->
                    <button href="" class="btn btn-lg btn-success btn-block btn-acesso-sis col-md-offset-3"> 
                          Entrar
                    </button>
                    
                </fieldset>

                <?php

                if ($this->session->userdata('tipo_acesso') == "venda")
                {
                    ?>
                        <input type="hidden" name="vendas" value="1">
                    <?php
                }
                else
                {
                    ?>
                        <input type="hidden" name="vendas" value="2">
                    <?php
                }

                echo form_close();
                ?>
                <!--
                </form>
                -->
                <br>
                <div class="text-center">
                    <a href="<?php echo base_url('home'); ?>" >
                        <span  class="btn-acesso-sis-voltar">Voltar ao Inicio</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
        
</div>
 