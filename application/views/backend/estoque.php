<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12 text-center">
            <h4 class="page-header"> <?php echo "Entrada de Produtos no Estoque" ?></h4>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                   <?php echo "Cadastro de Estoque/Notas" ?>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 cadnota">
                        <?php 

                            // aqui vamos vericar os erros de validação
                            echo validation_errors('<div class="alert alert-warning">','</div>'); 
                            
                            // vamos abrir o formulário,
                                        // apontando para:admin/controlador/metodo
                            echo form_open('admin/estoque/inserir');
        
                            ?>
                            <div class="form-group col-lg-5 col-sm-11 vercons"> 
                                <label> Numero da Nota </label>
                                <input id="nrnota" name="nrnota" type="text"class = "form-control" placeholder ="Digite o Numero da Nota" value="<?php echo set_value('nrnota') ?>">

                            </div>

                            <div class="form-group col-lg-1 col-sm-1 ">
                                <label> Sem Nota </label>
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                </div> 
                            </div>

                            <div class="form-group col-lg-6 col-sm-12 vercons"> 
                                <label> Serie  </label>
                                <input id="serie" name="serie" type="text"class = "form-control" placeholder ="Digite o serie da Nota" value="<?php echo set_value('serie') ?>">
                            </div>

                            <div class="form-group col-lg-6 col-sm-12 vercons"> 
                                <label> Emitente  </label>
                                <input id="emitente" name="emitente" type="text"class = "form-control" placeholder ="Digite o Emitente da Nota" value="<?php echo set_value('emitente') ?>">
                            </div>

                            <div class="form-group col-lg-6 col-sm-12 vercons">  
                                <label> Valor da Nota R$ </label>
                                <input type="number" class="form-control" id="valornota" name="valornota" step="0.01" placeholder="0.00" value="<?php echo set_value('valornota') ?>">
                            </div>

                            <br>

                            <div class ="col-lg-12 col-sm-12 ">
                                <a href="">
                                    <button class="btn btn-primary" > 
                                        Adicionar Estoque/Nota
                                    </button> 
                                </a>
                            </div>
                        
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
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                   <?php echo "Manutenção de Entrada de ".$subtitulo." - Estoques Lançados" ?>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                  
                            <!-- gerar tabela de categorias pela framework PJCS --> 
                            <?php
                            $this->table->set_heading("DT Entrada","Numero", "Serie","Emitente","Valor R$", "Itens ", "Alterar", "Excluir"); 

                            foreach ($estoques as $estoque)
                            { 
                                $id     = $estoque->id; 
                                $nrnota= $estoque->nrnota;
                                $data1  = $estoque->dataentrada; 
                                $data = date("d-m-Y", strtotime($data1));
                                $serie = $estoque->serie;
                                $emitente= $estoque->emitente;
                                $valornota= number_format($estoque->valornota,2,",","."); 

                                $botaoitens = anchor(base_url('admin/estoque/itens/'.md5($estoque->id)),'<h4 class="btn-itens"> <i class="fa fa-file-text"> </i> Ver Itens </h4>');
                                $botaoalterar = anchor(base_url('admin/estoque/alterar/'.md5($id)),
                                    '<h4 class="btn-alterar"> <i class="fas fa-edit"> </i> Alterar </h4>');
                                $botaoexcluir= '<button type="button" class="btn btn-link" data-toggle="modal" data-target=".excluir-modal-'.$id.'"> <h4 class="btn-excluir"><i class="fa fa-remove fa-fw"></i>  Excluir </h4> </button>';

                                echo $modal= ' <div class="modal fade excluir-modal-'.$id.'" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                                                </button>
                                                <h4 class="modal-title" id="myModalLabel2"> <i class="fa fa-remove fa-fw"></i> Exclusão de Nota/Estoque </h4>
                                            </div>
                                            <div class="modal-body">
                                                <h4>Deseja Excluir a Nota '.$nrnota.'?</h4>
                                                <p>Após Excluida a Nota <b>'.$nrnota.'</b> não ficara mais disponível no Sistema.</p>
                                                <p>Todos os itens relacionados a Nota <b>'.$nrnota.'</b> serão afetados e não aparecerão no site até que sejam editados.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                                <a type="button" class="btn btn-danger" href="'.base_url('admin/usuarios/excluir/'.md5($id)).'">Excluir</a>
                                            </div>

                                        </div>
                                    </div>
                                </div>';

                                $this->table->add_row($data,$nrnota,$serie,$emitente, $valornota,$botaoitens,$botaoalterar,$botaoexcluir); 
                            }

                            $this->table->set_template(array(
                                'table_open' => '<table class="table table-striped">'
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

    </div>

</div>