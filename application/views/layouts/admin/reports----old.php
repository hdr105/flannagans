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
        var sel_module          = $('#sel_module option:selected').val();
        var related_modules     = $('#related_modules').val();
        var report_des          = $('input[name="report_des"]').val();
        var module_fields       = $('#module_fields').val();
        
        var group_by_1          = $('#group_by_1 option:selected').val();
        var group_by_2          = $('#group_by_2 option:selected').val();
        var group_by_3          = $('#group_by_3 option:selected').val();
        
        var order_by_1          = $('input[name="order_by_1"]:checked').val();
        var order_by_2          = $('input[name="order_by_2"]:checked').val();
        var order_by_3          = $('input[name="order_by_3"]:checked').val();

        var filter_1            = $('#filter_1 option:selected').val();
        var cond_1              = $('#cond_1 option:selected').val();
        var cond_val_1          = $('input[name="cond_val_1"]').val();
        

        var filter_2            = $('#filter_2 option:selected').val();
        var cond_2              = $('#cond_2 option:selected').val();
        var cond_val_2          = $('input[name="cond_val_2"]').val();

        var filter_3            = $('#filter_3 option:selected').val();
        var cond_3              = $('#cond_3 option:selected').val();
        var cond_val_3          = $('input[name="cond_val_3"]').val();

        //var jsonData = {};
        
        var groupby       = [[group_by_1,order_by_1],[group_by_2,order_by_2],[group_by_3,order_by_3]];
        
        var conditions     = [[filter_1,cond_1,cond_val_1],[filter_2,cond_2,cond_val_2],[filter_3,cond_3,cond_val_3]];

        
        var jsonData = {report_name,sel_module, related_modules, module_fields, groupby, conditions};
        var json_string = JSON.stringify(jsonData);
        console.log(json_string);

        $.post('<?php echo base_url(); ?>index.php/admin/reports/saveReport', {jsonData:jsonData}, function(data){
            console.log('returned Data: ' + data);

        });




        window.location = '<?php echo base_url(); ?>index.php/admin/scrud/browse?com_id=46';
        
    }

    $('.filter').on('change',function(){
        var cutId           = (this.id).split('_');
        var thisId          = '#' + this.id;
        var selectedValue   = $(thisId + ' option:selected').val();
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
    $('.cond').on('change',function(){
        
        var breakID = (this.id).split('_');
        var selectedCond = '#cond_' + breakID[1];
        var varVal = $(selectedCond + ' option:selected').val();     
        var thisId          = '#filter_'+breakID[1];
        var selectedValue   = $(thisId + ' option:selected').val();
        var typeArr         = (selectedValue).split('|');
        var textBoxIdExHash = 'cond_val_'+breakID[1];
        var containerDiv = '#dynamic_controll_' + breakID[1];
        if (varVal == 'bw' && typeArr[2] == 'date') {
            
            $(containerDiv + ' .simpleText').attr('id','');
            $(containerDiv + ' .simpleText').css('display','none');
            $(containerDiv + ' select').attr('id','');
            $(containerDiv + ' select').css('display','none');
            $(containerDiv + ' select').remove('div');
            $('#cond_drange_'+breakID[1]).css('display','block');
            var dateRange = '<div id="cond_drange_'+breakID[1]+'" class="input-group daterange input-large date-picker input-daterange" data-date="10-11-2012" data-date-format="dd-mm-yyyy"><input type="text" class="form-control" name="dfrom"><span class="input-group-addon"> to </span><input type="text" class="form-control" name="dto"></div>';
            $(containerDiv).append(dateRange);
            $('input[name="dfrom"]').addClass('date-picker').datepicker();
            $('input[name="dfrom"]').datepicker('enable');
            $('input[name="dto"]').addClass('date-picker').datepicker();
            $('input[name="dto"]').datepicker('enable');
        } else if(varVal != 'bw' && typeArr[2] == 'date') {
            var dateRangeId = '#cond_drange_' + breakID[1];
            $(containerDiv).find('select').attr('id','');
            $(containerDiv).find('div').remove();
            
            $(containerDiv).find('input[type="text"]').addClass('date-picker').datepicker();
            $(containerDiv).find('input[type="text"]').datepicker('enable');
            $(containerDiv).find('input[type="text"]').datepicker({dateFormat:"dd-mm-yyyy"} );
            $(containerDiv).find('input[type="text"]').attr('id',textBoxIdExHash);
            $(containerDiv).find('input[type="text"]').attr('name',textBoxIdExHash);
            $(containerDiv).find('input[type="text"]').show();
            var dateOptions = '<option></option>'+
                        '<option value="e">equals</option>'+
                        '<option value="n">not equal to</option>'+
                        '<option value="bw">between</option>'+
                        '<option value="b">before</option>'+
                        '<option value="a">after</option>'+
                        '<option value="y">is empty</option>'+
                        '<option value="ny">is not empty</option>';
            $(this.id).select2({
                placeholder: "select..."
            }); 
            $(this.id).each(function () { //added a each loop here
                $(this).select2('val', '')
            });
            $(this.id).html(dateOptions);
        }
    });
   

    function add_cond(){

        var numItems = $('.filter_row').length;


        var rowId = 'filter_row_' + numItems;

        var aobjName = '#' + rowId;
        
        var newRowId = 'filter_row_' + Number(numItems+1);
        var nFilter = 'filter_' + Number(numItems+1);
        var nCond = 'cond_' + Number(numItems+1);
        var nCondVal = 'cond_val_' + Number(numItems+1);
        
        var f = $(aobjName).html();
        $(aobjName).parent().append('<tr class="filter_row" id="'+newRowId+'">'+f+'</tr>');
    
        /*var newProductRow = '#' + newRowId;
        $(newProductRow).find('.filter').attr({'id':nFilter,'name':nFilter});
        $(newProductRow).find('.cond').attr({'id':nCond,'name':nCond});
        $(newProductRow).find('.cond_val').attr({'id':nCondVal,'name':nCondVal});
        ComponentsDropdowns.init();*/
        
    }

    function add_cond2(){

        var numItems = $('.filter2_row').length;


        var rowId = 'filter2_row_' + numItems;

        var aobjName = '#' + rowId;
        
        var newRowId = 'filter2_row_' + Number(numItems+1);
        var nFilter = 'filter2_' + Number(numItems+1);
        var nCond = 'cond2_' + Number(numItems+1);
        var nCondVal = 'cond2_val_' + Number(numItems+1);
        
        var f = $(aobjName).html();
        $(aobjName).parent().append('<tr class="filter2_row" id="'+newRowId+'">'+f+'</tr>');
    
        /*var newProductRow = '#' + newRowId;
        $(newProductRow).find('.filter2').attr({'id':nFilter,'name':nFilter});
        $(newProductRow).find('.cond2').attr({'id':nCond,'name':nCond});
        $(newProductRow).find('.cond2_val').attr({'id':nCondVal,'name':nCondVal});
        ComponentsDropdowns.init();*/
    }    

     $('#sel_module').on('change',function(){
        var selectedModule = $( "#sel_module option:selected" ).val();
        
            
            var qjson = {};
            qjson['main_table'] = selectedModule;
            $('#qjson').val(JSON.stringify(qjson));
            $.post('<?php echo base_url(); ?>index.php/admin/reports/get_related', {moduleName:selectedModule}, function(data){
                console.log(JSON.stringify(data));
                var obj = JSON.parse(data);
                var control = '#related_modules';
                
                tagSelect(control, obj);
               
               
                
                
            });

       
    });
    $('#related_modules').on('change',function(){
        
        
            
           
                var valControl = $(this).val();

                var valArry = valControl.split(",");



                    var selectedModule = $( "#sel_module option:selected" ).val();


                    //var qjson = {};
                    //var pre_json = $('#qjson').val();
                    //qjson = JSON.parse(pre_json);
                    //qjson['related_modules'] = valArry;


                    //qjson['related_modules'].push(selectedModule);
                    //$('#qjson').val(JSON.stringify(qjson));

                    $.post('<?php echo base_url(); ?>index.php/admin/reports/relatedModFieldList', {selectedModule:selectedModule, relatedModules:valControl}, function(data){
                        var obj = JSON.parse(data);
                        console.log(obj);
                        var innerHtml = '';
                        for (var i = 0; i < obj.length; i++) {
                            
                             console.log('optons: ' + JSON.stringify(obj[i].moduleInfo));
                            var optionValues = '';
                            var array2 = obj[i].moduleInfo;
                            for (var a = 0; a < array2.length; a++) {
                              

                                optionValues = optionValues+ '<option value="'+array2[a][2]+'|'+array2[a][0]+'|'+array2[a][1]+'">' +array2[a][0] + '</option>';
                            }
                            console.log('optons: ' + optionValues);

                            innerHtml = innerHtml+ '<optgroup label="'+obj[i].moduleName+'">' + optionValues + '</optgroup>';
                        };
                        $('#module_fields').html(innerHtml);

                        $('#group_by_1').html(innerHtml);
                        $('#group_by_2').html(innerHtml);
                        $('#group_by_3').html(innerHtml);
                        $('#filter_1').html(innerHtml);
                        $('#filter_2').html(innerHtml);
                        $('#filter_3').html(innerHtml);
                        
                         

                    });

               
                
                 

       
    });


</script>
    </body>
</html>
