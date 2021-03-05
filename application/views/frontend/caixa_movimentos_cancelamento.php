<div class = "row">

    <div class = "text-center titulo-tela-consulta-movimento-cx">
        <h2> Cancelamento de Movimento do Caixa : <b> <?php echo $idcaixa ?> </b>  </h2>
    </div>
  

    <?php
    // tela VALOR DA VENDA
    //$this->load->view('frontend/template/valor-venda');
    echo form_open('caixa/consulta_dados_caixa');
    ?>

    <div class = "col-lg-12 col-sm-12 tela-movimento-caixa">

        <section id="dt-movimento-caixa">
            <div class="form-group col-lg-3 campo-titulo-mov-cx">
       
                <h4> Periodo do movimento: </h4>

            </div>
            <div class="form-group col-lg-3 campo-data-movcx">
                <input type="date" id="datainicial_mov" name="datainicial_mov" maxlength="10" class="form-control" value="<?php echo date('Y-m-d')  ?>"  onkeydown="javascript:EnterTab('datafinal_mov',event)" autofocus="true" />

            </div>
      
            <div class="form-group col-lg-3 campo-data-movcx">
                <input type="date" id="datafinal_mov" name="datafinal_mov" class="form-control" value="<?php echo date('Y-m-d')  ?>"  onkeydown="javascript:EnterTab('nomeproduto',event)" autofocus="true" />
            </div>


            <input type="hidden" id="idcaixa_mov" name="idcaixa_mov" value="<?php echo $idcaixa ?>">
            
        </section>


        <div class="col-lg-12 table-mov-caixa">
            <div>
                <section id="table-scroll">
            
                    <?php

                    $this->table->set_heading("Cod","Cod Venda","Data","Usuário","Tipo","Pagamento","Juros","Descontos","Vl Movimento","Situacao","Ver Venda","Cancelar" );

                    $vl_movimento=0;
                    $vl_juros =0;
                    $vl_desconto =0; 
                    $tipo_movimento; 

                    $idcaixa_mov = 0;
                    $idcliente =0; 
                    $data_movimento =0; 
                    $desmovimento = "";
                    $despagamento = "";

                    $avista = 0;
                    $cartaodebito =0;
                    $cartaocredito =0;
                    $crediario =0;
                    $crediarioreceb =0; 
                    $vl_real =0; 
                    $total_real=0; 
                    $situacao = ""; 

                    foreach ($movimento_caixa_do_dia as $movimento_caixa_result) 
                    {
                        $tipo_movimento= $movimento_caixa_result->tipo_movimento_caixa;
                        $vl_movimento = $movimento_caixa_result->vl_movimento;
                        $vl_juros       = $movimento_caixa_result->vl_juros;
                        $vl_desconto    = $movimento_caixa_result->vl_desconto;
                        $vl_real            = $vl_movimento + $vl_juros - $vl_desconto; 
                        $idvenda        = $movimento_caixa_result->idvenda; 
                        $idcaixa_mov    = $movimento_caixa_result->idcaixa_mov;
                        $idcliente      = $movimento_caixa_result->idcliente;
                        $data_movimento= datebr($movimento_caixa_result->data_movimento);
                        $desmovimento = $movimento_caixa_result->desmovimento;
                        $despagamento   = $movimento_caixa_result->destipopagamento; 
                        $codigousuario = $movimento_caixa_result->codigousuario; 
                        $situacao       = $movimento_caixa_result->situacao; 



                        $total_real += $vl_real; 

                        $vl_juros = reais($vl_juros); 
                        $vl_desconto = reais($vl_desconto);
                        $vl_real = reais($vl_real); 

                        $botaocancelar = ""; 
                        if ($situacao==0)
                        {
                            $situacao = "Normal"; 
                            $situacao = '<b id="normal">'.$situacao.'</b>';

                            $botaocancelar= '<button type="button" class="btn btn-link" data-toggle="modal" data-target=".excluir-modal-'.$idcaixa_mov.'"> <h4 class="btn-excluir"><i class="fa fa-remove fa-fw"></i> </h4> </button>';

                        }
                        else
                        {
                            $situacao = "CANCELADO";    

                            $situacao = '<b id="cancel">'.$situacao.'</b>';
                        }


                        $botaoitens = anchor(base_url('venda/produto_temp_altera/'.md5($idvenda)),
                            '<h4 class="btn-alterar"><i class="fas fa-edit"> </i> </h4>');


                        echo $modal= ' <div class="modal fade excluir-modal-'.$idcaixa_mov.'" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                                        </button>
                                        <h4 class="modal-title text-center" id="myModalLabel2"> <i class="fa fa-remove fa-fw"></i> Exclusão de Movimento do Caixa </h4>
                                    </div>
                                    <div class="modal-body">
                                        <h4>Deseja Excluir o Movimento '.$idcaixa_mov.'?</h4>
                                        <p>Após Excluir o Movimento, a Venda ou Recebimento referente ao Movimento <b>'.$idcaixa_mov.'</b>  será cancelada.</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                        <a type="button" class="btn btn-danger" href="'.base_url('caixa/confirma_cancelamento_mov/'.md5($idcaixa_mov).'/'.md5($idvenda).'/'.$tipo_movimento).'">Excluir</a>
                                    </div>

                                </div>
                            </div>
                        </div>';


                        $this->table->add_row($idcaixa_mov,$idvenda, $data_movimento,$codigousuario,$desmovimento,$despagamento,$vl_juros,$vl_desconto, $vl_real,$situacao, $botaoitens, $botaocancelar);
                    }
                    $this->table->set_template(array(
                                    'table_open' => '<table class="table table-striped">'
                    ));

                    echo $this->table->generate(); 

                    ?> 
         
                </section>  
                <!-- /.panel-body -->
            </div>
        </div>

        <div class="form-group col-lg-12 btn-link-mov-cx-cancel"> 
            <div class ="col-lg-12 text-center link-voltar link-voltar-tela-inicio ">
                <a href="<?php echo base_url('venda') ?>">
                       <i class="fa fa-home" aria-hidden="true"></i> Ir para Venda
                </a>
            </div>
        </div>
    </div>
</div>

