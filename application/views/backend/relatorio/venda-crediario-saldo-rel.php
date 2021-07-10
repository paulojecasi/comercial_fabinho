<div id="page-wrapper-pj">
    
    <?php 
        $this->load->view('backend/template/cabecalho-rel');
    ?>

        <div class="col-lg-12 table-mov-caixa-pro">
            <div>
                <section id="table-scroll-rel">
            
                    <?php

                    $this->table->set_heading("Codigo Venda","Data Venda","Cliente","","Vl Venda","Valor Saldo","Dias Atr","Situacao");

                     
                    $idvenda = 0;
                    $datavenda =0;
                    $idcliente =0;
                    $vlvenda =0;
                    $vlsaldo =0;
                    $diasatr =0;
                    $situacao ="";
                    $valor_vendido=0;
                    $valor_aberto=0;
                    $valor_recebido=0; 

                    $data_hoje = date('Y-m-d');                

                    foreach ($vendas_crediario_saldo as $vcred_saldo) 
                    {   
                        $idvenda = $vcred_saldo->idvenda;
                        $datavenda2 = $vcred_saldo->datavenda;
                        $datavenda = date('Y-m-d',strtotime($datavenda2));
                        $idcliente = $vcred_saldo->idcliente;
                        $vlvenda = $vcred_saldo->valorvenda;
                        $vlsaldo = $vcred_saldo->vlsaldo_crediario;

                        $diasatr2 = strtotime($data_hoje) - strtotime($datavenda); 
                        $diasatr = floor($diasatr2 / ( 60*60*24)); 

                        $valor_vendido += $vlvenda;
                        $valor_aberto += $vlsaldo; 
                        $valor_recebido = $valor_vendido - $valor_aberto; 

                        $datavenda = datebr($datavenda2);
                        $vlvenda = reais($vlvenda);
                        $vlsaldo = reais($vlsaldo);


                        foreach ($clientes as $cliente) {
                            if ($idcliente == $cliente->idcliente)
                            {
                                $nomecli = $cliente->nome; 
                            }
                        }

                        $situacao = $vcred_saldo->situacaovenda; 
                        if ($situacao==1)
                        {
                            $situacao = '<b class="cred-quit"> Quitada</b>';
                            $vlsaldo = '<b id="sit-vl-saldoq">'.$vlsaldo.'</b>';
                            $diasatr =0; 
                        }
                        elseif ($situacao==0)
                        {
                            $situacao = '<b class="cred-aber"> ABERTA</b>';
                            $vlsaldo = '<b id="sit-vl-saldoa">'.$vlsaldo.'</b>';
                        }


                        $vlvenda = '<b id="sit-vl-venda">'.$vlvenda.'</b>';
                        

                        $this->table->add_row($idvenda, $datavenda, $idcliente, $nomecli, $vlvenda, $vlsaldo, $diasatr, $situacao);
                        $this->table->set_template(array(
                                    'table_open' => '<table class="table table-striped table-vendas-cre table-rels">'));
                        
                    }
               
                    echo $this->table->generate(); 

                    $valor_tot_v = 
                     '<h4 class="vl-tot-cred-rel"> Valor total vendido R$ &nbsp &nbsp &nbsp &nbsp :  
                            <b id="vl-tot-cred-ven">'.reais($valor_vendido).' </b> </h4>';
                    $valor_tot_a = '<h4 class="vl-tot-cred-rel"> Valor total não recebido R$ : 
                            <b id="vl-tot-cred-abr"> '.reais($valor_aberto).' </b> </h4>';
                    $valor_tot_r = '<h4 class="vl-tot-cred-rel"> Valor total recebido R$ &nbsp &nbsp &nbsp &nbsp:
                            <b id="vl-tot-cred-rec"> '.reais($valor_recebido).' </b> </h4>';
                    echo $valor_tot_v; 
                    echo $valor_tot_a; 
                    echo $valor_tot_r; 
                    

                    if (!$vendas_crediario_saldo):
                    ?> 
                        <div class="col-lg-12">
                            <br>
                            <br> 
                            <div class = "alert alert-info text-center mens-sem-dados"> 
                              <b> Não há informações no período informado. </b>
                            </div>
                        </div>
                       <?php 
                   endif;
                   ?>
         
                </section>  
                <!-- /.panel-body -->
            </div>
        </div>

    </div>
</div>

