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
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                   <h4> <?php echo $subtitulo ?> </h4>
                </div>
                <div class="panel-body panel-cadastro-user">
                    <div class="row">
                        <div class="col-lg-12 fotos-usuarios">
                  
                            <!-- gerar tabela de usuarios pela framework PJCS --> 
                            <?php
                            $semFoto = "assets/frontend/img/usuarios/sem_foto.jpg";

                            $this->table->set_heading(  "Id", "Numero",
                                                        "Data Abertura",
                                                        "Data Fechamento",
                                                        "Situação",
                                                        "Abrir Caixa","Fechar Caixa"); 

                            foreach ($lista_caixas as $caixa)
                            {   

                                $idcaixa   = $caixa->idcaixa;
                                $numerocaixa = $caixa->numerocaixa;
                                $dataa = $caixa->dataabertura;
                                $dataf  = $caixa->datafechamento;
                                $situacao = $caixa->situacaocaixa;

                                if ($dataa == null){
                                    $dataa= "Não Aberto"; 
                                }else{
                                    $dataa = datebr($dataa); 
                                }

                                if ($dataf == null){
                                    $dataf= "Não Fechado"; 
                                }else{
                                    $dataf = datebr($dataf); 
                                }

                                $nosituacao = "";
                                $botaoabrir ="---";
                                $botaofechar = "---"; 

                                if ($situacao==0)
                                {
                                    $nosituacao = '<b id="sit-caixa-fechado">  FECHADO </b>';

                                    $botaoabrir = anchor(base_url('admin/caixa/abrir/'.$idcaixa),
                                    '<h4 class="btn-alterar"><i class="fa fa-folder-open"> </i>   </h4>');
                                }
                                else
                                {
                                    $nosituacao = '<b id="sit-caixa-aberto"> CAIXA ESTÁ ABERTO </b>' ; 
                                    $botaofechar = anchor(base_url('admin/caixa/fechar/'.$idcaixa),
                                    '<h4 class="btn-alterar"><i class="fa fa-folder"> </i>   </h4>');
                                }

                                $this->table->add_row($idcaixa, $numerocaixa, $dataa, $dataf, $nosituacao, $botaoabrir, $botaofechar); 
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
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper --> 