<div id="page-wrapper-pj">


    <?php 

    $this->load->view('backend/template/cabecalho-rel');
    
    if ($relatorio_fechamento_cx):
      ?>

      <div class="col-lg-12 scroll-mov-fecha">
        <br>
        <?php 

            $data_fecha = 0;
             $troco_ini = 0;

             $vlavista  = 0;
             $vlavista_con  = 0;
             $vlavista_fs  = 0;

             $vlreceb_cred = 0;
             $vlreceb_cred_con = 0;
             $vlreceb_cred_fs = 0;

             $vlvendaexterna = 0;
             $vlvendaexterna_con = 0;
             $vlvendaexterna_fs = 0;

             $vlcdebito = 0;
             $vlcdebito_con = 0;
             $vlcdebito_fs = 0;

             $vlccredito = 0;
             $vlccredito_con = 0;
             $vlccredito_fs = 0;

             $pix_transferencia = 0;
             $pix_transferencia_con = 0;
             $pix_transferencia_fs = 0;

             $vlcrediario = 0;
             $vlcrediario_con = 0;
             $vlcrediario_sf = 0;
             
             $vlretiradas = 0;
             $vlretiradas_con = 0;
             $vlretiradas_sf = 0;

             $saldo_dia =0 ; 
             $saldo_geral =0; 

            foreach ($relatorio_fechamento_cx as $rel_fecha) 
            {
            
               $data_fecha = datebr($rel_fecha->datafecha) ;
               $troco_ini = $rel_fecha->vltroco_inicial;

               $vlavista  = $rel_fecha->vlavista;
               $vlavista_con  = $rel_fecha->vlavista_con;
               $vlavista_fs  = $rel_fecha->vlavista_fs;

               $vlreceb_cred = $rel_fecha->vlreceb_cred;
               $vlreceb_cred_con = $rel_fecha->vlreceb_cred_con;
               $vlreceb_cred_fs = $rel_fecha->vlreceb_cred_fs;

               $vlvendaexterna = $rel_fecha->vlvendaexterna;
               $vlvendaexterna_con = $rel_fecha->vlvendaexterna_con;
               $vlvendaexterna_fs = $rel_fecha->vlvendaexterna_fs;

               $vlcdebito = $rel_fecha->vlcdebito;
               $vlcdebito_con = $rel_fecha->vlcdebito_con;
               $vlcdebito_fs = $rel_fecha->vlcdebito_fs;

               $vlccredito = $rel_fecha->vlccredito;
               $vlccredito_con = $rel_fecha->vlccredito_con;
               $vlccredito_fs = $rel_fecha->vlccredito_fs;

               $pix_transferencia = $pix_transferencia;
               $pix_transferencia_con = $pix_transferencia_con;
               $pix_transferencia_fs = $pix_transferencia_fs;

               $vlcrediario = $rel_fecha->vlcrediario;
               $vlcrediario_con = $rel_fecha->vlcrediario_con;
               $vlcrediario_fs = $rel_fecha->vlcrediario_fs;

               $vlretiradas = $rel_fecha->vlretiradas;
               $vlretiradas_con = $rel_fecha->vlretiradas_con;
               $vlretiradas_fs = $rel_fecha->vlretiradas_fs;


               $saldo_dia = $vlavista_fs + $vlreceb_cred_fs + $vlvendaexterna_fs +
                            $vlcdebito_fs + $vlccredito_fs + $pix_transferencia_fs +
                            $vlcrediario_fs + $vlretiradas_fs ; 

                $saldo_geral += $saldo_dia; 

                $saldo_dia = reais($saldo_dia); 

            ?>

            <section id="dados-rel-fechamento">
                <div class="form-group col-lg-12 disp-data-fecha">
                    <h4> DATA - <?php echo $data_fecha; ?>  </h4>
                </div>

                <div class="form-group col-lg-3 value-receb-fecha-cx">
                    <h4 class ="title-receb-fecha"> A Vista </h4>
                    <h5>Registrado R$  
                         <b> <?php echo $vlavista ?> </b>      </h5>
                    <h5>Conferido R$  
                        <b> <?php echo $vlavista_con ?> </b>   </h5>
                    <h5> <i> Sobra/Falta R$  </i> 
                        <?php 
                        if ($vlavista_fs < 0)
                        {
                            $class = "negativo";
                        }
                        else
                        {
                            $class = "normal";
                        }
                        ?>
                        <b class="<?php echo $class ?>"> <?php echo $vlavista_fs ?> </b>   </h5>
                </div>

                <div class="form-group col-lg-3 value-receb-fecha-cx">
                    <h4 class ="title-receb-fecha"> Crediário </h4>
                    <h5>Registrado R$
                        <b> <?php echo $vlreceb_cred ?> </b>     </h5>
                    <h5>Conferido R$  
                        <b> <?php echo $vlreceb_cred_con ?> </b>   </h5>
                    <h5>Sobra/Falta R$ 
                        <?php 
                        if ($vlreceb_cred_fs < 0)
                        {
                            $class = "negativo";
                        }
                        else
                        {
                            $class = "normal";
                        }
                        ?>
                        <b class="<?php echo $class ?>"> <?php echo $vlreceb_cred_fs ?> </b>   </h5>
                </div>

                <div class="form-group col-lg-3 value-receb-fecha-cx">
                    <h4 class ="title-receb-fecha"> Venda Externa </h4>
                    <h5>Registrado R$  
                        <b> <?php echo $vlvendaexterna ?> </b>     </h5>
                    <h5>Conferido R$  
                        <b> <?php echo $vlvendaexterna_con ?> </b>   </h5>
                    <h5>Sobra/Falta R$ 
                        <?php 
                        if ($vlvendaexterna_fs < 0)
                        {
                            $class = "negativo";
                        }
                        else
                        {
                            $class = "normal";
                        }
                        ?>
                        <b class="<?php echo $class ?>"> <?php echo $vlvendaexterna_fs ?> </b>   </h5>
                </div>

                <div class="form-group col-lg-3 value-receb-fecha-cx">
                    <h4 class ="title-receb-fecha"> Cartão Débito </h4>
                    <h5>Registrado R$  
                        <b> <?php echo $vlcdebito ?> </b>     </h5>
                    <h5>Conferido R$  
                        <b> <?php echo $vlcdebito_con ?> </b>   </h5>
                    <h5>Sobra/Falta R$ 
                        <?php 
                        if ($vlcdebito_fs < 0)
                        {
                            $class = "negativo";
                        }
                        else
                        {
                            $class = "normal";
                        }
                        ?>
                        <b class="<?php echo $class ?>"> <?php echo $vlcdebito_fs ?> </b>   </h5>
                </div>

                <div class="form-group col-lg-3 value-receb-fecha-cx">
                    <h4 class ="title-receb-fecha"> Cartão Crédito </h4>
                    <h5>Registrado R$  
                        <b> <?php echo $vlccredito ?> </b>     </h5>
                    <h5>Conferido R$  
                        <b> <?php echo $vlccredito_con ?> </b>   </h5>
                    <h5>Sobra/Falta R$ 
                        <?php 
                        if ($vlccredito_fs < 0)
                        {
                            $class = "negativo";
                        }
                        else
                        {
                            $class = "normal";
                        }
                        ?>
                        <b class="<?php echo $class ?>"> <?php echo $vlccredito_fs ?> </b>   </h5>
                </div>

                <div class="form-group col-lg-3 value-receb-fecha-cx">
                    <h4 class ="title-receb-fecha"> Pix-Transferencia </h4>
                    <h5>Registrado R$  
                        <b> <?php echo $pix_transferencia ?> </b>     </h5>
                    <h5>Conferido R$  
                        <b> <?php echo $pix_transferencia_con ?> </b>   </h5>
                    <h5>Sobra/Falta R$ 
                        <?php 
                        if ($pix_transferencia_fs < 0)
                        {
                            $class = "negativo";
                        }
                        else
                        {
                            $class = "normal";
                        }
                        ?>
                        <b class="<?php echo $class ?>"> <?php echo $pix_transferencia_fs ?> </b>   </h5>
                </div>

                <div class="form-group col-lg-3 value-receb-fecha-cx">
                    <h4 class ="title-receb-fecha"> Venda Crediário </h4>
                    <h5>Registrado R$  
                        <b> <?php echo $vlcrediario ?> </b>     </h5>
                    <h5>Conferido R$  
                        <b> <?php echo $vlcrediario_con ?> </b>   </h5>
                    <h5>Sobra/Falta R$ 
                        <?php 
                        if ($vlcrediario_fs < 0)
                        {
                            $class = "negativo";
                        }
                        else
                        {
                            $class = "normal";
                        }
                        ?>
                        <b class="<?php echo $class ?>"> <?php echo $vlcrediario_fs ?> </b>   </h5>
                </div>

                <div class="form-group col-lg-3 value-receb-fecha-cx">
                    <h4 class ="title-receb-fecha"> Retiradas </h4>
                    <h5>Registrado R$  
                        <b> <?php echo $vlretiradas ?> </b>     </h5>
                    <h5>Conferido R$  
                        <b> <?php echo $vlretiradas_con ?> </b>   </h5>
                    <h5>Sobra/Falta R$ 
                        <?php 
                        if ($vlretiradas_fs < 0)
                        {
                            $class = "negativo";
                        }
                        else
                        {
                            $class = "normal";
                        }
                        ?>
                        <b class="<?php echo $class ?>"> <?php echo $vlretiradas_fs ?> </b>   </h5>
                </div>

                <?php 
                if ($saldo_dia < 0)
                {
                    $class = "fal";
                    $desc_saldo= ">>>> Falta de R$ ";
                }
                elseif($saldo_dia == 0)
                {
                    $class = "nor";
                    $desc_saldo= ">>>>>>>> Fechou: ";
                }
                else
                {
                    $class = "sob";
                    $desc_saldo= ">>> Sobra de R$: ";
                }
                ?>

                <div class="form-group col-lg-4 value-saldo-dia-cx text-center">
                    <h4 class="<?php echo $class ?>"> <b><?php echo $desc_saldo." ".$saldo_dia ?> </b> </h4>
                </div>

                <!--
                <div class="form-group col-lg-3 campo-data-mov-fecha">
                    <input type="date" id="datainicial_fecha" name="datainicial_fecha" maxlength="10" class="form-control" value="<?php echo $datainicio; ?>"  onkeydown="javascript:EnterTab('datafinal_mov',event)" autofocus="true" />

                </div>
          
                <div class="form-group col-lg-3 campo-data-mov-fecha">
                    <input type="date" id="datafinal_fecha" name="datafinal_fecha" class="form-control" value="<?php echo $datafinal; ?>"  onkeydown="javascript:EnterTab('nomeproduto',event)" autofocus="true" />
                </div> --> 
            </section>

             <?php
        }


        if ($saldo_geral < 0)
        {
            $class = "fal";
            $desc_saldo= ">>>> Falta de R$: ";
        }
        elseif($saldo_geral == 0)
        {
            $class = "nor";
            $desc_saldo= ">>>>>>>>> Fechou: ";
        }
        else
        {
            $class = "sob";
            $desc_saldo= ">>>> Sobra de R$: ";
        }

        $saldo_geral = reais($saldo_geral); 
        ?>

        <div class="form-group col-lg-12 value-saldo-dia-cx text-center">
            <h4 class="<?php echo $class ?>"> Saldo Geral do Período: <b><?php echo $desc_saldo." ".$saldo_geral ?> </b> </h4>
        </div>
      </div>
      <?php
    else:
      ?>

       <div class="col-lg-12 scroll-mov-fecha">
        <br>
        <br> 
        <div class = "alert alert-info text-center mens-sem-dados"> 
          <b> Não há informações no período informado. </b>
        </div>
      </div>
      <?php
    endif; 
    ?>



 
</div>


