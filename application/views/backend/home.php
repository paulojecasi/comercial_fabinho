<div id="page-wrapper"> 
    <div class="boas-vindas-sis img-sistema-adm">
          <div class="logo-marca-ps text-center col-lg-12 col-sm-12">
                <h3> 
                     <img  src="<?php echo base_url('/assets/frontend/img/_PS_Solucoes2.png') ?>" height="65" width="300" >
                </h3>
            </div>
        <div class="row">
            <div class="col-lg-12 boas-vindas">
                <h1 class="page-header"> <?php echo $subtitulo ?> </h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="alert boas-vindas" role="alert">
                            <h2> Bem vindo, 
                                <?php echo $this->session->userdata('userLogado')->nome."!"; ?>
                            </h2>
                        </div>
                    </div>
                </div>
            </div>

            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
    </div>

</div>
<!-- /#page-wrapper -->
