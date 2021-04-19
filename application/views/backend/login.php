<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading text-center">

                    <h3 class="panel-title"> <?php echo $subtitulo ?> </h3>
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
                            <div class="form-group">
                                <input class="form-control campo-senha" placeholder="Usuário" name="txt-user" type="text" autofocus required>
                            </div>
                            <div class="form-group">
                                <input class="form-control campo-senha" placeholder="Senha" name="txt-senha" type="password" value="" required>
                            </div>
                            <!-- Change this to a button or input when using this as a form -->
                            <button href="" class="btn btn-lg btn-success btn-block"> 
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