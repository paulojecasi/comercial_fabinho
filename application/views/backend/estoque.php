<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12 text-center">
            <h4 class="page-header"> <?php echo "Entrada de Produtos no Estoque - Cadastro de Notas" ?>
                
            </h4>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    <div class="row panel-dados-notas">
        <div class="col-lg-12">
            <div class="panel-default">
           
                <div class="panel-cadastro-nota-estoque">
                    <div class="col-lg-12 cadnota back-color-default">
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

                        <div class="form-group col-lg-5 verconsn"> 
                            <label> Numero da Nota </label>
                            <input id="nrnota" name="nrnota" type="text"class = "form-control" placeholder ="Digite o Numero da Nota" value="<?php echo set_value('nrnota') ?>" autofocus ="true" required>

                        </div>

 
                        <div class="form-group col-lg-2 col-sm-2 check-sem-nota text-center">
                            <label> Sem Nota </label>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" id="check-sem-nota">
                            </div> 
                        </div>


                        <div class="form-group col-lg-5 col-sm-10 verconsn"> 
                            <label> Serie  </label>
                            <input id="serie" name="serie" type="text"class = "form-control" placeholder ="Digite o serie da Nota" value="<?php echo set_value('serie') ?>" required>
                        </div>

                        <div class="form-group col-lg-5 col-sm-12 verconsn"> 
                            <label> Emitente  </label>
                            <input id="emitente" name="emitente" type="text"class = "form-control" placeholder ="Digite o Emitente da Nota" value="<?php echo set_value('emitente') ?>" required>
                        </div>

                        <div class="form-group col-lg-3 col-sm-12 verconsn">  
                            <label> Valor da Nota R$ </label>
                            <input type="number" class="form-control" id="valornota" name="valornota" step="0.01" placeholder="0.00" value="<?php echo set_value('valornota') ?>" required>
                        </div>

                        <br>

                        <div class ="col-lg-4 col-sm-12 text-center ">
                            <a href="">
                                <button class="btn btn-primary btn-adicionar-nota person btn_click_shift_f4"  > 
                                    &nbsp Gravar Nota &nbsp <b class="atl-alt-s"> &nbsp  sF4 &nbsp </b> 
                                </button> 
                            </a>
                        </div>
                    
                        <?php 
                        // fechar o formulario 
                        echo form_close();
                        ?> 
                        
                    </div>
                    
           
                </div>
                <!-- /.panel-body -->
                
            </div>
            <!-- /.panel -->
        </div>
        <div class="col-lg-12">
            <div class="panel panel-default ">
                <div class="text-center title-notas-entradas">
                    <h4> <?php echo "Notas Cadastradas" ?> </h4> 
                </div>
                <div class="col-lg-12 notas-cadastradas-scroll">
                    <div class="row">
                        <div class="notas-cadastradass">
                  
                            <!-- gerar tabela de categorias pela framework PJCS --> 
                            <?php
                            $this->table->set_heading("DT Entrada","Numero", "Serie","Emitente","Valor R$","Situação", "Nota"); 

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
                                $nosit = " "; 

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
                                            $nosit = "Cadastrar Item";

                                        }
                                        elseif ($situacao  == 1)
                                        {
                                            $nosituacao_nt=
                                            '<b class="field-fechada">'
                                                .$nosituacao_nt.'
                                            </b>';
                                            $nosit = "Consultar Nota";
                                        }
                                        elseif ($situacao  == 2)
                                        {
                                            $nosituacao_nt=
                                            '<b class="field-cancelada">'
                                                .$nosituacao_nt.'
                                            </b>';
                                            $nosit = "Consultar Nota";
                                        }

                                        $botaoitens = anchor(base_url('admin/estoque/itens/'.md5($estoque->id)),'<h4 class="btn-itens"> <i class="fa fa-file-text"> </i> '.$nosit.'</h4>');
                                    }
                                }

                           

                                $this->table->add_row($data,$nrnota,$serie,$emitente, $valornota,$nosituacao_nt,$botaoitens); 
                            }

                            $this->table->set_template(array(
                                'table_open' => '<table class="table table-hover">'
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


