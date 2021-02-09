<div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <h1 class="page-header">
                    <?php echo $titulo ?>
                    <small> - <?php echo $subtitulo ?></small>
                </h1>

                <!-- First Blog Post -->
                <?php foreach ($postagens as $destaque) { ?>

                    <h2>
                        <a href="<?php echo base_url('postagem/'.$destaque->idpostagem.'/'.limpar($destaque->titulo)) ?>">
                            <?php echo $destaque->titulo ?>  
                        </a>
                    </h2>
                    <p class="lead">
                        por <a href="<?php echo base_url('postagem/'.$destaque->idautor.'/'.limpar($destaque->nome)) ?>"> <?php echo $destaque->nome ?> </a>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span>
                        Postado em :  <?php echo maskdatehour($destaque->data) ?> 
                    </p>
                    <hr>
                    <img class="img-responsive" src="http://placehold.it/900x300" alt="">
                    <hr>
                    <p> <?php echo $destaque->subtitulo ?></p>

                     <a class="btn btn-primary" href="<?php echo base_url('postagem/'.$destaque->idpostagem.'/'.limpar($destaque->titulo)) ?>">
                        Leia mais 
                        <span class="glyphicon glyphicon-chevron-right"></span>
                     </a>
                    

                    <hr>
                <?php 
                }
                ?>

            </div>
