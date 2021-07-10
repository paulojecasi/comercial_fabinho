<div id="page-wrapper-pj">
    
    <?php 
        $this->load->view('backend/template/cabecalho-rel');
    ?>

        <div class="col-lg-12 table-mov-caixa-pro">
            <div>
                <section id="table-scroll-rel">
            
                    <?php

                    //var_dump($cliente_faixa_atraso);
                    $this->table->set_heading("Faixa Atraso","Data Venda","Cod Cliente ","Nome do Cliente","Vl Venda","Valor Saldo","Dias Atr");

            
                    $data_hoje = date('Y-m-d'); 
                    $desc_faixa_atr= "";
                    $datavenda=0;
                    $datavenda2=0;
                    $diasatr=0;
                    $diasatr2=0;
                    $idcliente =0;
                    $nomecli ="";
                    $vlvenda=0;
                    $vlsaldo=0;
                    foreach ($cliente_faixa_atraso as $cliente_atr ) {

                        $datavenda2 = $cliente_atr->datavenda;
                        $datavenda = date('Y-m-d',strtotime($datavenda2));
                        $diasatr2 = strtotime($data_hoje) - strtotime($datavenda); 
                        $diasatr = floor($diasatr2 / ( 60*60*24));

                        $idcliente = $cliente_atr->idcliente;
                        $nomecli= $cliente_atr->nome;
                        $vlvenda= $cliente_atr->valorvenda;
                        $vlsaldo= $cliente_atr->vlsaldo_crediario;

                        if ($diasatr <= 30)
                        {
                            $desc_faixa_atr = "Até 30 dias";
                            $desc_faixa_atr  ='<b id="atr30">'.$desc_faixa_atr.' </b>';
                            $diasatr  ='<b id="atr30">'.$diasatr.' </b>';
                        } 
                        elseif ($diasatr > 30 and $diasatr <= 60)
                        {
                            $desc_faixa_atr = "Entre 31 e 60 dias";
                            $desc_faixa_atr  ='<b id="atr60">'.$desc_faixa_atr.' </b>';
                            $diasatr  ='<b id="atr60">'.$diasatr.' </b>';
                        } 
                        elseif ($diasatr > 60 and $diasatr <= 90)
                        {
                            $desc_faixa_atr = "Entre 61 e 90 dias";
                            $desc_faixa_atr  ='<b id="atr90">'.$desc_faixa_atr.' </b>';
                            $diasatr  ='<b id="atr90">'.$diasatr.' </b>';
                        } 
                        elseif ($diasatr > 90)
                        {
                            $desc_faixa_atr = "Maior que 90 dias";
                            $desc_faixa_atr  ='<b id="atr91">'.$desc_faixa_atr.' </b>';
                            $diasatr  ='<b id="atr91">'.$diasatr.' </b>';
                        } 

                        $this->table->add_row($desc_faixa_atr, $datavenda, $idcliente, $nomecli, $vlvenda, $vlsaldo, $diasatr);
                        $this->table->set_template(array(
                                    'table_open' => '<table class="table table-striped table-rels">'));
                    }
               
                    echo $this->table->generate(); 

                    /*
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
                   */
                   ?>
         
                </section>  
                <!-- /.panel-body -->
            </div>
        </div>

    </div>
</div>

