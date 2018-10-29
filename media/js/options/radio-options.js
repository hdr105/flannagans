var radioOption = function(field,pType,sectionId,sectionKey,object){
    if (sectionKey == undefined) {
            sectionKey = 0 ;
    }
    var sectionField = ScrudCForm.elements[sectionKey].section_fields[field];
    object.html('');
    object.append('<label><b>Options</b></label>');
	
    var so = $('<div id="radio-options"  style="margin-top:5px;"></div>');
    object.append(so);
    if (sectionField.values == undefined){
        sectionField.values = [];
    }
    if (sectionField.options != undefined && sectionField.options.length > 0){
        so.html('');
        var opts = sectionField.options;
        var vals = sectionField.values;
        for(var i in opts){
            var _vals = (vals[i] != undefined)?vals[i]:'';
            so.append(__scrudRadioOption(field,pType,sectionId,sectionKey,opts[i],_vals));
        }
    }else{
        so.append(__scrudRadioOption(field,pType,sectionId,sectionKey));
    }
	
};

var __scrudRadioOption = function(field,pType,sectionId,sectionKey,val,value){
    if (sectionKey == undefined) {
            sectionKey = 0 ;
    }
    var sectionField = ScrudCForm.elements[sectionKey].section_fields[field];
    val = (val == undefined)?"":val;
    value = (value == undefined)?$('input[name="r_value"]').length+1:value;
    var o = $('<div class="radio-list"></div>');
    var k = $('<input type="text" name="r_value"  style="width:60px;" value="'+value+'" placeholder="Value"/>');
    var t = $('<input type="text" name="r_lable"   style="width:98px;" value="'+val+'" placeholder="Label" />');
    t.keyup(function(){
        sectionField.options = [];
        $('#preview_field_'+field).find('.controls').html('');
        $('#radio-options').find('input[name="r_lable"]').each(function(index){
            if ($.trim($(this).val()) != '' && $.trim($($('input[name="r_value"]').get(index)).val()) != ''){
                $('#preview_field_'+field).find('.controls').append($('<label class="radio-inline" style="display:inline-block; margin-right: 15px;"><input type="radio" name="optionsRadios" value="'+$($('input[name="r_value"]').get(index)).val()+'"/>'+$(this).val()+'</label>'));
                var _length = sectionField.options.length;
                sectionField.options[_length] = $(this).val();
                sectionField.values[_length] = $($('input[name="r_value"]').get(index)).val();
            }
        });
    });
    k.keyup(function(){
        sectionField.options = [];
        $('#preview_field_'+field).find('.controls').html('');
        $('#radio-options').find('input[name="r_lable"]').each(function(index){
            if ($.trim($(this).val()) != '' && $.trim($($('input[name="r_value"]').get(index)).val()) != ''){
                $('#preview_field_'+field).find('.controls').append($('<label class="radio-inline" style="display:inline-block; margin-left: 25px;"><input type="radio" name="optionsRadios" value="'+$($('input[name="r_value"]').get(index)).val()+'"/>'+$(this).val()+'</label>'));
                var _length = sectionField.options.length;
                sectionField.options[_length] = $(this).val();
                sectionField.values[_length] = $($('input[name="r_value"]').get(index)).val();
            }
        });
    });
    var ab = $('<a style="margin-bottom:10px; cursor:pointer;"><i class="icon-plus"></i></a>');
    ab.click(function(){
        __scrudRadioOption(field).insertAfter($(this).parent());
    });
    var db = $('<a style="margin-bottom:10px; cursor:pointer;"><i class="icon-minus"></i></a>');
    db.click(function(){
        if ($('#radio-options').children('div[class!="deleted"]').length > 1){
            $(this).parent().hide();
            $(this).parent().addClass('deleted');
            $(this).parent().find('input[type="text"]').val('');
            
            sectionField.options = [];
            $('#preview_field_'+field).find('.controls').html('');
            $('#radio-options').find('input[name="r_lable"]').each(function(index){
                if ($.trim($(this).val()) != '' && $.trim($($('input[name="r_value"]').get(index)).val()) != ''){
                    $('#preview_field_'+field).find('.controls').append($('<label class="radio-inline" style="display:inline-block; margin-left: 25px;"><input type="radio" name="optionsRadios" value="'+$($('input[name="r_value"]').get(index)).val()+'"/>'+$(this).val()+'</label>'));
                    var _length = sectionField.options.length;
                    sectionField.options[_length] = $(this).val();
                    sectionField.values[_length] = $($('input[name="r_value"]').get(index)).val();
                }
            });
        }
    });
    o.append(k).append(' ').append(t).append(' ').append(ab).append(' ').append(db);
    return o;
};