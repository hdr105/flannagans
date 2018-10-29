<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <!-- BEGIN PAGE BAR -->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="<?php echo base_url(); ?>"><?php echo $this->lang->line('main'); ?></a>
                                <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span><?php echo $this->lang->line('tool_table_builder');?></span>
                </li>
            </ul>               
        </div>
        <!-- END PAGE BAR -->
        <h3 class="page-title"><?php echo $this->lang->line('tool_table_builder');?></h3>
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
                            <a href="<?php echo base_url(); ?>admin/table/form" class="btn btn-sm blue "  > <i class="icon-plus icon-white"></i> <?php echo $this->lang->line('add_table'); ?></a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-toolbar">
                            <div class="row"></div>
                        </div>
                        <table class="table table-striped table-bordered table-hover  order-column" id="sample_1">
                                <thead>
                                    <tr>
                                        <th style="text-align:center;width:30px;"><?php echo $this->lang->line('no_'); ?></th>
                                        <th style=""><?php echo $this->lang->line('tables'); ?></th>
                                        <th style="text-align:center; width: 120px;  "><?php echo $this->lang->line('actions'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if (count($tables) > 2) {
                                            foreach ($tables as $k => $table) {
                                                if ($table == 'cruds')
                                                    continue;
                                                if (strpos($table, 'crud_') !== false)
                                                    continue;
                                                
                                                $comDao = new ScrudDao('crud_components', $this->db);
                                                $params = array();
                                                $params['conditions'] = array('component_table = ?',array($table));
                                                $coms = $comDao->findFirst($params);
                                                ?>
                                                <tr  class="odd gradeX">
                                                    <td style="text-align:center;"><?php echo ($k + 1); ?></td>
                                                    <td><?php echo $table; ?></td>
                                                    <td style="text-align: center;">
                                                        <a  href="javascript:;"  class="btn btn-icon-only green fa fa-edit" id="table_btn_fields" onclick="edit_table('<?php echo $table; ?>')"></a>
                                                        <?php if (empty($coms)){?>
                                                        <a  href="javascript:;"  class="btn btn-icon-only red fa fa-trash" id="table_btn_delete" onclick="modal_delete_table('<?php echo $table; ?>');"></a>
                                                        <?php }else{ ?>
                                                        <a  href="javascript:;"  class="btn btn-icon-only red fa fa-trash" id="table_btn_delete" onclick="alert_modal_delete_table('<?php echo $table; ?>');"></a>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }  ?>
                                </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> 
    </div>
</div>
<script>
	function modal_delete_table(table){
       bootbox.dialog({
                
                title: "Confirmation",
                message: '<div class="row">  ' +
                    '<div class="col-md-12"> ' +
                    'Are you sure you want to delete <b>'+table+'</b>?' +
                    
                    '</div>  </div>',
                buttons: {
                    cancel: {
                        label: 'Cancel',
                        className: 'btn-warning'
                    },
                    save: {
                        label: 'Yes',
                        className: 'btn-success',
                        callback: function () {
                            delete_table(table);
                            return false;
                        }
                    }
                }
            });
	}

	function alert_modal_delete_table(table){
        bootbox.dialog({
                title: "Warning!",
                message: '<div class="row">  ' +
                    '<div class="col-md-12"> ' +
                    'You can not delete <b>'+table+'</b> table because there is at least one component  are created from this table.' +
                    
                    '</div>  </div>',
                buttons: {
                   
                 cancel: {
                  label: 'Cancel',
                  className: 'btn-warning'
                 }
           
            }
        });
	}
	
    function edit_table(table){
        window.location = '<?php echo base_url(); ?>index.php/admin/table/form?table='+table;
    }
    function delete_table(table){
        $.post('<?php echo base_url(); ?>index.php/admin/table/delete', {table:table}, function(data){
            $('#delModal').modal('hide');
            window.location = '<?php echo base_url(); ?>index.php/admin/table/index';
        },'html');
    }
    $(document).ready(function(){
        $('title').html($('h2').html());
    });
</script>