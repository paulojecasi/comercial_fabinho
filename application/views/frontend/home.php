<div class = "container img-acesso-escolha">
    <div class="col-md-4 col-md-offset-4">
        <div class="login-panel panel panel-default  senha-usuario-acesso">
            <div class="text-center">
                <h1> Escolha o tipo de acesso </h1>
                <br> 
            </div>
      
            <div class="panel-body">  
               
                <div class = "btn-acesso acesso-escolha-sis"> 
                    <?php
                        echo form_open('admin/login');
                    ?>
                    <div class ="col-lg-6 col-sm-12 btn-acesso text-center">
                        <a href="">
                            <button class="btn btn-success" type="submit" > 
                                Vendas
                            </button> 
                        </a>
                    </div>
                    <input type="hidden" name="vendas" value="1">

                    <?php
                    echo form_close();
                    ?>

                    <?php
                    echo form_open('admin/login');
                    ?>
                    <div class ="col-lg-6 col-sm-12 btn-acesso text-center">
                        <a href="">
                            <button class="btn btn-success" type="submit" > 
                                Administração 
                            </button> 
                        </a>
                    </div>
                    <input type="hidden" name="vendas" value="2">
                    <div class ="col-lg-12 mensagem-sis-acesso"> 
                        <?php
                            // vai alertar !!
                            $mensagem = $this->load->view('backend/mensagem');

                            // vai ficar no rodapé 
                        ?> 
                    </div>

                    <?php
                    echo form_close();
                    ?>

                    
                </div>

             
            </div>
       
        </div>
    </div>
</div>