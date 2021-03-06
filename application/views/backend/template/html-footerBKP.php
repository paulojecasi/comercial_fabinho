     <!-- jQuery -->
    <script src="<?php echo base_url('/assets/backend/js/jquery.min.js') ?>"></script>
    <script src="<?php echo base_url('/assets/backend/js/jquery.mask.min.js') ?>"></script>

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
    <script src="<?php echo base_url('/assets/backend/js/myscripts-calcula-entrada-nota.js') ?>"></script>
    <script src="<?php echo base_url('/assets/backend/js/myscripts-calculo-fechamento-cx.js') ?>"></script>


</body>

</html>

<script>

    $(document).ready(function(){

        // utilizado na consulta de estoque, e
        // entrada de itens no estoque 
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
            if (nomeproduto!= '')
            {   
                // se for codigo de barras
                if  (!isNaN(nomeproduto)) {
                    var nomeproduto = jQuery('#nomeproduto').val();
                    // só consulta se for a cima de 13 caract
                    if (nomeproduto.length >=13){
                        setTimeout(function() {
                            load_data(nomeproduto,1);
                        },300) // consulta depois de 0,5 segundos
                    }

                } else {

                    load_data(nomeproduto,0);
                }
                
            }
            else 
            {
                load_data(); 
            }

        });
    

        // utilizado no cadastro e manutenção de produtos
        carregarProdutos();
        function carregarProdutos(nomeproduto)
        {
            $.ajax({
                url:"<?php echo base_url(); ?>admin/produto/consultajquery_produtos_admin",
                method:"POST",
                data:{nomeproduto:nomeproduto},
                success:function(data){
                    $('#resultado_consulta_produtos tbody').html(data); 
                }
            })
        }
        $('#nomeproduto').keyup(function(){
            var nomeproduto = $(this).val();
            (nomeproduto!= '')  ? carregarProdutos(nomeproduto)
                                : carregarProdutos();
        });
  

        // utilizado na consulta de produtos para filtrar tipo (cadastro)
        load_tipo_rel();
        function load_tipo_rel(tiporel)
        {
            $.ajax({
                url:"<?php echo base_url(); ?>admin/produto/consultajquery_produtos_admin",
                method:"POST",
                data:{tiporel:tiporel},
                success:function(data){
                    $('#resultado_consulta_produtos tbody').html(data); 
                }
            })
        } 
        $('.tiporel').click(function(){
            var tiporel = $(this).val();
            (tiporel!= '')  ? load_tipo_rel(tiporel)
                            : load_tipo_rel();
        });
 
        // utilizado no carregamento do produto a ser adicionado no estoque 
        carregarProduto();
        function carregarProduto(idproduto_cons)
        {
            $.ajax({
                url:"<?php echo base_url(); ?>admin/produto/consultajquery_produto_admin",
                method:"POST",
                data:{idproduto_cons:idproduto_cons},
                success:function(data){
                    $('#resultado_prod_item').html(data); 
                }
            })
        } 
        $('#btn_buscar_item').click(function(){
            var idproduto_cons = (jQuery('#idproduto_res').val() == '' 
                                ? 0 
                                : jQuery('#idproduto_res').val());
         
            (idproduto_cons!='') ? carregarProduto(idproduto_cons)
                                 : carregarProduto(idproduto_cons); 

        });
    });

</script>
