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
                        <p class="text-center">
                            <a href="<?php echo base_url('/admin/usuarios') ?>"> 
                                <?php echo "Usuário -- ".$this->session->userdata('userLogado')->nome;?>
                            </a>
                        </p>
                        <p class="text-center" id="sair-do-sistema-admin">
                            <a href=" <?php echo base_url('admin/usuarios/logout') ?>"><i class="fa fa-sign-out fa-fw"></i> Sair do Sistema</a>
                        </p>
                      
                    </div>
                </div>

                <div class="sidebar-nav navbar-collapse col-lg-12 navbar-scroll">
                    <ul class="nav" id="side-menu">
                        <li>
                             <p class = "menu-admin"> Caixa </p>    
                        </li>
                         <li>
                            <a href="<?php echo base_url('admin/caixa') ?>" class="opc-menu btn_click_shift_a"> <i class="fa fa-cube fa-fw"></i> Abrir / Fechar  - <b class="atalho-shift"> sA </b> </a>
                        </li>
                       
                        <li>
                             <p class = "menu-admin"> Produtos </p>    
                        </li>
                        <li>
                            <a class = "opc-menu btn_click_shift_p" href="<?php echo base_url('admin/produto') ?>"><i class="fa fa-plus-circle fa-fw"></i>Cadastro de Produtos - <b class="atalho-shift"> sP </b></a>
                        </li>
                        <li>
                            <a class = "opc-menu btn_click_shift_e" href="<?php echo base_url('admin/estoque') ?>"><i class="fa fa-plus-square-o" aria-hidden="true"></i> Entrada no Estoque - <b class="atalho-shift"> sE </b></a>
                        </li>
                        <li>
                            <a class = "opc-menu btn_click_shift_t" href="<?php echo base_url('admin/estoque/estoque_consulta') ?>"><i class="fa fa-eye fa-fw"></i> Consultar Estoque - <b class="atalho-shift"> sT </b> </a>
                        </li>

                        <li>
                             <p class = "menu-admin"> Tabelas </p>    
                        </li>
                         <li>
                            <a class = "opc-menu btn_click_shift_d" href="<?php echo base_url('admin/categoria') ?>"><i class="fa fa-sitemap fa-fw"></i> Categoria do Produto - <b class="atalho-shift"> sD </b></a>
                        </li>
                        <li>
                            <a class = "opc-menu btn_click_shift_m" href="<?php echo base_url('admin/marca') ?>"><i class="fa fa-tags fa-fw"></i> Marca do Produto - <b class="atalho-shift"> sM </b></a>
                        </li>
                        <li>
                            <a class = "opc-menu btn_click_shift_u" href="<?php echo base_url('admin/usuarios') ?>"><i class="fa fa-user fa-fw"></i> Usuários - <b class="atalho-shift"> sU </b></a>
                        </li>

                        <li>
                             <p class = "menu-admin"> </p>    
                        </li>

                        <li>
                            <a class = "opc-menu btn_click_shift_v" href="<?php echo base_url('venda') ?>"><i class="fa fa-money fa-fw"></i> Ir para Vendas - <b class="atalho-shift"> sV </b> </a>
                        </li

                        
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

   