<div class = "row">

    <div class = "text-center titulo-tela-consulta-movimento-cx">
        <h2> Movimento geral do Caixa : <b> <?php echo $idcaixa ?> </b>  </h2>
    </div>
  

    <?php
    // tela VALOR DA VENDA
    //$this->load->view('frontend/template/valor-venda');
    echo form_open('caixa/consulta_dados_caixa');
    ?>

    <div class = "col-lg-12 col-sm-12 tela-movimento-caixa">

        <section id="dt-movimento-caixa">
            <div class="form-group col-lg-3 campo-titulo-mov-cx">
       
                <h4> Periodo do movimento: </h4>

            </div>
            <div class="form-group col-lg-3 campo-data-movcx">
                <label >Data Inicial</label>
                <input type="date" id="datainicial_mov" name="datainicial_mov" maxlength="10" class="form-control" value="<?php echo date('Y-m-d'); ?>"  onkeydown="javascript:EnterTab('datafinal_mov',event)" autofocus="true" />

            </div>
      
            <div class="form-group col-lg-3 campo-data-movcx">
                <label >Data Final</label>
                <input type="date" id="datafinal_mov" name="datafinal_mov" class="form-control" value="<?php echo date('Y-m-d'); ?>"  onkeydown="javascript:EnterTab('nomeproduto',event)" autofocus="true" />
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
                <div class="col-lg-12 sec-recebi">
                  <div class="col-lg-7 titulo-pag">
                      <h3> A Vista  </h3>
                  </div>
                  <div class="col-lg-4 valor-pag">
                      <h3> <?php echo $avista  ?> </h3>
                  </div>
                  <div class="col-lg-1 form-check btn-ver-mov-caixa">
                    <input class="form-check-input" type="checkbox" value="1" id="btn-lista-mov-cx1">
                  </div> 
                                   
              </div>


              <div class="col-lg-12 sec-recebi">
                  <div class="col-lg-7 titulo-pag">
                      <h3> Recebimentos Crediário </h3>
                  </div>
                  <div class="col-lg-4 valor-pag">
                      <h3> <?php echo $crediarioreceb  ?> </h3>
                  </div>
                  <div class="col-lg-1 form-check btn-ver-mov-caixa">
                    <input class="form-check-input ckeck-mov-caixa" type="checkbox" value="5" id="btn-lista-mov-cx5">
                  </div> 
              </div>

              <div class="col-lg-12 sec-recebi">
                  <div class="col-lg-7 titulo-pag">
                      <h3> Vendas Externas </h3>
                  </div>
                  <div class="col-lg-4 valor-pag">
                      <h3> 0,00  </h3>
                  </div>
                  <div class="col-lg-1 form-check btn-ver-mov-caixa">
                    <input class="form-check-input ckeck-mov-caixa" type="checkbox" value="8" id="btn-lista-mov-cx8">
                  </div> 
              </div>


              <div class="col-lg-12 sec-recebi">
                  <div class="col-lg-7 titulo-pag">
                      <h3> Cartão Débito </h3>
                  </div>
                  <div class="col-lg-4 valor-pag">
                      <h3> <?php echo $cartaodebito ?>  </h3>
                  </div>
                  <div class="col-lg-1 form-check btn-ver-mov-caixa">
                    <input class="form-check-input ckeck-mov-caixa" type="checkbox" value="2" id="btn-lista-mov-cx2">
                  </div> 
              </div>

              <div class="col-lg-12 sec-recebi">
                  <div class="col-lg-7 titulo-pag">
                      <h3> Cartão Crédito </h3>
                  </div>
                  <div class="col-lg-4 valor-pag">
                      <h3> <?php echo $cartaocredito ?> </h3>
                  </div>
                  <div class="col-lg-1 form-check btn-ver-mov-caixa">
                    <input class="form-check-input ckeck-mov-caixa" type="checkbox" value="3" id="btn-lista-mov-cx3">
                  </div> 
              </div>


              <div class="col-lg-12 sec-recebi">
                  <div class="col-lg-7 titulo-pag">
                      <h3> Crediário </h3>
                  </div>
                  <div class="col-lg-4 valor-pag">
                      <h3> <?php echo $crediario ?> </h3>
                  </div>
                  <div class="col-lg-1 form-check btn-ver-mov-caixa">
                    <input class="form-check-input ckeck-mov-caixa" type="checkbox" value="4" id="btn-lista-mov-cx4">
                  </div> 
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


        <div class="col-lg-7">
            <div class="panel panel-default consulta-mov-caixa-scrol">
                <section>
                    <table class="table table-hover consulta-mov-caixa" id="resultado_mov_caixa_scroll"
                    >
                        <thead>
                            <tr>
                                <th scope="col">Codigo  </th>
                                <th scope="col">Data    </th> 
                                <th scope="col">Usuário </th> 
                                <th scope="col">Tipo Movimento</th>
                                <th scope="col">Tipo Pagamento </th>
                                <th scope="col">Vl Juros</th>
                                <th scope="col">Vl Desconto</th>
                                <th scope="col">Vl Movimento</th>
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

