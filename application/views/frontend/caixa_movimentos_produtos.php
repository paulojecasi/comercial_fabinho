<div class = "row">

    <div class = "text-center titulo-tela-consulta-movimento-cx-pro">
        <h2>Movimentos dos Produtos no Caixa : <b> <?php echo $idcaixa ?> </b>  </h2>
    </div>
  
    <?php
    if (!$datainicio){
            $datainicio =date('Y-m-d');
        }

        if (!$datafinal){
            $datafinal =date('Y-m-d');
        }
    echo form_open('caixa/movimentos_produtos');
    ?>

    <div class = "col-lg-12 col-sm-12 tela-movimento-caixa-pro">

        <section id="dt-movimento-caixa">
            <div class="form-group col-lg-3 campo-titulo-mov-cx-pro">
       
                <h4> Periodo do movimento: </h4>

            </div>
            <div class="form-group col-lg-3 campo-data-movcx-pro">
                <input type="date" id="datainicial_mov" name="datainicial_movp" maxlength="10" class="form-control" value="<?php echo $datainicio  ?>"  onkeydown="javascript:EnterTab('datafinal_mov',event)" autofocus="true" />

            </div>
      
            <div class="form-group col-lg-3 campo-data-movcx-pro">
                <input type="date" id="datafinal_mov" name="datafinal_movp" class="form-control" value="<?php echo$datafinal  ?>"  onkeydown="javascript:EnterTab('nomeproduto',event)" autofocus="true" />
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


        <div class="col-lg-12 table-mov-caixa-pro">
            <div>
                <section id="table-scroll">
            
                    <?php

                    $this->table->set_heading("Codigo","Descricao","Vl Custo","Vl Venda","Qt Vendida","juros","descontos","Vl Custo Tot","Vl Total","DFAT","Saldo Estq");

                     
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
                             
                            foreach ($movimento_produto_caixa as $produto_vez) {
                                
                                if ($idproduto == $produto_vez->idproduto)
                                {
                                    $codproduto = $produto_vez->codproduto;
                                    $desproduto = $produto_vez->desproduto;
                                    $valorNota  += $produto_vez->valor_custo;
                                    // '<b id="vl-nota-list">'.$produto_vez->vlnota.'</b>';
                                    $valorunit  = $produto_vez->vlpreco;
                                    $quantpro  += $produto_vez->quantidadeitens;
                                    $vljuros   += $produto_vez->vl_juros;
                                    $descontos += $produto_vez->vl_desconto;
                                    //$valortot  += $produto_vez->vlpreco;
                                    $saldopro   = $produto_vez->qtsaldo;  

                                    $idproduto_ja_processado = $produto_vez->idproduto; 

                                    $valortotNota=($valorNota * $quantpro + $vljuros -$descontos);
                                    $valortot = ($valorunit * $quantpro + $vljuros -$descontos);

                                }
                            } 
                            
                            $valorCusto = $valorNota / $quantpro; 
                            $valortotNota=($valorCusto * $quantpro + $vljuros -$descontos);

                            $valortot = ($valorunit * $quantpro + $vljuros -$descontos);
                            $vlFatLuc = ($valortot - $valortotNota); 
                            $vlFatLuc = reais($vlFatLuc);
                            $valorCusto = reais($valorCusto);
                            $valorunit = reais($valorunit); 
                            $valortotNota = reais($valortotNota); 
                            $valortot = reais($valortot); 
                            $vljuros = reais($vljuros);
                            $descontos = reais($descontos); 

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


                            $this->table->add_row($codproduto, $desproduto, $valorCusto, $valorunit, $quantpro, $vljuros, $descontos,$valortotNota, $valortot,$vlFatLuc, $saldopro);
                        } 
                    }
                    $this->table->set_template(array(
                                    'table_open' => '<table class="table table-striped">'
                    ));

                    echo $this->table->generate(); 

                    if (!$movimento_produto_caixa):
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

