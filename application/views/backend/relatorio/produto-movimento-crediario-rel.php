<div id="page-wrapper-pj">
    
    <?php 
        $this->load->view('backend/template/cabecalho-rel');
    ?>

        <div class="col-lg-12 table-mov-caixa-pro">
            <div>
                <section id="table-scroll-rel">
            
                    <?php

                    $this->table->set_heading("Codigo","Descricao","Vl Venda","Qt Vendida","juros","descontos","Vl Total","Saldo Estq");

                     
                    $idproduto_ja_processado=0;  
                    $codproduto=0;
                    $desproduto=0;
                    $valorNota =0; 
                    $valorNota =0;
                    $valorunit=0; 
                    $quantpro=0; 
                    $vljuros =0; 
                    $descontos=0;
                    $valortot=0;
                    $saldopro=0;
                    $vlFatLucTot =0; 
                    $valortotNotaTot=0; 
                    $valortotTot =0; 

                    foreach ($movimento_produto_caixa as $movimento_produto) 
                    {   
                        $idproduto= $movimento_produto->idproduto;

                        if ($idproduto != $idproduto_ja_processado)
                        {   
                            $codproduto=0;
                            $desproduto=0;
                            $valorNota =0;
                            $valorunit=0; 
                            $quantpro=0; 
                            $vljuros =0; 
                            $descontos=0;
                            $valortot=0;
                            $saldopro=0;
                            $valorNotaTot=0; 
                            $valorunitTo=0;
                            $valorunitT=0; 
                             
                            foreach ($movimento_produto_caixa as $produto_vez) {

                                if ($idproduto == $produto_vez->idproduto)
                                {
                                    $codproduto = $produto_vez->codproduto;
                                    $desproduto = $produto_vez->desproduto;
                                    $valorNota  = $produto_vez->valor_custo;
                                    // '<b id="vl-nota-list">'.$produto_vez->vlnota.'</b>';
                                    $qtitens    = $produto_vez->quantidadeitens;
                                    $qtitensAtc = $produto_vez->qtatacado; 
                                    $valorunit  = $qtitens  < $qtitensAtc ?$produto_vez->vlpreco : $produto_vez->vlprecoatacado ;
                                    $quantproT  = $produto_vez->quantidadeitens;
                                    $vljuros   += $produto_vez->vl_juros;
                                    $descontos += $produto_vez->vl_desconto;
                                    //$valortot  += $produto_vez->vlpreco;
                                    $saldopro   = $produto_vez->qtsaldo;  

                                    $valorNotaTotTo = ($valorNota*$quantproT);
                                    $valorunitTo = ($valorunit*$quantproT);
                                    $valorNotaTot += $valorNotaTotTo; 
                                    $valorunitT += $valorunitTo;

                                    $quantpro   +=$quantproT;
        
                                    $idproduto_ja_processado = $produto_vez->idproduto; 

                                    $valortotNota=($valorNota * $quantpro + $vljuros -$descontos);
                                    $valortot = ($valorunit * $quantpro + $vljuros -$descontos);

                                }
                            } 

                            $valorCusto = $valorNotaTot / $quantpro; 
                            $valorUnitario = $valorunitT / $quantpro; 
                            //$valorCusto = $valorNota;

                            $valortotNota=($valorCusto * $quantpro + $vljuros -$descontos);

                            $valortot = ($valorUnitario * $quantpro + $vljuros -$descontos);

                            $vlFatLuc = ($valortot - $valortotNota); 
                            $vlFatLucTot += $vlFatLuc; 
                            $valortotTot += $valortot; 
                            $valortotNotaTot +=$valortotNota;  
                            $vlFatLuc = reais($vlFatLuc);
                            $valorCusto = reais($valorCusto);
                            $valorunit = reais($valorunit); 
                            $valortotNota = reais($valortotNota); 
                            $valortot = reais($valortot); 
                            $vljuros = reais($vljuros);
                            $descontos = reais($descontos); 
                            $valorUnitario = reais($valorUnitario);


                            $valorCusto  = 
                                    '<b class="vl-nota-list">'.$valorCusto.'</b>';
                            $valortotNota  = 
                                    '<b class="vl-nota-list">'.$valortotNota.'</b>';
                            $valorunit  = 
                                    '<b id="vl-tot-ven">'.$valorunit.'</b>';
                            $valortot  = 
                                    '<b id="vl-tot-ven">'.$valortot.'</b>';
                            if ($vlFatLuc < 0)
                            {
                                $vlFatLuc  = 
                                    '<b id="vl-fat-neg">'.$vlFatLuc.'</b>';
                            }
                            else
                            {
                                $vlFatLuc  = 
                                    '<b id="vl-fat-pos">'.$vlFatLuc.'</b>';
                            }

                            $this->table->add_row($codproduto, $desproduto, $valorunit, $quantpro, $vljuros, $descontos, $valortot, $saldopro);
                        } 
                    }

         
                    $desTot = '<h5 class ="totais-rel-venda"> Totais: </h5>';
                    $valortotNotaToti = '<h5 class ="totais-rel-venda" id="tot-custo">'
                                        .reais($valortotNotaTot).'</h5>'; 

                    $vlFatLucToti = '<h5 class ="totais-rel-venda" id="tot-luc">'
                                        .reais($vlFatLucTot).'</h5>'; 
                 
                    $valortotToti = '<h5 class ="totais-rel-venda" id="tot-ven">'
                                        .reais($valortotTot).'</h5>'; 

                    $this->table->add_row($desTot, "", "", "","","", $valortotToti, "");
                    $this->table->set_template(array(
                                    'table_open' => '<table class="table table-striped table-rels">'
                    ));

                    echo $this->table->generate(); 
                    

                    if (!$movimento_produto_caixa):
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

