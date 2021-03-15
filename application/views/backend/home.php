<div id="page-wrapper"> 
    <div class="boas-vindas-sis">
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
                        <div class="alert alert-success boas-vindas" role="alert">
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
