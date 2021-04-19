

<div class="acesso-geral">
    <div class="col-lg-4 col-md-offset-4">
        <div class="login-panel panel panel-default panel-pass">
            <div class="text-center">
                <h3 class="text-center"> ACESSO AO SISTEMA </h3>
            </div>
            <div class="panel-body">

                <?php
          
                        // aqui vamos vericar os erros de validação
                echo validation_errors('<div class="alert alert-warning text-center">','</div>'); 
                
                // vamos abrir o formulário,
                            // apontando para:admin/controlador/metodo
                echo form_open('admin/empresa/login_empresa','id="form-acesso-geral" autocomplete="off"');

                ?>

                    <fieldset>
                        <div class="form-group">
                            <input class="form-control campo-senha" placeholder="Login da Empresa" name="txt-user-empresa" type="text" autofocus required>
                        </div>
                        <div class="form-group">
                            <input class="form-control campo-senha" placeholder="Senha" name="txt-senha-empresa" type="password" value="" required>
                        </div>
                        <!-- Change this to a button or input when using this as a form -->
                        <button href="index.html" class="btn btn-lg btn-success btn-block" id="btn-acesso-geral"> 
                              Entrar
                        </button>
                        
                    </fieldset>



                <?php
                echo form_close();
                ?>
                <!--
                </form>
                -->
            </div>
        </div>
    </div>
    <div class="text-center cactosdev_acesso col-lg-12">
                 
          <p> <img class="img-fluid email" src=" <?php echo base_url('assets/frontend/img/email.png'); ?>"> cactosdev@gmail.com 
          <img class="img-fluid whats" src=" <?php echo base_url('assets/frontend/img/whats.png'); ?>"> (86) 99973 3764  </p>
    </div>
</div>
 