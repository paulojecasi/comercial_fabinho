<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12 text-center title-fechamento-caixa">
            <h3> <?php echo $titulo." - Caixa Nr -".$idcaixa ?></h3>
        </div>
        
    </div>
    <!-- /.row -->

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <?php
                         
                        // aqui vamos vericar os erros de validação
                        echo validation_errors('<div class="alert alert-warning">','</div>'); 
                        
                        echo form_open('admin/caixa/confirma_fechamento/'.$idcaixa,'autocomplete="off" id="form-fechamento-caixa"');
    
                        ?> 
                        <div class="form-group col-lg-12 panel-fechamento-caixa">
        
                            <div class = "col-lg-12 col-sm-12 tela-fechamento-cx">
                                <div class ="text-center"> 
                                    <h4> Referente a <?php echo datebr($datainicio).'  a  '.datebr($datafinal) ?> </h4> 
                                </div> 
                                <input value="<?php echo $datainicio ?>" id="dt-inicio-fecha" name ="dt-inicio-fecha" type="hidden">
                                <input value="<?php echo $datafinal ?>" id="dt-final-fecha" name ="dt-final-fecha" type="hidden">

                                <div class = "col-lg-12">

                                    <section class="col-lg-12 desc-mov-fecha">
                                        <div class="col-lg-12 ">
                                            <div class="col-lg-3">
                                                <label> Movimento </label>
                                            </div>
                                            <div class="col-lg-3">
                                                <label> Valor Total </label>
                                                
                                            </div>
                                            <div class="col-lg-3">
                                                <label> Valor Conferido </label>
                                        
                                            </div>

                                            <div class="col-lg-3">
                                                <label> Falta / Sobra </label>
                                    
                                            </div>
                                                        
                                        </div>
                                    </section>
                                    <section class="col-lg-12" id="valores-mov-fecha">
                                        <section class="col-lg-12 desc-mov-fecha">
                                            <div class="col-lg-12 confe-fecha">
                                                <div class="col-lg-3">
                                                    <h4> Troco Inicial  </h4>
                                                </div>
                                                

                                                <div class="col-lg-3 disab">
                                                    <input type="number" id="vl_troco_ini" name="vl_troco_ini" value ="<?php echo $trocoini?>">
                                                </div>

                                            </div>
                                        </section>

                                        <section class="col-lg-12 desc-mov-fecha">

                                            <div class="col-lg-12 confe-fecha">
                                                <div class="col-lg-3">
                                                   <h4> A Vista  </h4>
                                                </div>
                                                <div class="col-lg-3 disab">
                                                    <input type="number" id="vl-avista-fec" name="vl-avista-fec" value ="<?php echo $avista?>">
                                                </div>
                                                <div class="col-lg-3">
                                                    <input type="number" id="vl-avista-fec-c" name="vl-avista-fec-c" placeholder="0,00" step ="0.01" onkeydown="javascript:EnterTab('vl-rec-cred-fec-c',event)" autofocus="true">
                                                </div>

                                                <div class="col-lg-3 disab">
                                                    <input id="vl-avista-fec-fs" name="vl-avista-fec-fs" placeholder="0,00" step ="0,01" value ="<?php echo -$avista?>">
                                                </div>
                                                            
                                            </div>
                                        </section>


                                        <section class="col-lg-12 desc-mov-fecha">
                                            <div class="col-lg-12 confe-fecha">
                                                <div class="col-lg-3">
                                                    <h4> Recebimentos Crediário </h4>
                                                </div>
                                                <div class="col-lg-3 disab">
                                                    <input type="number" id="vl-rec-cred-fec" name="vl-rec-cred-fec" value="<?php echo $crediarioreceb  ?>" >
                                                </div>
                                                <div class="col-lg-3">
                                                    <input type="number" id="vl-rec-cred-fec-c" name="vl-rec-cred-fec-c" placeholder="0,00" step ="0.01"  onkeydown="javascript:EnterTab('vl-ext-fec-c',event)">
                                                </div>

                                                <div class="col-lg-3 disab" >
                                                    <input id="vl-rec-cred-fec-fs" name="vl-rec-cred-fec-fs" placeholder="0,00" step ="0,01" value="<?php echo -$crediarioreceb?>" >
                                                </div>
                                    
                                            </div>
                                        </section>


                                        <section class="col-lg-12 desc-mov-fecha">
                                            <div class="col-lg-12 confe-fecha">
                                                <div class="col-lg-3">
                                                    <h4> Vendas Externas </h4>
                                                </div>
                                                <div class="col-lg-3 disab">
                                                    <input type="number" id="vl-ext-fec" name="vl-ext-fec" value ="<?php echo $vendaexterna?>">
                                    
                                                </div>
                                                <div  class="col-lg-3">
                                                    <input type="number" id="vl-ext-fec-c" name="vl-ext-fec-c" placeholder="0,00" step ="0.01"  onkeydown="javascript:EnterTab('vl-cdeb-fec-c',event)">
                                                </div>

                                                <div class="col-lg-3 disab">
                                                    <input id="vl-ext-fec-fs" name="vl-ext-fec-fs" placeholder="0,00" step ="0,01" value ="<?php echo -$vendaexterna ?>"  >
                                                </div>
                                    
                                                
                                            </div>
                                        </section>


                                        <section class="col-lg-12 desc-mov-fecha">
                                            <div class="col-lg-12 confe-fecha">
                                                <div class="col-lg-3">
                                                    <h4> Cartão Débito </h4>
                                                </div>
                                                <div class="col-lg-3 disab">
                                                    <input type="number" id="vl-cdeb-fec" name="vl-cdeb-fec" value ="<?php echo $cartaodebito ?>">
                                                </div>
                                                <div class="col-lg-3">
                                                    <input type="number" id="vl-cdeb-fec-c" name="vl-cdeb-fec-c" placeholder="0,00" step ="0.01" onkeydown="javascript:EnterTab('vl-ccre-fec-c',event)">
                                                </div>

                                                <div class="col-lg-3 disab">
                                                    <input id="vl-cdeb-fec-fs" name="vl-cdeb-fec-fs" placeholder="0,00" step ="0,01" value ="<?php echo -$cartaodebito ?>">
                                                </div>
                                    
                                                
                                            </div>
                                        </section>

                                        <section class="col-lg-12 desc-mov-fecha">
                                            <div class="col-lg-12 confe-fecha">
                                                <div class="col-lg-3">
                                                     <h4> Cartão Crédito </h4>
                                                </div>
                                                <div class="col-lg-3 disab">
                                                    <input type="number" id="vl-ccre-fec" name="vl-ccre-fec" value="<?php echo $cartaocredito ?>" >
                                                </div>
                                                <div class="col-lg-3">
                                                    <input type="number" id="vl-ccre-fec-c" name="vl-ccre-fec-c"  placeholder="0,00" step ="0.01" onkeydown="javascript:EnterTab('vl-crediar-fec-c',event)">
                                                </div>

                                                <div class="col-lg-3 disab">
                                                    <input id="vl-ccre-fec-fs" name="vl-ccre-fec-fs" placeholder="0,00" step ="0,01"  value="<?php echo -$cartaocredito ?>">
                                                </div>
                                    
                                                 
                                            </div>
                                        </section>


                                        <section class="col-lg-12 desc-mov-fecha">
                                            <div class="col-lg-12 confe-fecha">
                                                <div class="col-lg-3">
                                                  <h4> Crediário </h4>
                                                </div>
                                                <div class="col-lg-3 disab">
                                                    <input id="vl-crediar-fec" name="vl-crediar-fec" type="number" value="<?php echo $crediarios ?>" >
                                                </div>
                                                <div class="col-lg-3">
                                                    <input type="number" id="vl-crediar-fec-c" name="vl-crediar-fec-c" placeholder="0,00" step ="0.01"  onkeydown="javascript:EnterTab('vl-ret-fec-c',event)">
                                                </div>

                                                <div class="col-lg-3 disab">
                                                    <input id="vl-crediar-fec-fs" name="vl-crediar-fec-fs" placeholder="0,00" step ="0,01" value="<?php echo -$crediarios?>">
                                                </div>
                                    
                                                
                                            </div>
                                        </section>

                                        <section class="col-lg-12 desc-mov-fecha">
                                            <div class="col-lg-12 confe-fecha">
                                                <div class="col-lg-3">
                                                   <h4> Retiradas  </h4>
                                                </div>
                                                <div class="col-lg-3 disab">
                                                    <input type="number" id="vl-ret-fec" name="vl-ret-fec" value ="<?php echo $retirada_dinheiro?>">
                                                </div>
                                                <div class="col-lg-3">
                                                    <input type="number" id="vl-ret-fec-c" name="vl-ret-fec-c" placeholder="0,00" step ="0.01" onkeydown="javascript:EnterTab('vl-avista-fec-c',event)">
                                                </div>

                                                <div class="col-lg-3 disab">
                                                    <input id="vl-ret-fec-fs" name="vl-ret-fec-fs" placeholder="0,00" step ="0,01" value ="<?php echo -$retirada_dinheiro ?>">
                                                </div>        
                                            </div>
                                        </section>

                                        <section class="col-lg-12 desc-mov-fecha">
                                            <div class="col-lg-12 confe-fecha">
                                                <div class="col-lg-3">
                                                   <h4> TOTAL </h4>
                                                </div>
                                                <div class="col-lg-3 disab">
                                                    <input id="vl-total-fec" name="vl-total-fec" step ="0.01" value="<?php echo $valor_total_cx ?>" >
                                                </div>
                                                <div class="col-lg-3 disab">
                                                    <input id="vl-total-fec-c" name="vl-total-fec-c" placeholder="0,00" step ="0.01">
                                                </div>

                                                <div class="col-lg-3 disab">
                                                    <input id="vl-total-fec-fs" name="vl-total-fec-fs" placeholder="0,00" step ="0.01" value="<?php echo -$valor_total_cx?>">
                                                </div>     
                                            </div>
                                        </section>

                                    </section>

                        
                                </div>
                            </div>
                        </div>


                        <section>
                            <div class="col-lg-6 text-center">
                                <br> 
                                <a href="">
                                    <button class="btn btn-primary person" id="btn-add-fecha-cx" type="submit" > 
                                        Fechar Caixa 
                                    </button> 
                                </a>
                            </div>
                            <div class ="col-lg-6 col-md-4 col-sm-4 text-center link-voltar-cadproduto">    
                                <a href ="<?php echo base_url('admin/caixa') ?>">         
                                    <h4 class="btn-return"> <i class="fa fa-reply-all"> </i> Voltar</h4>
                                </a>
                            </div>
                        </section>
                        
                        <?php 
                        // fechar o formulario 
                        echo form_close();
                        ?> 
                    
                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>

    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper --> 