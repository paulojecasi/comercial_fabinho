<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12 text-center">
            <h4 class="page-header"> <?php echo "Entrada de Produtos no Estoque - Cadastro de Notas" ?></h4>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    <div class="row panel-dados-nota-scroll">
        <div class="col-lg-12">
            <div class="panel panel-default">
           
                <div class="panel-body panel-cadastro-nota-estoque">
                    <div class="row">
                        <div class="col-lg-12 cadnota">
                        <?php 

                            foreach ($numero_nota_auto as $nota_aut) {
                               $numero_nota_aut = $nota_aut->codigo_nota_automatica ;
                            }

                            // aqui vamos vericar os erros de validação
                            echo validation_errors('<div class="alert alert-warning">','</div>'); 
                            
                            // vamos abrir o formulário,
                                        // apontando para:admin/controlador/metodo
                            echo form_open('admin/estoque/inserir');
        
                            ?>
                            <input id="nrnota_aut" name="nrnota_aut" type="hidden"class = "form-control"   value="<?php  echo $numero_nota_aut ?>">

                            <div class="form-group col-lg-5 vercons"> 
                                <label> Numero da Nota </label>
                                <input id="nrnota" name="nrnota" type="text"class = "form-control" placeholder ="Digite o Numero da Nota" value="<?php echo set_value('nrnota') ?>" required>

                            </div>

     
                            <div class="form-group col-lg-2 col-sm-2 check-sem-nota text-center">
                                <label> Sem Nota </label>
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" id="check-sem-nota">
                                </div> 
                            </div>


                            <div class="form-group col-lg-5 col-sm-10 vercons"> 
                                <label> Serie  </label>
                                <input id="serie" name="serie" type="text"class = "form-control" placeholder ="Digite o serie da Nota" value="<?php echo set_value('serie') ?>" required>
                            </div>

                            <div class="form-group col-lg-5 col-sm-12 vercons"> 
                                <label> Emitente  </label>
                                <input id="emitente" name="emitente" type="text"class = "form-control" placeholder ="Digite o Emitente da Nota" value="<?php echo set_value('emitente') ?>" required>
                            </div>

                            <div class="form-group col-lg-5 col-sm-12 vercons">  
                                <label> Valor da Nota R$ </label>
                                <input type="number" class="form-control" id="valornota" name="valornota" step="0.01" placeholder="0.00" value="<?php echo set_value('valornota') ?>" required>
                            </div>

                            <br>

                            <div class ="col-lg-2 col-sm-12 text-center ">
                                <a href="">
                                    <button class="btn btn-primary btn-adicionar-nota"  > 
                                        Adicionar Nota
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
            <div class="panel panel-default ">
                <div class="panel-heading text-center notas-entradas">
                    <h3> <?php echo "Notas Cadastradas" ?> </h3> 
                </div>
                <div class="panel-body notas-cadastradas-scroll">
                    <div class="row">
                        <div class="col-lg-12">
                  
                            <!-- gerar tabela de categorias pela framework PJCS --> 
                            <?php
                            $this->table->set_heading("DT Entrada","Numero", "Serie","Emitente","Valor R$","Situação", "Consultar Nota"); 

                            foreach ($estoques as $estoque)
                            { 
                                $id     = $estoque->id; 
                                $nrnota= $estoque->nrnota;
                                $data1  = $estoque->dataentrada; 
                                $data = date("d-m-Y", strtotime($data1));
                                $serie = $estoque->serie;
                                $emitente= $estoque->emitente;
                                $situacao = $estoque->situacao; 
                                $valornota= number_format($estoque->valornota,2,",","."); 

                                foreach ($situacao_nota as $sitnota) {
                                    if ($situacao == $sitnota->tiposituacao)
                                    {
                                        $nosituacao_nt = $sitnota->dessituacao; 
                                        if ($situacao  == 0)
                                        {
                                            $nosituacao_nt =
                                            '<b class="field-aberta">'
                                                .$nosituacao_nt.'
                                            </b>';
                                        }
                                        elseif ($situacao  == 1)
                                        {
                                            $nosituacao_nt=
                                            '<b class="field-fechada">'
                                                .$nosituacao_nt.'
                                            </b>';
                                        }
                                        elseif ($situacao  == 2)
                                        {
                                            $nosituacao_nt=
                                            '<b class="field-cancelada">'
                                                .$nosituacao_nt.'
                                            </b>';
                                        }
                                    }
                                }

                                $botaoitens = anchor(base_url('admin/estoque/itens/'.md5($estoque->id)),'<h4 class="btn-itens"> <i class="fa fa-file-text"> </i> Consultar Nota </h4>');

                                /*
                                $botaofechar = anchor(base_url('admin/estoque/itens/'.md5($estoque->id)),'<h4 class="btn-fechar"> <i class="fa fa-check"> </i> Fechar Nota </h4>');
                          
                                $botaoexcluir= '<button type="button" class="btn btn-link" data-toggle="modal" data-target=".excluir-modal-'.$id.'"> <h4 class="btn-excluir"><i class="fa fa-ban fa-fw"></i>  Cancelar Nota </h4> </button>';

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
                                */

                                $this->table->add_row($data,$nrnota,$serie,$emitente, $valornota,$nosituacao_nt,$botaoitens); 
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


