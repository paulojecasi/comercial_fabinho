<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading text-center">

                    <h3 class="panel-title"> <?php echo $subtitulo ?> </h3>
                </div>
                <div class="panel-body">
                    <!-- nao vamos utilizar a abertura do form, vamos usar o HELPER do
                        framework (form_open)
                    <form role="form">
                    -->
                    <?php
                    // aqui vamos vericar os erros de validação
                    echo validation_errors('<div class="alert alert-warning">','</div>'); 
                    
                    // vamos abrir o formulário,
                                // apontando para:admin/controlador/metodo
                    echo form_open('admin/usuarios/login');

                    ?>

                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="Usuário" name="txt-user" type="text" autofocus>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Senha" name="txt-senha" type="password" value="">
                            </div>
                            <!-- Change this to a button or input when using this as a form -->
                            <button href="index.html" class="btn btn-lg btn-success btn-block"> 
                                  Entrar
                            </button>
                            
                        </fieldset>

                    <?php
                    echo form_close();
                    ?>
                    <!--
                    </form>
                    -->
                    <br>
                    <a href="<?php echo base_url('home'); ?>" >
                        <button  class="btn btn-lg btn-default btn-block">
                                Voltar ao Inicio
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>