<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12 text-center">
            <h3 class="page-header"> <?php echo "Administrar ".$subtitulo ?></h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-4">
                    <a href="<?php echo base_url('/admin/produto/cadastro') ?>">
                        <button class="btn btn-primary" > 
                            Cadastrar Produto 
                        </button> 
                    </a>
                </div>
                <div class="col-lg-8 filtro-list-produtos">
                    <?php
                        $tipolistprod=base_url('/admin/produto/tipolistagem');
                        $tipolistacurrent = $this->session->userdata('tipolista'); 
                    ?>
                    <h4> Filtro de listagem dos Produtos </h4>
                    <div>
                        <a href="<?php echo $tipolistprod."/todos" ?>"
                            <?php
                            if ($tipolistacurrent=='todos'): 
                                ?>
                                class="btn btn-info" 
                                <?php
                            endif;
                            ?>
                        >   TODOS   </a>
                        <a href="<?php echo $tipolistprod."/destsim" ?>"
                            <?php
                            if ($tipolistacurrent=='destsim'): 
                                ?>
                                class="btn btn-info" 
                                <?php
                            endif;
                            ?>
                        > Destaque(S)  </a>
                        <a href="<?php echo $tipolistprod."/destnao" ?>"
                            <?php
                            if ($tipolistacurrent=='destnao'): 
                                ?>
                                class="btn btn-info" 
                                <?php
                            endif;
                            ?>
                        > Destaque(N)  </a>
                        <a href="<?php echo $tipolistprod."/sitesim" ?>"
                            <?php
                            if ($tipolistacurrent=='sitesim'): 
                                ?>
                                class="btn btn-info" 
                                <?php
                            endif;
                            ?>
                        > Site(S)  </a>
                        <a href="<?php echo $tipolistprod."/sitenao" ?>"
                            <?php
                            if ($tipolistacurrent=='sitenao'): 
                                ?>
                                class="btn btn-info" 
                                <?php
                            endif;
                            ?>
                        > Site(N)  </a>
                        <a href="<?php echo $tipolistprod."/ativos" ?>"
                            <?php
                            if ($tipolistacurrent=='ativos'): 
                                ?>
                                class="btn btn-info" 
                                <?php
                            endif;
                            ?>
                        > Ativos   </a>
                        <a href="<?php echo $tipolistprod."/inativos" ?>"
                            <?php
                            if ($tipolistacurrent=='inativos'): 
                                ?>
                                class="btn btn-info" 
                                <?php
                            endif;
                            ?>
                        > Inativos </a>
                    </div>
                </div>
            </div>
            <p> </p>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-lg-7">
                           <h4> <?php echo "Manutenção de ".$subtitulo ?> </h4>
                       </div>
                       <div class="item-page col-lg-5">
                           
                            <label class= "text-right"> 
                               Itens por Pagina:  
                            </label>
                            <?php
                                $itenspagina=base_url('/admin/produto/itensporpagina');
                            ?>
                            <a href="<?php echo $itenspagina."/a" ?>"
                                <?php
                                if ($this->session->userdata('qtdItensInfo')=='a'): 
                                    ?>
                                    class="btn btn-info" 
                                    <?php
                                endif;
                                ?>
                             >    
                                05 
                            </a>


                            <a href="<?php echo $itenspagina."/b" ?>"
                                <?php
                                if ($this->session->userdata('qtdItensInfo')=='b'): 
                                    ?>
                                    class="btn btn-info" 
                                    <?php
                                endif;
                                ?>
                            >
                                10
                            </a>
                            <a href="<?php echo $itenspagina."/c" ?>"
                                <?php
                                if ($this->session->userdata('qtdItensInfo')=='c'): 
                                    ?>
                                    class="btn btn-info" 
                                    <?php
                                endif;
                                ?>
                            >
                                15 
                            </a>
                            <a href="<?php echo $itenspagina."/d" ?>"
                                <?php
                                if ($this->session->userdata('qtdItensInfo')=='d'): 
                                    ?>
                                    class="btn btn-info" 
                                    <?php
                                endif;
                                ?>
                            > 
                                20 
                            </a>
                            <a href="<?php echo $itenspagina."/e" ?>"
                                <?php
                                if ($this->session->userdata('qtdItensInfo')=='e'): 
                                    ?>
                                    class="btn btn-info" 
                                    <?php
                                endif;
                                ?>
                            >
                                25 
                            </a>
                            <a href="<?php echo $itenspagina."/f" ?>"
                                <?php
                                if ($this->session->userdata('qtdItensInfo')=='f'): 
                                    ?>
                                    class="btn btn-info" 
                                    <?php
                                endif;
                                ?>
                            > 
                                30 
                            </a>

                            <a href="<?php echo $itenspagina."/g" ?>"
                                <?php
                                if ($this->session->userdata('qtdItensInfo')=='g'): 
                                    ?>
                                    class="btn btn-info" 
                                    <?php
                                endif;
                                ?>
                            > 
                                40 
                            </a>
                            <a href="<?php echo $itenspagina."/h" ?>"
                                <?php
                                if ($this->session->userdata('qtdItensInfo')=='h'): 
                                    ?>
                                    class="btn btn-info" 
                                    <?php
                                endif;
                                ?>
                            > 
                                50 
                            </a>

                          
                       </div>
                    </div>

                </div>


                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 fotos-lista-produtos">
                  
                            <!-- gerar tabela de categorias pela framework PJCS --> 
                            <?php
                            $semFoto = "assets/frontend/img/products/sem_foto.jpg";

                            $this->table->set_heading("Imagem","Nome do Produto","Site","Ativo","Destaq","Alterar", "Excluir"); 

                            foreach ($produtos as $produto)
                            {   
                                $id = $produto->idproduto;
                                $nome = $produto->desproduto; 
                              
                                if ($produto->img !=''){
                                    $foto   = img($produto->img);
                                }else{
                                    $foto   = img($semFoto);
                                }
                         
                                $desproduto= $produto->desproduto; 
                               
                                if ($produto->produtosite==1){
                                    $site = "SIM";
                                }else{
                                    $site = "NAO";
                                }

                                if ($produto->produtoativo==1){
                                    $ativo = "SIM";
                                }else{
                                    $ativo = "NAO";
                                }

                                if ($produto->produtodestaque==1){
                                    $destaque = "SIM";
                                }else{
                                    $destaque = "NAO";
                                }

                                
                                $botaoalterar = anchor(base_url('admin/produto/alterar/'.md5($id)),
                                    '<h4 class="btn-alterar"><i class="fas fa-edit"> </i> Alterar </h4>');
                     
                                $botaoexcluir= '<button type="button" class="btn btn-link" data-toggle="modal" data-target=".excluir-modal-'.$id.'"> <h4 class="btn-excluir"><i class="fa fa-remove fa-fw"></i>  Excluir </h4> </button>';

                                echo $modal= ' <div class="modal fade excluir-modal-'.$id.'" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                                                </button>
                                                <h4 class="modal-title" id="myModalLabel2"> <i class="fa fa-remove fa-fw"></i> Exclusão de Produto </h4>
                                            </div>
                                            <div class="modal-body">
                                                <h4>Deseja Excluir o Produto '.$nome.'?</h4>
                                                <p>Após Excluido, o Produto <b>'.$nome.'</b> não ficara mais disponível no Sistema.</p>
                                                <p>Todos os itens relacionados ao Produto <b>'.$nome.'</b> serão afetados e não aparecerão no site até que sejam editados.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                                <a type="button" class="btn btn-danger" href="'.base_url('admin/produto/excluir/'.md5($id)).'">Excluir</a>
                                            </div>

                                        </div>
                                    </div>
                                </div>';

                                $this->table->add_row($foto, $desproduto,$site,$ativo,$destaque, $botaoalterar,$botaoexcluir); 
                            }

                            $this->table->set_template(array(
                                'table_open' => '<table class="table table-striped">'
                            ));

                            echo $this->table->generate(); 
                            echo "<div class='paginacao'>".$links_paginacao."</div>";

                            ?>
                                        
                        </div>
                        
                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->
