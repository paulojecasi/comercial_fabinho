<div class = "row">

    <div class = "text-center titulo-tela-consulta-movimento-cx">
        <h2>Valores do Movimento geral do Caixa : <b> <?php echo $idcaixa ?> </b>  </h2>
    </div>
  

    <?php
    // tela VALOR DA VENDA
    //$this->load->view('frontend/template/valor-venda');
    echo form_open('caixa/consulta_dados_caixa');
        if (!$datainicio){
            $datainicio =date('Y-m-d');
        }

        if (!$datafinal){
            $datafinal =date('Y-m-d');
        }
        //abrir sessao, com valor disponivel no caixa
        $this->session->set_userdata('valor_disp_cx',$valor_disp_cx); 

    ?>

    <div class = "col-lg-12 col-sm-12 tela-movimento-caixa">

        <section id="dt-movimento-caixa">
            <div class="form-group col-lg-3 campo-titulo-mov-cx">
       
                <h4> Periodo do movimento: </h4>

            </div>
            <div class="form-group col-lg-3 campo-data-movcx">
                <input type="date" id="datainicial_mov" name="datainicial_mov" maxlength="10" class="form-control" value="<?php echo $datainicio; ?>"  onkeydown="javascript:EnterTab('datafinal_mov',event)" autofocus="true" />

            </div>
      
            <div class="form-group col-lg-3 campo-data-movcx">
                <input type="date" id="datafinal_mov" name="datafinal_mov" class="form-control" value="<?php echo $datafinal; ?>"  onkeydown="javascript:EnterTab('nomeproduto',event)" autofocus="true" />
            </div>

            <div class ="col-lg-3 btn-finalizar-venda  btn-dados-mov-caixa text-center">
                <a> 
                    <button class="btn btn-success" type="submit" id="btn-busca-mov-caixa"  > 
                        Gerar Dados
                    </button> 
                </a>
            </div>

            <input type="hidden" id="idcaixa_mov" name="idcaixa_mov" value="<?php echo $idcaixa ?>">
            
        </section>

    </div>

    
    <div class = "col-lg-12 col-sm-12 tela-movimento-caixa-2">
        <div class = "col-lg-5">
            <section class="col-lg-12 receb-caixa-mov" id="valores-mov-caixa">
                <div class ="text-center"> 
                    <h4> Referente a <?php echo datebr($datainicio).'  a  '.datebr($datafinal) ?> </h4> 
                </div> 

                <div class="col-lg-12 sec-recebi sec-entrada">
                    <div class="col-lg-7 titulo-pag">
                       <h3> Troco Inicial  </h3>
                    </div>
                    <div class="col-lg-4 valor-pag">
                        <h3> <?php echo reais($trocoini) ?> </h3>
                    </div>
                    <?php 
                    if ($trocoini!=0):
                    ?>
                       <div class="col-lg-1 form-check btn-ver-mov-caixa">
                         <input class="form-check-input ckeck-mov-caixa" type="checkbox" value="10" id="btn-lista-mov-cx10">
                       </div> 
                        <?php 
                    endif;
                    ?>            
                </div>

                <div class="col-lg-12 sec-recebi sec-entrada">
                    <div class="col-lg-7 titulo-pag">
                       <h3> A Vista  </h3>
                    </div>
                    <div class="col-lg-4 valor-pag">
                        <h3> <?php echo reais($avista)  ?> </h3>
                    </div>
                    <?php 
                    if ($avista!=0):
                    ?>
                       <div class="col-lg-1 form-check btn-ver-mov-caixa">
                         <input class="form-check-input ckeck-mov-caixa" type="checkbox" value="1" id="btn-lista-mov-cx1">
                       </div> 
                        <?php 
                    endif;
                    ?>            
                </div>

                <div class="col-lg-12 sec-recebi sec-entrada">
                    <div class="col-lg-7 titulo-pag">
                        <h3> Recebimentos Crediário </h3>
                    </div>
                    <div class="col-lg-4 valor-pag">
                        <h3> <?php echo reais($crediarioreceb)  ?> </h3>
                    </div>
                    <?php 
                    if ($crediarioreceb!=0):
                    ?>
                        <div class="col-lg-1 form-check btn-ver-mov-caixa">
                            <input class="form-check-input ckeck-mov-caixa" type="checkbox" value="5" id="btn-lista-mov-cx5">
                        </div> 
                        <?php 
                    endif;
                    ?>

                </div>

                <div class="col-lg-12 sec-recebi sec-entrada">
                    <div class="col-lg-7 titulo-pag">
                        <h3> Vendas Externas </h3>
                    </div>
                    <div class="col-lg-4 valor-pag">
                        <h3> <?php echo reais($vendaexterna) ?> </h3>
                    </div>
                    <?php 
                    if ($vendaexterna !=0):
                    ?>
                        <div class="col-lg-1 form-check btn-ver-mov-caixa">
                            <input class="form-check-input ckeck-mov-caixa" type="checkbox" value="8" id="btn-lista-mov-cx8">
                        </div> 
                        <?php 
                    endif;
                    ?>
                </div>


                <div class="col-lg-12 sec-recebi sec-neutro">
                    <div class="col-lg-7 titulo-pag">
                        <h3> Cartão Débito </h3>
                    </div>
                    <div class="col-lg-4 valor-pag">
                        <h3> <?php echo reais($cartaodebito) ?>  </h3>
                    </div>
                    <?php 
                    if ($cartaodebito!=0):
                    ?>
                        <div class="col-lg-1 form-check btn-ver-mov-caixa">
                            <input class="form-check-input ckeck-mov-caixa" type="checkbox" value="2" id="btn-lista-mov-cx2">
                        </div> 
                        <?php 
                    endif;
                    ?>
                </div>

                <div class="col-lg-12 sec-recebi sec-neutro">
                    <div class="col-lg-7 titulo-pag">
                         <h3> Cartão Crédito </h3>
                    </div>
                    <div class="col-lg-4 valor-pag">
                        <h3> <?php echo reais($cartaocredito) ?> </h3>
                    </div>
                    <?php 
                    if ($cartaocredito!=0):
                    ?>
                        <div class="col-lg-1 form-check btn-ver-mov-caixa">
                            <input class="form-check-input ckeck-mov-caixa" type="checkbox" value="3" id="btn-lista-mov-cx3">
                        </div>
                        <?php 
                    endif;
                    ?> 
                </div>

                <div class="col-lg-12 sec-recebi sec-neutro">
                    <div class="col-lg-7 titulo-pag">
                         <h3> Pix-Transferencia </h3>
                    </div>
                    <div class="col-lg-4 valor-pag">
                        <h3> <?php echo reais($pix_transferencia) ?> </h3>
                    </div>
                    <?php 
                    if ($pix_transferencia!=0):
                    ?>
                        <div class="col-lg-1 form-check btn-ver-mov-caixa">
                            <input class="form-check-input ckeck-mov-caixa" type="checkbox" value="11" id="btn-lista-mov-cx11">
                        </div>
                        <?php 
                    endif;
                    ?> 
                </div>


                <div class="col-lg-12 sec-recebi sec-a-receber">
                    <div class="col-lg-7 titulo-pag">
                      <h3> Crediário </h3>
                    </div>
                    <div class="col-lg-4 valor-pag">
                        <h3> <?php echo reais($crediario) ?> </h3>
                    </div>
                    <?php 
                    if ($crediario!=0):
                    ?>
                        <div class="col-lg-1 form-check btn-ver-mov-caixa">
                            <input class="form-check-input ckeck-mov-caixa" type="checkbox" value="4" id="btn-lista-mov-cx4">
                        </div> 
                        <?php 
                    endif;
                    ?>
                </div>

                <div class="col-lg-12 sec-recebi sec-saida">
                    <div class="col-lg-7 titulo-pag">
                       <h3> Retiradas  </h3>
                    </div>
                    <div class="col-lg-4 valor-pag">
                        <h3> <?php echo "- " .reais($retirada_dinheiro)  ?> </h3>
                    </div>
                    <?php 
                    if ($retirada_dinheiro!=0):
                    ?>
                       <div class="col-lg-1 form-check btn-ver-mov-caixa">
                         <input class="form-check-input ckeck-mov-caixa" type="checkbox" value="9" id="btn-lista-mov-cx9">
                       </div> 
                        <?php 
                    endif;
                    ?>            
                </div>

                <div class="col-lg-12 sec-recebi sec-disponivel">

                    <div class="col-lg-4 valor-disp">
                        <label> Total do movimento + </label>
                        <h3> <?php echo reais($valor_total_mov)  ?> </h3>
                    </div>
                  
                    <div class="col-lg-4 valor-disp">
                        <label> Disponível para retirada </label>
                        <h3> <?php echo reais($valor_disp_cx)  ?> </h3>
                    </div>
                    <?php 
                    $operacao_caixa = $this->session->userdata('operacao');

                    if ($valor_total_mov!=0 && $operacao_caixa=="CAIXA_ABERTO"):
                    ?>
                       <div class ="col-lg-4 btn-dados-mov-retirada text-center">
                            <a href="<?php echo base_url('caixa/retirada_caixa/').$datainicio.'/'.$datafinal ?>"> 
                                <button class="btn btn-success" type="button" id=""  > 
                                    Fazer Retirada (-)
                                </button> 
                            </a>
                        </div>
                        <?php 
                    endif;
                    ?>            
                </div>

            </section>

            <div class="form-group col-lg-12 btn-link-mov-cx"> 
                <div class ="col-lg-12 text-center link-voltar link-voltar-tela-inicio ">
                    <a href="<?php echo base_url('venda') ?>">
                           <i class="fa fa-home" aria-hidden="true"></i> Ir para Venda
                    </a>
                </div>
            </div>

        </div>


        <div class="col-lg-7 table-mov-caixa">
            <div>
                <section id="table-scroll">
                    <table class="table table-striped" id="resultado_caixa_mov"
                    >
                        <thead>
                            <tr>
                                <th scope="col">Id  </th>
                                <th scope="col">Data    </th> 
                                <th scope="col">Usuário </th> 
                                <th scope="col">Tipo </th>
                                <th scope="col">Pagamento </th>
                                <th scope="col">Juros</th>
                                <th scope="col">Desctos</th>
                                <th scope="col">Movimento</th>
                                <th scope="col">Venda</th>

                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </section>  
                <!-- /.panel-body -->
            </div>
        </div>

    </div>
 

</div>

