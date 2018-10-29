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


<!-- date n time pickers -->

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/media/assets/global/plugins/clockface/css/clockface.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/media/assets/global/plugins/bootstrap-datepicker/css/datepicker3.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/media/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/media/assets/global/plugins/bootstrap-colorpicker/css/colorpicker.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/media/assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/media/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css"/>
<!-- END PAGE LEVEL STYLES -->
<!-- date n time pickers -->

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/media/assets/global/plugins/bootstrap-select/bootstrap-select.min.css"/>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/media/assets/global/plugins/jquery-multi-select/css/multi-select.css"/>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/media/assets/global/plugins/select2/select2.css"/>
<!-- END PAGE LEVEL SCRIPTS -->
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
        <?php //echo $main_footer; ?>
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
//ComponentsDropdowns.init();
ComponentsPickers.init();



   

});
</script>

<script type="text/javascript">

    function saveReport(){

        var report_name         = $('input[name="report_name"]').val();

        var moduleIds = [];
        $('.related_module').each(function(){
            var thisId = this.id;
            if($(this)[0].nodeName == 'SELECT'){
                var moduleId = $('#'+thisId+' option:selected').val();
                if (moduleId !== '') {
                    moduleIds.push(moduleId);
                }
            }
        });
        var related_modules     = moduleIds;
        var report_des          = $('input[name="report_des"]').val();
        var module_fields       = $('#module_fields').val();
        
        var group_by_1          = $('#group_by_1 option:selected').val();

        
        var order_by_1          = $('input[name="order_by_1"]:checked').val();


        var filter_1            = $('#filter_1 option:selected').val();
        var cond_1              = $('#cond_1 option:selected').val();
        var cond_val_1          = $('#cond_val_1').val();

        //var jsonData = {};
        
        var groupby       = [group_by_1+'^'+order_by_1];
        
        var conditions     = [filter_1+'^'+cond_1+'^'+cond_val_1];

        
        var jsonData = {report_name, related_modules, module_fields, groupby, conditions};
        var json_string = JSON.stringify(jsonData);
        console.log(json_string);

        $.post('<?php echo base_url(); ?>index.php/admin/reports/saveReport', {jsonData:jsonData}, function(data){
            console.log('returned Data: ' + data);

        });




        //window.location = '<?php echo base_url(); ?>index.php/admin/scrud/browse?com_id=46';
        
    }

    $('.filter').on('change',function(){
        var cutId           = (this.id).split('_');
        var thisId          = '#' + this.id;
        var selectedValue   = $(this).find('option:selected').val();

        var typeArr         = (selectedValue).split('|');
        var textBoxIdExHash = 'cond_val_' + cutId[1];
        var textBoxId       = '#cond_val_' + cutId[1];
        var parentControl   = '#dynamic_controll_' + cutId[1];
        var condBox         = '#cond_' + cutId[1];
        // If filed type is date
        if (typeArr[2] == 'date') {
            $(parentControl).find('select').attr('id','');
            $(parentControl).find('div').remove();
            $(parentControl).find('input[type="text"]').addClass('date-picker').datepicker();
            $(parentControl).find('input[type="text"]').datepicker('enable');
            $(parentControl).find('input[type="text"]').datepicker({dateFormat:"dd-mm-yyyy"} );
            $(parentControl).find('input[type="text"]').attr('id',textBoxIdExHash);
            $(parentControl).find('input[type="text"]').attr('name',textBoxIdExHash);
            $(parentControl).find('input[type="text"]').show();
            var dateOptions = '<option></option>'+
                        '<option value="e">equals</option>'+
                        '<option value="n">not equal to</option>'+
                        '<option value="bw">between</option>'+
                        '<option value="b">before</option>'+
                        '<option value="a">after</option>'+
                        '<option value="y">is empty</option>'+
                        '<option value="ny">is not empty</option>';
            $(condBox).select2({
                placeholder: "select..."
            }); 
            $(condBox).each(function () { //added a each loop here
                $(this).select2('val', '')
            });
            $(condBox).html(dateOptions);
        }
        // If field type is autocomplete or select
        if (typeArr[2] == 'autocomplete' || typeArr[2] == 'select') {
            $(parentControl).find('select').select2();
            $(parentControl).find('select').show();
            $(parentControl).find('select').attr('id',textBoxIdExHash);
            $(parentControl).find('select').attr('name',textBoxIdExHash);
            $(parentControl).find('input[type="text"]').attr('id','');
            $(parentControl).find('input[type="text"]').attr('name','');
            $(parentControl).find('input[type="text"]').css('display','none');
            // Get fields from controller

            
            $.post('<?php echo base_url(); ?>index.php/admin/creport/field_data', {data:typeArr[0]}, function(output){
                var outvalues = JSON.parse(output);
                var opt = '<option></option>';
                console.log(output);
                // loop through all values of select box
                for (var i = 0; i < outvalues.length; i++) {
                    var getValue = (outvalues[i]).split('|');    
                    opt = opt + '<option value="'+getValue[0]+'">'+getValue[1]+'</option>';   
                }; // end of for  
                $(parentControl).find('select').select2({
                    placeholder: "select..."
                });
                $(parentControl).find('select').each(function () { //added a each loop here
                    $(this).select2('val', '')
                });
                $(parentControl).find('select').html(opt);             
            });
        }
        // if field type is text
        if (typeArr[2] == 'text') {
            $(parentControl).find('select').attr('id','');
            $(parentControl).find('div').remove();
            $(parentControl).find('input[type="text"]').removeClass('date-picker'); //
            $(parentControl).find('input[type="text"]').datepicker('remove');
            $(parentControl).find('input[type="text"]').attr('id',textBoxIdExHash);
            $(parentControl).find('input[type="text"]').show();
            $(parentControl).find('input[type="text"]').val('');
            var textOptions = '<option></option>'+
                            '<option value="e">equals</option>'+
                            '<option value="n">not equal to</option>'+
                            '<option value="s">starts with</option>'+
                            '<option value="ew">ends with</option>'+
                            '<option value="c">contains</option>'+
                            '<option value="k">does not contain</option>'+
                            '<option value="y">is empty</option>'+
                            '<option value="ny">is not empty</option>';
            $(condBox).select2({
                placeholder: "select..."
            }); 
            $(condBox).each(function () { //added a each loop here
                $(this).select2('val', '')
            });
            $(condBox).html(textOptions);
        }
        if (typeArr[2] == 'currency') {
            $(parentControl).find('select').attr('id','');
            $(parentControl).find('div').remove();
            $(parentControl).find('input[type="text"]').removeClass('date-picker'); //
            $(parentControl).find('input[type="text"]').datepicker('remove');
            $(parentControl).find('input[type="text"]').attr('id',textBoxIdExHash);
            $(parentControl).find('input[type="text"]').show();
            $(parentControl).find('input[type="text"]').val('');
            var numberOptions = '<option></option><option value="e">equals</option><option value="n">not equal to</option><option value="l">less than</option><option value="g">greater than</option><option value="m">less or equal</option><option value="h">greater or equal</option><option value="y">is empty</option><option value="ny">is not empty</option>';
            $(condBox).select2({
                placeholder: "select..."
            }); 
            $(condBox).each(function () { //added a each loop here
                $(this).select2('val', '')
            });
            $(condBox).html(numberOptions);
        }
    });
      
    $('.modules').change(function(){
        var selectedModule = $( "#"+this.id+" option:selected" ).val();
        var splitSelect = (this.id).split('_');
        $.post('<?php echo base_url(); ?>index.php/admin/reports/get_related', {module_id:selectedModule}, function(data){
                var obj = JSON.parse(data);
                var opt = '<option></option>';
                var nextSelect = Number(splitSelect[2]) + 1;
                for (var i = 0; i < obj.length; i++) {  
                    opt = opt + '<option value="'+obj[i].id+'">'+obj[i].module_name+'</option>';   
                }; // end of for  
                $('#related_module_'+nextSelect).html(opt);
        });
        getModuleFields();
    });
    function getModuleFields(){
        var moduleIds = [];
        $('.related_module').each(function(){
            var thisId = this.id;
            if($(this)[0].nodeName == 'SELECT'){
                var moduleId = $('#'+thisId+' option:selected').val();
                if (moduleId !== '') {
                    moduleIds.push(moduleId);
                }
            }
        });
        /// GET FIELDS OF ALL SELECTED MODULES
        $.post('<?php echo base_url(); ?>index.php/admin/reports/relatedModFieldList', {module_ids:moduleIds}, function(data){
                var json = JSON.parse(data);
                var innerHtml = '';
                for(var a in json) {
                    var optionHtml = '';
                    for (var i = 0; i < json[a].length; i++) {
                        var optionValue = json[a][i].field+'|'+json[a][i].alias+'|'+json[a][i].type;
                        optionHtml = optionHtml + '<option value="'+optionValue+'">'+json[a][i].alias+'</option>'; 
                    };
                    innerHtml = innerHtml+ '<optgroup label="'+a+'">' + optionHtml + '</optgroup>'; 
                };
                $('#module_fields').html(innerHtml);
                $('#group_by_1').html(innerHtml);
                $('#group_by_2').html(innerHtml);
                $('#group_by_3').html(innerHtml);
                $('#filter_1').html(innerHtml);
                $('#filter_2').html(innerHtml);
                $('#filter_3').html(innerHtml);
        });
    }
    function addAndRow(str){
        var splitRowId = str.split('_');
        var newRowId = Number(splitRowId[2]) + 1
        var content = $("#"+str).clone();
        
        $(content).attr('id',splitRowId[0]+'_'+splitRowId[1]+'_'+newRowId);

        $(content).find('#filter_'+splitRowId[2]).attr('id','filter_'+newRowId);
        $(content).find('#filter_'+newRowId).attr('name','filter_'+newRowId);
        
        //$(content).find('#filter_'+newRowId).attr('id','filter_'+newRowId).select2("destroy");

        $(content).find('#cond_'+splitRowId[2]).attr('id','cond_'+newRowId);
        $(content).find('#cond_'+newRowId).attr('name','cond_'+newRowId);
        
        //$(content).find('#cond_'+newRowId).select2("destroy");

        $(content).find('#cond_val_'+splitRowId[2]).attr('id','cond_val_'+newRowId);
        $(content).find('#cond_val_'+newRowId).attr('name','cond_val_'+newRowId);
        
        //$(content).find('#cond_val_'+newRowId).select2("destroy");

        $("#"+str).parent().append(content);
        $("#"+str).parent().find('select').select2("destroy");
        $("#"+str).parent().find('select').select2();
        $(content).find('#cond_'+splitRowId[2]).remove();
        $(content).find('#filter_'+splitRowId[2]).remove();
        $(content).find('#cond_val_'+splitRowId[2]).remove();
        
    }
     


</script>
    </body>
</html>
