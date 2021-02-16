 <!-- jQuery -->
    <script src="<?php echo base_url('/assets/backend/js/jquery.min.js') ?>"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url('/assets/backend/js/bootstrap.min.js') ?>"></script>

    <!-- Custom Theme JavaScript -->
    <script src="<?php echo base_url('/assets/backend/js/sb-admin-2.js') ?>"></script>
    <!-- meus scripts PJCS  -->
    <script src="<?php echo base_url('/assets/backend/js/myscripts.js') ?>"></script>

    <!-- tabelas --> 
    <script src="//cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"> </script>

    <script src="//cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css"> </script>

  </body>
</html>

<script>

    $(document).ready(function(){

        load_data();

        function load_data(nomeproduto)
        {
            $.ajax({
                url:"<?php echo base_url(); ?>home/consultajquery",
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

</script>