var textOptions = function (field,pType,sectionId,sectionKey,object){
	if (sectionKey == undefined) {
            sectionKey = 0 ;
    }
    var sectionField = ScrudCForm.elements[sectionKey].section_fields[field];
    object.html('');
    object.append('<label class="control-label">Size</label>');
    object.append($('<input type="text" class="form-control" style="width:60px; margin-bottom:0; line-height:16px; height:30px; font-size:13px;"  id="slider_width_val"/> px'));

    
};
var timzoneoptions = function (field,pType,sectionId,sectionKey,object){
	if (sectionKey == undefined) {
            sectionKey = 0 ;
    }
    var sectionField = ScrudCForm.elements[sectionKey].section_fields[field];
    object.html('');
    object.append('<label class="control-label">Size</label>');
    object.append($('<input type="text" class="form-control" style="width:60px; margin-bottom:0; line-height:16px; height:30px; font-size:13px;"  id="slider_width_val"/> px'));

    
};
var texthidden = function (field,pType,sectionId,sectionKey,object){
    if (sectionKey == undefined) {
            sectionKey = 0 ;
    }
    
    var sectionField = ScrudCForm.elements[sectionKey].section_fields[field];
    
    if (sectionField.hidden_options == undefined){
        sectionField.hidden_options = {}
    }
    var sd = $('<div id="select-database" style="margin-top:5px; display:none;"></div>');

    //Create Options DropDown Buttons
    var tbl = $('<select class="form-control select2" id="predefined" style="width:170%;"></select>');
        tbl.append('<option value="manual">Manual Value</option>');
        tbl.append('<option value="predefined">Predefined</option>');
    
    object.append($('<label>Please Select &nbsp; </label>').append(tbl));
    //Create Options DropDown Buttons
    
    tbl.change(function(){
        if ($.trim($(this).val()) != '' && $(this).val()=='predefined'){
            sectionField.hidden_options.choice = $(this).val();
            sd.empty();
            $.get(ScrudCForm.urlGetFields+'crud_module_entity_ids',{},function(json){
                
                //DATA STARTS HERE
                var options = $('<select class="form-control select2" ></select>');
                options.append('<option></option>');
                sd.append($('<label>Choose Below </label>').append(options));
                
                $.each(json['session'], function(k, v) {
                    options.append('<option value="'+k+'">'+k+'</option>');
                });
                
                if (sectionField.hidden_options.value != undefined && sectionField.hidden_options.value != ''){
                    options.val(sectionField.hidden_options.value);
                }
                options.change(function(){
                    sectionField.hidden_options.value = $(this).val();
                    ScrudCForm.changeFieldToForm(field,pType,sectionId,sectionKey);
                });
                //DATA ENDS HERE
            },'json');
        }else if($.trim($(this).val()) != '' && $(this).val()=='manual'){
            sectionField.hidden_options.choice = $(this).val();
            sd.empty();
            sd.append($('<input type="text" class="form-control" id="manual_data" style="width:100%;" />'));
            $('#manual_data').blur(function(){
                sectionField.hidden_options.value = $('#manual_data').val();
                ScrudCForm.changeFieldToForm(field,pType,sectionId,sectionKey);
            });
        } else {
            sd.empty();
        }
    });
    
    //HIDDEN FIELDS
    if(sectionField['hidden_options']['choice']=='manual'){
        
        var sd = $('<div style="margin-top:5px;"></div>');
        sd.append($('<input type="text" class="form-control" id="manual_data" style="width:100%;" />'));
        object.append(sd);
        $('#manual_data').val(sectionField['hidden_options']['value']);
        
    } else if(sectionField['hidden_options']['choice']=='predefined'){
        $('#predefined').val(sectionField['hidden_options']['choice']);
        
        var sd = $('<div style="margin-top:5px;"></div>');
        $.get(ScrudCForm.urlGetFields+'module_entity_ids',{},function(json){
                
                //DATA STARTS HERE
                var options = $('<select class="form-control select2" style="width:100%;" ></select>');
                options.append('<option></option>');
                sd.append($('<label>Choose Below </label>').append(options));
                
                $.each(json['session'], function(k, v) {
                    options.append('<option value="'+k+'">'+k+'</option>');
                });
                
                if (sectionField.hidden_options.value != undefined && sectionField.hidden_options.value != ''){
                    options.val(sectionField.hidden_options.value);
                }
                options.change(function(){
                    sectionField.hidden_options.value = $(this).val();
                    ScrudCForm.changeFieldToForm(field,pType,sectionId,sectionKey);
                });
                //DATA ENDS HERE
            },'json');
        object.append(sd);
    }
    //HIDDEN FIELDS
    
    $('#manual_data').blur(function(){
        sectionField.hidden_options.value = $('#manual_data').val();
        ScrudCForm.changeFieldToForm(field,pType,sectionId,sectionKey);
    }); 
};

