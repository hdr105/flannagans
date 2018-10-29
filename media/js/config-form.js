
var ScrudCForm = {
    elements : {},
    config:{
        frm_type:'1',
        table:{},
        filter:{
            list:undefined,
            actived:[],
            atrr:{}
        },
        column:{
            list:undefined,
            actived:[],
            attr:{}
        },
        join:[]
    },
    wpage:'',
    urlGetOptions:'',
    urlGetFields:'',
    urlSaveConfig:'',
    successfully_message:'',
    fields:[],
    table:'',
    tables:[],
    modules:[],
    current_field:'',
    
    init:function(table){
        if (table != undefined){
            ScrudCForm.table = table;	    	
        }
        $('#fieldTab a[href="#options"]').hide();
    },
    
    buildFields:function(){
        //        $('#form-fields').append('<li class="nav-header">'+ScrudCForm.table+' table</li>');
        

        for(var k in ScrudCForm.fields){
           
            $('#form-fields').append(ScrudCForm.createField(ScrudCForm.fields[k]));
        }
        $('#form-fields').append('---------------------------------');
        $('#form-fields').append(ScrudCForm.createField('empty1'));
        $('#form-fields').append(ScrudCForm.createField('empty2'));
        $('#form-fields').append(ScrudCForm.createField('empty3'));
        $('#form-fields').append(ScrudCForm.createField('empty4'));
        $('#form-fields').append(ScrudCForm.createField('empty5'));
    },
    
    addJoin:function (object){
        if (object == undefined){
            object = {};
        }
        
        var joinType = $('<select id="joinType" style="width:auto;"></select>');
        joinType.append('<option value="INNER">INNER</option>');
        joinType.append('<option value="LEFT">LEFT</option>');
        joinType.append('<option value="RIGHT">RIGHT</option>');
    	
        if (object.type != undefined){
            joinType.val(object.type);
        }
        
        var joinTable = $('<select id="joinTable"></select>');
        //joinTable.append('<option value=""></option>');
        for(var i in ScrudCForm.tables){
            if (ScrudCForm.tables[i] == ScrudCForm.table) continue; 
            joinTable.append('<option value="'+ScrudCForm.tables[i]+'">'+ScrudCForm.tables[i]+'</option>');
        }
    	
        if (object.table != undefined){
            joinTable.val(object.table);
        }
    	
        var currentField = $('<select id="currentField"></select>');
        //currentField.append('<option value=""></option>');
        for(var i in ScrudCForm.fields){
            currentField.append('<option value="'+ScrudCForm.table +'.'+ScrudCForm.fields[i]+'">'+ScrudCForm.table +'.'+ScrudCForm.fields[i]+'</option>');
        }
        if (object.currentField != undefined){
            currentField.val(object.currentField);
        }
    	
        var targetField = $('<select id="targetField"></select>');
    	
        var deleteButton = $('<input type="button" value="Delete" class="btn btn-danger" />');
        deleteButton.click(function(){
            $(this).parent().remove();
                
            var joinFields = [];
        
            $('#dataListJoin > div > #targetField > option').each(function(){
                joinFields[joinFields.length] = $(this).val();
            });

            var removeFields = [];
            var tmpFields = [];
                
            for(var i in ScrudCForm.fields){
                tmpFields[tmpFields.length] = ScrudCForm.fields[i];
            }
                
            for(var i in joinFields){
                tmpFields[tmpFields.length] = joinFields[i];
            }

            for(var i in ScrudCForm.config.column.list){
                if ($.inArray(ScrudCForm.config.column.list[i], tmpFields) == -1){
                    removeFields[removeFields.length] = ScrudCForm.config.column.list[i];
                }
            }
            for(var i in removeFields){
                ScrudCForm.config.column.list.splice($.inArray(removeFields[i], ScrudCForm.config.column.list),1);
            }
            ScrudCForm.buildColumn();
                
        });
    	
        joinTable.change(function(){
            var targetTable = $(this).val();
            $.get(ScrudCForm.urlGetFields+targetTable,{},function(json){
                if (json != null){
                    targetField.children().remove();
                    for(var i in json){
                        targetField.append('<option value="'+targetTable+'.'+json[i]+'">'+targetTable+'.'+json[i]+'</option>');
                    }
                    targetField.val(object.targetField);
                }
                var joinFields = [];
        
                $('#dataListJoin > div > #targetField > option').each(function(){
                    joinFields[joinFields.length] = $(this).val();
                });

                var removeFields = [];
                var tmpFields = [];

                for(var i in ScrudCForm.fields){
                    tmpFields[tmpFields.length] = ScrudCForm.fields[i];
                }

                for(var i in joinFields){
                    tmpFields[tmpFields.length] = joinFields[i];
                }

                for(var i in ScrudCForm.config.column.list){
                    if ($.inArray(ScrudCForm.config.column.list[i], tmpFields) == -1){
                        removeFields[removeFields.length] = ScrudCForm.config.column.list[i];
                    }
                }
                for(var i in removeFields){
                    ScrudCForm.config.column.list.splice($.inArray(removeFields[i], ScrudCForm.config.column.list),1);
                }
                ScrudCForm.buildColumn();
            },'json');
        });
    	
        $('#dataListJoin').append(
            $('<div></div>').css({
                'margin-bottom':'5px'
            })
            .append(joinType)
            .append(' JOIN ')
            .append(joinTable)
            .append(' ON ')
            .append(currentField)
            .append(' = ')
            .append(targetField)
            .append(' ')
            .append(deleteButton)
            );
        joinTable.trigger('change');
    },
    
    buildFilter:function(){
        if (ScrudCForm.config.filter == undefined){
            ScrudCForm.config.filter = {};
            ScrudCForm.config.filter.list = ScrudCForm.fields;
            ScrudCForm.config.filter.actived = [];
        }
        //if (ScrudCForm.config.filter.list == undefined){
            ScrudCForm.config.filter.list = ScrudCForm.fields;
        //}
        
        /*for(var i in ScrudCForm.fields){
            if ($.inArray(ScrudCForm.fields[i],ScrudCForm.config.filter.list) == -1){
                ScrudCForm.config.filter.list[ScrudCForm.config.filter.list.length] = ScrudCForm.fields[i];
            }
        }*/
        
        for(var i in ScrudCForm.config.filter.list){
            var f = $('<input type="checkbox">');
            f.val(ScrudCForm.config.filter.list[i]);
            if (jQuery.inArray(ScrudCForm.config.filter.list[i], ScrudCForm.config.filter.actived) >= 0){
                f.attr({
                    checked:'checked'
                });
            }
            var ebtn = $('<a class="btn btn-mini" style="float: right; cursor:pointer;"></a>')
            .attr({
                name:ScrudCForm.config.filter.list[i]
            })
            .append($('<i class="icon-pencil"></i>'));
    		
            ebtn.click(function(){
                var field = $(this).attr('name');
                if (ScrudCForm.config.filter.atrr == undefined){
                    ScrudCForm.config.filter.atrr = {}
                }
                if (ScrudCForm.config.filter.atrr[field] == undefined){
                    ScrudCForm.config.filter.atrr[field] = {}
                }
                $('#filter_container').removeClass('span5');
                $('#filter_container_right').remove();
                $('#filter_container').addClass('span5');
                var ccr = $('<div></div>').attr({
                    id:'filter_container_right'
                }).addClass('span7');
    			
                ccr.append(
                    $('<div style="margin-bottom:5px;"></div>')
                    .append(' Name &nbsp;&nbsp;&nbsp;&nbsp; ')
                    .append(field)
                    );
    			
                var alias = $('<input type="text" />');
    			
                if (ScrudCForm.config.filter.atrr[field].alias != undefined){
                    alias.val(ScrudCForm.config.filter.atrr[field].alias);
                }else{
                    if (ScrudCForm.elements[field] != undefined){
                        alias.val(ScrudCForm.elements[field].label);
                        ScrudCForm.config.filter.atrr[field].alias = ScrudCForm.elements[field].label;
                    }else{
                        alias.val(field);
                        ScrudCForm.config.filter.atrr[field].alias = field;
                    }
                }
                alias.keyup(function(){
                    ScrudCForm.config.filter.atrr[field].alias = $(this).val();
                });
    			
                ccr.append(
                    $('<div style="margin-bottom:5px;"></div>')
                    .append(' Alias &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  ')
                    .append(alias)
                    );
                $('#filter_container').after(ccr);
            });
    		
            $('#filter_elements').append(
                $('<li></li>')
                .append(
                    $('<a></a>')
                    .append(
                        $('<label class="checkbox"></label>')
                        .append(f)
                        .append(ScrudCForm.config.filter.list[i])
                        )
                    .append(ebtn)
                    )
                );
        }
    },
    
//CHANGES BY KAMRAN SB START
    buildQuickCreate:function(){
        var fields = ScrudCForm.extractFields();
        //console.log('Extracted Fields: ' + JSON.stringify(ScrudCForm.extractFields()));
        if (ScrudCForm.config.quickcreate == undefined){
            ScrudCForm.config.quickcreate = {};
            ScrudCForm.config.quickcreate.list = ScrudCForm.fields;//fields;
            ScrudCForm.config.quickcreate.actived = [];
        }
        //if (ScrudCForm.config.quickcreate.list == undefined){
            ScrudCForm.config.quickcreate.list = ScrudCForm.fields;//fields;
            //console.log(ScrudCForm.config.quickcreate.list);
        //}
        
        /*for(var i in ScrudCForm.fields){
            if ($.inArray(ScrudCForm.fields[i],ScrudCForm.config.filter.list) == -1){
                ScrudCForm.config.filter.list[ScrudCForm.config.filter.list.length] = ScrudCForm.fields[i];
            }
        }*/
        
        for(var i in ScrudCForm.config.quickcreate.list){
            var f = $('<input type="checkbox">');
            f.val(ScrudCForm.config.quickcreate.list[i]);
            if (jQuery.inArray(ScrudCForm.config.quickcreate.list[i], ScrudCForm.config.quickcreate.actived) >= 0){
                f.attr({
                    checked:'checked'
                });
            }
            var ebtn = $('<a class="btn btn-sm blue" style="float: right; cursor:pointer;"></a>')
            .attr({
                name:ScrudCForm.config.quickcreate.list[i]
            })
            .append($('<i class="icon-pencil"></i>'));
            
            ebtn.click(function(){
                var field = $(this).attr('name');
                if (ScrudCForm.config.quickcreate.atrr == undefined){
                    ScrudCForm.config.quickcreate.atrr = {}
                }
                if (ScrudCForm.config.quickcreate.atrr[field] == undefined){
                    ScrudCForm.config.quickcreate.atrr[field] = {}
                }
                $('#quickcreate_container').removeClass('col-md-5');
                $('#quickcreate_container_right').remove();
                $('#quickcreate_container').addClass('col-md-5');
                var ccr = $('<div></div>').attr({
                    id:'quickcreate_container_right'
                }).addClass('col-md-7');
                
                ccr.append(
                    $('<div style="margin-bottom:5px;"></div>')
                    .append(' Name &nbsp;&nbsp;&nbsp;&nbsp; ')
                    .append(field)
                    );
                
                var alias = $('<input type="text" class="form-control" />');
                
                if (ScrudCForm.config.quickcreate.atrr[field].alias != undefined){
                    alias.val(ScrudCForm.config.quickcreate.atrr[field].alias);
                }else{
                    if (fields[field] != undefined){
                        alias.val(fields[field].label);
                        ScrudCForm.config.quickcreate.atrr[field].alias = fields[field].label;
                    }else{
                        alias.val(field);
                        ScrudCForm.config.quickcreate.atrr[field].alias = field;
                    }
                }
                alias.keyup(function(){
                    ScrudCForm.config.quickcreate.atrr[field].alias = $(this).val();
                });
                
                ccr.append(
                    $('<div style="margin-bottom:5px;"></div>')
                    .append(' Alias &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  ')
                    .append(alias)
                    );
                $('#quickcreate_container').after(ccr);
            });
            
            $('#quickcreate_elements').append(
                $('<li></li>')
                .append(
                    $('<a></a>')
                    .append(
                        $('<label class="checkbox"></label>')
                        .append(f)
                        .append(ScrudCForm.config.quickcreate.list[i])
                        )
                    .append(ebtn)
                    )
                );
        }

        //console.log('quick created list: ' + JSON.stringify(ScrudCForm.config.quickcreate.list));
    },
    buildMassEdit:function(){
        var fields = ScrudCForm.extractFields();
        //console.log('Extracted Fields: ' + JSON.stringify(ScrudCForm.extractFields()));
        if (ScrudCForm.config.massedit == undefined){
            ScrudCForm.config.massedit = {};
            ScrudCForm.config.massedit.list = ScrudCForm.fields;//fields;
            ScrudCForm.config.massedit.actived = [];
        }
        //if (ScrudCForm.config.quickcreate.list == undefined){
            ScrudCForm.config.massedit.list = ScrudCForm.fields;//fields;
            //console.log(ScrudCForm.config.massedit.list);
        //}
        
        /*for(var i in ScrudCForm.fields){
            if ($.inArray(ScrudCForm.fields[i],ScrudCForm.config.filter.list) == -1){
                ScrudCForm.config.filter.list[ScrudCForm.config.filter.list.length] = ScrudCForm.fields[i];
            }
        }*/
        
        for(var i in ScrudCForm.config.massedit.list){
            var f = $('<input type="checkbox">');
            f.val(ScrudCForm.config.massedit.list[i]);
            if (jQuery.inArray(ScrudCForm.config.massedit.list[i], ScrudCForm.config.massedit.actived) >= 0){
                f.attr({
                    checked:'checked'
                });
            }
            var ebtn = $('<a class="btn btn-sm blue" style="float: right; cursor:pointer;"></a>')
            .attr({
                name:ScrudCForm.config.massedit.list[i]
            })
            .append($('<i class="icon-pencil"></i>'));
            
            ebtn.click(function(){
                var field = $(this).attr('name');
                if (ScrudCForm.config.massedit.atrr == undefined){
                    ScrudCForm.config.massedit.atrr = {}
                }
                if (ScrudCForm.config.massedit.atrr[field] == undefined){
                    ScrudCForm.config.massedit.atrr[field] = {}
                }
                $('#massedit_container').removeClass('col-md-5');
                $('#massedit_container_right').remove();
                $('#massedit_container').addClass('col-md-5');
                var ccr = $('<div></div>').attr({
                    id:'massedit_container_right'
                }).addClass('col-md-7');
                
                ccr.append(
                    $('<div style="margin-bottom:5px;"></div>')
                    .append(' Name &nbsp;&nbsp;&nbsp;&nbsp; ')
                    .append(field)
                    );
                
                var alias = $('<input type="text" class="form-control" />');
                
                if (ScrudCForm.config.massedit.atrr[field].alias != undefined){
                    alias.val(ScrudCForm.config.massedit.atrr[field].alias);
                }else{
                    if (fields[field] != undefined){
                        alias.val(fields[field].label);
                        ScrudCForm.config.massedit.atrr[field].alias = fields[field].label;
                    }else{
                        alias.val(field);
                        ScrudCForm.config.massedit.atrr[field].alias = field;
                    }
                }
                alias.keyup(function(){
                    ScrudCForm.config.massedit.atrr[field].alias = $(this).val();
                });
                
                ccr.append(
                    $('<div style="margin-bottom:5px;"></div>')
                    .append(' Alias &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  ')
                    .append(alias)
                    );
                $('#massedit_container').after(ccr);
            });
            
            $('#massedit_elements').append(
                $('<li></li>')
                .append(
                    $('<a></a>')
                    .append(
                        $('<label class="checkbox"></label>')
                        .append(f)
                        .append(ScrudCForm.config.massedit.list[i])
                        )
                    .append(ebtn)
                    )
                );
        }

        //console.log('quick created list: ' + JSON.stringify(ScrudCForm.config.massedit.list));
    },
    buildSummaryView:function(){
        var fields = ScrudCForm.extractFields();
        //console.log('Extracted Fields: ' + JSON.stringify(ScrudCForm.extractFields()));
        if (ScrudCForm.config.summary == undefined){
            ScrudCForm.config.summary = {};
            ScrudCForm.config.summary.list = ScrudCForm.fields;//fields;
            ScrudCForm.config.summary.actived = [];
        }
        //if (ScrudCForm.config.quickcreate.list == undefined){
            ScrudCForm.config.summary.list = ScrudCForm.fields;//fields;
            //console.log(ScrudCForm.config.massedit.list);
        //}
        
        /*for(var i in ScrudCForm.fields){
            if ($.inArray(ScrudCForm.fields[i],ScrudCForm.config.filter.list) == -1){
                ScrudCForm.config.filter.list[ScrudCForm.config.filter.list.length] = ScrudCForm.fields[i];
            }
        }*/
        
        for(var i in ScrudCForm.config.summary.list){
            var f = $('<input type="checkbox">');
            f.val(ScrudCForm.config.summary.list[i]);
            if (jQuery.inArray(ScrudCForm.config.summary.list[i], ScrudCForm.config.summary.actived) >= 0){
                f.attr({
                    checked:'checked'
                });
            }
            var ebtn = $('<a class="btn btn-sm blue" style="float: right; cursor:pointer;"></a>')
            .attr({
                name:ScrudCForm.config.summary.list[i]
            })
            .append($('<i class="icon-pencil"></i>'));
            
            ebtn.click(function(){
                var field = $(this).attr('name');
                if (ScrudCForm.config.summary.atrr == undefined){
                    ScrudCForm.config.summary.atrr = {}
                }
                if (ScrudCForm.config.summary.atrr[field] == undefined){
                    ScrudCForm.config.summary.atrr[field] = {}
                }
                $('#summary_container').removeClass('col-md-5');
                $('#summary_container_right').remove();
                $('#summary_container').addClass('col-md-5');
                var ccr = $('<div></div>').attr({
                    id:'summary_container_right'
                }).addClass('col-md-7');
                
                ccr.append(
                    $('<div style="margin-bottom:5px;"></div>')
                    .append(' Name &nbsp;&nbsp;&nbsp;&nbsp; ')
                    .append(field)
                    );
                
                var alias = $('<input type="text" class="form-control" />');
                
                if (ScrudCForm.config.summary.atrr[field].alias != undefined){
                    alias.val(ScrudCForm.config.summary.atrr[field].alias);
                }else{
                    if (fields[field] != undefined){
                        alias.val(fields[field].label);
                        ScrudCForm.config.summary.atrr[field].alias = fields[field].label;
                    }else{
                        alias.val(field);
                        ScrudCForm.config.summary.atrr[field].alias = field;
                    }
                }
                alias.keyup(function(){
                    ScrudCForm.config.summary.atrr[field].alias = $(this).val();
                });
                
                ccr.append(
                    $('<div style="margin-bottom:5px;"></div>')
                    .append(' Alias &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  ')
                    .append(alias)
                    );
                $('#summary_container').after(ccr);
            });
            
            $('#summary_elements').append(
                $('<li></li>')
                .append(
                    $('<a></a>')
                    .append(
                        $('<label class="checkbox"></label>')
                        .append(f)
                        .append(ScrudCForm.config.summary.list[i])
                        )
                    .append(ebtn)
                    )
                );
        }

        //console.log('quick created list: ' + JSON.stringify(ScrudCForm.config.massedit.list));
    },
    //CHANGES BY KAMRAN SB END
  
      buildColumn:function(){
        $('#column_elements').children().remove();
        if (ScrudCForm.config.column == undefined){
            ScrudCForm.config.column = {};
            ScrudCForm.config.column.list = ScrudCForm.fields;
            ScrudCForm.config.column.actived = [];
        }
        if (ScrudCForm.config.column.list == undefined){
            ScrudCForm.config.column.list = ScrudCForm.fields;
        }
        
        for(var i in ScrudCForm.fields){
            if ($.inArray(ScrudCForm.fields[i],ScrudCForm.config.column.list) == -1){
                ScrudCForm.config.column.list[ScrudCForm.config.column.list.length] = ScrudCForm.fields[i];
            }
        }
        
        
        $('#dataListJoin > div > #targetField > option').each(function(){
            if ($.inArray($(this).val(), ScrudCForm.config.column.list) == -1){
                ScrudCForm.config.column.list[ScrudCForm.config.column.list.length] = $(this).val();
            }
        });
        
        for(var i in ScrudCForm.config.column.list){
            var f = $('<input type="checkbox">');
            f.val(ScrudCForm.config.column.list[i]);
            if (jQuery.inArray(ScrudCForm.config.column.list[i], ScrudCForm.config.column.actived) >= 0){
                f.attr({
                    checked:'checked'
                });
            }
            var li = $('<li></li>');
            var ebtn = $('<a class="btn btn-mini" style="float: right; cursor:pointer;"></a>')
            .attr({
                name:ScrudCForm.config.column.list[i]
            })
            .append($('<i class="icon-pencil"></i>'));
    		 
            ebtn.click(function(){
                var field = $(this).attr('name');
                if (ScrudCForm.config.column.atrr == undefined){
                    ScrudCForm.config.column.atrr = {}
                }
                if (ScrudCForm.config.column.atrr[field] == undefined){
                    ScrudCForm.config.column.atrr[field] = {}
                }
                $('#column_container').removeClass('span5');
                $('#column_container_right').remove();
                $('#column_container').addClass('span5');
                var ccr = $('<div></div>').attr({
                    id:'column_container_right'
                }).addClass('span7');
    			
                ccr.append(
                    $('<div style="margin-bottom:5px;"></div>')
                    .append(' Name &nbsp;&nbsp;&nbsp;&nbsp; ')
                    .append(field)
                    );
    			
                var alias = $('<input type="text" />');
    			
                if (ScrudCForm.config.column.atrr[field].alias != undefined){
                    alias.val(ScrudCForm.config.column.atrr[field].alias);
                }else{
                    if (ScrudCForm.elements[field] != undefined){
                        alias.val(ScrudCForm.elements[field].label);
                        ScrudCForm.config.column.atrr[field].alias = ScrudCForm.elements[field].label;
                    }else{
                        alias.val(field);
                        ScrudCForm.config.column.atrr[field].alias = field;
                    }
                }
                alias.keyup(function(){
                    ScrudCForm.config.column.atrr[field].alias = $(this).val();
                });
    			
                ccr.append(
                    $('<div style="margin-bottom:5px;"></div>')
                    .append(' Alias &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  ')
                    .append(alias)
                    );
    			
                var format = $('<textarea ></textarea>');
    			
                if (ScrudCForm.config.column.atrr[field].format != undefined){
                    format.val(ScrudCForm.config.column.atrr[field].format);
                }
                format.keyup(function(){
                    ScrudCForm.config.column.atrr[field].format = $(this).val();
                });
    			
                ccr.append(
                    $('<div style="margin-bottom:5px;"></div>')
                    .append(' Format &nbsp;&nbsp; ')
                    .append(format)
                    );
    			
                var width = $('<input style="width: 40px;" type="text" />');
    			
                if (ScrudCForm.config.column.atrr[field].width != undefined){
                    width.val(ScrudCForm.config.column.atrr[field].width);
                }
                width.keyup(function(){
                    ScrudCForm.config.column.atrr[field].width = $(this).val();
                });
    			
                ccr.append(
                    $('<div style="margin-bottom:5px;"></div>')
                    .append(' Width &nbsp;&nbsp;&nbsp;&nbsp; ')
                    .append(width)
                    .append(' px')
                    );
    			
                var la = $('<select name="crud[list_align]" id="crudListAlign" style="width: auto;"></select>');
    			
                la.change(function(){
                    ScrudCForm.config.column.atrr[field].align = $(this).val();
                });
    			
                la.append('<option value=""></option>');
                la.append('<option value="left">Left</option>');
                la.append('<option value="center">Center</option>');
                la.append('<option value="right">Right</option>');
                ccr.append(' Align &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ');
                ccr.append(la);
    			
                if (ScrudCForm.config.column.atrr[field].align != undefined){
                    la.val(ScrudCForm.config.column.atrr[field].align);
                }
    			

                $('#column_container').after(ccr);
            });
            $('#column_elements').append(
                li
                .append(
                    $('<a></a>')
                    .append(
                        $('<label class="checkbox"></label>')
                        .append(f)
                        .append(ScrudCForm.config.column.list[i])
                        )
                    .append(ebtn)
                    )
                );
        }
    },
    
    buildConfigTable:function(){
        if (ScrudCForm.config.table == undefined){
            ScrudCForm.config.table = {};
        }
        if (ScrudCForm.config.table.crudTitle != undefined){
            $('#crudTitle').val(ScrudCForm.config.table.crudTitle);
        }else{
            $('#crudTitle').val(ScrudCForm.table+' manager');
            ScrudCForm.config.table.crudTitle = $('#crudTitle').val();
        }
        if (ScrudCForm.config.table.crudRowsPerPage != undefined){
            $('#crudRowsPerPage').val(ScrudCForm.config.table.crudRowsPerPage);
        }else{
            $('#crudRowsPerPage').val(20);
            ScrudCForm.config.table.crudRowsPerPage = $('#crudRowsPerPage').val();
        }
        if (ScrudCForm.config.table.crudOrderField != undefined){
            $('#crudOrderField').val(ScrudCForm.config.table.crudOrderField);
        }
        if (ScrudCForm.config.table.crudOrderType != undefined){
            $('#crudOrderType').val(ScrudCForm.config.table.crudOrderType);
        }
        if (ScrudCForm.config.table.noColumn != undefined && 
            ScrudCForm.config.table.noColumn == 1){
            //$('#crudNoColumn').val(ScrudCForm.config.table.noColumn);
            ScrudCForm.config.table.noColumn = 1;
            $('#crudNoColumn').attr({
                checked:'checked'
            });
        }
    	
        $('#crudTitle').keyup(function(){
            ScrudCForm.config.table.crudTitle = $(this).val();
        });
        
        $('#crudRowsPerPage').keyup(function(){
            ScrudCForm.config.table.crudRowsPerPage = $(this).val();
        });
        $('#crudOrderField').change(function(){
            ScrudCForm.config.table.crudOrderField = $(this).val();
        });
        $('#crudOrderType').change(function(){
            ScrudCForm.config.table.crudOrderType = $(this).val();
        });
        $('#crudNoColumn').click(function(){
            if ($('#crudNoColumn').attr('checked') == 'checked'){
                ScrudCForm.config.table.noColumn = 1;
            }else{
                ScrudCForm.config.table.noColumn = 0;
            }
        })
    },
        
    createField:function(field){

        if(field=="empty1" || field=="empty2" || field=="empty3" || field=="empty4" || field=="empty5"){
            var f = $('<li id="field_'+field+'" style="cursor:default;" ><a><i class="icon-plus"></i> &nbsp; '+field+'</a></li>');
            if ($('#preview_field_'+field).length >0){
                f.addClass('disabled');
            }
            f.click(function(){
                /*if (!$(this).hasClass('disabled')){
                    ScrudCForm.addFieldToForm(field,'prepend');
                }*/

                ///kamran
                var sectionId = $('#dragable div').first().attr('id');
                var sectionCounter = 0;
                $('#dragable > div').each(function(){
                    sectionCounter++;
                });
                sectionCounter = sectionCounter -1;
                //ScrudCForm.addFieldToForm(field,'prepend',sectionId,0); //for update old sections
                ScrudCForm.addFieldToFormEmpty(field,'prepend',sectionId,sectionCounter);
                //////
            });
            return f;
        }else{
            var f = $('<li id="field_'+field+'" style="cursor:default;" ><a><i class="icon-plus"></i> &nbsp; '+field+'</a></li>');
            if ($('#preview_field_'+field).length >0){
                f.addClass('disabled');
            }
            f.click(function(){
                /*if (!$(this).hasClass('disabled')){
                    ScrudCForm.addFieldToForm(field,'prepend');
                }*/

                ///kamran
                var sectionId = $('#dragable div').first().attr('id');
                var sectionCounter = 0;
                $('#dragable > div').each(function(){
                    sectionCounter++;
                });
                sectionCounter = sectionCounter -1;
                //ScrudCForm.addFieldToForm(field,'prepend',sectionId,0); //for update old sections
                ScrudCForm.addFieldToForm(field,'prepend',sectionId,sectionCounter);
                //////
            });
            return f;
        }
    },
    buildOptions:function(field,pType,sectionId,sectionKey){
        //console.log(sectionKey);
        if (sectionKey == undefined) {
            sectionKey = 0 ;
        }
        var sectionField = ScrudCForm.elements[sectionKey].section_fields[field];
        $('#preview_field_'+field).find('#form-options').append('<label class="control-label">Label</label>');
        var lbl = $('<input type="text" class="form-control" placeholder="Type something…" value="'+sectionField.label+'" />');
        lbl.keyup(function(){
            sectionField.label = $(this).val();
            $('#preview_field_'+field).find('.control-label').children('b').html($(this).val());;
            if (ScrudCForm.config.column.atrr == undefined){
                ScrudCForm.config.column.atrr = {};
            }
            if (ScrudCForm.config.column.atrr[field] == undefined){
                ScrudCForm.config.column.atrr[field] = {}
            }
            ScrudCForm.config.column.atrr[field].alias = $(this).val();
            
            if (ScrudCForm.config.filter.atrr == undefined){
                ScrudCForm.config.filter.atrr = {};
            }
            if (ScrudCForm.config.filter.atrr[field] == undefined){
                ScrudCForm.config.filter.atrr[field] = {}
            }
            ScrudCForm.config.filter.atrr[field].alias = $(this).val();
        });
        $('#preview_field_'+field).find('#form-options').append(lbl);
       
       ////////////////////////////////////////////////////////////////////
        $('#preview_field_'+field).find('#form-options').append('<label class="control-label">Attached Field</label>');
        if(sectionField.checkattached!='attached'){
            var checkattached = $('<br><input type="checkbox" value="attached" />');
        } else {
            var checkattached = $('<br><input type="checkbox" value="attached" checked="checked" />');
        }

        checkattached.click(function(){
            if (sectionField.checkattached == undefined){
                sectionField.checkattached = '';
            }
            if(this.checked==true){
                sectionField.checkattached = $(this).val();
            } else {
                sectionField.checkattached = '';
            }
        });
        $('#preview_field_'+field).find('#form-options').append(checkattached);

        var fieldattached = $('<select class="form-control" style="width:50%; display:inline;"></select> <br>');
            fieldattached.append($('<option value=""> </option>'));
        for(var k in ScrudCForm.fields){
            if(sectionField.fieldattached == ScrudCForm.fields[k]){
                fieldattached.append($('<option selected="selected" value="'+ScrudCForm.fields[k]+'">'+ScrudCForm.fields[k]+'</option>'));
            } else {
                fieldattached.append($('<option value="'+ScrudCForm.fields[k]+'">'+ScrudCForm.fields[k]+'</option>'));
            }  
        }
        $('#preview_field_'+field).find('#form-options').append(fieldattached);
        fieldattached.change(function(){
            if (sectionField.fieldattached == undefined){
                sectionField.fieldattached = {};
            }
            sectionField.fieldattached = $(this).val();
        });
        /////////////////////////////////////////////////////////////////


        var type = 
        $('<select class="form-control"></select>')
        .append($('<option value="currency">Currency</option>'))
        .append($('<option value="text">Textbox</option>'))
        .append($('<option value="password">Password</option>'))
        .append($('<option value="date_simple">Date</option>'))
        .append($('<option value="date">Date with Calendar</option>'))
        .append($('<option value="time">Time</option>'))
        .append($('<option value="datetime">DateTime</option>'))
        .append($('<option value="multiple_add">Multipe Add Field</option>'))
        .append($('<option value="textarea">Textarea</option>'))
        .append($('<option value="editor">Editor</option>'))
        .append($('<option value="file">File</option>'))
        .append($('<option value="image">Image</option>'))
        .append($('<option value="checkbox">Checkbox</option>'))
        .append($('<option value="radio">Radio</option>'))
        .append($('<option value="select">Selectbox</option>'))
        .append($('<option value="autocomplete">Autocomplete</option>'))
		.append($('<option value="timezone">Time Zone</option>'))
        .append($('<option value="hidden">Hidden Field</option>'))
        .append($('<option value="color_picker">Color Picker</option>'))
        .append($('<option value="custom">Custom Fields</option>'))
        .append($('<option value="related_module">Related Module</option>'))
        .append($('<option value="comments">Comment Box</option>'))
        .append($('<option value="rm_multiple">Related Record Multipe</option>'))
        .append($('<option value="checklist_panel">Check List Panel</option>'))
        .append($('<option value="notepanel">Notes Panel</option>'));

        type.val(sectionField.type);
		
        type.change(function(){
            sectionField.type = $(this).val();
            ScrudCForm.changeFieldToForm(field,pType,sectionId,sectionKey);
            $('#type-options').html('');
            switch (sectionField.type){
                case 'notepanel':
                case 'checklist_panel':
                case 'color_picker':
                case 'text':
                case 'multiple_add':
                    textOptions(field,pType,sectionId,sectionKey,typeOptions);
                    break;
                //time
                case 'time':
                    textOptions(field,pType,sectionId,sectionKey,typeOptions);
                    break;
                //time
                //Currency
                case 'currency':
                    textOptions(field,pType,sectionId,sectionKey,typeOptions);
                    break;
                case 'comments':
                    ScrudCForm.removeFieldsInSection(field,sectionId);
                    textOptions(field,pType,sectionId,sectionKey,typeOptions);
                    break;
                //Currency
                //HIDDEN FIELDS BY SALMAN START
                case 'hidden':
                    texthidden(field,pType,sectionId,sectionKey,typeOptions);
                    break;
                //TIMEZONE BY SALMAN START
				case 'timezone':
					timzoneoptions(field,pType,sectionId,sectionKey,typeOptions);
					break;
				//TIMEZONE BY SALMAN END
                //CUSTOM FIELDS BY SALMAN START
                case 'custom':
                    cfields(field,pType,sectionId,sectionKey,typeOptions);
                    break;
                //CUSTOM FIELDS BY SALMAN 
                // Related module filed type
                case 'rm_multiple':
                    relatedModuleOptionsMultipe(field,pType,sectionId,sectionKey,typeOptions);
                    break;
                case 'related_module':
                    ScrudCForm.removeFieldsInSection(field,sectionId);
                    relatedModuleOptions(field,pType,sectionId,sectionKey,typeOptions);
                    break;
                // Related module field type ends
                case 'password':
                    passwordOptions(field,pType,sectionId,sectionKey,typeOptions);
                    break;
                case 'textarea':
                    textareaOption(field,pType,sectionId,sectionKey,typeOptions);
                    break;
                case 'select':
                    
                    selectOption(field,pType,sectionId,sectionKey,typeOptions);
                    break;
                case 'autocomplete':
                    selectOption(field,pType,sectionId,sectionKey,typeOptions);
                    break;
                case 'radio':
                    radioOption(field,pType,sectionId,sectionKey,typeOptions);
                    break;
                case 'checkbox':
                    checkboxOption(field,pType,sectionId,sectionKey,typeOptions);
                    break;
                case 'image':
                    imageOptions(field,pType,sectionId,sectionKey,typeOptions);
                    break;
            }
            $('#form-preview').css({
                height:'auto'
            });
            //$('#form-preview').height($('#form-preview').height());
        });
		
        $('#preview_field_'+field).find('#form-options').append('<label class="control-label">Type</label>').append(type);
        var typeOptions = $('<div id="type-options"></div>').css({
            marginBottom:'10px'
        });
		
        $('#preview_field_'+field).find('#form-options').append(typeOptions);
		
        switch (sectionField.type){
            case 'notepanel':
            case 'checklist_panel':
            case 'color_picker':
            case 'text':
            case 'multiple_add':
                textOptions(field,pType,sectionId,sectionKey,typeOptions);
                break;
            //time
            case 'time':
                textOptions(field,pType,sectionId,sectionKey,typeOptions);
                break;
            case 'comments':
                    ScrudCForm.removeFieldsInSection(field,sectionId);
                    textOptions(field,pType,sectionId,sectionKey,typeOptions);
                    break;
            //time
            //Currency
            case 'currency':
                textOptions(field,pType,sectionId,sectionKey,typeOptions);
                break;
            //HIDDEN FIELDS BY SALMAN START
            case 'hidden':
                texthidden(field,pType,sectionId,sectionKey,typeOptions);
                break;
            //TIMEZONE BY SALMAN START
			case 'timezone':
				timzoneoptions(field,pType,sectionId,sectionKey,typeOptions);
				break;
			//TIMEZONE BY SALMAN END
            //CUSTOM FIELDS BY SALMAN START
                case 'custom':
                    cfields(field,pType,sectionId,sectionKey,typeOptions);
                    break;
            //CUSTOM FIELDS BY SALMAN
            // Related module filed type
            case 'rm_multiple':
                relatedModuleOptionsMultipe(field,pType,sectionId,sectionKey,typeOptions);
                break;
            case 'related_module':
                ScrudCForm.removeFieldsInSection(field,sectionId);
                relatedModuleOptions(field,pType,sectionId,sectionKey,typeOptions);
                break;
            // Related module field type ends
            case 'password':
                passwordOptions(field,pType,sectionId,sectionKey,typeOptions);
                break;
            case 'textarea':
                textareaOption(field,pType,sectionId,sectionKey,typeOptions);
                break;
            case 'select':
                selectOption(field,pType,sectionId,sectionKey,typeOptions);
                break;
            case 'autocomplete':

                selectOption(field,pType,sectionId,sectionKey,typeOptions);
                break;
            case 'radio':
                radioOption(field,pType,sectionId,sectionKey,typeOptions);
                break;
            case 'checkbox':
                checkboxOption(field,pType,sectionId,sectionKey,typeOptions);
                break;
            case 'image':
                imageOptions(field,pType,sectionId,sectionKey,typeOptions);
                break;
        }
		
        var validation = 
        $('<select class="form-control"></select>')
        .append($('<option value=""></option>'))
        .append($('<option value="notEmpty" selected="selected">Required</option>'))
        .append($('<option value="alpha">Alpha Characters</option>'))
        .append($('<option value="alphaSpace">Alpha Characters with Space</option>'))
        .append($('<option value="numeric">Numeric Characters</option>'))
        .append($('<option value="alphaNumeric">Alpha-Numeric Characters</option>'))
        .append($('<option value="alphaNumericSpace">Alpha-Numeric Characters with Space</option>'))
        .append($('<option value="date">Date</option>'))
        .append($('<option value="time">Time</option>'))//time
        .append($('<option value="datetime">Date time</option>'))
        .append($('<option value="email">Email</option>'))
        .append($('<option value="ip">IP</option>'))
        .append($('<option value="url">URL</option>'));
		
        validation.val(sectionField.validation);
        if (sectionField.validation != ''){
            $('#preview_error_field_'+field).show();
        }else{
            $('#preview_error_field_'+field).hide();
        }
        validation.change(function(){
            sectionField.validation = $(this).val();
            if (sectionField.validation != ''){
                $('#preview_error_field_'+field).show();
            }else{
                $('#preview_error_field_'+field).hide();
            }
        });
		
        $('#preview_field_'+field).find('#form-options').append('<label class="control-label">Validations</label>').append(validation);

        //CLICK EVENTS STARTS
        com_event = '';
        var events = $('<select class="form-control"></select>')
        .append($('<option value=""></option>'))
        .append($('<option value="onclick">On Click</option>'))
        .append($('<option value="onkeyup">On Key UP</option>'))
        .append($('<option value="onkeydown">On Key Down</option>'))
        .append($('<option value="onchange">On Change</option>'))
        .append($('<option value="onblur">On Blur</option>'))
        .append($('<option value="onfocus">On Focus</option>'))
        .append($('<option value="onselect">On Select</option>'))
        .append($('<option value="onmouseover">On Mouse Over</option>'))
        .append($('<option value="onmouseout">On Mouse Out</option>'))
        .append($('<option value="onload">On Load</option>'));

        if (sectionField.events != ''){
            $('#preview_error_field_'+field).show();
        }else{
            $('#preview_error_field_'+field).hide();
        }
        $('#preview_field_'+field).find('#form-options').append('<label class="control-label">Event Type</label>').append(events);
    
        events.change(function(){
            if($(this).val()!=''){
                if(!document.getElementById("action_events_label")){
                //alert($('#action_events_label'));
                    var action_events = 
                    $('<input type="text" class="form-control" id="action_events_field">');
                    $('#preview_field_'+field).find('#form-options')
                    .append('<label class="control-label" id="action_events_label">Event Value</label>')
                    .append(action_events)
                    .append('</div>');
                    event_type = $(this).val();
                    
                    $('#action_events_field').keyup(function(){
                        sectionField.events = event_type;
                        sectionField.events_action = $(this).val();
                    });
                }else{
                    $('#action_events_label').show();
                    event_type = $(this).val();
                    
                    $('#action_events_field').keyup(function(){
                        sectionField.events = event_type;
                        sectionField.events_action = $(this).val();
                    });
                }
            }else{
                $('#action_events').hide();
                $('#action_events_label').hide();
                $('#action_events_field').hide();
                event_type = '';
            }
        });
    },
    //UPDATE By KAMRAN SB 30-3-16
    removeFieldsInSection: function(field,sectionId){

               var section = $('#'+sectionId);
               section.find('.section_head input[name="sizeType"]').val('default');
 
    },
    //UPDATE By KAMRAN SB 30-3-16
    addBlockToForm:function(){
        var error = false;
        var sectionTitle = $('input[name="setSectionTitle"]');
        var title = sectionTitle.val();
        var id = title.split(' ').join('_');
        id = id.toLowerCase();
        $('#'+id).each(function(){
            var ids = $('[id="'+this.id+'"]');
            if(ids.length>1 && ids[0]==this)
                error = true;
                
        });
        if (title == '') { error = true; }
        if(error == false){
            
            //ScrudCForm.addSectionToForm(id,title,'prepend');
            ScrudCForm.addSectionToForm(id,title,'outer','default','prepend'); //given by kamran
            sectionTitle.parent().removeClass('has-error');
            
            $('#closeSectionNameModal').trigger('click');
            sectionTitle.val('');
            sectionTitle.parent().find('.help-block').text('Only unique section title.');
        } else {

            sectionTitle.parent().addClass('has-error');
            sectionTitle.parent().find('.help-block').text('Blank/duplicate section name.');
        }
        
    },
    changeBlcokTitle:function(){
        var error = false;
        var sectionTitle = $('input[name="setSectionTitle"]');
        var title = sectionTitle.val();
        var id = title.split(' ').join('_');
        id = id.toLowerCase();
        $('#'+id).each(function(){
            var ids = $('[id="'+this.id+'"]');
            if(ids.length>1 && ids[0]==this)
                error = true;
                
        });
        if (title == '') { error = true; }
        if(error == false){
            var toChangeId = $('input[name="toChangeId"]').val();
            $('#'+toChangeId).attr('id',id);
            $('#'+id).find('span').text(title);
            $('#'+id).find('input[name="sectionTitle"]').val(title);
            $('#saveBlockBtn').show();
            $('#updateBlockBtn').hide();
            sectionTitle.parent().removeClass('has-error');
            $('#closeSectionNameModal').trigger('click');
            $('input[name="toChangeId"]').val('');
            sectionTitle.val('');
            sectionTitle.parent().find('.help-block').text('Only unique section title.');
        } else {

            sectionTitle.parent().addClass('has-error');
            sectionTitle.parent().find('.help-block').text('Blank/duplicate section name.');
        }
        
    },

    //empty function

        addFieldToFormEmpty:function(field,pType,sectionId,sectionKey){
        // SectionId = section_name
        // sectionKey = array key of section inside elements object

        if (sectionKey == undefined) {
            var numbreOfSectons = Number($('#dragable .portlet').length);
            sectionKey = numbreOfSectons-1 ;
        }
        //console.log('section key data' + JSON.stringify());
        
        if (pType == undefined){
            pType = 'append';
        }
        //console.log($('#dragable .portlet').length);
       // console.log('Before undefined: ' + JSON.stringify(ScrudCForm.elements));
        if (ScrudCForm.elements[sectionKey] == undefined){

            // set element key for each section 


            // Ends code for settign key for each section
           
           var firstSectionHeads = $('#frm_preview .form-body .portlet .portlet-title .section_head');
           var sectionTitle = firstSectionHeads.find('input[name="sectionTitle"]').val();
           
           var sectionName = sectionTitle.split(' ').join('_');
            sectionName = sectionName.toLowerCase();

           var sectionviewTypee = firstSectionHeads.find('input[name="viewType"]').val();
/////given by Kamran
var sectionSizeTypee = firstSectionHeads.find('input[name="sizeType"]').val();
////////////////
            ScrudCForm.elements[sectionKey] = {
                section_name:sectionName,
                    section_title:sectionTitle,
                    section_view:sectionviewTypee,
                    section_size:sectionSizeTypee, ////given by kamran
                    section_fields:{}
                };
                    

            ScrudCForm.elements[sectionKey].section_fields[field] = {

                field:field,
                label:field,
                type:'empty',
                options:[],
                type_options:{
                    size:'100%',
                    width:300,
                    height:100,
                    thumbnail:'mini'
                },
                validation:''
            }
        }
        if (ScrudCForm.elements[sectionKey].section_fields[field] == undefined) {
            ScrudCForm.elements[sectionKey].section_fields[field] = {

                field:field,
                label:field,
                type:'empty',
                options:[],
                type_options:{
                    size:'100%',
                    width:300,
                    height:100,
                    thumbnail:'mini'
                },
                validation:''
            }
        }

         console.log('After assigning values: ' + JSON.stringify(ScrudCForm.elements));
       var sectionField = ScrudCForm.elements[sectionKey].section_fields[field];
       //console.log('After sectionField: ' + JSON.stringify(ScrudCForm.elements[sectionKey].section_fields));


        var ir = $('<a class="btn btn-sm red" id="btn_close" />').append($('<i class="fa fa-trash"></i>'));
        var iedit = $('<a class="btn btn-sm green" id="btn_edit" />').append($('<i class="fa fa-edit"></i>'));
        iedit.clickover({
            placement: 'left',
            title:'Design form',
            global_close:true,
            esc_close:true,
            html:true,
            width:260,
            content:'<div id="form-options"></div>&nbsp;',
            onShown:function(){
                ScrudCForm.buildOptions(field,pType,sectionId,sectionKey);
            }
        }); 
        
        ir.click(function(){
            $('#preview_field_'+field).remove();
            $('#field_'+field).removeClass('disabled');
            $('#form-preview').css({
                height:'auto'
            });
            //$('#form-preview').height($('#form-preview').height());
            if (ScrudCForm.current_field == field){
                $('#fieldTab a[href="#fields"]').tab('show');
                //$('#form-options').html('');
                $('#fieldTab a[href="#options"]').hide();
            }
        });
        
        var filedLabel = '';
        if (sectionField.label == undefined) {
            filedLabel = field;
        } else {
            filedLabel = sectionField.label;
        }
        var lbl = $('<label class="control-label col-md-3">'+
            ''+filedLabel+'  <span id="preview_error_field_'+field+'" style="color:red;display:none;">*</span></label>');
        
        //console.log(sectionField.type);
        // fixme
        var ctl;
        var field_editor = [];
        var select2 = [];
        switch (sectionField.type){
            case 'comments':
                    ScrudCForm.removeFieldsInSection(field,sectionId);
                    textOptions(field,pType,sectionId,sectionKey,typeOptions);
                    break;
            //CURRENCY CASE
            case 'notepanel':
            case 'checklist_panel':
            case 'color_picker':
            case 'currency':
            case 'text':
            case 'time':
            case 'multiple_add':
                ctl = $('<input type="text" class="form-control" />').width(sectionField.type_options.size); // for
                // text
                break;
            //HIDDEN FIELD BY SALMAN START
            case 'hidden':
                ctl = $('<input type="hidden"/>').width(sectionField.type_options.size); // for
                // text
                break;
            //TIMEZONE BY SALMAN START
            case 'timezone':
                ctl = $('<select id="preview_field_'+field+'_select2"  style="width:220px;" ></select>').append($('<option></option>'));
                $('#preview_field_'+field).find('.controls').append(ctl);
                $("#preview_field_"+field+"_select2").select2();
                select2[select2.length] = "preview_field_"+field+"_select2";
                break;
            //TIMEZONE BY SALMAN END
            //CUSTOM FIELD BY SALMAN START
            case 'custom':
                ctl = $('<textarea></textarea>').width(sectionField.type_options.size); // for
                // text
                break;
            //CUSTOM FIELD BY SALMAN
            // Related module
            case 'rm_multiple':
            case 'related_module':
                ctl = $('<a href="javascript:;" class="btn blue"><i class="fa fa-external-link"></i>Related Module</a>').width(sectionField.type_options.size);
                break;
            // Related module ends
            case 'password':
                ctl = $('<input type="password" class="form-control" />').width(sectionField.type_options.size);
                break;
            case 'date':
                var strDate = '<div data-date-format="yyyy-mm-dd" data-date="2012-11-27" class="input-group input-medium date date-picker">' +
                '<input type="text" class="form-control"  value="">'+
                '<span class="input-group-btn"><a class="btn default"><i class="icon-calendar"></i></a></span>'+
                '</div>';
                ctl = $(strDate);
                break;
            case 'date_simple':
                var strDate = '<div data-date-format="yyyy-mm-dd" data-date="2012-11-27" class="input-group input-medium date date-picker">' +
                '<input type="text" class="form-control"  value="">'+
                '<span class="input-group-btn"><a class="btn default"><i class="icon-calendar"></i></a></span>'+
                '</div>';
                ctl = $(strDate);
                break;
            case 'datetime':
                var strDate = '<div data-date-format="yyyy-mm-dd" data-date="2012-11-27" class="input-group input-medium date date-picker">' +
                '<input type="text" class="form-control" value="" >'+
                '<span class="input-group-btn"><button class="btn default"><i class="icon-calendar"></i></button></span>'+
                '</div>';
                ctl = $(strDate);
                break;    
            case 'textarea':
                ctl = $('<textarea class="form-control"></textarea>');
                if (sectionField.type_options.width != undefined){
                    ctl.width(sectionField.type_options.width);
                }
                if (sectionField.type_options.height != undefined){
                    ctl.height(sectionField.type_options.height);
                }
                break;
            case 'editor':
                ctl = $('<textarea class="form-control" id="preview_field_'+field+'_editor"></textarea>');
                field_editor[field_editor.length] = 'preview_field_'+field+'_editor';
                break;
            case 'image':
                ctl = $('<input id="filename" type="text" class="input disabled" name="filename" readonly="readonly"> '+
                    '<input type="button" class="btn" value="Choose..."/>');
                break;
            case 'file':
                ctl = $('<input id="filename" type="text" class="input disabled" name="filename" readonly="readonly"> '+
                    '<input type="button" class="btn" value="Choose..."/>');
                break;
            case 'checkbox':
                var tmp = '';
                if (sectionField.options != undefined && 
                    sectionField.options.length > 0){
                    var opts = sectionField.options;
                    for(var i in opts){
                        if ($.trim(opts[i]) != ''){
                            tmp += '<label class="checkbox-inline" style="display:inline-block; margin-right: 15px;"><input type="checkbox"/>'+opts[i]+'</label>';
                        }
                    }
                }
                ctl = $(tmp);
                break;
            case 'radio':
                var tmp = '';
                if (sectionField.options != undefined &&
                    sectionField.options.length > 0){
                    var opts = sectionField.options;
                    for(var i in opts){
                        if ($.trim(opts[i]) != ''){
                            tmp += '<label class="radio-inline" style="display:inline-block; margin-right: 15px;"><input type="radio" name="optionsRadios"/>'+opts[i]+'</label>';
                        }
                    }
                }
                ctl = $(tmp);
                break;
            case 'select':
                var tmpMultiple = '';
                if (sectionField.multiple != undefined && sectionField.multiple == 'multiple'){
                    tmpMultiple = 'multiple="multiple"';
                }
                if (sectionField.list_choose == 'default'){
                    ctl = $('<select class="form-control" style="width:auto;" '+tmpMultiple+' ></select>').append($('<option></option>'));
                    if (sectionField.options.length > 0){
                        var opts = sectionField.options;
                        for(var i in opts){
                            if ($.trim(opts[i]) != ''){
                                ctl.append($('<option>'+opts[i]+'</option>'));
                            }
                        }
                    }
                }else if (sectionField.list_choose == 'database'){
                    $.post(ScrudCForm.urlGetOptions,{
                        config:sectionField.db_options
                    },function(json){
                        ctl = $('<select class="form-control" '+tmpMultiple+'></select>').append($('<option></option>'));
                        for(var i in json){
                            ctl.append($('<option>'+json[i]+'</option>'));
                        }
                        $('#preview_field_'+field).find('.controls').append(ctl);
                    },'json');
                }
               
                break;
            case 'autocomplete':
                if (sectionField.list_choose == 'default'){
                    ctl = $('<select id="preview_field_'+field+'_select2"  class="form-control select2"></select>').append($('<option></option>'));
                    if (sectionField.options.length > 0){
                        var opts = sectionField.options;
                        for(var i in opts){
                            if ($.trim(opts[i]) != ''){
                                ctl.append($('<option>'+opts[i]+'</option>'));
                            }
                        }
                    }
                }else if (sectionField.list_choose == 'database'){
                    $.post(ScrudCForm.urlGetOptions,{
                        config:sectionField.db_options
                    },function(json){
                        ctl = $('<select id="preview_field_'+field+'_select2" class="form-control select2" ></select>').append($('<option></option>'));
                        for(var i in json){
                            ctl.append($('<option>'+json[i]+'</option>'));
                        }
                        $('#preview_field_'+field).find('.controls').append(ctl);
                        $("#preview_field_"+field+"_select2").select2();
                    },'json');
                }
                
                select2[select2.length] = "preview_field_"+field+"_select2";
                break;
        }
        
        
        var el = $('<div class="controls col-md-6"></div>').append(ctl);
        var li = $('<div id="preview_field_'+field+'" class="row portlet-sortable"></div>');
        
        li.hover(function(){
            $(this).children('.btn-group').children('#btn_close').show();
            $(this).children('.btn-group').children('#btn_edit').show();
        },function(){
            if (!$(this).hasClass('selected')){
               // $(this).children('.btn-group').children('#btn_close').hide();
               // $(this).children('.btn-group').children('#btn_edit').hide();
            }
        });
        
        iedit.click(function(){
            $('a[id=btn_close]').each(function(){
               // $(this).children('.btn-group').hide();
            });
            $('a[id=btn_edit]').each(function(){
                //$(this).children('.btn-group').hide();
            });
            ScrudCForm.current_field = field;
            $('.elements_preview > div').removeClass('selected');
            $('#preview_field_'+field).addClass('selected');
            $('#preview_field_'+field).children('.btn-group').children('#btn_close').show();
            $('#preview_field_'+field).children('.btn-group').children('#btn_edit').show();
        });
        
        li.click(function(){
            if (dragFlag == false){
               /* $('a[id=btn_close]').each(function(){
                    $(this).hide();
                });
                $('a[id=btn_edit]').each(function(){
                    $(this).hide();
                });*/
                ScrudCForm.current_field = field;
                $('.elements_preview > div').removeClass('selected');
                $('#preview_field_'+field).addClass('selected');
                
                //$('#form-options').html('');
                //ScrudCForm.buildOptions(field);
                
                $('#fieldTab a[href="#options"]').show();
                $('#fieldTab a[href="#options"]').tab('show');
                $(this).children('.btn-group').children('#btn_close').show();
                $(this).children('.btn-group').children('#btn_edit').show();
                
            }else{
                dragFlag = false;
            }
        });

        var btnGroups = '<div class="btn-group btn-group-xs btn-group-solid pull-right col-md-2"></div>';
        li.append($(btnGroups).append(ir).append(iedit)).append($('<div class="form-group col-md-10"></div>').append(lbl).append(el)).append('<div style="clear:both;"></div>');
        $('#form-preview').css({
            height:'auto'
        });
        switch (pType){
            case 'prepend':
                //console.log('section id: ' + sectionId);
                if (sectionId == undefined) {
                    $('.elements_preview').first().prepend(li);
                } else {
                     $('#'+sectionId).find('.elements_preview').prepend(li);
                }
                
                break;
            default:
            //console.log('section id: ' + sectionId + ' section el: ' + JSON.stringify(li));
            //console.log('section id: ' + li);
                if (sectionId == undefined) {
                    $('.elements_preview').first().append(li);
                } else {
                    $('#'+sectionId).find('.elements_preview').append(li);
                }
                break;
        }
        
        for(var k in field_editor){
            CKEDITOR.replace(field_editor[k],{width:360,height:100});
        }
        $(document).ready(function() { 
            for(var k in select2){
                $("#"+select2[k]).select2();
            }
        });
        
        if (sectionField.validation != ''){
            $('#preview_error_field_'+field).show();
        }else{
            $('#preview_error_field_'+field).hide();
        }
        //$('#form-preview').height($('#form-preview').height());
        $('#field_'+field).addClass('disabled');
    },
    ///////////////////////

    addFieldToForm:function(field,pType,sectionId,sectionKey){
        // SectionId = section_name
        // sectionKey = array key of section inside elements object

        if (sectionKey == undefined) {
            var numbreOfSectons = Number($('#dragable .portlet').length);
            sectionKey = numbreOfSectons-1 ;
        }
        //console.log('section key data' + JSON.stringify());
        
        if (pType == undefined){
            pType = 'append';
        }
        //console.log($('#dragable .portlet').length);
       // console.log('Before undefined: ' + JSON.stringify(ScrudCForm.elements));
        if (ScrudCForm.elements[sectionKey] == undefined){

            // set element key for each section 


            // Ends code for settign key for each section
           
           var firstSectionHeads = $('#frm_preview .form-body .portlet .portlet-title .section_head');
           var sectionTitle = firstSectionHeads.find('input[name="sectionTitle"]').val();
           
           var sectionName = sectionTitle.split(' ').join('_');
            sectionName = sectionName.toLowerCase();

           var sectionviewTypee = firstSectionHeads.find('input[name="viewType"]').val();
/////given by Kamran
var sectionSizeTypee = firstSectionHeads.find('input[name="sizeType"]').val();
////////////////
            ScrudCForm.elements[sectionKey] = {
                section_name:sectionName,
                    section_title:sectionTitle,
                    section_view:sectionviewTypee,
                    section_size:sectionSizeTypee, ////given by kamran
                    section_fields:{}
                };
                    

            ScrudCForm.elements[sectionKey].section_fields[field] = {

                field:field,
                label:field,
                type:'text',
                options:[],
                type_options:{
                    size:'100%',
                    width:300,
                    height:100,
                    thumbnail:'mini'
                },
                validation:''
            }
        }
        if (ScrudCForm.elements[sectionKey].section_fields[field] == undefined) {
            ScrudCForm.elements[sectionKey].section_fields[field] = {

                field:field,
                label:field,
                type:'text',
                options:[],
                type_options:{
                    size:'100%',
                    width:300,
                    height:100,
                    thumbnail:'mini'
                },
                validation:''
            }
        }

         console.log('After assigning values: ' + JSON.stringify(ScrudCForm.elements));
       var sectionField = ScrudCForm.elements[sectionKey].section_fields[field];
       //console.log('After sectionField: ' + JSON.stringify(ScrudCForm.elements[sectionKey].section_fields));


        var ir = $('<a class="btn btn-sm red" id="btn_close" />').append($('<i class="fa fa-trash"></i>'));
        var iedit = $('<a class="btn btn-sm green" id="btn_edit" />').append($('<i class="fa fa-edit"></i>'));
        iedit.clickover({
            placement: 'left',
            title:'Design form',
            global_close:true,
            esc_close:true,
            html:true,
            width:260,
            content:'<div id="form-options"></div>&nbsp;',
            onShown:function(){
                ScrudCForm.buildOptions(field,pType,sectionId,sectionKey);
            }
        }); 
        
        ir.click(function(){
            $('#preview_field_'+field).remove();
            $('#field_'+field).removeClass('disabled');
            $('#form-preview').css({
                height:'auto'
            });
            //$('#form-preview').height($('#form-preview').height());
            if (ScrudCForm.current_field == field){
                $('#fieldTab a[href="#fields"]').tab('show');
                //$('#form-options').html('');
                $('#fieldTab a[href="#options"]').hide();
            }
        });
        
        var filedLabel = '';
        if (sectionField.label == undefined) {
            filedLabel = field;
        } else {
            filedLabel = sectionField.label;
        }
        var lbl = $('<label class="control-label col-md-3">'+
            ''+filedLabel+'  <span id="preview_error_field_'+field+'" style="color:red;display:none;">*</span></label>');
		
        //console.log(sectionField.type);
        // fixme
        var ctl;
        var field_editor = [];
        var select2 = [];
        switch (sectionField.type){
            //CURRENCY CASE
            case 'notepanel':
            case 'checklist_panel':
            case 'color_picker':
            case 'currency':
            case 'text':
            case 'time':
            case 'multiple_add':
                ctl = $('<input type="text" class="form-control" />').width(sectionField.type_options.size); // for
                // text
                break;
			//HIDDEN FIELD BY SALMAN START
            case 'hidden':
                ctl = $('<input type="hidden"/>').width(sectionField.type_options.size); // for
                // text
                break;
            //TIMEZONE BY SALMAN START
			case 'timezone':
				ctl = $('<select id="preview_field_'+field+'_select2"  style="width:220px;" ></select>').append($('<option></option>'));
				$('#preview_field_'+field).find('.controls').append(ctl);
				$("#preview_field_"+field+"_select2").select2();
				select2[select2.length] = "preview_field_"+field+"_select2";
				break;
			//TIMEZONE BY SALMAN END
            //CUSTOM FIELD BY SALMAN START
            case 'custom':
                ctl = $('<textarea></textarea>').width(sectionField.type_options.size); // for
                // text
                break;
            //CUSTOM FIELD BY SALMAN
            // Related module
            case 'rm_multiple':
            case 'related_module':
                ctl = $('<a href="javascript:;" class="btn blue"><i class="fa fa-external-link"></i>Related Module</a>').width(sectionField.type_options.size);
                break;
            // Related module ends
            case 'password':
                ctl = $('<input type="password" class="form-control" />').width(sectionField.type_options.size);
                break;
            case 'date':
                var strDate = '<div data-date-format="yyyy-mm-dd" data-date="2012-11-27" class="input-group input-medium date date-picker">' +
                '<input type="text" class="form-control"  value="">'+
                '<span class="input-group-btn"><a class="btn default"><i class="icon-calendar"></i></a></span>'+
                '</div>';
                ctl = $(strDate);
                break;
            case 'date_simple':
                var strDate = '<div data-date-format="yyyy-mm-dd" data-date="2012-11-27" class="input-group input-medium date date-picker">' +
                '<input type="text" class="form-control"  value="">'+
                '<span class="input-group-btn"><a class="btn default"><i class="icon-calendar"></i></a></span>'+
                '</div>';
                ctl = $(strDate);
                break;
            case 'datetime':
                var strDate = '<div data-date-format="yyyy-mm-dd" data-date="2012-11-27" class="input-group input-medium date date-picker">' +
                '<input type="text" class="form-control" value="" >'+
                '<span class="input-group-btn"><button class="btn default"><i class="icon-calendar"></i></button></span>'+
                '</div>';
                ctl = $(strDate);
                break;    
            case 'comments':
            case 'textarea':
                ctl = $('<textarea class="form-control"></textarea>');
                if (sectionField.type_options.width != undefined){
                    ctl.width(sectionField.type_options.width);
                }
                if (sectionField.type_options.height != undefined){
                    ctl.height(sectionField.type_options.height);
                }
                break;
            case 'editor':
                ctl = $('<textarea class="form-control" id="preview_field_'+field+'_editor"></textarea>');
                field_editor[field_editor.length] = 'preview_field_'+field+'_editor';
                break;
            case 'image':
                ctl = $('<input id="filename" type="text" class="input disabled" name="filename" readonly="readonly"> '+
                    '<input type="button" class="btn" value="Choose..."/>');
                break;
            case 'file':
                ctl = $('<input id="filename" type="text" class="input disabled" name="filename" readonly="readonly"> '+
                    '<input type="button" class="btn" value="Choose..."/>');
                break;
            case 'checkbox':
                var tmp = '';
                if (sectionField.options != undefined && 
                    sectionField.options.length > 0){
                    var opts = sectionField.options;
                    for(var i in opts){
                        if ($.trim(opts[i]) != ''){
                            tmp += '<label class="checkbox-inline" style="display:inline-block; margin-right: 15px;"><input type="checkbox"/>'+opts[i]+'</label>';
                        }
                    }
                }
                ctl = $(tmp);
                break;
            case 'radio':
                var tmp = '';
                if (sectionField.options != undefined &&
                    sectionField.options.length > 0){
                    var opts = sectionField.options;
                    for(var i in opts){
                        if ($.trim(opts[i]) != ''){
                            tmp += '<label class="radio-inline" style="display:inline-block; margin-right: 15px;"><input type="radio" name="optionsRadios"/>'+opts[i]+'</label>';
                        }
                    }
                }
                ctl = $(tmp);
                break;
            case 'select':
            	var tmpMultiple = '';
            	if (sectionField.multiple != undefined && sectionField.multiple == 'multiple'){
            		tmpMultiple = 'multiple="multiple"';
        	    }
                if (sectionField.list_choose == 'default'){
                    ctl = $('<select class="form-control" style="width:auto;" '+tmpMultiple+' ></select>').append($('<option></option>'));
                    if (sectionField.options.length > 0){
                        var opts = sectionField.options;
                        for(var i in opts){
                            if ($.trim(opts[i]) != ''){
                                ctl.append($('<option>'+opts[i]+'</option>'));
                            }
                        }
                    }
                }else if (sectionField.list_choose == 'database'){
                    $.post(ScrudCForm.urlGetOptions,{
                        config:sectionField.db_options
                    },function(json){
                        ctl = $('<select class="form-control" '+tmpMultiple+'></select>').append($('<option></option>'));
                        for(var i in json){
                            ctl.append($('<option>'+json[i]+'</option>'));
                        }
                        $('#preview_field_'+field).find('.controls').append(ctl);
                    },'json');
                }
               
                break;
            case 'autocomplete':
                if (sectionField.list_choose == 'default'){
                    ctl = $('<select id="preview_field_'+field+'_select2"  class="form-control select2"></select>').append($('<option></option>'));
                    if (sectionField.options.length > 0){
                        var opts = sectionField.options;
                        for(var i in opts){
                            if ($.trim(opts[i]) != ''){
                                ctl.append($('<option>'+opts[i]+'</option>'));
                            }
                        }
                    }
                }else if (sectionField.list_choose == 'database'){
                    $.post(ScrudCForm.urlGetOptions,{
                        config:sectionField.db_options
                    },function(json){
                        ctl = $('<select id="preview_field_'+field+'_select2" class="form-control select2" ></select>').append($('<option></option>'));
                        for(var i in json){
                            ctl.append($('<option>'+json[i]+'</option>'));
                        }
                        $('#preview_field_'+field).find('.controls').append(ctl);
                        $("#preview_field_"+field+"_select2").select2();
                    },'json');
                }
                
                select2[select2.length] = "preview_field_"+field+"_select2";
                break;
        }
		
		
        var el = $('<div class="controls col-md-6"></div>').append(ctl);
        var li = $('<div id="preview_field_'+field+'" class="row portlet-sortable"></div>');
		
        li.hover(function(){
            $(this).children('.btn-group').children('#btn_close').show();
            $(this).children('.btn-group').children('#btn_edit').show();
        },function(){
            if (!$(this).hasClass('selected')){
               // $(this).children('.btn-group').children('#btn_close').hide();
               // $(this).children('.btn-group').children('#btn_edit').hide();
            }
        });
        
        iedit.click(function(){
            /*$('a[id=btn_close]').each(function(){
                $(this).children('.btn-group').hide();
            });
            $('a[id=btn_edit]').each(function(){
                $(this).children('.btn-group').hide();
            });*/
            ScrudCForm.current_field = field;
            $('.elements_preview > div').removeClass('selected');
            $('#preview_field_'+field).addClass('selected');
            $('#preview_field_'+field).children('.btn-group').children('#btn_close').show();
            $('#preview_field_'+field).children('.btn-group').children('#btn_edit').show();
        });
        
        li.click(function(){
            if (dragFlag == false){
                /*$('a[id=btn_close]').each(function(){
                    $(this).hide();
                });
                $('a[id=btn_edit]').each(function(){
                    $(this).hide();
                });*/
                ScrudCForm.current_field = field;
                $('.elements_preview > div').removeClass('selected');
                $('#preview_field_'+field).addClass('selected');
                
                //$('#form-options').html('');
                //ScrudCForm.buildOptions(field);
                
                $('#fieldTab a[href="#options"]').show();
                $('#fieldTab a[href="#options"]').tab('show');
                $(this).children('.btn-group').children('#btn_close').show();
                $(this).children('.btn-group').children('#btn_edit').show();
                
            }else{
                dragFlag = false;
            }
        });

        var btnGroups = '<div class="btn-group btn-group-xs btn-group-solid pull-right col-md-2"></div>';
        li.append($(btnGroups).append(ir).append(iedit)).append($('<div class="form-group col-md-10"></div>').append(lbl).append(el)).append('<div style="clear:both;"></div>');
        $('#form-preview').css({
            height:'auto'
        });
        switch (pType){
            case 'prepend':
                //console.log('section id: ' + sectionId);
                if (sectionId == undefined) {
                    $('.elements_preview').first().prepend(li);
                } else {
                     $('#'+sectionId).find('.elements_preview').prepend(li);
                }
                
                break;
            default:
            //console.log('section id: ' + sectionId + ' section el: ' + JSON.stringify(li));
            //console.log('section id: ' + li);
                if (sectionId == undefined) {
                    $('.elements_preview').first().append(li);
                } else {
                    $('#'+sectionId).find('.elements_preview').append(li);
                }
                break;
        }
		
        for(var k in field_editor){
        	CKEDITOR.replace(field_editor[k],{width:360,height:100});
        }
        $(document).ready(function() { 
	        for(var k in select2){
	        	$("#"+select2[k]).select2();
	        }
        });
		
        if (sectionField.validation != ''){
            $('#preview_error_field_'+field).show();
        }else{
            $('#preview_error_field_'+field).hide();
        }
        //$('#form-preview').height($('#form-preview').height());
        $('#field_'+field).addClass('disabled');
    },
    changeFieldToForm:function(field,pType,sectionId,sectionKey){
        //console.log(sectionKey);
        if (sectionKey == undefined) {
            sectionKey = 0 ;
        }
        var sectionField = ScrudCForm.elements[sectionKey].section_fields[field];
        $('#preview_field_'+field).find('.controls').html('');
        switch (sectionField.type){
            case 'notepanel':
            case 'checklist_panel':
            case 'color_picker':
            case 'text':
            case 'multiple_add':
            case 'time'://Time 
                $('#preview_field_'+field).find('.controls').append($('<input type="text" class="form-control" />').width(sectionField.type_options.size));
                break;
            //Time CASE
			//HIDDEN FIELD BY SALMAN START
            case 'hidden':
                $('#preview_field_'+field).find('.controls').append($('<input type="hidden" class="form-control" />').width(sectionField.type_options.size));
                break;
            //TIMEZONE BY SALMAN START
			case 'timezone':
				var ctl = $('<select id="preview_field_'+field+'_select2"  style="width:220px;"  ></select>').append($('<option></option>'));
				$('#preview_field_'+field).find('.controls').append(ctl);
				$("#preview_field_"+field+"_select2").select2();
                break;
			//TIMEZONE BY SALMAN END
            //CURRENCY CASE
            case 'currency':
                $('#preview_field_'+field).find('.controls').append($('<input type="text" />').width(sectionField.type_options.size));
                break;
            //CURRENCY CASE
            //CUSTOM FIELD BY SALMAN START
            case 'custom':
                $('#preview_field_'+field).find('.controls').append($('<textarea class="form-control"></textarea>').width(sectionField.type_options.size));
                break;
            //CUSTOM FIELD BY SALMAN
            // Rleated Module
            case 'rm_multiple':
            case 'related_module':
                $('#preview_field_'+field).find('.controls').append($('<a href="javascript:;" class="btn blue"><i class="fa fa-external-link"></i>Related Module</a>').width(sectionField.type_options.size));
                break;
            // Related Module Ends
            case 'password':
                $('#preview_field_'+field).find('.controls').append($('<input type="password" class="form-control" />').width(sectionField.type_options.size));
                break;
            case 'date':
                var strDate = '<div data-date-format="yyyy-mm-dd" data-date="2012-11-27" class="form-control input-medium date date-picker">' +
                '<input type="text" value="" >'+
                '<span class="input-group-btn"><button class="btn default"><i class="icon-calendar"></i></button></span>'+
                '</div>';
                $('#preview_field_'+field).find('.controls').append($(strDate));
                break;
            case 'date_simple':
                var strDate = '<div data-date-format="yyyy-mm-dd" data-date="2012-11-27" class="form-control input-medium date date-picker">' +
                '<input type="text" value="" >'+
                '<span class="input-group-btn"><button class="btn default"><i class="icon-calendar"></i></button></span>'+
                '</div>';
                $('#preview_field_'+field).find('.controls').append($(strDate));
                break;
            case 'datetime':
                var strDate = '<div data-date-format="yyyy-mm-dd" data-date="2012-11-27" class="form-control date">' +
                '<input type="text" value="" style="width:100px;">'+
                '<span class="add-on"><i class="icon-calendar"></i></span>'+
                '</div>';
                $('#preview_field_'+field).find('.controls').append($(strDate));
                break;
            case 'comments':
            case 'textarea':
                var ctl = $('<textarea class="form-control"></textarea>');
                if (sectionField.type_options.width != undefined){
                    ctl.width(sectionField.type_options.width);
                }
                if (sectionField.type_options.height != undefined){
                    ctl.height(sectionField.type_options.height);
                }
                $('#preview_field_'+field).find('.controls').append(ctl);
                break;
            case 'editor':
                $('#preview_field_'+field).find('.controls').append($('<textarea id="preview_field_'+field+'_editor" class="ckeditor"></textarea>'));
                CKEDITOR.replace('preview_field_'+field+'_editor',{width:660,height:200});
                break;
            case 'image':
                var file = $('<input id="filename" type="text" class="form-control input disabled" name="filename" readonly="readonly"> '+
                    '<input type="button" class="btn" value="Choose..."/>');
                $('#preview_field_'+field).find('.controls').append(file);
                break;
            case 'file':
                var file = $('<input id="filename" type="text" class="form-control input disabled" name="filename" readonly="readonly"> '+
                    '<input type="button" class="btn" value="Choose..."/>');
                $('#preview_field_'+field).find('.controls').append(file);
                break;
            case 'checkbox':
                var tmp = '';
                if (sectionField.options != undefined && sectionField.options.length > 0){
                    var opts = sectionField.options;
                    for(var i in opts){
                        if ($.trim(opts[i]) != ''){
                            tmp += '<label class="checkbox" style="display:inline-block; margin-right: 15px;"><input type="checkbox"/>'+opts[i]+'</label>';
                        }
                    }
                }
                $('#preview_field_'+field).find('.controls').append($(tmp));
                break;
            case 'radio':
                var tmp = '';
                if (sectionField.options != undefined && sectionField.options.length > 0){
                    var opts = sectionField.options;
                    for(var i in opts){
                        if ($.trim(opts[i]) != ''){
                            tmp += '<label class="radio" style="display:inline-block; margin-right: 15px;"><input type="radio" name="optionsRadios"/>'+opts[i]+'</label>';
                        }
                    }
                }
                $('#preview_field_'+field).find('.controls').append($(tmp));
                break;
            case 'select':
                if (sectionField.list_choose == 'default'){
                    var ctl = $('<select style="width:auto;" class="form-control" ></select>').append($('<option></option>'));
                    if (sectionField.options.length > 0){
                        var opts = sectionField.options;
                        for(var i in opts){
                            if ($.trim(opts[i]) != ''){
                                ctl.append($('<option>'+opts[i]+'</option>'));
                            }
                        }
                    }
                    $('#preview_field_'+field).find('.controls').append(ctl);
                }else if (sectionField.list_choose == 'database'){
                    $.post(ScrudCForm.urlGetOptions,{
                        config:sectionField.db_options
                    },function(json){
                        var ctl = $('<select class="form-control"></select>').append($('<option></option>'));
                        for(var i in json){
                            ctl.append($('<option>'+json[i]+'</option>'));
                        }
                        $('#preview_field_'+field).find('.controls').append(ctl);
                        $('#form-preview').css({
                            height:'auto'
                        });
                        //$('#form-preview').height($('#form-preview').height());
                    },'json');
                }
                break;
            case 'autocomplete':
                if (sectionField.list_choose == 'default'){
                    var ctl = $('<select id="preview_field_'+field+'_select2"  class="form-control"  ></select>').append($('<option></option>'));
                    if (sectionField.options.length > 0){
                        var opts = sectionField.options;
                        for(var i in opts){
                            if ($.trim(opts[i]) != ''){
                                ctl.append($('<option>'+opts[i]+'</option>'));
                            }
                        }
                    }
                    $('#preview_field_'+field).find('.controls').append(ctl);
                    $("#preview_field_"+field+"_select2").select2();
                }else if (sectionField.list_choose == 'database'){
                    $.post(ScrudCForm.urlGetOptions,{
                        config:sectionField.db_options
                    },function(json){
                        var ctl = $('<select id="preview_field_'+field+'_select2"  class="form-control" ></select>').append($('<option></option>'));
                        for(var i in json){
                            ctl.append($('<option>'+json[i]+'</option>'));
                        }
                        $('#preview_field_'+field).find('.controls').append(ctl);
                        $('#form-preview').css({
                            height:'auto'
                        });
                        //$('#form-preview').height($('#form-preview').height());
                        $("#preview_field_"+field+"_select2").select2();
                    },'json');
                }
                break;
        }
		
    },
    updateSectionTitle: function(id){
        $('input[name="toChangeId"]').val(id);
        var sectionTitle = $('input[name="setSectionTitle"]');
        var sectionTitleValue = $('#'+id).find('input[name="sectionTitle"]').val();
        sectionTitle.val(sectionTitleValue);
        $('#saveBlockBtn').hide();
        $('#updateBlockBtn').show();
        $('#basic').modal('show');
    },
    removeSection: function(id){
        $('#'+id).remove();
    },
    /*addSectionToForm: function(id,title,ptype){
        var block = $('<div class="portlet green-sharp box" id="'+id+'"></div>').append($('<div class="portlet-title"><div class="caption section_head"><span>'+title+'</span><input type="hidden" name="sectionTitle" value="'+title+'" /><input type="hidden" name="viewType" value="outer" /></div><div class="tools"><a href="javascript:;" onclick="ScrudCForm.updateSectionTitle(\''+id+'\');" class="config" data-original-title="" title=""></a><a href="javascript:;" class="remove" onclick="ScrudCForm.removeSection(\''+id+'\');" title=""></a></div></div>')).append($('<div class="portlet-body elements_preview dragableArea sortable section_body"></div>'));
    */
    addSectionToForm: function(id,title,view,size,ptype){ //chnage by kamran
        
        var block = $('<div class="portlet green-sharp box portlet-sortable" id="'+id+'"></div>').append($('<div class="portlet-title"><div class="caption section_head"><span>'+title+'</span><input type="hidden" name="sectionTitle" value="'+title+'" /><input type="hidden" name="viewType" value="'+view+'" /><input type="hidden" name="sizeType" value="'+size+'" /></div><div class="tools"><a href="javascript:;" onclick="ScrudCForm.updateSectionTitle(\''+id+'\');" class="config" data-original-title="" title=""></a><a href="javascript:;" class="remove" onclick="ScrudCForm.removeSection(\''+id+'\');" title=""></a></div></div>')).append($('<div class="portlet-body elements_preview dragableArea sortable section_body"></div>')); //given by kamran
        if (ptype == 'append') {
            $('.form-body').append(block );
        } else {
            $('.form-body').prepend(block );
        }
    },
//CHANGES BY KAMRAN SB STart
 extractFields:function(){
        var fieldsArr = [];
        var fields = ScrudCForm.elements;
        var sections = ScrudCForm.elements;
       
        for (var i = 0; i <= ScrudCForm.config.sections; i++) {
            
            
            for(var a = 0; a < ScrudCForm.config.ids2[i].length; a++){
                
                if (fields[i].section_fields[ScrudCForm.config.ids2[i][a]] != undefined){
                   
                    fieldsArr.push(fields[i].section_fields[ScrudCForm.config.ids2[i][a]].field);
                    
                }
            }
        }
        return fieldsArr;
        
    },
 //CHANGES BY KAMRAN SB END
     buildPreviews:function(){
        var fields = ScrudCForm.elements;
        var sections = ScrudCForm.elements;
        var Cfunctions = ScrudCForm.config.functions;
		
		//CHANGE HERE TO VIEW BUILD START
        if (ScrudCForm.config.functions != undefined){
            $('#searchListFunctions').find('input:checkbox').each(function(){
                var func_name   = this.name;
                var func_id     = this.id;
                for (i = 0; i < Cfunctions.length; i++) {
                    var myfunc = Cfunctions[i].split(':');
                    if(myfunc[0]==func_name){
                        if(myfunc[1]==$('#'+func_id).val()){
                            $('#uniform-'+func_id).find('span').addClass("checked");
                        }
                    }
                }
            });
        }
        //CHANGE HERE TO VIEW BUILD END
		
        //console.log('sections JSON on page load: ' + JSON.stringify(Cfunctions));
        /* if (ScrudCForm.config.ids == undefined){
            ScrudCForm.config.ids = [];
            for(var i in fields){
                ScrudCForm.config.ids[ScrudCForm.config.ids.length] = i;
            }
        }*/
        for (var i = 0; i <= ScrudCForm.config.sections; i++) {
            //ScrudCForm.addSectionToForm(sections[i].section_name,sections[i].section_title,'prepend');
            ScrudCForm.addSectionToForm(sections[i].section_name,sections[i].section_title,sections[i].section_view,sections[i].section_size,'prepend'); //given by kamran
            //console.log('Lenthg of IDS2: ' + ScrudCForm.config.ids2[i].length);
            for(var a = 0; a < ScrudCForm.config.ids2[i].length; a++){
                //console.log('conifig ids2: ' + JSON.stringify(ScrudCForm.config.ids2[i][a]));
                
                //console.log('Field Level JSAON from section:' + JSON.stringify(fields[i].section_fields));

                if (fields[i].section_fields[ScrudCForm.config.ids2[i][a]] != undefined){
                   
                    ScrudCForm.addFieldToForm(fields[i].section_fields[ScrudCForm.config.ids2[i][a]].field,fields[i].section_fields[ScrudCForm.config.ids2[i][a]].label,sections[i].section_name,i);
                    //console.log(fields[i].section_fields[ScrudCForm.config.ids2[i][a]].label+' section: ' + i);
                }
            }
        }
		
		$('#form-preview').css({
            height:'auto'
        });
        //$('#form-preview').height($('#form-preview').height());
    },
    updateFormLayout: function(layout){
        var layouts = [];
        switch(layout) {
            case '1':
                 layouts = ['outer'];
                
                break;
            case '2':
                layouts = ['outer','tabbed'];

                break;
            case '3':
                layouts = ['outer','accordion'];
                break;
            case '4':
                layouts = ['accordion'];
                break;
            case '5':
                layouts = ['tabbed'];
                break;
            default:
                layouts = ['outer'];
        }
        var counter = 0;
        $('#dragable .portlet').each(function(){
            $(this).find('.section_head input[name="viewType"]').val(layouts[counter]);

            if (layouts.length == 2) {
                counter = 1;
            }
            
        });
    },
    saveElements:function(table,com_id){
        if (table == undefined) return;
        
        ScrudCForm.config.filter.list = [];
        $('#filter_elements').find('input').each(function(){
            ScrudCForm.config.filter.list[ScrudCForm.config.filter.list.length] = $(this).val();
        });
        
        ScrudCForm.config.filter.actived = [];
        $('#filter_elements').find('input:checked').each(function(){
            ScrudCForm.config.filter.actived[ScrudCForm.config.filter.actived.length] = $(this).val();
        });
        
        //UPDATE BY KAMRAN SB START
        ScrudCForm.config.quickcreate.list = [];
        $('#quickcreate_elements').find('input').each(function(){
            ScrudCForm.config.quickcreate.list[ScrudCForm.config.quickcreate.list.length] = $(this).val();
        });
        
        ScrudCForm.config.quickcreate.actived = [];
        $('#quickcreate_elements').find('input:checked').each(function(){
            ScrudCForm.config.quickcreate.actived[ScrudCForm.config.quickcreate.actived.length] = $(this).val();
        });

        ScrudCForm.config.massedit.list = [];
        $('#massedit_elements').find('input').each(function(){
            ScrudCForm.config.massedit.list[ScrudCForm.config.massedit.list.length] = $(this).val();
        });
        ScrudCForm.config.massedit.actived = [];
        $('#massedit_elements').find('input:checked').each(function(){
            ScrudCForm.config.massedit.actived[ScrudCForm.config.massedit.actived.length] = $(this).val();
        });

        ScrudCForm.config.summary.list = [];
        $('#summary_elements').find('input').each(function(){
            ScrudCForm.config.summary.list[ScrudCForm.config.summary.list.length] = $(this).val();
        });
        ScrudCForm.config.summary.actived = [];
        $('#summary_elements').find('input:checked').each(function(){
            ScrudCForm.config.summary.actived[ScrudCForm.config.summary.actived.length] = $(this).val();
        });
        //UPDATE BY KAMRAN SB END



        ScrudCForm.config.column.list = [];
        $('#column_elements').find('input').each(function(){
            ScrudCForm.config.column.list[ScrudCForm.config.column.list.length] = $(this).val();
        });
        
        ScrudCForm.config.column.actived = [];
        $('#column_elements').find('input:checked').each(function(){
            ScrudCForm.config.column.actived[ScrudCForm.config.column.actived.length] = $(this).val();
        });
		
		ScrudCForm.config.join = [];
        
        $('#dataListJoin > div').each(function(){
            var object = {};
            object.type = $(this).find('#joinType').val();
            object.table = $(this).find('#joinTable').val();
            object.currentField = $(this).find('#currentField').val();
            object.targetField = $(this).find('#targetField').val();
            ScrudCForm.config.join[ScrudCForm.config.join.length] = object;
        });
        
        var elements = {};
        var ids = [];
        $('.elements_preview > div').each(function(){
            var id = $(this).attr('id');
            id = id.replace("preview_field_",""); 
            ids[ids.length] = id;
            if (ScrudCForm.elements[id] != undefined){
                elements[id] = ScrudCForm.elements[id];
            }
        });
        var config = ScrudCForm.config;
        config.ids = ids;
        console.log(config);/////////////////////////////////////////
        var sections = [];
        var ids2 = [];
        ////kamran

        var sectionCounter = 0;
        $('#dragable > div').each(function(){
            sectionCounter++;
        });

        var kam = 0;
        var tempElements = {};
        console.log('From elements: '+JSON.stringify(ScrudCForm.elements));
        $('#dragable > div').each(function(){
            var sectionTitle = $(this).find('.section_head input[name="sectionTitle"]').val();
            var section_name = (sectionTitle.toLowerCase()).split(' ').join('_');
            //console.log('section title: '+section_name+', From elements: '+JSON.stringify(ScrudCForm.elements[sectionCounter].section_name));
            for (var i = 0; i < sectionCounter; i++) {
                if (ScrudCForm.elements[i] != undefined) {
                    if (section_name == ScrudCForm.elements[i].section_name) {
                        tempElements[kam] = ScrudCForm.elements[i];
                        //console.log('found at: ' +kam +' of: ' +i);
                        //delete ScrudCForm.elements[i];
                    }
                }
                
            }
            kam++;
        });
        //console.log("its array for process: "+JSON.stringify(tempElements));//tempElements.length
        //console.log("the length of array is: " + Object.keys(tempElements).length);
        naumanArray = {};
        var naumancount=Object.keys(tempElements).length-1;
        for (var i = 0; i <= naumancount; i++) {
            naumanArray[naumancount-i] =tempElements[i] ;  
        }

        /*var naumanArray; //= {};
        for(var iii = 0; iii < tempElements.length; iii++){
            console.log("Index no : "+iii+" "+JSON.stringify(tempElements[iii]));
            // naumanArray[tempElements.length-iii] = tempElements[iii];
            naumanArray[iii] = tempElements[iii];
        }*/

        ScrudCForm.elements = naumanArray;
        ///////////////
        //console.log("Its new array"+JSON.stringify(tempElements));
        //console.log("Its Nauman's array"+JSON.stringify(naumanArray));
        var sectionCounter = $('#dragable').length;
        console.log('section count: ' + sectionCounter);
        var simpleCounter = Object.keys(tempElements).length-1 ;
        //console.log('all elements field: ' + JSON.stringify(ScrudCForm.elements));
        //$($('#dragable .portlet').get().reverse()).each(function(){
        $('#dragable  .portlet').each(function(){    
            var section = {};
            var sectionTitle = $(this).find('.section_head input[name="sectionTitle"]').val();
            console.log('section title: '+sectionTitle);
            var sectionView = $(this).find('.section_head input[name="viewType"]').val();
            var sizeType = $(this).find('.section_head input[name="sizeType"]').val(); //given by kamran
            section['section_name'] = (sectionTitle.toLowerCase()).split(' ').join('_');
            section['section_title'] = sectionTitle;
            section['section_view'] = sectionView;
            section['section_size'] = sizeType; //given by kamran

            var elements2 = {};
            var ids = [];

            $(this).find('.elements_preview > .row').each(function(){
                var id = $(this).attr('id');
                
                id = id.replace("preview_field_",""); 
                //console.log('div id: '+ id);
                ids[ids.length] = id;
                if (ScrudCForm.elements[simpleCounter] != undefined){
                    var sectionField = ScrudCForm.elements[simpleCounter].section_fields[id];
                    elements2[id] = sectionField;
                    console.log('section field: ' + JSON.stringify(sectionField) + ' For section Counter: ' + simpleCounter + ' AND for field: ' + id);
                }
            });
            ids2[simpleCounter] = ids;
            section['section_fields'] = elements2;
            console.log(JSON.stringify(elements2));
            sections[simpleCounter] = section;
            sectionCounter--;
            simpleCounter--;

        });
		
		//DATA OF FUNCTIONS START
        var Cfunctions = [];
        $('#searchListFunctions').find('input:checked').each(function(){
            Cfunctions.push($(this).attr('name')+":"+$(this).val());
        });
        config.functions = Cfunctions;
        //DATA OF FUNCTIONS END
		
		config.ids2 = ids2;
        config.sections = naumancount;
        //console.log('Section JSON String: ' + JSON.stringify(sections));
        //console.log('Config JSON String: ' + JSON.stringify(config));
        var strAlertSuccess = '<div class="alert alert-success" style="position: fixed; right:3px; bottom:20px; -webkit-box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; -moz-box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; display: none;">' +
        '<button data-dismiss="alert" class="close" type="button">×</button>' +
        ScrudCForm.successfully_message +
        '</div>';
        $.post(ScrudCForm.urlSaveConfig, {
            scrud:sections,
            table:table,
            com_id:com_id,
            config:config
        }, function(json){
            console.log(json);
            var alertSuccess = $(strAlertSuccess).appendTo('body');
            alertSuccess.show();
            
            setTimeout(function(){ 
                alertSuccess.remove();
            },2000);
        }, 'html');
    }
	
};
var dragFlag = false;
$(document).ready(function(){
    $(".sortable_portlets").sortable({
                connectWith: ".row",
                items: ".row", 
                opacity: 0.8,
                handle : '.control-label',
                coneHelperSize: true,
                placeholder: 'portlet-sortable-placeholder',
                forcePlaceholderSize: true,
                tolerance: "pointer",
                helper: "clone",
                tolerance: "pointer",
                forcePlaceholderSize: !0,
                helper: "clone",
                cancel: ".portlet-sortable-empty, .portlet-fullscreen", // cancel dragging if portlet is in fullscreen mode
                revert: 250, // animation in milliseconds
                update: function(b, c) {
                    if (c.item.prev().hasClass("portlet-sortable-empty")) {
                        c.item.prev().before(c.item);
                    }                    
                }
    });
    
    // $(".elements_preview").disableSelection();
    
    $('#btn_field_to_form').clickover({
        placement: 'bottom',
        title:'Add field to form',
        html:true,
        width:250,
        global_close:true,
        esc_close:true,
        content:'<ul class="nav nav-tabs nav-stacked" style="margin-bottom:0px;" id="form-fields"></ul>&nbsp;',
        onShown:function(){
            ScrudCForm.buildFields();
        }
    }); 
	        
    ScrudCForm.init();
    ScrudCForm.buildPreviews();
    ScrudCForm.buildConfigTable();
    ScrudCForm.buildFilter();
    ScrudCForm.buildColumn();

    //UPDATE BY KAMRAN SB START
    ScrudCForm.buildQuickCreate();
    ScrudCForm.buildMassEdit();
    ScrudCForm.buildSummaryView();
    //UPDATE BY KAMRAN SB END
    
    /*$('#btnSaveDataList').click(function(){
        ScrudCForm.saveElements(ScrudCForm.table);
    });*/

        
    $('#addJoinButton').click(function(){
        ScrudCForm.addJoin();
    });
    if (ScrudCForm.config.join != undefined){
        //        console.log(ScrudCForm.config.join);
        for(var i in ScrudCForm.config.join){
            ScrudCForm.addJoin(ScrudCForm.config.join[i]);
        }
    }
});
