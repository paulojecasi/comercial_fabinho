$(document).ready(function(){

    load_data();

    function load_data(query)
    {
        $.ajax({
            url:"<?php echo base_url(); ?>home/fetch",
            method:"POST",
            data:{query:query},
            success:function(data){
                $('#resultado').html(data); 
            }
        })
    } 

});  

$('#nomeproduto').keyup(function(){
    var search = $(this).val();
    if (search!= '')
    {
        load_data(search);
    }else 
    {
        load_data(); 
    }

});

