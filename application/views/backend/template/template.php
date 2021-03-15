    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top col-lg-2" role="navigation" style="margin-bottom: 0">
            
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar col-sm-12" role="navigation">

                <div class ="col-sm-12"> 
                    <div class="navbar-header col-lg-12 foto-perfil text-center">

                        <a href="<?php echo base_url('/admin/usuarios') ?>"> 
                            <?php

                            $semFoto = "assets/frontend/img/usuarios/sem_foto.jpg";

                            if ($this->session->userdata('userLogado')->img !=''){
                                echo img($this->session->userdata('userLogado')->img) ;
                            }else{
                                echo img($semFoto); 
                            }
                            ?>
                        </a>
                    </div>

                    <div class="navbar-header col-lg-12">
                        <p class="text-left">
                            <a href="<?php echo base_url('/admin/usuarios') ?>"> 
                                <?php echo "Usuário -- ".$this->session->userdata('userLogado')->nome;?>
                            </a>
                        </p>
                      
                    </div>
                </div>

                <div class="sidebar-nav navbar-collapse col-lg-12">
                    <ul class="nav" id="side-menu">
                       
                        <li>
                             <p class = "menu-admin"> Produtos </p>    
                        </li>
                        <li>
                            <a href="<?php echo base_url('admin/produto') ?>"><i class="fa fa-plus-circle fa-fw"></i>Cadastro de Produtos </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('admin/estoque') ?>"><i class="fa fa-linode fa-fw"></i> Entrada no Estoque </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('admin/estoque/estoque_consulta') ?>"><i class="fa fa-eye fa-fw"></i> Consultar Estoque </a>
                        </li>

                        <li>
                             <p class = "menu-admin"> Tabelas </p>    
                        </li>
                         <li>
                            <a href="<?php echo base_url('admin/categoria') ?>"><i class="fa fa-sitemap fa-fw"></i> Categoria do Produto</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('admin/marca') ?>"><i class="fa fa-tags fa-fw"></i> Marca do Produto</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('admin/usuarios') ?>"><i class="fa fa-user fa-fw"></i> Usuários</a>
                        </li>

                        <li>
                             <p class = "menu-admin"> </p>    
                        </li>

                        <li>
                            <a href=" <?php echo base_url('admin/usuarios/logout') ?>"><i class="fa fa-sign-out fa-fw"></i> Sair do Sistema</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

   