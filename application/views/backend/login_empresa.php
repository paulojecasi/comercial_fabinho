<div class = "container img-sistema">
    <div class="col-md-4 col-md-offset-4">
        <div class="login-panel panel panel-default senha-usuario-acesso-geral">
            <div class="text-center">
                <h1> Acesso ao Sistema </h1>
                <br> 
    
            </div>
            <div class="panel-body">

                <?php
          
                        // aqui vamos vericar os erros de validação
                echo validation_errors('<div class="alert alert-warning text-center">','</div>'); 
                
                // vamos abrir o formulário,
                            // apontando para:admin/controlador/metodo
                echo form_open('admin/empresa/login_empresa','id="form-acesso-geral" autocomplete="off"');

                ?>
                <!--
                <input id ="form-acesso-gera" type="hidden" value="1">
                <input class ="base_url" type="hidden" value="<?php echo base_url() ?>">
                <input id ="acesso" type="hidden" value="0"> --> 

                    <fieldset>
                        <div class="form-group input-usuario-g">
                            <i class="fa fa-users" aria-hidden="true"></i>
                            <input class="form-control campo-senha" placeholder="Login da Empresa" name="txt-user-empresa" type="text" autofocus required>
                        </div>
                        <div class="form-group input-usuario-g input-usuario-g2">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                            <input class="form-control campo-senha" placeholder="Senha" name="txt-senha-empresa" type="password" value="" required>
                        </div>
                        <!-- Change this to a button or input when using this as a form -->
                        <button href="index.html" class="btn btn-lg btn-success btn-block btn-acesso-sis col-md-offset-3" id="btn-acesso-geral">                            > 
                              Entrar
                        </button>
                        
                    </fieldset>
                <?php
                echo form_close();
                ?>
                <br> 
                <div class ="col-lg-12 mensagem-sis-acesso"> 
                    <?php
                        // vai alertar !!
                        $mensagem = $this->load->view('backend/mensagem');

                        // vai ficar no rodapé 
                    ?> 
                </div>
            </div>
        </div>
    </div>
    <div class="logo-marca-ps text-center col-lg-12 col-sm-12">
        <h3> 
             <img  src="<?php echo base_url('/assets/frontend/img/_PS_Solucoes2.png') ?>" height="65" width="300" >
        </h3>
    </div>
    <div class="form-group text-center cactosdev_acesso col-lg-12">          
        <img class="img-fluid whats" src=" <?php echo base_url('assets/frontend/img/whats.png'); ?>"> <b> (86) 99973 3764 </b>  </p>
    </div>
</div>
 