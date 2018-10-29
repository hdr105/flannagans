var selectOption = function(field,pType,sectionId,sectionKey,object){
    if (sectionKey == undefined) {
            sectionKey = 0 ;
    }
    var sectionField = ScrudCForm.elements[sectionKey].section_fields[field];
    if (sectionField.db_options == undefined){
        sectionField.db_options = {}
    }
    var so = $('<div id="select-options" style="margin-top:5px; display:none;"></div>');
    var sd = $('<div id="select-database" style="margin-top:5px; display:none;"></div>');
    object.html('');
    object.append('<label class="control-label"><b>Opt</b></label>&nbsp;');
    var too1 = $('<input name="type-of-options" value="default" type="radio">');
    if (sectionField.list_choose == 'default'){
        too1.attr({
            checked:'checked'
        });
        so.show();
        sd.hide();
    }
    too1.click(function(){
        sectionField.list_choose = 'default';
        ScrudCForm.changeFieldToForm(field,pType,sectionId,sectionKey);
        so.show();
        sd.hide();
        $('#form-preview').css({
            height:'auto'
        });
        $('#form-preview').height($('#form-preview').height());
    });
    
    object.append($('<label class="radio-inline"></label>').append(too1).append(' Default '));
    
    var too2 = $('<input name="type-of-options" value="database"  type="radio">');
    if (sectionField.list_choose == 'database'){
        too2.attr({
            checked:'checked'
        });
        so.hide();
        sd.show();
    }
    too2.click(function(){
        sectionField.list_choose = 'database';
        ScrudCForm.changeFieldToForm(field,pType,sectionId,sectionKey);
        so.hide();
        sd.show();
    });
    
    object.append($('<label class="radio-inline"></label>').append(too2).append(' Database '));
    
    object.append(so).append(sd);
    if (sectionField.options == undefined){
        sectionField.options = [];
    }
    if (sectionField.options.length > 0){
        so.html('');
        var opts = sectionField.options;
        for(var i in opts){
            so.append(__scrudOption(field,pType,sectionId,sectionKey,opts[i]));
        }
    }else{
        so.append(__scrudOption(field,pType,sectionId,sectionKey));
    }
    
    var tbl = $('<select class="form-control select2" style="width:176px;"></select>');
    tbl.append('<option></option>');
    for(var i in ScrudCForm.tables){
        tbl.append('<option value="'+ScrudCForm.tables[i]+'">'+ScrudCForm.tables[i]+'</option>');
    }
    sd.append($('<label>Table &nbsp; </label>').append(tbl));
    
    var osd = $('<div></div>');
    sd.append(osd);
    
    tbl.change(function(){
        if ($.trim($(this).val()) != ''){
            __scrudDbOption(osd,$(this).val(),field,pType,sectionId,sectionKey);
            sectionField.db_options.table = $(this).val();
        }else{
            sectionField.db_options.table = '';
            sectionField.db_options.key = '';
            sectionField.db_options.value = '';
            osd.html('');
        }
    });
    
    if (sectionField.list_choose == 'database'){
        if (sectionField.db_options != undefined){
            if (sectionField.db_options.table != undefined && sectionField.db_options.table != ''){
                tbl.val(sectionField.db_options.table);
                __scrudDbOption(osd,sectionField.db_options.table,field,pType,sectionId,sectionKey);
            }
        }
    }
    if (sectionField.type == 'select'){
        var multiple = $('<input type="checkbox" />');
        object.append($('<label class="checkbox"> multiple</label>').prepend(multiple));
        multiple.click(function(){
            if ($(this).is(':checked')) {
                sectionField.multiple = 'multiple';
                $('#preview_field_'+field).find('.controls').children('select').attr('multiple','multiple');
            }else{
                ScrudCForm.elements[field].multiple = null;
                $('#preview_field_'+field).find('.controls').children('select').attr('multiple',null);
            }
        });
        
        if (sectionField.multiple != undefined && sectionField.multiple == 'multiple'){
            multiple.attr('checked','checked');
        }
    }
    
};

var __scrudOption = function(field,pType,sectionId,sectionKey,val){
    if (sectionKey == undefined) {
            sectionKey = 0 ;
    }
    var sectionField = ScrudCForm.elements[sectionKey].section_fields[field];
    val = (val == undefined)?"":val;
    var o = $('<div></div>');
    var t = $('<input class="form-control" type="text"  style="/*width:100px;*/" value="'+val+'" />');
    t.keyup(function(){
        sectionField.options = [];
        $('#preview_field_'+field).find('.controls').children('select').html('');
        $('#preview_field_'+field).find('.controls').children('select').append($('<option></option>'));
        $('#select-options').find('input[type="text"]').each(function(){
            if ($.trim($(this).val()) != ''){
                $('#preview_field_'+field).find('.controls').children('select').append($('<option>'+$(this).val()+'</option>'));
                sectionField.options[sectionField.options.length] = $(this).val();
            }
        });
    });
    var ab = $('<a class="btn btn-sm blue icon-only" style="margin-bottom:2px;"><i class="fa fa-plus"></i></a>');
    ab.click(function(){
        __scrudOption(field,pType,sectionId,sectionKey).insertAfter($(this).parent());
    });
    var db = $('<a class="btn btn-sm red icon-only" style="margin-bottom:2px;"><i class="fa fa-trash"></i></a>');
    db.click(function(){
        if ($('#select-options').children('div[class!="deleted"]').length > 1){
            $(this).parent().hide();
            $(this).parent().addClass('deleted');
            $(this).parent().find('input[type="text"]').val('');
            
            sectionField.options = [];
            $('#preview_field_'+field).find('.controls').children('select').html('');
            $('#preview_field_'+field).find('.controls').children('select').append($('<option></option>'));
            $('#select-options').find('input[type="text"]').each(function(){
                if ($.trim($(this).val()) != ''){
                    $('#preview_field_'+field).find('.controls').children('select').append($('<option>'+$(this).val()+'</option>'));
                    sectionField.options[sectionField.options.length] = $(this).val();
                }
            });
        }
    });
    o.append(t).append(' ').append(ab).append(' ').append(db);
    return o;
};

