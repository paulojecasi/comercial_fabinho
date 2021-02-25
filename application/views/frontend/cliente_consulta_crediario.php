<div class = "row">

    <div class = "text-center tipo-de-pagamento-escolha tipo-de-pagamento-escolha-cliente">
        <h2> Demonstração de Crediário do Cliente </h2>
    </div>

    <?php
    $nome       = $this->session->userdata('nome');
    $vl_saldo   = $this->session->userdata('vl_saldo_devedor');
    $codigo     = $this->session->userdata('idcliente');
    ?>

    <div class = "col-lg-12 col-sm-12 tela-manutencao-cli">

        <div class="panel2-consulta-cliente col-lg-12">
            <div class="form-group cliente_venda col-lg-8">
                <label for="nome"> Cliente </label>
                <input type="text" id="nome" name="nome" class="form-control" value = "<?php echo $nome ?>" disabled />
                <br> 
            </div>

            <div class="form-group cliente_venda col-lg-2">
                <label for="cliente_apelido"> Código </label>
                <input type="text" id="cliente_codigo" name="cliente_codigo" class="form-control" value = "<?php echo $codigo; ?>"  disabled />
                <br> 
            </div>

            
            <div class="form-group cliente_venda col-lg-2">
                <label for="cliente_saldo"> Saldo Devedor </label>
                <input type="text" id="cliente_saldo" name="cliente_saldo" class="form-control" placeholder="0,00" value = "<?php echo reais($vl_saldo); ?>" disabled/>
                <br> 
            </div>

        </div>

        <div class="panel panel-default panel-vendas2-2">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                  
                            <!-- gerar tabela de categorias pela framework PJCS --> 
                        <?php
                        if ($vendas_cli):
                            $this->table->set_heading(
                                '<h5>'."Codigo da Venda".'</h5>',
                                '<h5>'."Data Compra".'</h5>',
                                '<h5>'."Valor R$".'</h5>', 
                                '<h5>'."Saldo Devedor R$".'</h5>',
                                '<h5>'."Situacao".'</h5>'); 
                                //'<h5>'."Produto".'</h5>',
                                //'<h5>'."Quantidade".'</h5>',
                                //'<h5>'."Vl Unt".'</h5>',
                                //'<h5>'."Vl Total".'</h5>'); 

                            foreach ($vendas_cli as $vendas_cred):
                                $idvenda         = $vendas_cred->idvenda;
                                $data       = datebr($vendas_cred->datavenda); 
                                $valor      = reais($vendas_cred->valorvenda);
                                $vlsaldo    = $vendas_cred->vlsaldo_crediario;
                                $situacaovenda = $vendas_cred->situacaovenda; 
                                if ($vlsaldo > 0):
                                    $vlsaldo =
                                       '<b id="aberto">'.reais($vlsaldo).'</b>';
                                else:
                                    $vlsaldo =
                                       '<b id="quitado">'.reais($vlsaldo).'</b>';
                                  
                                endif;  

                                if ($situacaovenda==0):
                                    $situacao = "Aberta"; 
                                    $situacao = 
                                    '<b id="aberto">'.$situacao.'</b>';
                                elseif ($situacaovenda==1):
                                    $situacao = "Quitada";
                                    $situacao = 
                                    '<b id="quitado">'.$situacao.'</b>';
                                else:
                                    $situacao = "Cancelada";
                                endif; 

                                $btn_veritens = anchor(base_url(''),
                                    '<button class="btn-ver-itens btn btn-default"><i class="fas fa-th-list"> </i> Ver Itens </button>');

                                if ($situacaovenda==0):
                                    if ($localchamado == "cliente"):
                                        $btn_pagar = anchor(base_url('cliente/pagamento_crediario/').md5($idvenda),
                                            '<button class="btn-pagar-cred btn btn-success"><i class="fas fa-usd"> </i> PAGAR </button>');
                                    else:
                                        $btn_pagar = null;
                                    endif; 
                                else:
                
                                        $btn_pagar = null; 

                                endif; 
                                //$desproduto = $vendas_cred->desproduto; 
                                //$quantidadeitens = $vendas_cred->quantidadeitens;  
                                //$valorunit  = $vendas_cred->valorunitario; 
                                //$valortotal = $vendas_cred->valortotal;   

                                
                                $this->table->add_row($idvenda,$data,$valor,$vlsaldo, $situacao,$btn_veritens, $btn_pagar);
                                //$desproduto,$quantidadeitens,$valorunit,$valorunit,$valortotal); 


                            endforeach; 

                            $this->table->set_template(array(
                                'table_open' => '<table class="table table-striped">'
                            ));

                            echo $this->table->generate(); 
                      
                        else:
                            ?> 
                            <div class="form-group col-lg-12 text-center">
                                <h1> Cliente nao possui crediário </h1>
                            </div>
                            <?php
                        endif;
                        ?>
                                        
                    </div>
                    
                </div>
                <!-- /.row (nested) -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->

        <div class="form-group col-lg-12 btn-link btn-link-consulta-cred"> 
            
            <?php 
                if ($localchamado == "cliente")
                {
                    $link_retorno =  base_url('cliente/manutencao_clientes');
                }
                else
                {
                    $link_retorno =  base_url('venda/venda_pagamento/').$idcaixa.'/4';
                }
            ?>

            <div class ="col-lg-6 text-center link-voltar link-voltar-tela-inicio">
                <a href="<?php echo $link_retorno ?>">
                       <i class="fa fa-reply" aria-hidden="true"></i> Voltar
                </a>
            </div>
        </div>
    </div>
</div>


           

