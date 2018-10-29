<?php $CRUD_AUTH = $this->session->userdata('CRUD_AUTH'); ?>
<!--<div class="container">
		<h2><?php echo $this->lang->line('user_manager_users');?></h2>
        <ul class="nav nav-tabs" id="auth_tab" style="margin-bottom: 0px;">
        <?php if ((int) $CRUD_AUTH['group']['group_manage_flag'] == 1 || 
        		(int) $CRUD_AUTH['group']['group_manage_flag'] == 3 ||
        		(int) $CRUD_AUTH['user_manage_flag'] == 1 || 
        		(int) $CRUD_AUTH['user_manage_flag'] == 3 ) { ?>
            <li class="active"><a href="<?php echo base_url(); ?>index.php/admin/user/user"> &nbsp; <?php echo $this->lang->line('users');?> &nbsp; </a></li>
            <li><a href="<?php echo base_url(); ?>index.php/admin/user/group"><?php echo $this->lang->line('groups');?></a></li>
            <li><a href="<?php echo base_url(); ?>index.php/admin/user/permission"><?php echo $this->lang->line('permissions');?></a></li>
          <?php } ?>
        </ul>-->
        <!-- BEGIN CONTENT -->
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
                                <span><?php echo $this->lang->line('user_manager_users');?></span>
                            </li>
                        </ul>
                        <!--<div class="page-toolbar">
                            <div id="dashboard-report-range" class="pull-right tooltips btn btn-sm" data-container="body" data-placement="bottom" data-original-title="Change dashboard date range">
                                <i class="icon-calendar"></i>&nbsp;
                                <span class="thin uppercase hidden-xs"></span>&nbsp;
                                <i class="fa fa-angle-down"></i>
                            </div>
                        </div>-->
                    </div>
                    <!-- END PAGE BAR -->
                    <!-- BEGIN PAGE TITLE-->
                    <h3 class="page-title"><?php echo $this->lang->line('user_manager_users');?></h3>
                    <!-- END PAGE TITLE-->
                    <!-- END PAGE HEADER-->
                    <?php echo $content; ?>        
<!--</div>-->
