    <div id="wrapper">

        <?php 
            $usuario_permissao  = $this->session->userdata('userLogado')->tipo_acesso;
        ?>

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
                             <p class = "menu-admin"> </p>    
                        </li>

                        <!--
                        <li class= "navegacao text-center" id="navegacao-backup">
                            <a href="<?php echo 'http://localhost/phpmyadmin/db_export.php?db=comercial_fabinho' ?>" target="_blank"> <i class="fa fa-floppy-o" aria-hidden="true"></i> &nbsp  Fazer Backup </a>
                        </li>
                        --> 

                        <li class= "navegacao text-center" id="navegacao-backu">
                            <a href="<?php echo 'http://localhost/phpmyadmin/db_export.php?db=comercial_fabinho' ?>" target="_blank"> 
                                <img src="<?php echo base_url("assets/frontend/img/backp.png"); ?>">
                            </a>
                        </li>
                        
                        <li>
                             <p class = "menu-admin"> Caixa </p>    
                        </li>
                         <li  class= "navegacao">
                            <a href="<?php echo base_url('admin/caixa') ?>" class="opc-menu btn_click_shift_a ">  <b class="atalho-shift atl-atl"> sA </b> &nbsp Abrir / Fechar  </a> 
                        </li>
                       
                       <?php
                        if ($usuario_permissao ==3):
                        ?>

                            <li  class= "navegacao">
                                <a href="<?php echo base_url('admin/relatorios/') ?>" class="opc-menu btn_click_shift_a ">  <b class="atalho-shift atl-atl"> sR </b> &nbsp Relatórios  </a> 
                            </li>

                            <li>
                                 <p class = "menu-admin"> Produtos </p>    
                            </li>
                            <li class= "navegacao">
                                <a class = "opc-menu btn_click_shift_p" href="<?php echo base_url('admin/produto') ?>"><b class="atalho-shift atl-atl"> sP </b> &nbsp Cadastro de Produtos </a>
                            </li>
                            <li class= "navegacao">
                                <a class = "opc-menu btn_click_shift_e" href="<?php echo base_url('admin/estoque') ?>"><b class="atalho-shift atl-atl"> sE </b> &nbsp Entrada no Estoque </a>
                            </li>

                            <li class= "navegacao">
                                <a class = "opc-menu btn_click_shift_t" href="<?php echo base_url('admin/estoque/estoque_consulta') ?>"><b class="atalho-shift atl-atl"> sT </b> &nbsp Consultar Estoque  </a>
                            </li>

                            <li>
                                 <p class = "menu-admin"> Tabelas </p>    
                            </li>
                             <li class= "navegacao">
                                <a class = "opc-menu btn_click_shift_d" href="<?php echo base_url('admin/categoria') ?>"><b class="atalho-shift atl-atl"> sD </b> &nbsp Categoria do Produto </a>
                            </li>
                            <li class= "navegacao">
                                <a class = "opc-menu btn_click_shift_m" href="<?php echo base_url('admin/marca') ?>"><b class="atalho-shift atl-atl"> sM </b> &nbsp Marca do Produto </a>
                            </li>
                            <li class= "navegacao">
                                <a class = "opc-menu btn_click_shift_u" href="<?php echo base_url('admin/usuarios') ?>"><b class="atalho-shift atl-atl"> sU </b> &nbsp Usuários </a>
                            </li>
                            <?php
                        endif; 
                        ?>

                        <li>
                             <p class = "menu-admin"> </p>    
                        </li>

                        <li class= "navegacao">
                            <a class = "opc-menu btn_click_shift_v" href="<?php echo base_url('venda') ?>"><b class="atalho-shift atl-atl"> sV </b> &nbsp  Ir para Vendas </a>
                        </li>
                   
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

   