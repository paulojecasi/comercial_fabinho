    <div class = "titulo-tela-tipopag">
        <div class="row">
            <div class="col-lg-3 col-sm-12">
                <div class="form-group">
                    <h2> Valor da Venda R$ : </h2>
                </div>
            </div>
            <div class="col-lg-9 col-sm-12">
                <div class="form-group">
                    <h5 class="valor-total-venda">
                        <?php echo reais($valortotal) ?> 
                    </h5>
                    
                    <input id="vl_total" name="vl_total" type="hidden" class="form-control" placeholder ="0.00" value="<?php echo $valortotal_sem_conversao ?>">
                  
                </div>
            </div> 
        </div>
    </div>
 