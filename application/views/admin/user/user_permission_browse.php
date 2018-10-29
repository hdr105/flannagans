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
                                <span class="caption-subject font-green-sharp bold uppercase"><?php echo $this->lang->line('user_manager_permission');?></span>
                            </div>
                        </div><!-- portlet head -->
                        <div class="portlet-body">
                        <!-- USER PERMISSION BROWSE SECTION STARTS HERE -->
                        <?php $CRUD_AUTH = $this->session->userdata('CRUD_AUTH'); ?>
<div class="container">
       
        <!-- <ul class="nav nav-tabs" id="auth_tab" style="margin-bottom: 10px;">
            <?php if ((int) $CRUD_AUTH['group']['group_manage_flag'] == 1 || 
                    (int) $CRUD_AUTH['group']['group_manage_flag'] == 3 ||
                    (int) $CRUD_AUTH['user_manage_flag'] == 1 || 
                    (int) $CRUD_AUTH['user_manage_flag'] == 3 ) { ?>
            <li><a href="<?php echo base_url(); ?>index.php/admin/user/user"> &nbsp; <?php echo $this->lang->line('users');?> &nbsp; </a></li>
            <li><a href="<?php echo base_url(); ?>index.php/admin/user/group"><?php echo $this->lang->line('groups');?></a></li>
            <li  class="active"><a href="<?php echo base_url(); ?>index.php/admin/user/permission"><?php echo $this->lang->line('permissions');?></a></li>
          <?php } ?>
        </ul> -->
        <div class="caption" style="margin-bottom: 20px;">
            <?php if ((int) $CRUD_AUTH['group']['group_manage_flag'] == 1 || 
                (int) $CRUD_AUTH['group']['group_manage_flag'] == 3 ||
                (int) $CRUD_AUTH['user_manage_flag'] == 1 || 
                (int) $CRUD_AUTH['user_manage_flag'] == 3 ) { ?>
            <a href="<?php echo base_url(); ?>admin/scrud/browse?com_id=32" class="btn btn-sm green"><?php echo $this->lang->line('users');?>
            </a>
             <a href="<?php echo base_url(); ?>admin/user/group" class="btn btn-sm green"><?php echo $this->lang->line('groups');?>
            </a>
             <a href="<?php echo base_url(); ?>admin/user/permission" class="btn btn-sm green"><?php echo $this->lang->line('permissions');?>
            </a>
          <?php } ?>
                                                    
        </div>  
        
         <ul class="nav nav-tabs" id="auth_tab" style="margin-bottom: 10px;">
            <li><a href="<?php echo base_url(); ?>index.php/admin/user/permission"><?php echo $this->lang->line('group_permissions');?></a></li>
            <li class="active" ><a href="<?php echo base_url(); ?>index.php/admin/user/user_permission"><?php echo $this->lang->line('user_permissions');?></a></li>
         </ul>
         <div>
            <label><strong><?php echo $this->lang->line('choose_user');?></strong></label> 
                <div id="user_permission" style="width:400px;"></div>
         </div>
         <br/>
         <div id="user_permission_container"></div>
</div>
<script>
$("#user_permission").select2({
    placeholder: "<?php echo $this->lang->line('search_for_a_user');?>",
    minimumInputLength: 1,
    ajax: {
        url: "<?php echo base_url(); ?>index.php/admin/user/user_json",
        dataType: 'jsonp',
        data: function(term, page) {
            return {
                q: term, // search term
            };
        },
        results: function(data, page) { // parse the results into the format expected by Select2.
            return {results: data};
        }
    },
    initSelection: function(element, callback) {},
    formatResult: movieFormatResult, // omitted for brevity, see the source of this page
    formatSelection: movieFormatSelection, // omitted for brevity, see the source of this page
    dropdownCssClass: "bigdrop", // apply css that makes the dropdown taller
    escapeMarkup: function(m) {
        return m;
    } 
});

$("#user_permission").on('change',function(e){
    $.get("<?php echo base_url(); ?>index.php/admin/user/user_json?id="+e.val,{},function(data){
        $('#user_permission_container').html('');
        $('#user_permission_container').append(data);
    },'html');
});

function movieFormatResult(user) {
    return user.user_name;;
}

function movieFormatSelection(user) {
    return user.user_name;
}
$(document).ready(function(){
    $('title').html($('h2').html());
});
</script>
                        <!-- USER PERMISSIONS BROWSE SECION ENDS HERE -->
                        </div><!-- portlet body -->
                    </div>
                </div>
            </div>
    </div>
</div>