    <div class="col-lg-12 text-center title-relatorio-cx">
        <h4 class="page-header"> <?php echo $titulo ?>           
        </h4>
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

    <div class = "col-lg-12 col-sm-12">

        <section class="dt-rel-fechamento col-lg-12">
            <div class="form-group col-lg-3 campo-rel-fecha">
       
                <h4> Periodo do movimento: </h4>

            </div>
            <div class="form-group col-lg-3 campo-data-mov-fecha">
                <input type="date" id="datainicial_fecha" name="datainicial_fecha" maxlength="10" class="form-control" value="<?php echo $datainicio; ?>"  onkeydown="javascript:EnterTab('datafinal_mov',event)" disabled="disabled" />

            </div>
      
            <div class="form-group col-lg-3 campo-data-mov-fecha">
                <input type="date" id="datafinal_fecha" name="datafinal_fecha" class="form-control" value="<?php echo $datafinal; ?>"  onkeydown="javascript:EnterTab('nomeproduto',event)" disabled="disabled" />
            </div>

            <div class ="col-lg-3 text-center link-voltar-rel">    
                <a href ="<?php echo base_url('admin/relatorios') ?>">         
                    <button class="btn btn-default btn-return" id="btn-return-cad-cli" type="button"> <i class="fa fa-reply-all"> </i> 
                        Voltar para gerar relatório 
                    </button>
                </a>
            </div>
            
        </section>