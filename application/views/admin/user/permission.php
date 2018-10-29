<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
            <!-- BEGIN PAGE BAR -->
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="<?php echo base_url(); ?>"><?php echo $this->lang->line('main'); ?></a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span><?=$this->lang->line('user_manager');?></span>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span><?=$this->lang->line('permissions');?></span>
                    </li>
                </ul>
            </div>
            <!-- END PAGE BAR -->
            <!-- BEGIN PAGE TITLE-->
            <h3 class="page-title"> <?=$this->lang->line('permissions');?> 
            </h3>
            <!-- END PAGE TITLE-->
            <div class="row">
                <div class="col-md-12">
                    <!-- BEGIN TAB PORTLET-->
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="pull-left">
                                    <!-- PERMISSION SECTION STARTS HERE -->
                                    <?php $CRUD_AUTH = $this->session->userdata('CRUD_AUTH'); ?>
                                    <?php if ((int) $CRUD_AUTH['group']['group_manage_flag'] == 1 || 
                                    (int) $CRUD_AUTH['group']['group_manage_flag'] == 3 ||
                                    (int) $CRUD_AUTH['user_manage_flag'] == 1 || 
                                    (int) $CRUD_AUTH['user_manage_flag'] == 3 ) { ?>
                                        <a href="<?php echo base_url(); ?>admin/scrud/browse?com_id=65" class="btn btn-sm green"><?php echo $this->lang->line('users');?></a>
                                        <a href="<?php echo base_url(); ?>admin/user/group" class="btn btn-sm green"><?php echo $this->lang->line('groups');?></a>
                                        <a href="<?php echo base_url(); ?>admin/user/permission" class="btn btn-sm green"><?php echo $this->lang->line('permissions');?></a>
                                    <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div><!-- portlet head -->
                        <div class="portlet-body">
                                <!-- <ul class="nav nav-tabs" id="auth_tab">
                                    <li class="active"><a href="<?php echo base_url(); ?>index.php/admin/user/permission"><?php echo $this->lang->line('group_permissions');?></a></li>
                                    <li><a href="<?php echo base_url(); ?>index.php/admin/user/user_permission"><?php echo $this->lang->line('user_permissions');?></a></li>
                                </ul>
                                <div class="clearfix" style="margin-bottom: 30px;"> </div> -->
                                <div>
                                    <p><strong><?php echo $this->lang->line('groups');?></strong></p>

                                    <div class="tabbable tabs-left">
                                        <ul class="nav nav-tabs" id="p_t">
                                            <?php 
                                                foreach($groups as $group){ 
                                                    $gid = strtolower(str_replace(' ', '_', $group['group_name']));
                                            ?>
                                                <li ><a href="#<?php echo $gid; ?>" data-toggle="tab"><?php echo $group['group_name'] ?></a></li>
                                            <?php } ?>
                                        </ul>
                                        <div class="tab-content" id="permissions">
                                            <?php 
                                                foreach($groups as $group){ 
                                                    $gid = strtolower(str_replace(' ', '_', $group['group_name']));
                                            ?>
                                            <div class="tab-pane" id="<?php echo $gid; ?>">
                                                <input type="hidden" name="group_id" id="group_id" value="<?php echo $group['id']; ?>" />
                                                <p><strong><?php echo $this->lang->line('administrator_levels');?> </strong></p>
                                                <label class="checkbox inline">
                                                    <input type="checkbox" id="group_user_management" value="1" <?php if ((int)$group['group_manage_flag'] == 1 || (int)$group['group_manage_flag'] == 3){ ?> checked="checked" <?php } ?> /> <?php echo $this->lang->line('user_management'); ?>
                                                </label>
                                                
                                                <label class="checkbox inline">
                                                    <input type="checkbox" id="group_database_management" value="2" <?php if ((int)$group['group_manage_flag'] == 2  || (int)$group['group_manage_flag'] == 3){ ?> checked="checked" <?php } ?> /> <?php echo $this->lang->line('tool_management'); ?>
                                                </label>
                                                
                                                <label class="checkbox inline">
                                                    <input type="checkbox" id="group_setting_management" value="1" <?php if (isset($group['group_setting_management']) && (int)$group['group_setting_management'] == 1){ ?> checked="checked" <?php } ?> /> <?php echo $this->lang->line('setting_management'); ?> 
                                                </label>
                                                <label class="checkbox inline">
                                                    <input type="checkbox" id="group_global_access" value="1" <?php if (isset($group['group_global_access']) && (int)$group['group_global_access'] == 1){ ?> checked="checked" <?php } ?> /> <?php echo $this->lang->line('global_access'); ?>
                                                </label>
                                                <br/>
                                                <br/>
                                                <p><strong><?php echo $this->lang->line('manage_components'); ?></strong></p>
                                                <table class="table table-bordered table-hover list table-condensed table-striped" style="width: auto;">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 30px;cursor:default; color:#333333;text-shadow: 0 1px 0 #FFFFFF;background-color: #e6e6e6;vertical-align: -webkit-baseline-middle;"><?php echo $this->lang->line('no_'); ?></th>
                                                            <th style="width: 200px;cursor:default; color:#333333;text-shadow: 0 1px 0 #FFFFFF;background-color: #e6e6e6;vertical-align: -webkit-baseline-middle;"><?php echo $this->lang->line('component_name'); ?></th>
                                                            <th style="width: 100px;cursor:default; color:#333333;text-shadow: 0 1px 0 #FFFFFF;background-color: #e6e6e6;vertical-align: -webkit-baseline-middle;">
                                                                <input type="hidden" name="com_id" id="com_id" value="<?php echo $com['id']; ?>" />
                                                                <label class="checkbox inline">
                                                                    <input type="checkbox" value="1" name="all_add" id="all_add_<?php echo $gid; ?>"   />Add All 
                                                                </label>
                                                            </th>
                                                            <th style="width: 100px;cursor:default; color:#333333;text-shadow: 0 1px 0 #FFFFFF;background-color: #e6e6e6;vertical-align: -webkit-baseline-middle;">
                                                                <label class="checkbox inline">
                                                                    <input type="checkbox" value="2" name="all_edit" id="all_edit_<?php echo $gid; ?>"   /> Edit All 
                                                                </label>
                                                            </th>
                                                            <th style="width: 100px;cursor:default; color:#333333;text-shadow: 0 1px 0 #FFFFFF;background-color: #e6e6e6;vertical-align: -webkit-baseline-middle;">
                                                                <label class="checkbox inline">
                                                                    <input type="checkbox" value="3" name="all_delete" id="all_delete_<?php echo $gid; ?>"    />Delete All 
                                                                </label>
                                                            </th>
                                                            <th style="width: 200px;cursor:default; color:#333333;text-shadow: 0 1px 0 #FFFFFF;background-color: #e6e6e6;vertical-align: -webkit-baseline-middle;">
                                                                <label class="checkbox inline">
                                                                    <input type="checkbox"  value="4" name="all_read" id="all_read_<?php echo $gid; ?>"    />Read All 
                                                                </label>
                                                            </th>
                                                            <th style="width: 160px;cursor:default; color:#333333;text-shadow: 0 1px 0 #FFFFFF;background-color: #e6e6e6;vertical-align: -webkit-baseline-middle;">
                                                                <label class="checkbox inline">
                                                                    <input type="checkbox" value="5" name="all_global_access" id="all_global_access_<?php echo $gid; ?>"    /> Global Access 
                                                                </label>
                                                            </th>
                                                            <th style="width: 150px;cursor:default; color:#333333;text-shadow: 0 1px 0 #FFFFFF;background-color: #e6e6e6; text-align: center;">
                                                                <input type="button" class="btn btn-primary save_all_permission" value="<?="Save All"?>" /><!--id="btn_save"-->
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 0; foreach($coms as $k => $com){ 
                                                        $i++;
                                                        ?>
                                                        <tr class="mod_level_permission" id="row_<?php echo $com['id']; ?>"><!-- new change for field level permissions -->
                                                            <td style="text-align:center;"><?php echo $i ?></td>
                                                            <td><?php echo $com['component_name']; ?></td>
                                                            <td >
                                                                <input type="hidden" name="com_id" id="com_id" value="<?php echo $com['id']; ?>" />
                                                                    <label class="checkbox inline">
                                                                        <input type="checkbox" value="1" name="add" class="check_add_<?php echo $gid; ?>" <?php if (isset($pt[$group['id'].'_'.$com['id'].'_1']) && (int)$pt[$group['id'].'_'.$com['id'].'_1'] == 1){ ?> checked="checked" <?php } ?> /> <?php echo $this->lang->line('add');?>
                                                                    </label>
                                                            </td>
                                                            <td>
                                                                    <label class="checkbox inline">
                                                                        <input type="checkbox" value="2" name="edit" class="check_edit_<?php echo $gid; ?>" <?php if (isset($pt[$group['id'].'_'.$com['id'].'_2']) && (int)$pt[$group['id'].'_'.$com['id'].'_2'] == 2){ ?> checked="checked" <?php } ?>  /> <?php echo $this->lang->line('edit');?>
                                                                    </label>
                                                            </td>
                                                            <td>
                                                                    <label class="checkbox inline">
                                                                        <input type="checkbox" value="3" name="delete" class="check_delete_<?php echo $gid; ?>" <?php if (isset($pt[$group['id'].'_'.$com['id'].'_3']) && (int)$pt[$group['id'].'_'.$com['id'].'_3'] == 3){ ?> checked="checked" <?php } ?>  /> <?php echo $this->lang->line('delete');?>
                                                                    </label>
                                                            </td>
                                                            <td>
                                                                    <label class="checkbox inline">
                                                                        <input type="checkbox"  value="4" name="read" class="check_read_<?php echo $gid; ?>" <?php if (isset($pt[$group['id'].'_'.$com['id'].'_4']) && (int)$pt[$group['id'].'_'.$com['id'].'_4'] == 4){ ?> checked="checked" <?php } ?>  /> <?php echo $this->lang->line('export_list_search_view');?>
                                                                    </label>
                                                            </td>
                                                            <td>
                                                                    <label class="checkbox inline">
                                                                        <input type="checkbox" value="5" name="global_access" class="check_global_access_<?php echo $gid; ?>"  <?php if (isset($pt[$group['id'].'_'.$com['id'].'_5']) && (int)$pt[$group['id'].'_'.$com['id'].'_5'] == 5){ ?> checked="checked" <?php } ?> /> <?php echo $this->lang->line('global_access'); ?>
                                                                    </label>
                                                            </td>

                                                            <!-- Custom Field Permissions Starts -->                                    
                                                            <!-- Add Save button to save each componenet seperatly
                                                            along with Field Permission
                                                             -->                                    
                                                            <td style="width:150px; text-align: center;">
                                                                <input type="hidden" id="grp_<?php echo $com['id']; ?>" value="<?=$group['id']?>">
                                                                <input type="button" class="btn btn-primary save_permission" value="<?php echo $this->lang->line('save');?>" id="btn_<?php echo $com['id']; ?>" />
                                                                <!-- <a class="btn btn-mini btn-info" role="button" data-toggle="collapse" href="#collapseExample_<?=$group['id']?>_<?=$com['id']?>" aria-expanded="false" aria-controls="collapseExample">Field Level</a> -->
                                                            </td>
                                                        </tr>
                                                        <tr id="row_fp_<?php echo $com['id']; ?>">
                                                            <td colspan="4">
                                                           
                                                                <div class="collapse" id="collapseExample_<?=$group['id']?>_<?=$com['id']?>">
                                                                  <div class="well flp_div_<?php echo $com['id']; ?>">
                                                                        <p><strong>Field Level Permissions</strong></p>
                                                                            <table class="table table-bordered table-hover list table-condensed table-striped" style="width: auto;">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th style="width: 30px;cursor:default; color:#333333;text-shadow: 0 1px 0 #FFFFFF;background-color: #e6e6e6;">
                                                                                            Field
                                                                                        </th> 
                                                                                        <th style="width: 30px;cursor:default; color:#333333;text-shadow: 0 1px 0 #FFFFFF;background-color: #e6e6e6;">
                                                                                            Permission
                                                                                        </th>                         
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    
                                                                                     
                                                                                    <?php
                                                                                        $field_list = $component_info[$com['id']]['form_elements'];

                                                                                        /*echo '<pre>';
                                                                                        print_r($component_info[$com['id']]);
                                                                                        echo '</pre>';*/

                                                                                        $field_list = $field_list[0]['section_fields'];

                                                                                        foreach ($field_list as $key => $value) {
                                                                                            $ex_key = explode('.', $key);
                                                                                            /*echo '<pre>';
                                                                                            print_r($value);
                                                                                            echo '</pre>';*/

                                                                                            ?>
                                                                                            <tr>
                                                                                                <td>
                                                                                                    <?php echo $value['alias'];?>
                                                                                                </td>
                                                                                                <td>
                                                                                                <input type="hidden" name="field_name" id="field_name" value="<?php echo $ex_key[1]; ?>" />
                                                                                                <input type="hidden" name="com_id2" id="com_id2" value="<?php echo $com['id']; ?>" />
                                                                <div style="width: 360px;" id="fdiv_<?php echo $com['id']; ?>">
                                                                    <label class="radio inline">
                                                                        <input type="radio" value="6" name="fp_<?php echo $group['id']; ?>_<?php echo $com['id']; ?>_<?php echo $ex_key[1]; ?>" <?php if (isset($ept[$group['id'].'_'.$com['id'].'_'.$ex_key[1].'_6']) && (int)$ept[$group['id'].'_'.$com['id'].'_'.$ex_key[1].'_6'] == 6){ ?> checked="checked" <?php } ?>  />Invisible 
                                                                    </label>
                                                                    <label class="radio inline">
                                                                        <input type="radio" value="7" name="fp_<?php echo $group['id']; ?>_<?php echo $com['id']; ?>_<?php echo $ex_key[1]; ?>" <?php if (isset($ept[$group['id'].'_'.$com['id'].'_'.$ex_key[1].'_7']) && (int)$ept[$group['id'].'_'.$com['id'].'_'.$ex_key[1].'_7'] == 7){ ?> checked="checked" <?php } ?>  /> Read Only
                                                                    </label>
                                                                    <label class="radio inline">
                                                                        <input type="radio" value="2" name="fp_<?php echo $group['id']; ?>_<?php echo $com['id']; ?>_<?php echo $ex_key[1]; ?>" <?php if (isset($ept[$group['id'].'_'.$com['id'].'_'.$ex_key[1].'_2']) && (int)$ept[$group['id'].'_'.$com['id'].'_'.$ex_key[1].'_2'] == 2){ ?> checked="checked" <?php } ?>  /> Edit
                                                                    </label>
                                                                    
                                                                    
                                                                </div>
                                                                                                </td>
                                                                                            <?php
                                                                                        }
                                                                                    ?>
                                                                                       
                                                                                   
                                                                                    

                                                                                </tbody>
                                                                            </table>
                                                                      
                                                                  </div>
                                                                </div>
                                                            </td>


                                                                <!-- Custom Field Permissions Ends -->                                    
                                                        </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                                <script>
                                                    $("#all_add_<?php echo $gid; ?>").click(function () {
                                                        if($(this).prop('checked'))
                                                            $('.check_add_<?php echo $gid; ?>').parent().addClass('checked');
                                                        else
                                                            $('.check_add_<?php echo $gid; ?>').parent().removeClass('checked');
                                                        $(".check_add_<?php echo $gid; ?>").prop('checked', $(this).prop('checked'));
                                                    });
                                                    $("#all_edit_<?php echo $gid; ?>").click(function () {
                                                        if($(this).prop('checked'))
                                                            $('.check_edit_<?php echo $gid; ?>').parent().addClass('checked');
                                                        else
                                                            $('.check_edit_<?php echo $gid; ?>').parent().removeClass('checked');
                                                        $(".check_edit_<?php echo $gid; ?>").prop('checked', $(this).prop('checked'));
                                                    });
                                                    $("#all_delete_<?php echo $gid; ?>").click(function () {
                                                        if($(this).prop('checked'))
                                                            $('.check_delete_<?php echo $gid; ?>').parent().addClass('checked');
                                                        else
                                                            $('.check_delete_<?php echo $gid; ?>').parent().removeClass('checked');
                                                        $(".check_delete_<?php echo $gid; ?>").prop('checked', $(this).prop('checked'));
                                                    });
                                                    $("#all_read_<?php echo $gid; ?>").click(function () {
                                                        if($(this).prop('checked'))
                                                            $('.check_read_<?php echo $gid; ?>').parent().addClass('checked');
                                                        else
                                                            $('.check_read_<?php echo $gid; ?>').parent().removeClass('checked');
                                                        $(".check_read_<?php echo $gid; ?>").prop('checked', $(this).prop('checked'));
                                                    });
                                                    $("#all_global_access_<?php echo $gid; ?>").click(function () {
                                                        if($(this).prop('checked'))
                                                            $('.check_global_access_<?php echo $gid; ?>').parent().addClass('checked');
                                                        else
                                                            $('.check_global_access_<?php echo $gid; ?>').parent().removeClass('checked');
                                                        $(".check_global_access_<?php echo $gid; ?>").prop('checked', $(this).prop('checked'));
                                                    });

                                                </script>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div> 
                                    <br />
                                    <!-- <div style="padding-left:300px;">
                                        <input type="button" class="btn btn-primary" value="Save All<?php //echo $this->lang->line('save');?>" id="btn_save"/>
                                    </div> -->
                                </div>
                            <script>
                                $(document).ready(function(){
                                    $('title').html($('h2').html());
                                    $($('#p_t  a').get(0)).tab('show');

                                    $('input[name="add"]').change(function(){
                                        var nDiv = '#f' + $(this).parent().parent().get( 0 ).id + ' > input';
                                        
                                        $('#fdiv > input').each(function(){
                                            alert(this.tagName);
                                        });


                                    });


                                    ///////////////////////////////////////////

                                    $('.save_permission').click(function(){
                                        var thisId = this.id;
                                        var breakId = (this.id).split("_");
                                        var roleId = $(this).parent().parent().parent().parent().parent().attr("id");
                                        var rowId = $(this).parent().parent().attr("id");
                                        //alert(rowId);

                                        var loopFull = '#permissions > #'+roleId;
                                        var rowLoopFull = 'table > tbody > tr#'+rowId;
                                        var rowFpLoopFull = '.flp_div_'+breakId[1]+' > table > tbody > tr';
                                    // ''
                                        var data = [];
                                        var c = 0;
                                            $(loopFull).each(function(){
                                                var obj = {};
                                                obj.group_id = $(this).children('#group_id').val();
                                                obj.group_manage_flag = 0;
                                                obj.group_setting_management = 0;
                                                obj.group_global_access = 0;
                                                obj.coms = [];
                                                obj.fp = [];
                                                //console.log(obj.group_id);
                                                if ($(this).find('input[id="group_user_management"]:checked').val() == '1'){
                                                    obj.group_manage_flag = obj.group_manage_flag + 1;
                                                }
                                                
                                                if ($(this).find('input[id="group_database_management"]:checked').val() == '2'){
                                                    obj.group_manage_flag = obj.group_manage_flag + 2;
                                                }

                                                if ($(this).find('input[id="group_setting_management"]:checked').val() == '1'){
                                                    obj.group_setting_management = 1;
                                                }

                                                if ($(this).find('input[id="group_global_access"]:checked').val() == '1'){
                                                    obj.group_global_access = 1;
                                                }
                                                $(this).find(rowLoopFull).each(function(){
                                                    var com = {}
                                                    var per = {add:0,edit:0,del:0,read:0,global_access:0};
                                                    var checkPer = 0;
                                                    if ($(this).find('input[name="add"]:checked').val() == '1'){
                                                        per.add = 1;
                                                    }
                                                    if ($(this).find('input[name="edit"]:checked').val() == '2'){
                                                        per.edit = 2;
                                                    }
                                                    if ($(this).find('input[name="delete"]:checked').val() == '3'){
                                                        per.del = 3;
                                                    }
                                                    if ($(this).find('input[name="read"]:checked').val() == '4'){
                                                        per.read = 4;
                                                    }
                                                    if ($(this).find('input[name="global_access"]:checked').val() == '5'){
                                                        per.global_access = 5;
                                                    }
                                                     
                                                    com.com_id = $(this).find('#com_id').val();
                                                    com.permission_type = per;
                                                    obj.coms[obj.coms.length] = com;
                                                    c = c +1;
                                               

                                                });


                                //Field Permissions
                                            $(this).find(rowFpLoopFull).each(function(){
                                                var comf = {};
                                                var fper = 0;
                                              
                                                var com_id2 =  $(this).find('#com_id2').val();  
                                                var field_name = $(this).find('#field_name').val();

                                                var inputName = 'input[name="fp_'+obj.group_id+'_'+com_id2+'_'+field_name+'"]:checked';

                                                if($(inputName).is(':checked')){
                                                     fper = $(inputName).val();
                                                     
                                                }
                                               
                                                comf.com_id2 = com_id2;
                                                comf.field_name = field_name;
                                                comf.field_permissions = fper; 
                                                

                                                obj.fp[obj.fp.length] = comf;

                                            });

                                            data = [obj];
                                            console.log(JSON.stringify(data));
                                            $.post('<?php echo base_url(); ?>index.php/admin/user/savePermission', {data:data}, function(html){
                                               
                                                
                                                var strAlertSuccess = '<div class="alert alert-success" style="position: fixed; right:3px; bottom:20px; -webkit-box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; -moz-box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; display: none;"><button data-dismiss="alert" class="close" type="button">×</button>Permissions saved succesfully</div>';
                                                var alertSuccess = $(strAlertSuccess).appendTo('body');
                                                alertSuccess.show();

                                                 setTimeout(function(){ 
                                                    alertSuccess.remove();
                                                },2000);
                                               
                                                
                                            }, 'html');
                                        });

                                    });


                                ///////////////////////////////////////////
                                    $('.save_all_permission').click(function(){
                                        var thisId = this.id;
                                        var breakId = (this.id).split("_");
                                        var roleId = $(this).parent().parent().parent().parent().parent().attr("id");
                                        var rowId = $(this).parent().parent().attr("id");
                                        //alert(rowId);

                                        var loopFull = '#permissions > #'+roleId;
                                        var rowLoopFull = 'table > tbody > tr.mod_level_permission';

                                        var data = [];
                                        var c = 0;
                                            $(loopFull).each(function(){
                                                var obj = {};
                                                obj.group_id = $(this).children('#group_id').val();
                                                obj.group_manage_flag = 0;
                                                obj.group_setting_management = 0;
                                                obj.group_global_access = 0;
                                                obj.coms = [];
                                                obj.fp = [];
                                                //console.log(obj.group_id);
                                                if ($(this).find('input[id="group_user_management"]:checked').val() == '1'){
                                                    obj.group_manage_flag = obj.group_manage_flag + 1;
                                                }
                                                
                                                if ($(this).find('input[id="group_database_management"]:checked').val() == '2'){
                                                    obj.group_manage_flag = obj.group_manage_flag + 2;
                                                }

                                                if ($(this).find('input[id="group_setting_management"]:checked').val() == '1'){
                                                    obj.group_setting_management = 1;
                                                }

                                                if ($(this).find('input[id="group_global_access"]:checked').val() == '1'){
                                                    obj.group_global_access = 1;
                                                }
                                                $(this).find(rowLoopFull).each(function(){
                                                    var com = {}
                                                    var per = {add:0,edit:0,del:0,read:0,global_access:0};
                                                    var checkPer = 0;
                                                    if ($(this).find('input[name="add"]:checked').val() == '1'){
                                                        per.add = 1;
                                                    }
                                                    if ($(this).find('input[name="edit"]:checked').val() == '2'){
                                                        per.edit = 2;
                                                    }
                                                    if ($(this).find('input[name="delete"]:checked').val() == '3'){
                                                        per.del = 3;
                                                    }
                                                    if ($(this).find('input[name="read"]:checked').val() == '4'){
                                                        per.read = 4;
                                                    }
                                                    if ($(this).find('input[name="global_access"]:checked').val() == '5'){
                                                        per.global_access = 5;
                                                    }
                                                     
                                                    com.com_id = $(this).find('#com_id').val();
                                                    com.permission_type = per;
                                                    obj.coms[obj.coms.length] = com;
                                                    c = c +1;
                                               
                                                
                                                });
                                                

                                            data = [obj];
                                            console.log(JSON.stringify(data));
                                            $.post('<?php echo base_url(); ?>index.php/admin/user/savePermission', {data:data}, function(html){
                                               
                                                
                                                var strAlertSuccess = '<div class="alert alert-success" style="position: fixed; right:3px; bottom:20px; -webkit-box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; -moz-box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; display: none;"><button data-dismiss="alert" class="close" type="button">×</button>Permissions saved succesfully</div>';
                                                var alertSuccess = $(strAlertSuccess).appendTo('body');
                                                alertSuccess.show();

                                                 setTimeout(function(){ 
                                                    alertSuccess.remove();
                                                },2000);
                                               
                                                
                                            }, 'html');
                                        });

                                    });

                                    ///////////////////////////////////////////////////

                                    $('#btn_save').click(function(){
                                        var data = [];
                                        $('#permissions > div').each(function(){
                                            var obj = {};
                                            obj.group_id = $(this).children('#group_id').val();
                                            obj.group_manage_flag = 0;
                                            obj.group_setting_management = 0;
                                            obj.group_global_access = 0;
                                            obj.coms = [];
                                                obj.fp = [];
                                            if ($(this).find('input[id="group_user_management"]:checked').val() == '1'){
                                                obj.group_manage_flag = obj.group_manage_flag + 1;
                                            }
                                            
                                            if ($(this).find('input[id="group_database_management"]:checked').val() == '2'){
                                                obj.group_manage_flag = obj.group_manage_flag + 2;
                                            }

                                            if ($(this).find('input[id="group_setting_management"]:checked').val() == '1'){
                                                obj.group_setting_management = 1;
                                            }

                                            if ($(this).find('input[id="group_global_access"]:checked').val() == '1'){
                                                obj.group_global_access = 1;
                                            }
                                            $(this).find('table > tbody > tr').each(function(){
                                                var com = {}
                                                var per = {add:0,edit:0,del:0,read:0,configure:0};

                                                if ($(this).find('input[name="add"]:checked').val() == '1'){
                                                    per.add = 1;
                                                }
                                                if ($(this).find('input[name="edit"]:checked').val() == '2'){
                                                    per.edit = 2;
                                                }
                                                if ($(this).find('input[name="delete"]:checked').val() == '3'){
                                                    per.del = 3;
                                                }
                                                if ($(this).find('input[name="read"]:checked').val() == '4'){
                                                    per.read = 4;
                                                }
                                                if ($(this).find('input[name="global_access"]:checked').val() == '5'){
                                                    per.global_access = 5;
                                                }
                                                
                                                com.com_id = $(this).find('#com_id').val();
                                                com.permission_type = per;
                                                
                                                obj.coms[obj.coms.length] = com;
                                            });
                                            
                                            data[data.length] = obj;
                                            console.log(JSON.stringify(data));
                                        });
                                        $.post('<?php echo base_url(); ?>index.php/admin/user/savePermission', {data:data}, function(html){
                                            var strAlertSuccess = '<div class="alert alert-success" style="position: fixed; right:3px; bottom:20px; -webkit-box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; -moz-box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; display: none;"><button data-dismiss="alert" class="close" type="button">×</button>Permissions saved succesfully</div>';
                                            var alertSuccess = $(strAlertSuccess).appendTo('body');
                                            alertSuccess.show();
                                            setTimeout(function(){ 
                                                alertSuccess.remove();
                                            },2000);
                                            
                                        }, 'html');
                                        
                                    });
                                });
                            </script>

                            <!-- PERMISSIONS SECION ENDS HERE -->
                        </div><!-- portlet body -->
                    </div>
                </div>
            </div>
    </div>
</div>