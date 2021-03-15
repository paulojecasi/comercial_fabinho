<div class = "row">

    <div class = "text-center titulo-tela-retirada-movimento-cx">
        <h2> Retirada de Valores do Caixa : <b> <?php echo $idcaixa ?> </b>  </h2>
    </div>
  

    <?php

    echo form_open('caixa/confirma_retirada/'.$idcaixa,'id="form-retirada-valor"');

       $valor_disp = $this->session->userdata('valor_disp_cx'); 
       $valor_disp_cx = reais($valor_disp); 

    ?>


    <div class = "col-lg-12 col-sm-12 tela-retirada-caixa">
        <div class = "row"> 
            <section id="dt-movimento-caixa-retirada">
                <div class="form-group col-lg-3 campo-titulo-mov-cx-retirada">
           
                    <h4> Periodo do movimento: </h4>

                </div>
                <div class="form-group col-lg-3 campo-data-movcx-retirada">
                    <input type="date" id="datainicial_ret" name="datainicial_ret" maxlength="10" class="form-control" value="<?php echo $datainicio  ?>"  onkeydown="javascript:EnterTab('datafinal_mov',event)" disabled />

                </div>
          
                <div class="form-group col-lg-3 campo-data-movcx-retirada">
                    <input type="date" id="datafinal_ret" name="datafinal_ret" class="form-control" value="<?php echo $datafinal  ?>"  onkeydown="javascript:EnterTab('nomeproduto',event)" disabled/>
                </div>


                <input type="hidden" id="idcaixa_mov" name="idcaixa_mov" value="<?php echo $idcaixa ?>">
            </section>

            <div class = "col-lg-12">
                <div class="col-lg-12 panel-valores-retirada"> 

                    <div class="col-lg-3 col-sm-12">
                        <div class="form-group">
                            <h3> Valor Disponível R$ : </h2>
                        </div>
                    </div>
                    <div class="col-lg-9 col-sm-12">
                        <div class="form-group">
                            <h1 class="valor-retirada-disponivel">
                                <?php echo $valor_disp_cx ?>
                            </h1>
                            <input id="vl_retirada_disponivel" name="vl_retirada_disponivel" type="hidden"  step="0.01" value = "<?php echo $valor_disp ?>">
                          
                        </div>
                    </div> 

                    <section id ="ret-tipo" class = "col-lg-6">
                        <div class="col-lg-6 col-sm-12 campo-pag">
                            <h3> Tipo de Retirada: </h3>
                        </div>

                        <div class="form-group col-lg-6 tipo-retirada-mov">
                            <select class="form-control" id="id_retirada_mov" name="id_retirada_mov"  onkeydown="javascript:EnterTab('descricao_ret',event)" autofocus="true">
                                <?php 
                                foreach ($tipo_retirada as $tpret): 
                                    $idretirada         = $tpret->idretirada;
                                    $desretirada         = $tpret->desretirada; 
                                ?> 
                                    <option  value =" <?php echo $idretirada ?> "
                                    >
                                         <?php echo $desretirada ?>  
                                    </option>
                                <?php
                                endforeach; 
                                ?> 
                            </select>
                        </div>
                    </section>

                    <section id ="ret-descricao" class = "col-lg-6">
                        <div class="col-lg-4 col-sm-12 retdescricao">
                            <div class="form-group">
                                <h3> Descrição : </h3>
                            </div>
                        </div>
                        <div class="col-lg-8 col-sm-12 retdescricao">
                            <div class="form-group">
                                <textarea rows="2" id="descricao_ret" name="descricao_ret"  class="form-control" placeholder ="Descreva o motivo da retirada" onkeydown="javascript:EnterTab('vl_retirada_caixa',event)" maxlength=250  required></textarea>
                                
                              
                            </div>
                        </div> 
                    </section>

                    <section id ="ret-valor" class= "col-lg-6">
                        <div class="col-lg-6 col-sm-12 retvalor">
                            <div class="form-group">
                                <h3> Valor da Retirada R$ : </h3>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12 retvalor">
                            <div class="form-group">
                                <h1 class="valor-retirada-caixa">
                                    <input id="vl_retirada_caixa" name="vl_retirada_caixa" type="number" class="form-control" placeholder ="0,00" step="0.01" required value="1,00" onkeydown="javascript:EnterTab('id_retirada_mov',event)">
                                </h1>
                              
                            </div>
                        </div> 
                    </section>

                    <section id ="ret-saldo" class =  "col-lg-6">
                        <div class="col-lg-4 col-sm-12 retsaldo">
                            <div class="form-group">
                                <h3> Saldo Caixa R$ : </h3>
                            </div>
                        </div>
                        <div class="col-lg-8 col-sm-12 retsaldo">
                            <div class="form-group">
                                <h1 class="valor-saldo-caixa">
                                    <!-- <?php echo $valortotal ?> --> 
                                    <input id="vl_saldo_caixa_ret" name="vl_saldo_caixa_ret" type="text" class="form-control"  placeholder="0,00" step="0.01">
                                </h1>
                              
                            </div>
                        </div>
                    </section>

                    <div class ="col-lg-12 col-sm-12 btn-finalizar-venda btn-finalizar-retirada text-center">
                        <a href="">
                            <button class="btn btn-success" type="submit" id="btn-concluir-retirada" > 
                                Confirmar Retirada
                            </button> 
                        </a>
                    </div>
                </div>

              
              
            </div>

            <div class="form-group col-lg-12 btn-link-mov-retirada"> 
                <div class ="col-lg-6 text-center link-voltar link-voltar-tela-inicio">
                    <a href="<?php echo base_url('caixa/movimentos_caixa') ?>">
                           <i class="fa fa-reply" aria-hidden="true"></i> Voltar
                    </a>
                </div>
                <div class ="col-lg-6 text-center link-voltar link-voltar-tela-inicio ">
                    <a href="<?php echo base_url('venda') ?>">
                           <i class="fa fa-home" aria-hidden="true"></i> Ir para Venda
                    </a>
                </div>
            </div>
        </div>

    </div>
 

</div>

