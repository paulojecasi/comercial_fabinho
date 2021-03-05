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
    <script src="<?php echo base_url('/assets/backend/js/myscripts-calcula-entrada-nota.js') ?>"></script>


    <script src="<?php echo base_url('/assets/backend/js/jquery.mask.min.js') ?>"></script>
 

</body>

</html>

<script>

    $(document).ready(function(){

        load_data();
        function load_data(nomeproduto)
        {
            $.ajax({
                url:"<?php echo base_url(); ?>admin/produto/consultajquery_produto",
                method:"POST",
                data:{nomeproduto:nomeproduto},
                success:function(data){
                    $('#resultado').html(data); 
                }
            })
        } 
        $('#nomeproduto').keyup(function(){
            var nomeproduto = $(this).val();
            if (nomeproduto!= '')
            {
                load_data(nomeproduto);
            }else 
            {
                load_data(); 
            }
        });
    

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
            if (nomeproduto!= '')
            {
                carregarProdutos(nomeproduto);
            }else 
            {
                carregarProdutos(); 
            }
        });
  

        load_tipo_rel();
        function load_tipo_rel(tiporel)
        {
            $.ajax({
                url:"<?php echo base_url(); ?>admin/produto/consultajquery_produto_admin",
                method:"POST",
                data:{tiporel:tiporel},
                success:function(data){
                    $('#resultado_consulta_produto tbody').html(data); 
                }
            })
        } 
        $('.tiporel').click(function(){
            var tiporel = $(this).val();
            if (tiporel!= '')
            {
                load_tipo_rel(tiporel);
            }else 
            {
                load_tipo_rel(); 
            }
        });
 
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
            var idproduto_cons = (jQuery('#idproduto_res').val() == '' ? 0 : jQuery('#idproduto_res').val());
            if (idproduto_cons!= '')
            {
                carregarProduto(idproduto_cons);
            }else 
            {
                carregarProduto(); 
            }
        });
    });

</script>
