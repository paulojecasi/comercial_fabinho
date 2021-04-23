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
        var idcaixa = jQuery('#lista_itens_temp_venda').val();

        load_data();
        function load_data(nomeproduto,asyncTF)
        {
            $.ajax({
                url:"<?php echo base_url(); ?>admin/produto/consultajquery_produto",
                cache : false,
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
                    if (nomeproduto.length >=7){
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
                    dataType:'json',
                    url:"<?php echo base_url(); ?>venda/adicionar_produto_temp_jquery",
                    cache : false,
                    method:"POST",
                    data:{idproduto:idproduto,
                            quantidade:quantidade},     
                    //async: false,
                    success:function(data){
                        //template/mensagem-alert
                        $('#mensagem_jquery').html(data); 

                        // limpar campos
                        $('#nomeproduto').val(''); 
                        $('#idproduto_res').val('');
                        $('#quantidade').val(1);
                        var select = document.getElementById("idproduto_res");
                        var length = select.options.length;
                        for (i = length-1; i >= 0; i--) {
                          select.options[i] = null;
                        }
                        // posicionar cursor no campo
                        document.getElementById("nomeproduto").select();

                        // totalizando valores 
                        lista_itens_temp_caixa(idcaixa);
                        totaliza_caixa_temp(1);
                  
                        if (data){
                            $('#mensagem_rodape').html(data.mens);
                            alert(data.mens);
                            //alert(data.outro); 
                        }

                    }
                });
            }
        });


        // LISTA PRODUTOS-TEMP QUE AINDA NÃO FORAM FINALIZADOS VENDA  
    
        lista_itens_temp_caixa(idcaixa);

        function lista_itens_temp_caixa(idcaixa){
            if (idcaixa!=null && idcaixa !=0){
                $.ajax({
                    url:"<?php echo base_url(); ?>venda/venda_lista_produto_temp_jquery",
                    cache : false,
                    method:"POST",
                    data:{idcaixa:idcaixa},     
                    //async: false,
                    success:function(data){
                        $('#resultado_itens_temp tbody').html(data); 
                        if (data){
                            // totalizando valores 
                            totaliza_caixa_temp(1);  
                        }
                        else
                        {
                            // botao só ficará disponivel caso tenha produtas para venda
                            document.getElementById('btn-finaliza-venda').style.display = 'none';
                        }
                     
                    }
                });
            }
        }

        var atualizar =0; 
        function totaliza_caixa_temp(atualizar)
        {

            if (atualizar==1){
                $.ajax({
                    dataType:'json',
                    url:"<?php echo base_url(); ?>venda/totaliza_valores_venda_temp",
                    cache : false,
                    method:"POST",
                    data:{idcaixa:idcaixa},     
                    //async: false,
                    success:function(data){

                        // valores totais dos intes do caixa 
                        var nritens     = data.numero_itens
                        
                        if (nritens)
                        {
                            document.getElementById('btn-finaliza-venda').style.display = 'block';
                         
                            var vltotdesc   = parseFloat(data.vl_tot_desc).toFixed(2); 
                            var vltotacre   = parseFloat(data.vl_tot_acre).toFixed(2); 
                            var vltotalven  = parseFloat(data.valortotal_sem_conversao).toFixed(2);
                        
                            $('#quantidadeitens').val(nritens); 
                            $('#venda-desconto').val(vltotdesc);//.mask('0000,00', {reverse: true}); 
                            $('#venda-juros').val(vltotacre);//.mask('0000,00', {reverse: true}); 
                            $('#vl-venda-total').val(vltotalven);//.mask('0000,00', {reverse: true});


                            // valores do ultimo item adicionado
                            var nritens_ult     = data.numero_itens_ult; 
                            var vl_unitario_ult = parseFloat(data.vl_unitario_ult).toFixed(2); 
                            var vltotalven_ult  = parseFloat(data.valortotal_sem_conversao_ult).toFixed(2);
                            var descricao_ult   = data.descricao_ult; 

                            $('#quantidadeitens_ult').val(nritens_ult); 
                            $('#vl_unitario_ult').val(vl_unitario_ult);//.mask('0000,00', {reverse: true});
                            $('#vl-venda-total_ult').val(vltotalven_ult);//.mask('0000,00', {reverse: true});
                            $('#descricao-prod-caixa').val(descricao_ult);
                        }
                        else
                        {

                            // botao só ficará disponivel caso tenha produtas para venda
                            document.getElementById('btn-finaliza-venda').style.display = 'none';

                        }                

                    } 
                });
            }
        } 

        // CONSULTA DE CLIENTES 

        consulta_clientes();
        function consulta_clientes(nomecliente)
        {
            $.ajax({
                url:"<?php echo base_url(); ?>cliente/consultajquery_cliente",
                cache : false,
                method:"POST",
                data:{nomecliente:nomecliente},
                success:function(data){
                    $('#resultado_cli select').html(data); 
                }
            })
        } 

        $('#nomecliente').keyup(function(){
            var nomecliente = $(this).val();
            if (nomecliente!='' && nomecliente.length >3)
            {
                consulta_clientes(nomecliente);
            }else 
            {
                consulta_clientes(); 
            }
        });
  

        load_data_itens();
        function load_data_itens(idvenda_it)
        {

            $.ajax({
                url:"<?php echo base_url(); ?>venda/consultajquery_itens_venda",
                cache : false,
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
                cache : false,
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
        function carregarDadosCaixaMov(idcaixa_mov, datainicial_mov, datafinal_mov,mov_avista, mov_debito, mov_credito, mov_crediario, mov_crediariorec, mov_externa, porJQuery,mov_retirada, mov_troco_ini, mov_pix)
        {
            $.ajax({
                url:"<?php echo base_url(); ?>caixa/consultajquery_dados_caixa",
                cache : false,
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
                        mov_pix:mov_pix,
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

                if ($('#btn-lista-mov-cx11').is(':checked')) {
                    var mov_pix = $('#btn-lista-mov-cx11').val(); 
                }else{
                    var mov_pix=0; 
                }

                carregarDadosCaixaMov(idcaixa_mov,datainicial_mov,datafinal_mov,mov_avista, mov_debito, mov_credito, mov_crediario, mov_crediariorec, mov_externa, porJQuery, mov_retirada, mov_troco_ini, mov_pix);
            }else 
            {
                carregarDadosCaixaMov(); 
            }
        });

        // LISTA TODOS OS CLIENTES COM DEBITO 

        lista_clientes();
        function lista_clientes(id_solicitacao)
        {

            $.ajax({
                url:"<?php echo base_url(); ?>cliente/consultajquery_clientes",
                cache : false,
                method:"POST",
                data:{id_solicitacao:id_solicitacao},
                success:function(data){
                    $('#resultado_clientes tbody').html(data); 
                }
            })
        } 

        var id_solicitacao = $('#mostrar-clientes-abertos').val();
        if (id_solicitacao=1)
        {
            lista_clientes(id_solicitacao);
        }else 
        {
            lista_clientes(); 
        }

       
    }); 

</script>

