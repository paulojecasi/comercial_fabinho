
    <div class="panel panel-default">
        <div class="text-center titulo-acesso-sistema col-lg-12">
           <h1>
                <?php echo $titulo ?>
           </h1>
        </div>
        <h2>
            <?php
                $this->load->view('backend/mensagem');
            ?> 
        </h2>
 
       

        <div class="panel-body acesso-ao-sistema col-sm-12">
            <div class = "btn-acesso"> 
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

                <?php
                echo form_close();
                ?>
            </div>
        </div>

        

        
            <div class="text-center cactosdev_acesso col-lg-12">
                  <p class="des-por"> Desenvolvido por </p>
                  <h3> <img class="img-fluid cacto" src=" <?php echo base_url('assets/frontend/img/cactosdev.png'); ?>"> Cactos Dev </h3>
                  <p> <img class="img-fluid email" src=" <?php echo base_url('assets/frontend/img/email.png'); ?>"> cactosdev@gmail.com 
                  <img class="img-fluid whats" src=" <?php echo base_url('assets/frontend/img/whats.png'); ?>"> (86) 99973 3764  </p>
            </div>
        

    </div>