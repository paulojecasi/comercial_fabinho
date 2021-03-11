<div id="page-wrapper">
    <div class="row">
        
        <div class="col-lg-12 text-center titulo-cad-prod">
            <h3 class="page-header-adm"> <?php echo "Administração de Produtos" ?></h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    <div class="row panel-cadastro-produto">
        <div class="col-lg-12">
            <div class="row">
                
                <div class="col-lg-6 btn-cadastro-produto">
                    <a href="<?php echo base_url('/admin/produto/cadastro') ?>">
                        <button class="btn btn-primary" > 
                            Cadastrar Produto 
                        </button> 
                    </a>
                </div>
                <div class="col-lg-6 filtro-list-produtos">
                    <?php
                        $tipolistprod=base_url('/admin/produto/tipolistagem');
                        $tipolistacurrent = $this->session->userdata('tipolista'); 
                    ?>
                    <h4> Filtro de listagem dos Produtos </h4>
                    <div>
                        <button  class="btn btn-default" class="tiporel" value="todos">
                            TODOS   
                        </button>
                        
                        <button class="btn btn-default"   class="tiporel" value="ativos"> 
                            Ativos  
                        </button>

                        <button class="btn btn-default" class="tiporel" value="inativos"> 
                            Inativos  
                        </button>
                    </div>

                </div>
                <section class= "col-lg-12">
                    <label for="nomeproduto"> Pesquisar Produto </label>
                    <input type="text" id="nomeproduto" name="nomeproduto" class="form-control consulta-prod-admin" autofocos required placeholder="Digite o Nome, ou Codigo do Produto, ou Código de Barras"  autofocus="true" />
                </section>
            </div>

            <p> </p>
            <div class="panel panel-default panel-produtos-admin-scroll">
                <section>
                    <table class="table table-hover consulta-produto-admin" id="resultado_consulta_produtos"
                    >
                        <thead>
                            <tr>
                                <th scope="col">Código</th>
                                <th scope="col">Descrição</th> 
                                <th scope="col">Vl Nota</th> 
                                <th scope="col">Vl Venda</th> 
                                <th scope="col">Cód Barras</th> 
                                <th scope="col">Saldo </th> 
                                <th scope="col"> Ativo</th>
                                <th scope="col"> Alterar </th>
                                <th scope="col"> Excluir </th>
                            </tr>
                        </thead>

                        <tbody>
                        </tbody>
                    </table>
                </section>  
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->
