<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12 text-center">
            <h3 class="page-header"> <?php echo "Administrar ".$subtitulo ?></h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                   <h4> <?php echo "Adicionar nova ".$subtitulo ?> </h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">


                        <!-- nao vamos utilizar a abertura do form, vamos usar o HELPER do
                        framework (form_open) --> 
              
                            <?php
                            // aqui vamos vericar os erros de validação
                            echo validation_errors('<div class="alert alert-warning">','</div>'); 
                            
                            // vamos abrir o formulário,
                                        // apontando para:admin/controlador/metodo
                            echo form_open('admin/marca/inserir');
        
                            ?>
                            <div class="form-group"> 
                                <label> Nome da Marca </label>
                                <input id="desmarca" name="desmarca" type="text"class = "form-control" placeholder ="Digite o nome da Marca" autofocus="true" required>
                            </div>

                            <br>
                            <a href="">
                                <button class="btn btn-primary person btn_click_shift_f4" > 
                                    &nbsp Cadastrar  &nbsp <b class="atl-alt-s"> &nbsp  sF4 &nbsp </b>
                                </button> 
                            </a>
                      
                            <?php 
                            // fechar o formulario 
                            echo form_close();
                            ?> 
                            
                        </div>
                        
                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>

        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                   <H4><?php echo "Alterar ".$subtitulo." existente" ?> </H4>
                </div>
                <div class="panel-body panel-altera-marca">
                    <div class="row">
                        <div class="col-lg-12">
                  
                            <!-- gerar tabela de categorias pela framework PJCS --> 
                            <?php
                            $this->table->set_heading("Nome da Marca", 
                                                        "Alterar",
                                                        "Excluir"); 

                            foreach ($marcas as $marca)
                            { 
                                $nomemarca= $marca->desmarca;
                                $id = $marca->idmarca; 


                                $botaoalterar = anchor(base_url('admin/marca/alterar/'.md5($marca->idmarca)),
                                    '<h4 class="btn-alterar"><i class="fas fa-edit"> </i>   </h4>');
                                $botaoexcluir= '<button type="button" class="btn btn-link" data-toggle="modal" data-target=".excluir-modal-'.$id.'"> <h4 class="btn-excluir"><i class="fa fa-remove fa-fw"></i>    </h4> </button>';

                                echo $modal= ' <div class="modal fade excluir-modal-'.$id.'" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                                                </button>
                                                <h4 class="modal-title" id="myModalLabel2"> <i class="fa fa-remove fa-fw"></i> Exclusão de Marca do Produto </h4>
                                            </div>
                                            <div class="modal-body">
                                                <h4>Deseja Excluir a Marca '.$nomemarca.'?</h4>
                                                <p>Após Excluida a Marca <b>'.$nomemarca.'</b> não ficara mais disponível no Sistema.</p>
                                                <p>Todos os itens relacionados a Marca <b>'.$nomemarca.'</b> serão afetados e não aparecerão no site até que sejam editados.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                                <a type="button" class="btn btn-danger" href="'.base_url('admin/marca/excluir/'.md5($id)).'">Excluir</a>
                                            </div>

                                        </div>
                                    </div>
                                </div>';

                                $this->table->add_row($nomemarca,$botaoalterar,$botaoexcluir); 
                            }

                            $this->table->set_template(array(
                                'table_open' => '<table class="table table-striped table-uper-case">'
                            ));

                            echo $this->table->generate(); 
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