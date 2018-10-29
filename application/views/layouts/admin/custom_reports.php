<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="<?php echo __HTML_CHARSET__; ?>">
        <title><?php echo $this->lang->line('codeigniter_admin_pro'); ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

 <!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>/media/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>/media/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>/media/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>/media/assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css">
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/media/assets/global/plugins/bootstrap-select/bootstrap-select.min.css"/>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/media/assets/global/plugins/jquery-multi-select/css/multi-select.css"/>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/media/assets/global/plugins/select2/select2.css"/>
<!-- END PAGE LEVEL SCRIPTS -->


<!-- date n time pickers -->

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/media/assets/global/plugins/clockface/css/clockface.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/media/assets/global/plugins/bootstrap-datepicker/css/datepicker3.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/media/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/media/assets/global/plugins/bootstrap-colorpicker/css/colorpicker.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/media/assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/media/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css"/>
<!-- END PAGE LEVEL STYLES -->
<!-- date n time pickers -->

<!-- BEGIN THEME STYLES -->
<link href="<?php echo base_url(); ?>/media/assets/global/css/components-md.css" id="style_components" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>/media/assets/global/css/plugins-md.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>/media/assets/admin/layout3/css/layout.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>/media/assets/admin/layout3/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color">
<link href="<?php echo base_url(); ?>/media/assets/admin/layout3/css/custom.css" rel="stylesheet" type="text/css">
    </head>
    <body>
    
        <?php echo $main_menu; ?>
        <?php echo $main_content; ?>
        
     <!-- BEGIN FOOTER -->
<div class="page-footer">
    <div class="container">
         <?php echo date('Y');?> © SenServe CRM.
    </div>
</div>
<div class="scroll-to-top">
    <i class="icon-arrow-up"></i>
</div>
<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="../../assets/global/plugins/respond.min.js"></script>
<script src="../../assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
<script src="<?php echo base_url(); ?>/media/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/media/assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="<?php echo base_url(); ?>/media/assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/media/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/media/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/media/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/media/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/media/assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/media/assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="<?php echo base_url(); ?>/media/assets/global/plugins/jquery-validation/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/media/assets/global/plugins/jquery-validation/js/additional-methods.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/media/assets/global/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
<!-- END PAGE LEVEL PLUGINS -->


<!-- BEGIN MULTI SELECT PLUGINS -->
<script type="text/javascript" src="<?php echo base_url(); ?>/media/assets/global/plugins/bootstrap-select/bootstrap-select.min.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>/media/assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js"></script>
<!-- END  MULTI SELECT PLUGINS -->


<!-- date n time pickers -->

<script type="text/javascript" src="<?php echo base_url(); ?>/media/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/media/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/media/assets/global/plugins/clockface/js/clockface.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/media/assets/global/plugins/bootstrap-daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/media/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/media/assets/global/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/media/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<!-- date n time pickers -->

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="<?php echo base_url(); ?>/media/assets/global/plugins/select2/select2.min.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url(); ?>/media/assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/media/assets/admin/layout3/scripts/layout.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/media/assets/admin/layout3/scripts/demo.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/media/assets/admin/pages/scripts/form-wizard.js"></script>

<script src="<?php echo base_url(); ?>/media/assets/admin/pages/scripts/components-dropdowns-kam.js"></script>
<script src="<?php echo base_url(); ?>/media/assets/admin/pages/scripts/components-pickers.js"></script>

<!-- END PAGE LEVEL SCRIPTS -->
<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {       
   // initiate layout and plugins
   Metronic.init(); // init metronic core components
Layout.init(); // init current layout
Demo.init(); // init demo features
FormWizard.init();
ComponentsPickers.init();


});




// Check filters 

$('.filter').on('change',function(){

    var cutId = (this.id).split('_');

    var thisId = '#' + this.id;
    var selectedValue = $(thisId + ' option:selected').val();
    
    var typeArr = (selectedValue).split(',');

    var textBoxIdExHash = 'cond_val_' + cutId[1];
    var textBoxId = '#cond_val_' + cutId[1];

    var parentControl = '#dynamic_controll_' + cutId[1];
  
    if (typeArr[1] == 'date') {
        $(parentControl).find('select').attr('id','');
        $(parentControl).find('div').remove();
        $(parentControl).find('input[type="text"]').addClass('date-picker').datepicker();
        $(parentControl).find('input[type="text"]').datepicker('enable');
        $(parentControl).find('input[type="text"]').attr('id',textBoxIdExHash);
        $(parentControl).find('input[type="text"]').attr('name',textBoxIdExHash);
        $(parentControl).find('input[type="text"]').show();

    }
    if (typeArr[1] == 'autocomplete' || typeArr[1] == 'select') {
       
        $(parentControl).find('select').select2();
        $(parentControl).find('select').show();
        $(parentControl).find('select').attr('id',textBoxIdExHash);
        $(parentControl).find('select').attr('name',textBoxIdExHash);
        $(parentControl).find('input[type="text"]').attr('id','');
        $(parentControl).find('input[type="text"]').attr('name','');
        $(parentControl).find('input[type="text"]').css('display','none');


        

         $.post('<?php echo base_url(); ?>index.php/admin/creport/field_data', {data:typeArr[2]}, function(output){
               
               

               var outvalues = JSON.parse(output);
               
              
               var opt = '';
               for (var i = 0; i < outvalues.length; i++) {

                    var getValue = (outvalues[i]).split('|');
                    
                    opt = opt + '<option value="'+getValue[0]+'">'+getValue[1]+'</option>';
                   
                };  
                $(parentControl).find('select').html(opt);         
                
        });



       


    }
    if (typeArr[1] == 'text') {
        
        $(parentControl).find('select').attr('id','');
        $(parentControl).find('div').remove();
        $(parentControl).find('input[type="text"]').removeClass('date-picker'); //
        $(parentControl).find('input[type="text"]').datepicker('remove');
        $(parentControl).find('input[type="text"]').attr('id',textBoxIdExHash);
        $(parentControl).find('input[type="text"]').show();
    }



    
});


$('#all').on('click',function(){

    var postUrl = '<?php echo base_url(); ?>index.php/admin/creport/allpdf';
    $('#genReport').attr('action', postUrl).submit();
});

$('#individual').on('click',function(){
    
    var postUrl = '<?php echo base_url(); ?>index.php/admin/creport/creport2';
    $('#genReport').attr('action', postUrl).submit();
});
</script>

    </body>
</html>
