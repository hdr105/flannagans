<?php
$editFlag = false;
if (isset($_GET['table']) && trim($_GET['table']) != '') {
    if (!in_array($_GET['table'], $tables)) {
        redirect('/admin/table/index');
    }
    $editFlag = true;
}
?>
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="<?php echo base_url(); ?>"><?php echo $this->lang->line('main'); ?></a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span><?php echo $this->lang->line('tool_component_builder');?></span>
                </li>
            </ul>
        </div>
        <!-- END PAGE BAR -->
        <!-- BEGIN PAGE TITLE-->
        <h3 class="page-title"><?php echo $this->lang->line('tool_component_builder');?></h3>
        <!-- END PAGE TITLE-->
        <!-- END PAGE HEADER-->
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="pull-left">
                            <a href="<?php echo base_url(); ?>admin/component/builder" class="btn btn-sm green"><?php echo $this->lang->line('components');?></a>
                            <a href="<?php echo base_url(); ?>admin/component/groups" class="btn btn-sm green"><?php echo $this->lang->line('group_component');?></a>
                            <a href="<?php echo base_url(); ?>admin/table/index" class="btn btn-sm green"><?php echo $this->lang->line('table_builder'); ?></a>
                            <!--<a href="<?php echo base_url(); ?>admin/language/index" class="btn btn-sm green"> <?php echo $this->lang->line('language_manager'); ?> </a>-->
                        </div>
                        <div class="pull-right">
                            
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-toolbar">
                        <div class="row"></div>
                        <form class="form-horizontal" id="frm_new_table">
                        <?php if ($editFlag == true) { ?>
                            <input type="hidden" id="table_name_id" value="<?php echo $_GET['table']; ?>" />
                        <?php } ?>
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-5"><?php echo $this->lang->line('table_name'); ?></label>
                                            <div class="col-md-7">
                                                <input class="form-control" type="text" id="table_name" name="table_name" placeholder="<?php echo $this->lang->line('table_name'); ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-5"><?php echo $this->lang->line('storage_engine'); ?></label>
                                            <div class="col-md-7">
                                                <select id="storage_engine" name="storage_engine" class="form-control">
                                                    <?php foreach ($engines as $k => $v) { ?>
                                                        <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-5"><?php echo $this->lang->line('collation'); ?></label>
                                            <div class="col-md-7">
                                                <select class="form-control" name="collation" id="collation">
                                                    <option value=""></option>
                                                    <?php foreach ($collations as $k => $v) { ?>
                                                        <optgroup label="<?php echo $k; ?>">
                                                            <?php foreach ($v as $k1 => $v1) { ?>
                                                                <option value="<?php echo $k1; ?>"><?php echo $v1; ?></option>
                                                            <?php } ?>
                                                        </optgroup>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-5"><?php echo $this->lang->line('table_comments'); ?></label>
                                            <div class="col-md-7">
                                                <input class="form-control" type="text" id="table_comment" name="table_comment" placeholder="<?php echo $this->lang->line('table_comments'); ?>" class="input-xxlarge">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-striped table-bordered table-hover" id="crud_table">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Type</th>
                                                    <th>Length/Values</th>
                                                    <th>Default</th>
                                                    <th>Collation</th>
                                                    <th>Null</th>
                                                    <th>Key</th>
                                                    <th>A_I</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <body>
                                                <tr style="display:none;" id="template">
                                                    <td>
                                                        <input type="text"  class="form-control"  name="field_name[]" placeholder="Field Name"/>
                                                    </td>
                                                    <td>
                                                        <select  class="form-control" name="field_type[]"  onchange="resetCollation(this);">
                                                            <option selected="selected" value="INT">INT</option>
                                                            <option value="VARCHAR">VARCHAR</option>
                                                            <option value="TEXT">TEXT</option>
                                                            <option value="DATE">DATE</option>
                                                            <optgroup label="NUMERIC">
                                                                <option value="TINYINT">TINYINT</option>
                                                                <option value="SMALLINT">SMALLINT</option>
                                                                <option value="MEDIUMINT">MEDIUMINT</option>
                                                                <option value="INT">INT</option>
                                                                <option value="BIGINT">BIGINT</option>
                                                                <option value="-">-</option>
                                                                <option value="DECIMAL">DECIMAL</option>
                                                                <option value="FLOAT">FLOAT</option>
                                                                <option value="DOUBLE">DOUBLE</option>
                                                                <option value="REAL">REAL</option>
                                                                <option value="-">-</option>
                                                                <option value="BIT">BIT</option>
                                                                <option value="BOOL">BOOL</option>
                                                                <option value="SERIAL">SERIAL</option>
                                                            </optgroup>
                                                            <optgroup label="DATE and TIME">
                                                                <option value="DATE">DATE</option>
                                                                <option value="DATETIME">DATETIME</option>
                                                                <option value="TIMESTAMP">TIMESTAMP</option>
                                                                <option value="TIME">TIME</option>
                                                                <option value="YEAR">YEAR</option>
                                                            </optgroup>
                                                            <optgroup label="STRING">
                                                                <option value="CHAR">CHAR</option>
                                                                <option value="VARCHAR">VARCHAR</option>
                                                                <option value="-">-</option>
                                                                <option value="TINYTEXT">TINYTEXT</option>
                                                                <option value="TEXT">TEXT</option>
                                                                <option value="MEDIUMTEXT">MEDIUMTEXT</option>
                                                                <option value="LONGTEXT">LONGTEXT</option>
                                                                <option value="-">-</option>
                                                                <option value="BINARY">BINARY</option>
                                                                <option value="VARBINARY">VARBINARY</option>
                                                                <option value="-">-</option>
                                                                <option value="TINYBLOB">TINYBLOB</option>
                                                                <option value="MEDIUMBLOB">MEDIUMBLOB</option>
                                                                <option value="BLOB">BLOB</option>
                                                                <option value="LONGBLOB">LONGBLOB</option>
                                                                <option value="-">-</option>
                                                                <option value="ENUM">ENUM</option>
                                                                <option value="SET">SET</option>
                                                            </optgroup>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text"  class="form-control" name="field_length_value[]"  placeholder="Length"/>
                                                    </td>
                                                    <td>
                                                        <select name="field_default[]" class="form-control" onchange="default_field(this);">
                                                            <option value=""></option>
                                                            <option value="NULL">NULL</option>
                                                            <option value="USER_DEFINED">As defined:</option>
                                                            <option value="CURRENT_TIMESTAMP">CURRENT_TIMESTAMP</option>
                                                        </select>
                                                        <br>
                                                        <input type="text"  class="form-control" name="field_user_defined[]" style=" margin-top: 3px;  display: none;" />

                                                    </td>
                                                    <td>
                                                        <select  name="field_collation[]"  class="form-control" >
                                                            <option value=""></option>
                                                            <?php foreach ($collations as $k => $v) { ?>
                                                                <optgroup label="<?php echo $k; ?>">
                                                                    <?php foreach ($v as $k1 => $v1) { ?>
                                                                        <option value="<?php echo $k1; ?>"><?php echo $v1; ?></option>
                                                                    <?php } ?>
                                                                </optgroup>
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                    <td style=" text-align: center;">
                                                        
                                                        <input type="checkbox" value="1" checked="checked" name="field_null[]">
                                                        
                                                    </td>
                                                    <td style=" text-align: center;">
                                                        <input type="checkbox" value="1" name="field_key[]"/>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <input type="checkbox" value="1" name="field_ai[]"/>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <a href="javascript:;" class="btn btn-icon-only blue fa fa-plus" onclick="add_field(this);"></a>
                                                        <a href="javascript:;" class="btn btn-icon-only red fa fa-trash" onclick="delete_field(this);"></a>
                                                    </td>
                                                </tr>
                                            </body>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-offset-3 col-md-9">
                                                <?php if ($editFlag == true) { ?>
                                                    <button type="button" class="btn blue" onclick="updateTable();" ><?php echo $this->lang->line('save'); ?> </button>
                                                <?php } else { ?>
                                                    <button type="button" class="btn blue" onclick="createNewTable();" ><?php echo $this->lang->line('save'); ?> </button>
                                                <?php } ?>
                                               
                                                <button type="button" onclick="cancel();" class="btn default">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6"> </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End CONTENT BODY -->
</div>

<script>
    function add_field(obj){
        var _field = $('#template').clone();
        _field.attr('id', '');
        _field.addClass('crud_field');
        _field.show();
        $(obj).parent().parent().after(_field);
    }
    function delete_field(obj){
        if ($('.crud_field').length > 1){
            $(obj).parent().parent().remove();
        }
    }
    function default_field(obj){
        var target = $(obj).parent().children('input[name="field_user_defined\[\]"]');
        if ($(obj).val() == 'USER_DEFINED'){
            target.show();
        }else{
            target.hide();
        }
    }
    function cancel(){
        window.location = '<?php echo base_url(); ?>index.php/admin/table/index';
    }
    function resetCollation(obj){
        var _field = $(obj).parent().parent();
        _field.find('select[name="field_collation\[\]"]').val('');
    }
    function createNewTable(){
        var obj = {};
        obj.table_name = $('#table_name').val();
        obj.storage_engine = $('#storage_engine').val();
        obj.collation = $('#collation').val();
        obj.table_comment = $('#table_comment').val();
        obj.fields = [];
        $('.crud_field').each(function(){
            var o = {};
            o.name = $(this).find('input[name="field_name\[\]"]').val();
            o.type = $(this).find('select[name="field_type\[\]"]').val();
            o.length_value = $(this).find('input[name="field_length_value\[\]"]').val();
            o.def = $(this).find('select[name="field_default\[\]"]').val();
            o.user_def = $(this).find('input[name="field_user_defined\[\]"]').val();
            o.collation = $(this).find('select[name="field_collation\[\]"]').val();
            o.is_null = $(this).find('input[name="field_null\[\]"]:checked').val();
            o.key = $(this).find('input[name="field_key\[\]"]:checked').val();
            o.ai = $(this).find('input[name="field_ai\[\]"]:checked').val();
            
            obj.fields[obj.fields.length] = o;
        });
        
        $.post('<?php echo base_url(); ?>index.php/admin/table/insert', obj, function(o){
            if (o.error == 1){
                var objError = $('<div class="alert alert-error"></div>');
                objError.append('<button data-dismiss="alert" class="close" type="button">×</button>');
                if (o.messages.length >0){
                    for(var i in o.messages){
                        objError.append('<strong>Error!</strong> '+o.messages[i]+'. <br/>');
                    }
                }
                $('#errors').html(objError);
                $('#errors').show();
            }else{
                window.location = '<?php echo base_url(); ?>index.php/admin/table/index';
            }
        }, 'json');
    }
    
    function updateTable(){
        var obj = {};
        obj.table_name = $('#table_name').val();
        obj.table_name_id = $('#table_name_id').val();
        obj.storage_engine = $('#storage_engine').val();
        obj.collation = $('#collation').val();
        obj.table_comment = $('#table_comment').val();
        obj.fields = [];
        $('.crud_field').each(function(){
            var o = {};
            o.id = $(this).attr('id');
            o.name = $(this).find('input[name="field_name\[\]"]').val();
            o.type = $(this).find('select[name="field_type\[\]"]').val();
            o.length_value = $(this).find('input[name="field_length_value\[\]"]').val();
            o.def = $(this).find('select[name="field_default\[\]"]').val();
            o.user_def = $(this).find('input[name="field_user_defined\[\]"]').val();
            o.collation = $(this).find('select[name="field_collation\[\]"]').val();
            o.is_null = $(this).find('input[name="field_null\[\]"]:checked').val();
            o.key = $(this).find('input[name="field_key\[\]"]:checked').val();
            o.ai = $(this).find('input[name="field_ai\[\]"]:checked').val();
            
            obj.fields[obj.fields.length] = o;
        });
        
        $.post('<?php echo base_url(); ?>index.php/admin/table/update', obj, function(o){
            if (o.error == 1){
                var objError = $('<div class="alert alert-error"></div>');
                objError.append('<button data-dismiss="alert" class="close" type="button">×</button>');
                if (o.messages.length >0){
                    for(var i in o.messages){
                        objError.append('<strong>Error!</strong> '+o.messages[i]+'. <br/>');
                    }
                }
                $('#errors').html(objError);
                $('#errors').show();
            }else{
                window.location = '<?php echo base_url(); ?>index.php/admin/table/index';
            }
        }, 'json');
    }
    
    $(document).ready(function(){
    	$('title').html($('h2').html());
        $('input[type="checkbox"]').each(function(){
            $(this).parent().parent().removeClass('checker');
        });
<?php if ($editFlag == true) { ?>
            $('#table_name').val('<?php echo $table_info['Name']; ?>');
            $('#storage_engine').val('<?php echo $table_info['Engine']; ?>');
            $('#collation').val('<?php echo $table_info['Collation']; ?>');
            $('#table_comment').val('<?php echo $table_info['Comment']; ?>');
    <?php if (is_array($columns_info) && count($columns_info) > 0) { ?>
        <?php foreach ($columns_info as $k => $v) { ?>
            <?php
            $aryType = explode('(', $v['Type']);
			preg_match("/\((.*)\)/i", $v['Type'],$aryTmp);
			$valType = (isset($aryTmp[1]))?$aryTmp[1]:'';
            ?>
                                var _field = $('#template').clone();
                                _field.attr('id', '<?php echo $v['Field'] ?>');
                                _field.addClass('crud_field');
                                _field.find('input[name="field_name\[\]"]').val('<?php echo $v['Field'] ?>');
                                _field.find('select[name="field_type\[\]"]').val('<?php echo strtoupper($aryType[0]); ?>');
            <?php if (isset($aryType[1])) { ?>
                                    _field.find('input[name="field_length_value\[\]"]').val('<?php echo $valType; ?>');
            <?php } ?>
            <?php if ($v['Default'] === NULL) { ?>
                <?php if ($v['Null'] == 'YES') { ?>
                                            _field.find('select[name="field_default\[\]"]').val('NULL');
                <?php } ?>
            <?php } else if ($v['Default'] == 'CURRENT_TIMESTAMP') { ?>
                                    _field.find('select[name="field_default\[\]"]').val('<?php echo $v['Default'] ?>');
            <?php } else { ?>
                                    _field.find('select[name="field_default\[\]"]').val('USER_DEFINED');
                                    _field.find('input[name="field_user_defined\[\]"]').val('<?php echo $v['Default'] ?>');
                                    _field.find('input[name="field_user_defined\[\]"]').show();
            <?php } ?>
                                _field.find('select[name="field_collation\[\]"]').val('<?php echo $v['Collation'] ?>');
            <?php if ($v['Null'] == 'NO') { ?>
                                    _field.find('input[name="field_null\[\]"]').attr({checked:false});
            <?php } ?>
            <?php if ($v['Key'] == 'PRI') { ?>
                                    _field.find('input[name="field_key\[\]"]').attr({checked:true});
            <?php } ?>
            <?php if ($v['Extra'] == 'auto_increment') { ?>
                                    _field.find('input[name="field_ai\[\]"]').attr({checked:true});
            <?php } ?>
                                            
                                _field.show();
                                $('#crud_table').append(_field);
        <?php } ?>
    <?php } ?>
                                                    
<?php } ?>
    
        if ($('.crud_field').length <= 0){
            var _field = $('#template').clone();
            _field.attr('id', '');
            _field.addClass('crud_field');
            _field.find('input[name="field_name\[\]"]').val('id');
            _field.find('input[name="field_null\[\]"]').attr({checked:false});
            _field.find('input[name="field_key\[\]"]').attr({checked:true});
            _field.find('input[name="field_ai\[\]"]').attr({checked:false});
            _field.show();
            $('#crud_table').append(_field);
        }
    
    });
</script>