var imageOptions = function (field,pType,sectionId,sectionKey,object){
    if (sectionKey == undefined) {
            sectionKey = 0 ;
    }
    var sectionField = ScrudCForm.elements[sectionKey].section_fields[field];
    object.html('<div class="form-group"></div>');
    var innerObject = $('<div class="radio-list"></div>');
    object.append(innerObject);
    innerObject.append('<label><b>Thumbnail size</b></label>');
    innerObject.append();
    innerObject.append('<label>'+
        '<input type="radio" value="mini" name="thumbnail" checked="checked">'+
        '&nbsp;Mini'+
        '</label>');
    innerObject.append('<label>'+
        '<input type="radio"  value="small" name="thumbnail">'+
        '&nbsp;Small'+
        '</label>');
        
        
    innerObject.append('<label>'+
        '<input type="radio" value="medium" name="thumbnail">'+
        '&nbsp;Medium'+
        '</label>');
        
        
    innerObject.append('<label>'+
        '<input type="radio"  value="large" name="thumbnail">'+
        '&nbsp;Large'+
        '</label>');
    
    object.append('<label><b>Size</b></label>');
    object.append('<div class="form-group"><label> &nbsp;Width: <input type="text" class="input-small form-control" name="img_width" /> </lable></div>');
    object.append('<div class="form-group"><label> Height: <input type="text" class="input-small form-control" name="img_height" /> </lable></div>');
    
    $('input[name="thumbnail"]').click(function(){
        if (sectionField.type_options == undefined){
            sectionField.type_options = {};
        }
        sectionField.type_options.thumbnail = $(this).val();
    });
    
    $('input[name="thumbnail"]').each(function(){
        if (sectionField.type_options.thumbnail == $(this).val()){
            $('input[name="thumbnail"]').attr({checked:false});
            $(this).attr({checked:true});
        }
    });
    
    $('input[name="img_width"]').keyup(function(){
    	sectionField.type_options.img_width = $(this).val();
    });
    
    $('input[name="img_height"]').keyup(function(){
    	sectionField.type_options.img_height = $(this).val();
    });
    
    if (sectionField.type_options.img_width != undefined){
    	$('input[name="img_width"]').val(sectionField.type_options.img_width);
    }
    
    if (sectionField.type_options.img_height != undefined){
    	$('input[name="img_height"]').val(sectionField.type_options.img_height);
    }
	
};
