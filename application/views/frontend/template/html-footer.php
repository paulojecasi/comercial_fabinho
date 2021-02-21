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
    <script src="<?php echo base_url('/assets/backend/js/myscripts-delay-teclas.js') ?>"></script>

    <!-- tabelas --> 
    <script src="//cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"> </script>

    <script src="//cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css"> </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <!-- para mascarar numeros 
    <script src="<?php echo base_url('/assets/backend/js/jquery.mask.min.js') ?>"></script> 
    --> 
     <script src="https://igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js"></script> 

  

  </body>
</html>

<script>

    $(document).ready(function(){

        load_data();

        function load_data(nomeproduto)
        {
            $.ajax({
                url:"<?php echo base_url(); ?>venda/consultajquery",
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
    });  

    $(document).ready(function(){

        load_data_cli();

        function load_data_cli(nomecliente)
        {

            $.ajax({
                url:"<?php echo base_url(); ?>cliente/consultajquery_cliente",
                method:"POST",
                data:{nomecliente:nomecliente},
                success:function(data){
                    $('#resultado_cli').html(data); 
                }
            })
        } 

        $('#nomecliente').keyup(function(){
            var nomecliente = $(this).val();
            if (nomecliente!= '')
            {
                load_data_cli(nomecliente);
            }else 
            {
                load_data_cli(); 
            }

        });
    });  

</script>

