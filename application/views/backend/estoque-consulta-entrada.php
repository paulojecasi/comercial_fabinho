<div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                   <?php echo "Manutenção de Entrada de ".$subtitulo ?>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                  
                            <!-- gerar tabela de categorias pela framework PJCS --> 
                            <?php
                            $this->table->set_heading("Numero", "Serie","Emitente","Valor",
                                                        "Alterar",
                                                        "Excluir"); 

                            foreach ($estoques as $estoque)
                            { 
                                $nrnota= $estoque->nrnota;
                                $serie = $estoque->serie;
                                $emitente= $estoque->emitente;
                                $valornota= $estoque->valornota;


                                $botaoalterar = anchor(base_url('admin/estoque/alterar/'.md5($categoria->id)),
                                    '<i class="fas fa-edit"> </i> Alterar');
                                $botaoexcluir = anchor(base_url('admin/estoque/excluir/'.md5($categoria->id)),
                                    '<i class="fa fa-remove fa-fw"> </i> Excluir');

                                $this->table->add_row($nrnota,$serie,$emitente, $valornota,$botaoalterar,$botaoexcluir); 
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
        <!-- /.col-lg-12 -->