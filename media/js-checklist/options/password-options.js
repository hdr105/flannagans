var passwordOptions = function (field,pType,sectionId,sectionKey,object){
    if (sectionKey == undefined) {
            sectionKey = 0 ;
    }
    var sectionField = ScrudCForm.elements[sectionKey].section_fields[field];
    object.html('');
    object.append('<label><b>Size</b></label>');
    object.append($('<label class="inline">Width: <input type="text" style="width:30px; margin-bottom:0; line-height:16px; height:16px; font-size:13px;" id="slider_width_val"/> px </label>'));
   
	
};