var __scrudDbOption = function(osd,table,field,pType,sectionId,sectionKey){
    if (sectionKey == undefined) {
            sectionKey = 0 ;
    }
    
    var sectionField = ScrudCForm.elements[sectionKey].section_fields[field];
    osd.html('');
    $.get(ScrudCForm.urlGetFields+table,{},function(json){
        var value = $('<select class="form-control select2" style="width:176px;"></select>');
        value.append('<option></option>');
        osd.append($('<label>Value  &nbsp; </label>').append(value));
        for(var i in json){
            value.append('<option value="'+json[i]+'">'+json[i]+'</option>');
        }
        if (sectionField.db_options.key != undefined && sectionField.db_options.key != ''){
            value.val(sectionField.db_options.key);
        }
        value.change(function(){
            sectionField.db_options.key = $(this).val();
            ScrudCForm.changeFieldToForm(field,pType,sectionId,sectionKey);
        });
        
        var option = $('<select class="form-control select2" style="width:176px;"></select>');
        option.append('<option></option>');
        osd.append($('<label>Option </label>').append(option));
        for(var i in json){
            option.append('<option value="'+json[i]+'">'+json[i]+'</option>');
        }
        if (sectionField.db_options.value != undefined && sectionField.db_options.value != ''){
            option.val(sectionField.db_options.value);
        }
        option.change(function(){
            sectionField.db_options.value = $(this).val();
            ScrudCForm.changeFieldToForm(field,pType,sectionId,sectionKey);
        });
        
        // CONDITION CODE STARTS HERE
        osd.append($('<br /><label><b>Custom Condition</b> </label><br />').append(column));
        
        //COLUMNS STARTS HERE
        var column = $('<select class="form-control select2" style="width:176px;"></select>');
        column.append('<option></option>');
        osd.append($('<label>Column </label>').append(column));
        for(var i in json){
            column.append('<option value="'+json[i]+'">'+json[i]+'</option>');
        }
        if (sectionField.db_options.column != undefined && sectionField.db_options.column != ''){
            column.val(sectionField.db_options.column);
        }
        column.change(function(){
            sectionField.db_options.column = $(this).val();
            ScrudCForm.changeFieldToForm(field,pType,sectionId,sectionKey);
        });
        //COLUMNS END HERE
        
        //ACTIONS STARTS HERE
        var action = $('<select class="form-control select2" style="width:176px;"></select>');
        action.append('<option></option>');
        osd.append($('<label>Action </label>').append(action));
        
        action.append('<option value="=">Equals</option>');
        action.append('<option value="!=">Not Equals</option>');
        action.append('<option value=">">Greater Than</option>');
        action.append('<option value="<">Less Than</option>');
        action.append('<option value=">=">Greater Than And Equal To</option>');
        action.append('<option value="<=">Less Than And Equal To</option>');
        
        if (sectionField.db_options.action != undefined && sectionField.db_options.action != ''){
            action.val(sectionField.db_options.action);
        }
        action.change(function(){
            sectionField.db_options.action = $(this).val();
            ScrudCForm.changeFieldToForm(field,pType,sectionId,sectionKey);
        });
        //ACTIONS END HERE
        
        //CONDITION STARTS HERE
        var condition = $('<select class="form-control select2" style="width:176px;"></select>');
        condition.append('<option></option>');
        osd.append($('<label>Condition </label>').append(condition));
        
        $.each(json[i], function(k, v) {
            condition.append('<option value="'+k+'">'+k+'</option>');
        });
        
        condition.append('<option value="">-------User Roles--------</option>');
        condition.append('<option value="1">Administrators</option>');
        condition.append('<option value="2">Managers</option>');
        condition.append('<option value="6">Line Managers</option>');
        condition.append('<option value="3">Staff</option>');
        condition.append('<option value="5">Client</option>');

        if (sectionField.db_options.condition != undefined && sectionField.db_options.condition != ''){
            condition.val(sectionField.db_options.condition);
        }
        condition.change(function(){
            sectionField.db_options.condition = $(this).val();
            ScrudCForm.changeFieldToForm(field,pType,sectionId,sectionKey);
        });
        //CONDITION ENDS HERE
        
        //CUSTOM TEXT CONDITIONS STARTS
        if(sectionField.db_options.customtext != undefined){
            var customtext = $('<input class="form-control" type="text" value="'+sectionField.db_options.customtext+'" style="width:176px;">');
        } else{
            var customtext = $('<input class="form-control" type="text" style="width:176px;">');
        }
        
        osd.append($('<label>Custom Text Condition </label>').append(customtext));
        customtext.keyup(function(){
            sectionField.db_options.customtext = $(this).val();
            ScrudCForm.changeFieldToForm(field,pType,sectionId,sectionKey);
        });
        //CUSTOM TEXT CONDITIONS ENDS
        // CONDITION CODE STARTS HERE
        
        $('#form-preview').css({
            height:'auto'
        });
        $('#form-preview').height($('#form-preview').height());
    },'json');
}
