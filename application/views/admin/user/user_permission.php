<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
            <!-- BEGIN PAGE BAR -->
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="index.html">Home</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="#">Blank Page</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>Page Layouts</span>
                    </li>
                </ul>
            </div>
            <!-- END PAGE BAR -->
            <!-- BEGIN PAGE TITLE-->
            <h3 class="page-title"> Components 
                <small>component builder</small>
            </h3>
            <!-- END PAGE TITLE-->
            <div class="row">
                <div class="col-md-12">
                    <!-- BEGIN TAB PORTLET-->
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject font-green-sharp bold uppercase"><?php echo $this->lang->line('user_manager_permission'); ?></span>
                            </div>
                        </div><!-- portlet head -->
                        <div class="portlet-body">
                        <!-- USER PERMISSION SECTION STARTS HERE -->
                        <input  type="hidden" name="user_id" id="user_id" value="<?php echo $user['id']; ?>" />
<p>
    <strong><?php echo $this->lang->line('administrator_levels');?> </strong>
</p>
<label class="checkbox inline"> 
    <input type="checkbox" id="user_user_management" value="1" <?php if ((int)$user['user_manage_flag'] == 1 || (int)$user['user_manage_flag'] == 3){ ?> checked="checked" <?php } ?> /> <?php echo $this->lang->line('user_management'); ?>
</label>
<label class="checkbox inline"> 
    <input type="checkbox" id="user_database_management" value="2" <?php if ((int)$user['user_manage_flag'] == 2  || (int)$user['user_manage_flag'] == 3){ ?> checked="checked" <?php } ?> /> <?php echo $this->lang->line('tool_management'); ?>
</label>
<label class="checkbox inline"> <input type="checkbox"
    id="user_setting_management" value="1"
    <?php if (isset($user['user_setting_management']) && (int)$user['user_setting_management'] == 1){ ?>
    checked="checked" <?php } ?> /> <?php echo $this->lang->line('setting_management'); ?> 
</label>
<label class="checkbox inline"> <input type="checkbox"
    id="user_global_access" value="1"
    <?php if (isset($user['user_global_access']) && (int)$user['user_global_access'] == 1){ ?>
    checked="checked" <?php } ?> /> <?php echo $this->lang->line('global_access'); ?>
</label>
<br />
<br />
<p>
    <strong><?php echo $this->lang->line('manage_components'); ?></strong>
</p>
<table class="table table-bordered table-hover list table-condensed table-striped" style="width: auto;">
    <thead>
        <tr>
            <th
                style="width: 30px; cursor: default; color: #333333; text-shadow: 0 1px 0 #FFFFFF; background-color: #e6e6e6;"><?php echo $this->lang->line('no_'); ?></th>
            <th
                style="width: 300px; cursor: default; color: #333333; text-shadow: 0 1px 0 #FFFFFF; background-color: #e6e6e6;"><?php echo $this->lang->line('component_name'); ?></th>
            <th
                style="width: 50px; cursor: default; color: #333333; text-shadow: 0 1px 0 #FFFFFF; background-color: #e6e6e6;">&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 0; foreach($coms as $k => $com){ 
           $i++;
            ?>
        <tr>
            <td style="text-align: center;"><?php echo $i ?></td>
            <td><?php echo $com['component_name']; ?></td>
            <td style="text-align: center;"><input type="hidden"
                name="com_id" id="com_id" value="<?php echo $com['id']; ?>" />
                <div style="width: 460px;">
                    <label class="checkbox inline"> <input type="checkbox" value="1"
                        name="add"
                        <?php if (isset($pt[$user['id'].'_'.$com['id'].'_1']) && (int)$pt[$user['id'].'_'.$com['id'].'_1'] == 1){ ?>
                        checked="checked" <?php } ?> /> <?php echo $this->lang->line('add');?>
                    </label> <label class="checkbox inline"> <input type="checkbox"
                        value="2" name="edit"
                        <?php if (isset($pt[$user['id'].'_'.$com['id'].'_2']) && (int)$pt[$user['id'].'_'.$com['id'].'_2'] == 2){ ?>
                        checked="checked" <?php } ?> /> <?php echo $this->lang->line('edit');?>
                    </label> <label class="checkbox inline"> <input type="checkbox"
                        value="3" name="delete"
                        <?php if (isset($pt[$user['id'].'_'.$com['id'].'_3']) && (int)$pt[$user['id'].'_'.$com['id'].'_3'] == 3){ ?>
                        checked="checked" <?php } ?> /> <?php echo $this->lang->line('delete');?>
                    </label> <label class="checkbox inline"> <input type="checkbox"
                        value="4" name="read"
                        <?php if (isset($pt[$user['id'].'_'.$com['id'].'_4']) && (int)$pt[$user['id'].'_'.$com['id'].'_4'] == 4){ ?>
                        checked="checked" <?php } ?> /> <?php echo $this->lang->line('export_list_search_view');?>
                    </label> 
                    <label class="checkbox inline"> <input type="checkbox"
                        value="5" name="global_access"
                        <?php if (isset($pt[$user['id'].'_'.$com['id'].'_5']) && (int)$pt[$user['id'].'_'.$com['id'].'_5'] == 5){ ?>
                        checked="checked" <?php } ?> /> <?php echo $this->lang->line('global_access'); ?>
                    </label>
                </div>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
<br />
<div style="padding-left: 300px;">
    <input type="button" class="btn btn-primary" value="<?php echo $this->lang->line('save');?>" id="btn_save" />
</div>
<script type="text/javascript">
$(document).ready(function(){
    $('#btn_save').click(function(){
        var data = [];
        $('#user_permission_container').each(function(){
            var obj = {};
            obj.user_id = $(this).children('#user_id').val();
            obj.user_manage_flag = 0;
            obj.user_setting_management = 0;
            obj.user_global_access = 0;
            
            obj.coms = [];
            if ($(this).find('input[id="user_user_management"]:checked').val() == '1'){
                obj.user_manage_flag = obj.user_manage_flag + 1;
            }
            
            if ($(this).find('input[id="user_database_management"]:checked').val() == '2'){
                obj.user_manage_flag = obj.user_manage_flag + 2;
            }

            if ($(this).find('input[id="user_setting_management"]:checked').val() == '1'){
                obj.user_setting_management = 1;
            }

            if ($(this).find('input[id="user_global_access"]:checked').val() == '1'){
                obj.user_global_access = 1;
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
        });
        $.post('<?php echo base_url(); ?>index.php/admin/user/saveUserPermission', {data:data}, function(html){
            var strAlertSuccess = '<div class="alert alert-success" style="position: fixed; right:3px; bottom:20px; -webkit-box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; -moz-box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; display: none;">' +
            '<button data-dismiss="alert" class="close" type="button">×</button>' +
            '<?php echo $this->lang->line('you_successfully_saved');?>' +
            '</div>';
            var alertSuccess = $(strAlertSuccess).appendTo('body');
            alertSuccess.show();
            setTimeout(function(){ 
                alertSuccess.remove();
            },2000);
            
        }, 'html');
        
    });
});             
</script>

                        <!-- USER PERMISSIONS SECION ENDS HERE -->
                        </div><!-- portlet body -->
                    </div>
                </div>
            </div>
    </div>
</div>