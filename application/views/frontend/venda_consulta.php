<div class = "row">

    <div class = "text-center titulo-tela-consulta-movimento-cx-venda">
        <h2> Consulta de Vendas </h2>
    </div>
  

    <?php
    $situacao=0; 
    $idvenda=0;
    $valor_venda=0;
    $data_venda=0;
    
    // tela VALOR DA VENDA
    //$this->load->view('frontend/template/valor-venda');
    echo form_open('caixa/consulta_dados_caixa');

    foreach ($consulta_venda as $venda_consultada) 
    {
        $idvenda = $venda_consultada->idvenda;
        $valor_venda = reais($venda_consultada->valorvenda);
        $data_venda = datebr($venda_consultada->datavenda);
        $situacao = $venda_consultada->situacaovenda; 
    }

    if ($situacao !=2)
    {
        $dessituacao= "Normal";  
        $dessituacao = '<b>'.$dessituacao.'</b>';
    }
    else
    {
        $dessituacao= "CANCELADA"; 
        $dessituacao = '<b id="cancell">'.$dessituacao.'</b>';
    }
    ?>

    <div class = "col-lg-12 col-sm-12 tela-movimento-caixa-venda">

        <section id="panel-consulta-venda">
            <div class = "col-lg-12 venda-cx-consulta"> 
                <div class="col-lg-3">
                    <h3> Venda: <b> <?php echo $idvenda; ?> </b> </h3>
                </div>

                <div class="col-lg-3">
                    <h3> Valor R$: <b> <?php echo $valor_venda; ?> </b> </h3>
                </div>

                <div class="col-lg-3">
                    <h3> Data Venda: <b> <?php echo $data_venda; ?> </b> </h3>
                </div>
                <div class="col-lg-3">
                    <h3> Situacao: <?php echo $dessituacao; ?> </h3>
                </div>

            </div>
        </section>


        <div class="col-lg-12 table-mov-caixa-venda">
            <div>
                <section id="table-scroll-venda">
                    <h3 class="text-center itens-venda-cx-mov"> Itens da Venda </h3>
            
                    <?php

                    $this->table->set_heading("Cod","Cod Venda","Produto","Valor Unitario","Qt Itens ","Valor Total");

                    foreach ($consulta_venda_itens as $row_itens) {
                        $id                 = $row_itens->idvendaitem; 
                        $codigo         = $row_itens->codproduto;
                        $descricao  = $row_itens->desproduto; 
                        $vlunitario = $row_itens->valorunitario;
                        $qtitens        = $row_itens->quantidadeitens;
                        $vltotal        = $row_itens->valortotal; 



                        $this->table->add_row($id,$codigo,$descricao,$vlunitario,$qtitens,$vltotal);
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

        <?php
        if ($tipo_acesso == "movcaixa"):
            $link_voltar = 'caixa/movimentos_caixa';
        else:
            $link_voltar = 'caixa/movimento_cancel_mov_caixa';
        endif; 
        ?>

        <div class="form-group col-lg-12 btn-link-mov-cx-cancel"> 
            <div class ="col-lg-12 text-center link-voltar link-voltar-tela-inicio ">
                <a href="<?php echo base_url($link_voltar) ?>">
                       <i class="fa fa-reply" aria-hidden="true"></i> Voltar
                </a>
            </div>
        </div>
    </div>
</div>

