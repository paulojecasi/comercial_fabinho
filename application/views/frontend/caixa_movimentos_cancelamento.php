<div class = "row">

    <div class = "text-center titulo-tela-consulta-movimento-cx">
        <h2>Movimentos do Dia do Caixa : <b> <?php echo $idcaixa ?> </b>  </h2>
    </div>
  

    <?php
    if (!$datainicio){
        $datainicio =date('Y-m-d');
    }

    if (!$datafinal){
        $datafinal =date('Y-m-d');
    }
    echo form_open('caixa/movimento_cancel_mov_caixa');
    ?>

    <div class = "col-lg-12 col-sm-12 tela-movimento-caixa">

        <section id="dt-movimento-caixa">
            <div class="form-group col-lg-3 campo-titulo-mov-cx">
       
                <h4> Periodo do movimento: </h4>

            </div>
            <div class="form-group col-lg-3 campo-data-movcx">
                <input type="date" id="datainicial_movc" name="datainicial_movc" maxlength="10" class="form-control" value="<?php echo $datainicio  ?>"  onkeydown="javascript:EnterTab('datafinal_mov',event)" autofocus="true"  />

            </div>
      
            <div class="form-group col-lg-3 campo-data-movcx">
                <input type="date" id="datafinal_movc" name="datafinal_movc" class="form-control" value="<?php echo $datafinal  ?>"  onkeydown="javascript:EnterTab('nomeproduto',event)" autofocus="true" />
            </div>

            <div class ="col-lg-3 btn-finalizar-venda  btn-dados-mov-prod text-center">
                <a> 
                    <button class="btn btn-success" type="submit" id="btn-busca-mov-prod"  > 
                        Gerar Dados
                    </button> 
                </a>
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
                    $idretirada=0;
                    $vl_saldo_venda=0; 

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
                        $idretirada = $movimento_caixa_result->idretirada; 
                        $vl_saldo_venda = $movimento_caixa_result->vlsaldo_crediario; 



                        $total_real += $vl_real; 
                        $valor_real = $vl_real; 
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

                        if ($tipo_movimento ==4)
                        {
                            if ($valor_real != $vl_saldo_venda)
                            {
                                // vamos ver se a venda-crediário ja teve alguma parcela paga, se sim
                                // a mesma não poderá ser cancelada, primeiramente tera que cancelas as
                                // parcelas
                                $botaocancelar = "Tem Parcela PG"; 
                            }
                        }

                        if ($tipo_movimento ==5
                            || $tipo_movimento==9
                            || $tipo_movimento==10){

                            $botaovenda ="";
                        } 
                        else
                        {
                            $botaovenda = anchor(base_url('venda/consulta_venda/'.md5($idvenda)),
                            '<h4 class="btn-alterar"><i class="fas fa-shopping-cart"> </i> </h4>');
                        }


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
                                        <a type="button" class="btn btn-danger" href="'.base_url('caixa/cancelamentar_movimento/'.md5($idcaixa_mov).'/'.md5($idvenda).'/'.$tipo_movimento).'/'.$valor_real.'/'.md5($idcliente).'/'.md5($idretirada). '">Excluir</a>
                                    </div>

                                </div>
                            </div>
                        </div>';


                        $this->table->add_row($idcaixa_mov,$idvenda,$data_movimento,$codigousuario,$desmovimento,$despagamento,$vl_juros,$vl_desconto, $vl_real,$situacao, $botaovenda, $botaocancelar);
                    }
                    $this->table->set_template(array(
                                    'table_open' => '<table class="table table-striped">'
                    ));

                    echo $this->table->generate(); 

                    if (!$movimento_caixa_do_dia):
                    ?> 
                        <div class="text-center mens-sem-movimento">
                           <h1> Sem movimento no periódo informado! </h1>
                       </div>
                       <?php 
                   endif;
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

