<div class = "row">

    <div class = "text-center titulo-tela-consulta-crediario">
        <h2>
             Demonstração de Crediário do Cliente 
         </h2>
    </div>

    <?php

    if ($nome_cli){

        $nome       = $nome_cli;
        $vl_saldo   = $saldo_cli;
        $codigo     = $codigo_cli; 

        $this->session->set_userdata('nome',$nome);
        $this->session->set_userdata('idcliente',$codigo);
        $this->session->set_userdata('cliente_aberto',"S");

    }
    else
    {
        $nome       = $this->session->userdata('nome');
        $vl_saldo   = $this->session->userdata('vl_saldo_devedor');
        $codigo     = $this->session->userdata('idcliente'); 
    }
    
    echo form_open('cliente/pagamento_crediario/'.md5(404),'id="form-lista-vendas" autocomplete="off"');
    ?>

    <?php 
        // vamos criar os campos se os mesmo forem != null (vindo do jquery)
        for ($i=0; $i < 50 ; $i++) { 
             ?>
            <input type="" id="<?php echo 'id'.$i ?>" name="<?php echo 'id'.$i ?>"/>
            <input type="" id="<?php echo 'vl'.$i ?>" name="<?php echo 'vl'.$i ?>"/>
            <?php 
        }
    ?>


    <div class = "col-lg-12 col-sm-12 tela-manutencao-cli">

        <div class="panel-demostracao-cliente col-lg-12">
            <div class="form-group cliente_venda col-lg-6">
                <label for="nome"> Cliente </label>
                <input type="text" id="nome" name="nome" class="form-control" value = "<?php echo $nome ?>" disabled />
                <br> 
            </div>

            <div class="form-group cliente_venda col-lg-1">
                <label for="cliente_apelido"> Código </label>
                <input type="text" id="cliente_codigo" name="cliente_codigo" class="form-control" value = "<?php echo $codigo; ?>"  disabled />
                <br> 
            </div>

            
            <div class="form-group cliente_venda col-lg-2">
                <label for="cliente_saldo"> Saldo Devedor </label>
                <input type="text" id="cliente_saldoc" name="cliente_saldoc" class="form-control" placeholder="0,00" value = "<?php echo reais($vl_saldo); ?>" disabled/>
                <br> 
            </div>

            <div class="form-group cliente_venda col-lg-2">
                <label for="valor_a_pagar"> Valor Pagamento </label>
                <input type="text" id="valor_a_pagar" name="valor_a_pagar" class="form-control" placeholder="0,00" step="0.01" value = "0" disabled/>
                <br> 
            </div>

            <div class="form-group cliente_venda btn-pagamento-select btn-finalizar-venda">
                <button class="btn btn-success" id="btn-pagamento-cred"> Pagar </button>
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
                                '<h5>'."Situacao".'</h5>',
                                '<h5>'."Itens".'</h5>',
                                '<h5>'."Pagamento".'</h5>'); 
                                //'<h5>'."Produto".'</h5>',
                                //'<h5>'."Quantidade".'</h5>',
                                //'<h5>'."Vl Unt".'</h5>',
                                //'<h5>'."Vl Total".'</h5>'); 

                            foreach ($vendas_cli as $vendas_cred):
                                $idvenda         = $vendas_cred->idvenda;
                                $data       = datebr($vendas_cred->datavenda); 
                                $valor_o      = $vendas_cred->valorvenda;
                                $valor        = reais($valor_o);
                                $vlsaldo_o    = $vendas_cred->vlsaldo_crediario;
                                $situacaovenda = $vendas_cred->situacaovenda; 
                                if ($vlsaldo_o > 0):
                                    $vlsaldo =
                                       '<b id="aberto">'.reais($vlsaldo_o).'</b>';
                                else:
                                    $vlsaldo =
                                       '<b id="quitado">'.reais($vlsaldo_o).'</b>';
                                  
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
                                    $vlsaldo =0; 
                                    $vlsaldo =
                                       '<b id="cancelado">'.reais($vlsaldo).'</b>';
                                endif; 

                                /*
                                $btn_veritens =  
                                    '<button class="btn-ver-itens btn idvenda_it" type="submit"  value="'.md5($idvenda).'"> <i class="fas fa-th-list"> </i>Ver Itens </button>';
                                    */

                                $btn_veritens = '<button class="btn-ver-itens btn btn-success idvenda_it" value="'.md5($idvenda).'"><i class="fas fa-th-list"> </i> Ver Itens </button>';

                                if ($vlsaldo_o < $valor_o):
                                    $btn_verpagamentos = '<button class="btn-ver-pagamentos btn btn-success idpagamento" value="'.md5($idvenda).'"><i class="fas fa-th-list"> </i> Ver Pagamentos </button>';
                                else:
                                    $btn_verpagamentos = "-";
                                endif; 

                               
                                if ($situacaovenda==0):
                                    if ($localchamado == "cliente"):
                                        /*
                                        $btn_pagar = anchor(base_url('cliente/pagamento_crediario/').md5($idvenda),
                                            '<button class="btn-pagar-cred btn btn-success"><i class="fas fa-usd"> </i> PAGAR </button>');
                                        */
                                        $btn_pagar = 
                                        '<div class="col-lg-1 form-check pag-acumula-cred">
                                            <input class="form-check-input ckeck-pag-cred" type="checkbox" value="'.$idvenda.'" id="'.$idvenda.'">
                                        </div>';

                                    else:
                                        $btn_pagar = "-";
                                    endif; 
                                else:
                
                                        $btn_pagar = "-"; 

                                endif; 
                               
                                
                                
                                
                                //$desproduto = $vendas_cred->desproduto; 
                                //$quantidadeitens = $vendas_cred->quantidadeitens;  
                                //$valorunit  = $vendas_cred->valorunitario; 
                                //$valortotal = $vendas_cred->valortotal;   

                                
                                $this->table->add_row($idvenda,$data,$valor,$vlsaldo, $situacao,$btn_veritens, $btn_pagar, $btn_verpagamentos);
                                //$desproduto,$quantidadeitens,$valorunit,$valorunit,$valortotal); 


                            endforeach; 

                            $this->table->set_template(array(
                                'table_open' => '<table class="table table-striped">'
                            ));

                            echo $this->table->generate(); 

                            ?>
                            </table>
                            <?php 
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
        
        <div class="panel panel-default panel-vendas2-3">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div id="resultado_itens"> </div>
                    </div>
                </div>
            </div>
        </div>

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

            <section class = "link-voltar-tela-demonstracao">
                <div class ="col-lg-6 text-center">
                    <a href="<?php echo $link_retorno ?>">
                           <i class="fa fa-reply" aria-hidden="true"></i> Voltar
                    </a>
                </div>

                 <div class ="col-lg-3 text-center">
                    <?php 
                    if ($localchamado == "cliente"):
                    ?>
                        <a href="<?php echo base_url('venda') ?>">
                               <i class="fa fa-home" aria-hidden="true"></i> Ir para Venda
                        </a>
                        <?php 
                    endif;
                    ?>
                </div>
            </section>
        </div>
    </div>
    <?php 
    // fechar o formulario 
    echo form_close();

    ?>
</div>
<?php
    $this->load->view('frontend/template/mensagem-alert');
?> 


           