//Custom Functions
var cfields = function (field,pType,sectionId,sectionKey,object){
    if (sectionKey == undefined) {
            sectionKey = 0 ;
    }
    
    var sectionField = ScrudCForm.elements[sectionKey].section_fields[field];
    if (sectionField.cfieldsdata == undefined){
        sectionField.cfieldsdata = {}
    }
    
    var sectionField = ScrudCForm.elements[sectionKey].section_fields[field];
    object.html('');
    object.append('<label class="control-label">Please Enter HTML & JS</label>');
    object.append($('<textarea class="form-control" id="customfields" placeholder="Please Enter Here"></textarea>'));
    if(sectionField.cfieldsdata.value){
        $('#customfields').val(sectionField.cfieldsdata.value);
    }

    $('#customfields').keyup(function(){
        sectionField.cfieldsdata.value = $('#customfields').val();
        ScrudCForm.changeFieldToForm(field,pType,sectionId,sectionKey);
    }); 
    
};

/// Add new function for Rleated modules
var relatedModuleOptions = function (field,pType,sectionId,sectionKey,object){
    if (sectionKey == undefined) {
            sectionKey = 0 ;
    }
    var sectionField = ScrudCForm.elements[sectionKey].section_fields[field];
    object.html('');
    object.append('<p class="font-red-mint">Related Module is not regular type of field, it will always be displayed in a separate section of module. </p>');
    //ScrudCForm.modules.sort();
    //console.log((ScrudCForm.modules));
    var sd = $('<div id="select-module" style="margin-top:5px;"></div>');
    var mdls = $('<select class="form-control select2" style="width:100%;"></select>');
    mdls.append('<option></option>');

    for(var i in ScrudCForm.modules){
        if(sectionField.options.id == i){
            mdls.append('<option value="'+i+'" selected="selected">'+ScrudCForm.modules[i]+'</option>');
        } else{
            mdls.append('<option value="'+i+'">'+ScrudCForm.modules[i]+'</option>');
        }
    }
    sd.append($('<label>Select Module &nbsp; </label>')).append(mdls);
    
    var osd = $('<div></div>');
    sd.append(osd);
    object.append(sd);
    mdls.change(function(){
        var related_module_id = {};

        if ($.trim($(this).val()) != ''){
            related_module_id = {id:$(this).val()};
            //sectionField.options.id = $(this).val();
            console.log(JSON.stringify(sectionField));
        }else{
           // sectionField.options.id = 0;
            related_module_id = {id:$(this).val()};
        }
        console.log(JSON.stringify(related_module_id));
        sectionField.options = related_module_id;
    });
    
};

var relatedModuleOptionsMultipe = function (field,pType,sectionId,sectionKey,object){
    if (sectionKey == undefined) {
            sectionKey = 0 ;
    }
    var sectionField = ScrudCForm.elements[sectionKey].section_fields[field];
    object.html('');
    object.append('<p class="font-red-mint">Related Module is not regular type of field, it will always be displayed in a separate section of module. </p>');
    //ScrudCForm.modules.sort();
    //console.log((ScrudCForm.modules));
    var sd = $('<div id="select-module" style="margin-top:5px;"></div>');
    var mdls = $('<select class="form-control select2-multiple" style="width:100%;" multiple></select>');
    mdls.append('<option></option>');

    for(var i in ScrudCForm.modules){
        if(sectionField.options.id == i){
            mdls.append('<option value="'+i+'" selected="selected">'+ScrudCForm.modules[i]+'</option>');
        } else{
            mdls.append('<option value="'+i+'">'+ScrudCForm.modules[i]+'</option>');
        }
    }
    sd.append($('<label>Select Module &nbsp; </label>')).append(mdls);
    
    var osd = $('<div></div>');
    sd.append(osd);
    object.append(sd);
    $(".select2, .select2-multiple").select2({
            placeholder: "Select...",
            width: null
        });
    mdls.change(function(){
        var related_module_id = {};

        if ($.trim($(this).val()) != ''){
            related_module_id = {id:$(this).val()};
            //sectionField.options.id = $(this).val();
            console.log(JSON.stringify(sectionField));
        }else{
           // sectionField.options.id = 0;
            related_module_id = {id:$(this).val()};
        }
        console.log(JSON.stringify(related_module_id));
        sectionField.options = related_module_id;
    });

    
};
