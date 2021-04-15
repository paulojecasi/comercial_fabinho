 <!-- jQuery -->
    <script src="<?php echo base_url('/assets/backend/js/jquery.min.js') ?>"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url('/assets/backend/js/bootstrap.min.js') ?>"></script>

    <!-- Custom Theme JavaScript -->
    <script src="<?php echo base_url('/assets/backend/js/sb-admin-2.js') ?>"></script>

    <!-- meus scripts PJCS  -->
    <script src="<?php echo base_url('/assets/backend/js/myscripts.js') ?>"></script>
    <script src="<?php echo base_url('/assets/backend/js/myscripts-mask.js') ?>"></script>
    <script src="<?php echo base_url('/assets/backend/js/myscripts-teclas.js') ?>"></script>
    <script src="<?php echo base_url('/assets/backend/js/myscripts-troco.js') ?>"></script>
    <script src="<?php echo base_url('/assets/backend/js/myscripts-sidenav.js') ?>"></script>
    <script src="<?php echo base_url('/assets/backend/js/myscripts-desconto-acrescimo-prod.js') ?>"></script>
    <script src="<?php echo base_url('/assets/backend/js/myscripts-calculo-recebimento-crediario.js') ?>"></script>
    <script src="<?php echo base_url('/assets/backend/js/myscripts-calculo-retirada.js') ?>"></script>

    <!-- tabelas
    <script src="//cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"> </script>

    <script src="//cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css"> </script> 

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    -->

    <!-- mascara --> 
    <script src="<?php echo base_url('/assets/backend/js/jquery.mask.min.js') ?>"></script> 

  </body>
</html>

