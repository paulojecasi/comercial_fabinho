jQuery(document).ready(function(){
  jQuery('input').on('keyup',function(){
    if(jQuery(this).attr('name') === 'result'){
    return false;
    }

    var vl_troco_ini  = (jQuery('#vl_troco_ini').val() == '' ? 0 : jQuery('#vl_troco_ini').val());
    var vl_avista     = (jQuery('#vl-avista-fec').val() == '' ? 0 : jQuery('#vl-avista-fec').val());
    var vl_receb_cred = (jQuery('#vl-rec-cred-fec').val() == '' ? 0 : jQuery('#vl-rec-cred-fec').val());
    var vl_externa    = (jQuery('#vl-ext-fec').val() == '' ? 0 : jQuery('#vl-ext-fec').val());
    var vl_debito     = (jQuery('#vl-cdeb-fec').val() == '' ? 0 : jQuery('#vl-cdeb-fec').val());
    var vl_credito    = (jQuery('#vl-ccre-fec').val() == '' ? 0 : jQuery('#vl-ccre-fec').val());
    var vl_crediario  = (jQuery('#vl-crediar-fec').val() == '' ? 0 : jQuery('#vl-crediar-fec').val());
    var vl_retiradas  = (jQuery('#vl-ret-fec').val() == '' ? 0 : jQuery('#vl-ret-fec').val());
    var vl_total      = (jQuery('#vl-total-fec').val() == '' ? 0 : jQuery('#vl-total-fec').val());
   
    var vl_avista_c     = (jQuery('#vl-avista-fec-c').val() == '' ? 0 : jQuery('#vl-avista-fec-c').val());
    var vl_receb_cred_c = (jQuery('#vl-rec-cred-fec-c').val() == '' ? 0 : jQuery('#vl-rec-cred-fec-c').val());
    var vl_externa_c    = (jQuery('#vl-ext-fec-c').val() == '' ? 0 : jQuery('#vl-ext-fec-c').val());
    var vl_debito_c     = (jQuery('#vl-cdeb-fec-c').val() == '' ? 0 : jQuery('#vl-cdeb-fec-c').val());
    var vl_credito_c    = (jQuery('#vl-ccre-fec-c').val() == '' ? 0 : jQuery('#vl-ccre-fec-c').val());
    var vl_crediario_c  = (jQuery('#vl-crediar-fec-c').val() == '' ? 0 : jQuery('#vl-crediar-fec-c').val());
    var vl_retiradas_c  = (jQuery('#vl-ret-fec-c').val() == '' ? 0 : jQuery('#vl-ret-fec-c').val());
           
    var vl_avista_fs      = (parseFloat(vl_avista_c) - parseFloat(vl_avista)); 
    var vl_receb_cred_fs  = (parseFloat(vl_receb_cred_c) - parseFloat(vl_receb_cred)); 
    var vl_externa_fs     = (parseFloat(vl_externa_c) - parseFloat(vl_externa));
    var vl_debito_fs      = (parseFloat(vl_debito_c) - parseFloat(vl_debito)); 
    var vl_credito_fs     = (parseFloat(vl_credito_c) - parseFloat(vl_credito));
    var vl_crediario_fs   = (parseFloat(vl_crediario_c) - parseFloat(vl_crediario));
    var vl_retiradas_fs   = (parseFloat(vl_retiradas_c) - parseFloat(vl_retiradas));
    var vl_total_fs       = (parseFloat(vl_total) - parseFloat(vl_total_c)); 
    var vl_total_c =  (parseFloat(vl_avista_c) + parseFloat(vl_receb_cred_c) +
                      parseFloat(vl_externa_c) + parseFloat(vl_debito_c) +
                      parseFloat(vl_credito_c) + parseFloat(vl_crediario_c) -
                      parseFloat(vl_retiradas_c) + parseFloat(vl_troco_ini));  

    var vl_total_fec_c = (parseFloat(vl_total_c) - parseFloat(vl_total));

    var vl_avista_fs = parseFloat(vl_avista_fs).toFixed(2); 
    var vl_receb_cred_fs = parseFloat(vl_receb_cred_fs).toFixed(2); 
    var vl_externa_fs = parseFloat(vl_externa_fs).toFixed(2); 
    var vl_debito_fs = parseFloat(vl_debito_fs).toFixed(2); 
    var vl_credito_fs = parseFloat(vl_credito_fs).toFixed(2); 
    var vl_crediario_fs = parseFloat(vl_crediario_fs).toFixed(2); 
    var vl_retiradas_fs = parseFloat(vl_retiradas_fs).toFixed(2); 
    var vl_total_fs = parseFloat(vl_total_fs).toFixed(2); 
    var vl_total_c = parseFloat(vl_total_c).toFixed(2); 
    var vl_total_fec_c = parseFloat(vl_total_fec_c).toFixed(2); 

    
    jQuery('#vl-avista-fec-fs').val(vl_avista_fs);
    jQuery('#vl-rec-cred-fec-fs').val(vl_receb_cred_fs);
    jQuery('#vl-ext-fec-fs').val(vl_externa_fs);
    jQuery('#vl-cdeb-fec-fs').val(vl_debito_fs);
    jQuery('#vl-ccre-fec-fs').val(vl_credito_fs);
    jQuery('#vl-crediar-fec-fs').val(vl_crediario_fs);
    jQuery('#vl-ret-fec-fs').val(vl_retiradas_fs);
    jQuery('#vl-total-fec-c').val(vl_total_c);
    jQuery('#vl-total-fec-fs').val(vl_total_fec_c);

    var corPos = "#00FF00";
    var corNeg = "#FF8C00"; 

    if (vl_avista_fs < 0){
      document.getElementById('vl-avista-fec-fs').style.color = corNeg;
    }else{
      document.getElementById('vl-avista-fec-fs').style.color = corPos; 
    }
    if (vl_receb_cred_fs < 0){
      document.getElementById('vl-rec-cred-fec-fs').style.color = corNeg;
    }else{
      document.getElementById('vl-rec-cred-fec-fs').style.color = corPos; 
    }
    if (vl_externa_fs < 0){
      document.getElementById('vl-ext-fec-fs').style.color = corNeg;
    }else{
      document.getElementById('vl-ext-fec-fs').style.color = corPos; 
    }
    if (vl_debito_fs < 0){
      document.getElementById('vl-cdeb-fec-fs').style.color = corNeg;
    }else{
      document.getElementById('vl-cdeb-fec-fs').style.color = corPos; 
    }
    if (vl_credito_fs < 0){
      document.getElementById('vl-ccre-fec-fs').style.color = corNeg;
    }else{
      document.getElementById('vl-ccre-fec-fs').style.color = corPos; 
    }
    if (vl_crediario_fs < 0){
      document.getElementById('vl-crediar-fec-fs').style.color = corNeg;
    }else{
      document.getElementById('vl-crediar-fec-fs').style.color = corPos; 
    }
    if (vl_retiradas_fs < 0){
      document.getElementById('vl-ret-fec-fs').style.color = corNeg;
    }else{
      document.getElementById('vl-ret-fec-fs').style.color = corPos; 
    }
    if (vl_total_c < 0){
      document.getElementById('vl-total-fec-c').style.color = corNeg;
    }else{
      document.getElementById('vl-total-fec-c').style.color = corPos; 
    }
    if (vl_total_fec_c < 0){
      document.getElementById('vl-total-fec-fs').style.color = corNeg;
    }else{
      document.getElementById('vl-total-fec-fs').style.color = corPos; 
    }
    
  });
});