<script>

    $(document).ready(function(){

        // Consulta produtos (nome/Cod Barras/ Cod Produto)

        load_data();
        function load_data(nomeproduto,asyncTF)
        {
            $.ajax({
                url:"<?php echo base_url(); ?>admin/produto/consultajquery_produto",
                method:"POST",
                data:{nomeproduto:nomeproduto},
                async: (asyncTF==1) ? false : true,
                success:function(data){
                    $('#resultado select').html(data); 
                }
            })
        } 
        $('#nomeproduto').keyup(function(){
            var nomeproduto = $(this).val();
            if (nomeproduto!='' && nomeproduto.length >2)
            {   
                // se for codigo de barras
                if  (!isNaN(nomeproduto)  && nomeproduto[0] != "-") {
                    //var nomeproduto = jQuery('#nomeproduto').val();
                    // só consulta se for a cima de 13 caract
                    if (nomeproduto.length >=13){
                        setTimeout(function() {
                            load_data(nomeproduto,1);
                        },300) // consulta depois de 0,5 segundos
                    }

                } else {
                    
                    if (nomeproduto[0] == "-") { // consulta pelo código do produto
                        var tam = nomeproduto.length;
                        var nomeproduto = nomeproduto.slice(1,tam);
                    }

                    load_data(nomeproduto,0);
                    
                }
                
            }
            else 
            {
                load_data(); 
            }

        });


        // BUSCAR E GRAVAR ITEM DA VENDA NO CAIXA_TEMP

        $('#btn_buscar_item_venda').click(function(){
            var idproduto = jQuery('#idproduto_res').val(); 
            var quantidade   = jQuery('#quantidade').val();

            if (idproduto!=0)
            {
                $.ajax({
                    url:"<?php echo base_url(); ?>venda/adicionar_produto_temp_jquery",
                    method:"POST",
                    data:{idproduto:idproduto,
                            quantidade:quantidade},     
                    //async: false,
                    success:function(data){
                        $('#resultado select').html(data); 
                    }
                });
            }
        });
 
        // CONSULTA DE CLIENTES 
 

        $('#nomecliente').keyup(function(){
            load_data_cli();
            function load_data_cli(nomecliente)
            {

                $.ajax({
                    url:"<?php echo base_url(); ?>cliente/consultajquery_cliente",
                    method:"POST",
                    data:{nomecliente:nomecliente},
                    success:function(data){
                        $('#resultado_cli select').html(data); 
                    }
                })
            }

            var nomecliente = jQuery('#nomecliente').val();
            if (nomecliente!='' && nomecliente.length >3)
            {
                load_data_cli(nomecliente);
            }else 
            {
                load_data_cli(); 
            }

        });
  

        load_data_itens();
        function load_data_itens(idvenda_it)
        {

            $.ajax({
                url:"<?php echo base_url(); ?>venda/consultajquery_itens_venda",
                method:"POST",
                data:{idvenda_it:idvenda_it},
                success:function(data){
                    $('#resultado_itens').html(data); 
                }
            })
        } 

        $('.idvenda_it').click(function(){
            var idvenda_it = $(this).val();
            if (idvenda_it!= '')
            {
                load_data_itens(idvenda_it);
            }else 
            {
                load_data_itens(); 
            }

        });
    

        load_data_pagto();

        function load_data_pagto(idpagamento)
        {

            $.ajax({
                url:"<?php echo base_url(); ?>venda/consultajquery_pagamento",
                method:"POST",
                data:{idpagamento:idpagamento},
                success:function(data){
                    $('#resultado_itens').html(data); 
                }
            })
        } 

        $('.idpagamento').click(function(){
            var idpagamento = $(this).val();
            if (idpagamento!= '')
            {
                load_data_pagto(idpagamento);
            }else 
            {
                load_data_pagto(); 
            }

        });


        carregarDadosCaixaMov();
        function carregarDadosCaixaMov(idcaixa_mov, datainicial_mov, datafinal_mov,mov_avista, mov_debito, mov_credito, mov_crediario, mov_crediariorec, mov_externa, porJQuery,mov_retirada, mov_troco_ini)
        {

            $.ajax({
                url:"<?php echo base_url(); ?>caixa/consultajquery_dados_caixa",
                method:"POST",
                data:{idcaixa_mov:idcaixa_mov,
                        datainicial_mov:datainicial_mov,
                        datafinal_mov:datafinal_mov,
                        mov_avista:mov_avista,
                        mov_debito:mov_debito,
                        mov_credito:mov_credito,
                        mov_crediario:mov_crediario,
                        mov_crediariorec:mov_crediariorec,
                        mov_externa:mov_externa,
                        porJQuery:porJQuery,
                        mov_retirada:mov_retirada,
                        mov_troco_ini:mov_troco_ini},
                success:function(data){
                    $('#resultado_caixa_mov tbody').html(data); 
                }
            })
        } 
        $('.ckeck-mov-caixa').click(function(){
            var idcaixa_mov = (jQuery('#idcaixa_mov').val());
            var datainicial_mov = (jQuery('#datainicial_mov').val());
            var datafinal_mov = (jQuery('#datafinal_mov').val());
            var porJQuery = "S"; 

            if (datainicial_mov!='' & datafinal_mov!='')
            {
                if ($('#btn-lista-mov-cx1').is(':checked')) {
                    var mov_avista = jQuery('#btn-lista-mov-cx1').val(); 
                }else{
                    var mov_avista=0; 
                }
            
                if ($('#btn-lista-mov-cx2').is(':checked')) {
                    var mov_debito = jQuery('#btn-lista-mov-cx2').val(); 
                }else{
                    var mov_debito=0; 
                }

                if ($('#btn-lista-mov-cx3').is(':checked')) {
                    var mov_credito = jQuery('#btn-lista-mov-cx3').val(); 
                }else{
                    var mov_credito=0; 
                }

                if ($('#btn-lista-mov-cx4').is(':checked')) {
                    var mov_crediario = jQuery('#btn-lista-mov-cx4').val(); 
                }else{
                    var mov_crediario=0; 
                }

                if ($('#btn-lista-mov-cx5').is(':checked')) {
                    var mov_crediariorec = jQuery('#btn-lista-mov-cx5').val(); 
                }else{
                    var mov_crediariorec=0; 
                }

                if ($('#btn-lista-mov-cx8').is(':checked')) {
                    var mov_externa = jQuery('#btn-lista-mov-cx8').val(); 
                }else{
                    var mov_externa=0; 
                }
                if ($('#btn-lista-mov-cx9').is(':checked')) {
                    var mov_retirada = jQuery('#btn-lista-mov-cx9').val(); 
                }else{
                    var mov_retirada=0; 
                }
                if ($('#btn-lista-mov-cx10').is(':checked')) {
                    var mov_troco_ini = jQuery('#btn-lista-mov-cx10').val(); 
                }else{
                    var mov_troco_ini=0; 
                }

                carregarDadosCaixaMov(idcaixa_mov,datainicial_mov,datafinal_mov,mov_avista, mov_debito, mov_credito, mov_crediario, mov_crediariorec, mov_externa, porJQuery, mov_retirada, mov_troco_ini);
            }else 
            {
                carregarDadosCaixaMov(); 
            }
        });
    }); 

</script>

